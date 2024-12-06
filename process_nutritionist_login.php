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

    // SQL query to fetch nutritionist details
    $sql = "SELECT * FROM nutritionists WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the nutritionist's data
        $nutritionist = $result->fetch_assoc();

        // Directly compare the password (plain text in this case)
        if ($password === $nutritionist['password']) {
            // Set session variables
            $_SESSION['nutritionist_id'] = $nutritionist['id'];
            $_SESSION['nutritionist_email'] = $nutritionist['email'];

            // Redirect to nutritionist dashboard
            header("Location: nutritionists_dashboard.php");
            exit;
        } else {
            // Incorrect password
            header("Location: nutritionist_login.php?error=Invalid password");
            exit;
        }
    } else {
        // No nutritionist found with that email
        header("Location: nutritionist_login.php?error=No account found with that email");
        exit;
    }

    // Close connection
    $conn->close();
}
?>
