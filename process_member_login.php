<?php
// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Database connection (replace with your actual credentials)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "CalistheniX_db";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the database
    $sql = "SELECT * FROM members WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['member_id'] = $user['id'];
            $_SESSION['member_name'] = $user['name'];

            // Redirect to member dashboard
            header("Location: member_dashboard.php");
            exit;
        } else {
            // Invalid password
            header("Location: member_login.php?error=Invalid password");
            exit;
        }
    } else {
        // No account found
        header("Location: member_login.php?error=No account found with that email address");
        exit;
    }

    // Close connection
    $conn->close();
}
?>
