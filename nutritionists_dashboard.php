<?php
session_start();

// Check if nutritionist is logged in
if (!isset($_SESSION['nutritionist_id'])) {
    header("Location: nutritionist_login.php?error=Please log in first.");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nutritionist_id = $_SESSION['nutritionist_id'];
$nutritionist_name = "Nutritionist";

// Fetch the nutritionist's name from the database
$sql = "SELECT name FROM nutritionists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $nutritionist_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $nutritionist = $result->fetch_assoc();
    $nutritionist_name = $nutritionist['name'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist Dashboard</title>
    <link rel="stylesheet" href="css/nutritionists_dashboard.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
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
        <section class="welcome">
            <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($nutritionist_name); ?>!</h1>
            <p>Your role is vital in providing customized diet plans to help members achieve their fitness goals.</p>
        </section>

        <section class="about">
            <h2>About Nutritionists</h2>
            <p>As a nutritionist, you play an integral role in promoting health and wellness. Here at CalistheniX, we value the importance of proper nutrition in achieving fitness milestones. Use this dashboard to manage members under your guidance and create personalized diet plans tailored to their needs.</p>
        </section>

        <section class="tips">
            <h2>Nutrition Tips</h2>
            <div class="tips-container">
                <div class="tip-card">
                    <h3>Tip 1</h3>
                    <p>Encourage balanced diets rich in fruits, vegetables, and lean proteins.</p>
                </div>
                <div class="tip-card">
                    <h3>Tip 2</h3>
                    <p>Remind members to stay hydrated throughout the day for optimal performance.</p>
                </div>
                <div class="tip-card">
                    <h3>Tip 3</h3>
                    <p>Suggest meal prepping to make it easier for members to stick to their diet plans.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
