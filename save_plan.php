<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: trainer_login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['member_id'], $_POST['plan'])) {
    $trainer_id = $_SESSION['trainer_id'];
    $member_id = $_POST['member_id'];
    $plan = $_POST['plan'];

    $stmt = $conn->prepare("INSERT INTO exercise_plans (member_id, trainer_id, plan) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $member_id, $trainer_id, $plan);

    if ($stmt->execute()) {
        header("Location: under_my_guidance.php?success=Plan assigned successfully.");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
