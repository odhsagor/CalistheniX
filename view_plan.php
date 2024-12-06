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
    <link rel="stylesheet" href="css/member_dashboard.css">
    <style>
       /* Fill it */
    </style>
</head>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="member_dashboard.php">Home</a></li>
                <li><a href="trainer_list.php">Trainer</a></li>
                <li><a href="nutritionist_list.php">Nutritionist</a></li>
                <li><a href="bmi_calculator.php">BMI</a></li>
                <li><a href="diet_plan.php">Diet Plan</a></li>
                <li><a href="memberSubscription.php">Subscription</a></li>
                <li><a href="calorie_tracker.php">Consume Calories</a></li>
                <li><a href="member_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h1>My Exercise Plan</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <h2>Plan Assigned By: <?php echo htmlspecialchars($row['trainer_name']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($row['plan'])); ?></p>
                <small>Assigned on: <?php echo htmlspecialchars($row['created_at']); ?></small>
            </div>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No plans assigned yet.</p>
    <?php endif; ?>
</body>
</html>
