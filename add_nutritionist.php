<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['authority_id'])) {
    header("Location: authority_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Nutritionist</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="authority_dashboard.php">Dashboard</a></li>
                <li><a href="authority_member.php">Member</a></li>
                <li><a href="add_trainer.php">Trainer</a></li>
                <li><a href="add_nutritionist.php">Nutritionist</a></li>
                <li><a href="website_update.php">Website Update</a></li>
                <li><a href="authority_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="add-nutritionist">
            <h2>Add New Nutritionist</h2>
            
            <!-- Display Success/Error Messages -->
            <?php
            if (isset($_GET['success'])) {
                echo "<p class='success'>" . htmlspecialchars($_GET['success']) . "</p>";
            }
            if (isset($_GET['error'])) {
                echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
            ?>

            <form action="process_add_nutritionist.php" method="POST">
                <label for="name">Nutritionist Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Add Nutritionist</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
