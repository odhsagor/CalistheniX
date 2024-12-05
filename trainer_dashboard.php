<?php
// Start session
session_start();

// Check if trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: trainer_login.php?error=Please log in first.");
    exit;
}

// Database connection (replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CalistheniX_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch trainer's name using the stored ID
$trainer_id = $_SESSION['trainer_id'];
$sql = "SELECT name FROM trainers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();

$trainer_name = "Trainer"; 
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $trainer_name = $row['name'];
}

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
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

    <main>
        <section class="fitness-blog">
            <h2>Hello, Trainer - <?php echo htmlspecialchars($trainer_name); ?>!</h2>
            <h2>Fitness Blog</h2>
            <p>Welcome to the fitness center's official blog. Here you'll find articles, tips, and advice to help you stay fit and healthy!</p>

            <article class="blog-post">
                <h3>How to Stay Motivated During Your Fitness Journey</h3>
                <p>Staying motivated is crucial when pursuing fitness goals. Here are some tips to keep you on track...</p>
            </article>

            <article class="blog-post">
                <h3>The Importance of Nutrition in Fitness</h3>
                <p>Fitness isn't just about working out. Proper nutrition is essential to reach your fitness goals...</p>
            </article>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
