<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "CalistheniX_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to fetch trainer details
    $sql = "SELECT * FROM trainers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the trainer's data
        $trainer = $result->fetch_assoc();

        // Directly compare the password (since we're using plain text)
        if ($password === $trainer['password']) {
            // Set session variables
            $_SESSION['trainer_id'] = $trainer['id'];
            $_SESSION['trainer_email'] = $trainer['email'];

            // Redirect to trainer dashboard
            header("Location: trainer_dashboard.php");
            exit;
        } else {
            // Incorrect password
            header("Location: trainer_login.php?error=Invalid password");
            exit;
        }
    } else {
        // No trainer found with that email
        header("Location: trainer_login.php?error=No account found with that email");
        exit;
    }

    // Close connection
    $conn->close();
}
