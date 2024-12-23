<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$member_id = $_SESSION['member_id'];
$sql = "SELECT p.plan, t.name AS trainer_name, p.created_at 
        FROM exercise_plans p
        JOIN trainers t ON p.trainer_id = t.id
        WHERE p.member_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Exercise Plan</title>
    <link rel="stylesheet" href="css/view_plan.css">
</head>
<style>

/* Notification Icon Styles */
    .notification {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .notification a {
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .notification i {
        font-size: 24px;
        color: white;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .notification a:hover i {
        transform: scale(1.2);
        color: #1abc9c;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: linear-gradient(90deg, #ff4500, #ff7e5f);
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        padding: 4px 7px;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(255, 69, 0, 0.5);
        animation: pulse 1.5s infinite;
    }

    /* Pulse Animation for Badge */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 10px rgba(255, 69, 0, 0.5);
        }
        50% {
            transform: scale(1.2);
            box-shadow: 0 0 20px rgba(255, 69, 0, 0.7);
        }
    }


</style>
</head>
<body>
<header>
<div class="logo">
    <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
</div>
<nav>
    <ul>
        <li><a href="member_dashboard.php">Home</a></li>
        <li><a href="trainer_list.php">Trainer</a></li>
        <li><a href="nutritionists_list.php">Nutritionist</a></li>
        <li><a href="bmi_calculator.php">BMI</a></li>
        <li><a href="view_diet_plan.php">Diet Plan</a></li>
        <li><a href="memberSubscription.php">Subscription</a></li>
        <li><a href="calorie_tracker.php">Consume Calories</a></li>
        <li class="notification">
            <a href="memberNotifications.php">
                <i class="fa fa-bell"></i>
                <span class="notification-badge">See</span>
            </a>
        </li>
        <li><a href="member_login.php">Logout</a></li>
    </ul>
</nav>
</header>
<body>
    <main>
    <h1>My Exercise Plan</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h2>Plan Assigned By your Trainer: <?php echo htmlspecialchars($row['trainer_name']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($row['plan'])); ?></p>
                <small>Assigned on: <?php echo htmlspecialchars($row['created_at']); ?></small>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No plans assigned yet.</p>
    <?php endif; ?>
    </main>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
