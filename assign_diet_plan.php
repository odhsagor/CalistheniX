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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];
    $nutritionist_id = $_SESSION['nutritionist_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist Dashboard</title>
    <link rel="stylesheet" href="css/nutritionists_dashboard.css">
    <style>

       h1 {
           text-align: center;
           margin-top: 1.5rem;
           color: #333;
       }

       form {
           max-width: 600px;
           margin: 2rem auto;
           padding: 1.5rem;
           background: white;
           border: 1px solid #ddd;
           border-radius: 8px;
           box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
       }

       textarea {
           width: 100%;
           height: 200px;
           padding: 1rem;
           border: 1px solid #ddd;
           border-radius: 4px;
           font-size: 1rem;
       }

       button {
           background-color: #4CAF50;
           color: white;
           border: none;
           padding: 0.8rem 1.5rem;
           font-size: 1rem;
           cursor: pointer;
           border-radius: 4px;
           transition: background-color 0.3s ease;
           display: block;
           margin: 1rem auto 0;
       }

       button:hover {
           background-color: #45a049;
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
                <li><a href="nutritionists_dashboard.php">Dashboard</a></li>
                <li><a href="nutritionists_guidance.php">Under My Guidance</a></li>
                <li><a href="nutritionist_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Assign Diet Plan</h1>
        <form action="save_diet_plan.php" method="POST">
            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($member_id); ?>">
            <textarea name="plan" placeholder="Write the diet plan here..." required></textarea>
            <button type="submit">Save Diet Plan</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
