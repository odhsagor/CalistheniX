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
<style>
    .add-nutritionist {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #f5f5f5;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.add-nutritionist h2 {
    text-align: center;
    font-family: 'Arial', sans-serif;
    color: #4CAF50;
    margin-bottom: 1.5rem;
}

.add-nutritionist form {
    display: flex;
    flex-direction: column;
}

.add-nutritionist label {
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
    font-size: 1rem;
}

.add-nutritionist input {
    padding: 0.8rem;
    margin-bottom: 1.2rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.add-nutritionist input:focus {
    border-color: #4CAF50;
    box-shadow: 0px 0px 5px rgba(76, 175, 80, 0.3);
    outline: none;
}

.add-nutritionist button {
    padding: 0.8rem;
    font-size: 1rem;
    font-weight: bold;
    color: white;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-nutritionist button:hover {
    background-color: #45a049;
}

.add-nutritionist .success, .add-nutritionist .error {
    text-align: center;
    font-size: 1rem;
    margin: 1rem 0;
    padding: 0.8rem;
    border-radius: 5px;
}

.add-nutritionist .success {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.add-nutritionist .error {
    color: #721c24;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
}

</style>
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
