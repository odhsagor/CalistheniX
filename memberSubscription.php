<?php
session_start();

// Check if the member is logged in
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

// Fetch all subscription plans
$subscriptions = $conn->query("SELECT * FROM subscriptions");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Subscriptions</title>
    <link rel="stylesheet" href="css/member_dashboard.css">
    <style>
        main {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #3498db;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
        }

        .subscription-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .subscription-table th, .subscription-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .subscription-table th {
            background-color: #3498db;
            color: white;
        }

        .subscription-table tr:nth-child(even) {
            background-color: #3498db;
        }

       

        button.buy-btn {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
    <h2>Choose a Subscription Plan</h2>
    <table class="subscription-table">
        <thead>
            <tr>
                <th>Plan Name</th>
                <th>Details</th>
                <th>Price (BDT)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($subscriptions->num_rows > 0) { ?>
                <?php while ($row = $subscriptions->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['plan_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td>
                            <form action="buy_subscription.php" method="POST">
                                <input type="hidden" name="subscription_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="buy-btn">Buy</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No subscription plans available.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
<!-- Add Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
