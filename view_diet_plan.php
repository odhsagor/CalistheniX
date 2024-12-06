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

$member_id = $_SESSION['member_id'];
$sql = "SELECT dp.plan, n.name AS nutritionist_name, dp.created_at 
        FROM diet_plans dp
        JOIN nutritionists n ON dp.nutritionist_id = n.id
        WHERE dp.member_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Diet Plan</title>
    <link rel="stylesheet" href="#">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="member_dashboard.php">Home</a></li>
                <li><a href="nutritionists_list.php">Nutritionists</a></li>
                <li><a href="diet_plan.php">Diet Plan</a></li>
                <li><a href="memberSubscription.php">Subscription</a></li>
                <li><a href="calorie_tracker.php">Consume Calories</a></li>
                <li><a href="member_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>My Diet Plan</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div>
                    <h2>Plan Assigned By: <?php echo htmlspecialchars($row['nutritionist_name']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row['plan'])); ?></p>
                    <small>Assigned on: <?php echo htmlspecialchars($row['created_at']); ?></small>
                </div>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No plans assigned yet.</p>
        <?php endif; ?>
    </main>
</body>
</html>
