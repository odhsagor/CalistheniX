<?php
session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}

// Get the member's name from the session
$member_name = isset($_SESSION['member_name']) ? $_SESSION['member_name'] : "Member";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="css/member_dashboard.css">
    <style>
        /* Inline styles for background image */
        body {
            background-image: url('images/gym.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #ffffff;
        }
        main {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            width: 80%;
        }

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
        <h1>Welcome to Your Profile</h1>
        <h2>Hello, <?php echo htmlspecialchars($member_name); ?>!</h2>
        <p>Stay motivated and take charge of your fitness journey!</p>
        <section class="fitness-messages">
            <h2>Fitness Tips</h2>
            <ul>
                <li>Stay consistent with your workouts for lasting results.</li>
                <li>Drink plenty of water throughout the day.</li>
                <li>Include a mix of cardio, strength, and flexibility exercises.</li>
                <li>Focus on eating a balanced diet with whole, nutrient-dense foods.</li>
                <li>Get adequate sleep to help your body recover and recharge.</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>