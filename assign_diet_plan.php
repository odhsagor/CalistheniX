<?php
session_start();

// Check if the nutritionist is logged in
if (!isset($_SESSION['nutritionist_id'])) {
    header("Location: nutritionists_login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve member_id from the POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $nutritionist_id = $_SESSION['nutritionist_id'];
}

// Handle diet plan submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['plan'])) {
    $plan = $_POST['plan'];

    // Insert the diet plan into the database
    $insertSql = "INSERT INTO diet_plans (member_id, nutritionist_id, plan, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("iis", $member_id, $nutritionist_id, $plan);

    if ($stmt->execute()) {
        // Add notification for the member
        $notifSql = "INSERT INTO notifications (member_id, message, link) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifMessage = "Your nutritionist has assigned you a diet plan.";
        $notifLink = "view_diet_plan.php";
        $notifStmt->bind_param("iss", $member_id, $notifMessage, $notifLink);
        $notifStmt->execute();

        $successMessage = "Diet plan assigned successfully!";
    } else {
        $errorMessage = "Failed to assign diet plan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Diet Plan</title>
    <link rel="stylesheet" href="css/nutritionists_dashboard.css">
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
            height: 200px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .success {
            color: #4CAF50;
        }

        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo">
        </div>
        <nav>
            <ul>
                <li><a href="nutritionists_dashboard.php">Dashboard</a></li>
                <li><a href="nutritionists_guidance.php">Under My Guidance</a></li>
                <li><a href="nutritionist_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Assign Diet Plan</h1>
        <?php if (isset($successMessage)) echo "<p class='message success'>$successMessage</p>"; ?>
        <?php if (isset($errorMessage)) echo "<p class='message error'>$errorMessage</p>"; ?>
        <form action="assign_diet_plan.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">
            <textarea name="plan" placeholder="Write the diet plan here..." required></textarea>
            <button type="submit">Save Diet Plan</button>
        </form>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
    <!-- Add Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
