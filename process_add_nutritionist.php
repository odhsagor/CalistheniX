<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['authority_id'])) {
    header("Location: authority_login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
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

    // SQL query to insert nutritionist details
    $sql = "INSERT INTO nutritionists (name, email, password) VALUES ('$name', '$email', '$password')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect with success message
        header("Location: add_nutritionist.php?success=Nutritionist added successfully");
        exit;
    } else {
        // Redirect with error message
        header("Location: add_nutritionist.php?error=" . urlencode($conn->error));
        exit;
    }

    // Close connection
    $conn->close();
}
?>
