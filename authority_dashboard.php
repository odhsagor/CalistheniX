<?php
// Start session to check if user is logged in
session_start();
if (!isset($_SESSION['authority_id'])) {
    header("Location: authority_login.php?error=Please log in first.");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Dashboard</title>
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
        <section class="fitness-blog">
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
