
<?php
session_start(); // Start session

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

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch authority details by email
    $sql = "SELECT * FROM authority WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $authority = $result->fetch_assoc();

        // Directly compare the plain text password
        if ($password === $authority['password']) {
            // Set session variables
            $_SESSION['authority_id'] = $authority['id'];
            $_SESSION['authority_email'] = $authority['email'];

            // Redirect to the authority dashboard
            header("Location: authority_dashboard.php");
            exit;
        } else {
            // Incorrect password
            header("Location: authority_login.php?error=Invalid password");
            exit;
        }
    } else {
        // No user found with that email
        header("Location: authority_login.php?error=No account found with that email");
        exit;
    }
// Close connection
$conn->close();
}

?>

