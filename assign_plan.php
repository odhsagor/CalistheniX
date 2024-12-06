<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: trainer_login.php");
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $trainer_id = $_SESSION['trainer_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="css/trainer_dashboard.css">
    <style>
       /* Fill it */
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
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
<body>
    <h1>Assign Exercise Plan</h1>
    <form action="save_plan.php" method="POST">
        <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">
        <textarea name="plan" rows="10" cols="50" placeholder="Write the exercise plan here..." required></textarea>
        <button type="submit">Save Plan</button>
    </form>


    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
