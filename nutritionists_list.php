<?php
session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php?error=Please log in first.");
    exit;
}

// Database connection
$servername = "localhost";
$username = "calisthe_CalistheniX_db_user";
$password_db = "zI3t=Pa94uG#";
$dbname = "calisthe_CalistheniX_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$member_id = $_SESSION['member_id'];

// Fetch the chosen nutritionist if already assigned
$chosenNutritionistSql = "SELECT n.id, n.name, n.email FROM nutritionists n 
                          JOIN nutritionists_guidance ng ON n.id = ng.nutritionist_id 
                          WHERE ng.member_id = ?";
$stmt = $conn->prepare($chosenNutritionistSql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$chosenNutritionistResult = $stmt->get_result();
$chosenNutritionist = $chosenNutritionistResult->fetch_assoc();

// Fetch available nutritionists if no nutritionist is chosen
if (!$chosenNutritionist) {
    $sql = "SELECT id, name, email FROM nutritionists";
    $result = $conn->query($sql);
}

// Handle nutritionist selection
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nutritionist_id'])) {
    $nutritionist_id = $_POST['nutritionist_id'];

    if ($chosenNutritionist) {
        $message = "You have already chosen a nutritionist.";
    } else {
        // Insert nutritionist assignment
        $insertSql = "INSERT INTO nutritionists_guidance (member_id, nutritionist_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $nutritionist_id);

        if ($stmt->execute()) {
            // Add notification
            $notifSql = "INSERT INTO notifications (member_id, message, link) VALUES (?, ?, ?)";
            $notifStmt = $conn->prepare($notifSql);
            $notifMessage = "Your nutritionist has been assigned successfully!";
            $notifLink = "nutritionists_list.php";
            $notifStmt->bind_param("iss", $member_id, $notifMessage, $notifLink);
            $notifStmt->execute();

            header("Location: nutritionists_list.php");
            exit;
        } else {
            $message = "Failed to select nutritionist.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist List</title>
    <link rel="stylesheet" href="css/nutritionist_list.css">


<style>

body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
    
        h1, h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            color: #4CAF50;
            font-weight: bold;
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
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

        <?php if ($chosenNutritionist): ?>
            <h2>Your Nutritionist</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>View Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($chosenNutritionist['name']); ?></td>
                        <td><?php echo htmlspecialchars($chosenNutritionist['email']); ?></td>
                        <td>
                            <form action="view_diet_plan.php" method="POST">
                                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                                <input type="hidden" name="nutritionist_id" value="<?php echo $chosenNutritionist['id']; ?>">
                                <button type="submit">View Plan</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <h2>Available Nutritionists</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="nutritionist_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Choose</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>

    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
