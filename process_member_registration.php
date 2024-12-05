<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $dob = htmlspecialchars($_POST['dob']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    // Validate passwords match
    if ($password !== $confirm_password) {
        header("Location: member_registration.php?error=Passwords do not match");
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection (replace with your actual credentials)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "CalistheniX_db";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        header("Location: member_registration.php?error=Connection failed");
        exit;
    }

    // Insert data into database
    $sql = "INSERT INTO members (name, email, phone, dob, password)
            VALUES ('$name', '$email', '$phone', '$dob', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: member_registration.php?success=Registration successful! Welcome, $name.");
    } else {
        header("Location: member_registration.php?error=Registration failed. Please try again.");
    }

    // Close connection
    $conn->close();
}
?>
