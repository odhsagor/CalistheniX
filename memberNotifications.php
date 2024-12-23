<?php
session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "calisthe_CalistheniX_db_user";
$password_db = "zI3t=Pa94uG#";
$dbname = "calisthe_CalistheniX_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$member_id = $_SESSION['member_id'];
$sql = "SELECT message, link, created_at FROM notifications WHERE member_id = ? ORDER BY created_at DESC";
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
    <title>Notifications</title>
    <link rel="stylesheet" href="css/memberNotifications.css">
</head>
<body>
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
    <main>
        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <p><?php echo htmlspecialchars($row['message']); ?></p>
                        <a href="<?php echo htmlspecialchars($row['link']); ?>">View Details</a>
                        <small><?php echo htmlspecialchars($row['created_at']); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No notifications yet.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
