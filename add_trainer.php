<?php
session_start();

// Check if the authority is logged in, if not redirect to login page
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
    <title>Add Trainer</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
</head>
<style>
    .add-trainer {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.add-trainer h2 {
    text-align: center;
    color: #4CAF50;
    margin-bottom: 1.5rem;
    font-family: 'Arial', sans-serif;
}

.add-trainer form {
    display: flex;
    flex-direction: column;
}

.add-trainer label {
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

.add-trainer input {
    padding: 0.8rem;
    margin-bottom: 1.2rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    box-shadow: inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.add-trainer input:focus {
    border-color: #4CAF50;
    box-shadow: 0px 0px 5px rgba(76, 175, 80, 0.3);
    outline: none;
}

.add-trainer button {
    padding: 0.8rem;
    font-size: 1rem;
    font-weight: bold;
    color: #fff;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-trainer button:hover {
    background-color: #45a049;
}

.add-trainer .success, .add-trainer .error {
    text-align: center;
    font-size: 1rem;
    margin: 1rem 0;
    padding: 0.8rem;
    border-radius: 5px;
}

.add-trainer .success {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.add-trainer .error {
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
        <section class="add-trainer">
            <h2>Add New Trainer</h2>
            
            <!-- Display Success/Error Messages -->
            <?php
            if (isset($_GET['success'])) {
                echo "<p class='success'>" . htmlspecialchars($_GET['success']) . "</p>";
            }
            if (isset($_GET['error'])) {
                echo "<p class='error'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
            ?>

            <form action="process_add_trainer.php" method="POST">
                <label for="name">Trainer Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Add Trainer</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
