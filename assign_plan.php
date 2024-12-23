<?php
session_start();

// Check if the trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: trainer_login.php");
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

// Get member ID from the POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $trainer_id = $_SESSION['trainer_id'];

    // Handle plan submission
    if (isset($_POST['plan'])) {
        $plan = $_POST['plan'];

        // Insert the exercise plan into the database
        $insertSql = "INSERT INTO exercise_plans (member_id, trainer_id, plan) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("iis", $member_id, $trainer_id, $plan);

        if ($stmt->execute()) {
            // Add notification
            $notifSql = "INSERT INTO notifications (member_id, message, link) VALUES (?, ?, ?)";
            $notifStmt = $conn->prepare($notifSql);
            $notifMessage = "Your trainer has given you an exercise plan.";
            $notifLink = "view_plan.php";
            $notifStmt->bind_param("iss", $member_id, $notifMessage, $notifLink);
            $notifStmt->execute();

            $message = "Exercise plan assigned successfully!";
        } else {
            $message = "Failed to assign the exercise plan.";
        }
    }
} else {
    header("Location: trainer_dashboard.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Exercise Plan</title>
    <link rel="stylesheet" href="css/trainer_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="CalistheniX Logo">
        </div>
        <nav>
            <ul>
                <li><a href="trainer_dashboard.php">Dashboard</a></li>
                <li><a href="under_my_guidance.php">Under My Guidance</a></li>
                <li><a href="my_salary.php">My Salary</a></li>
                <li><a href="trainer_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Assign Exercise Plan</h1>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form action="assign_plan.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">
            <textarea name="plan" placeholder="Write the exercise plan here..." required></textarea>
            <button type="submit">Save Plan</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
