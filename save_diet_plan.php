<?php
session_start();

// Check if the nutritionist is logged in
if (!isset($_SESSION['nutritionist_id'])) {
    header("Location: nutritionists_login.php");
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
    $nutritionist_id = $_SESSION['nutritionist_id'];
    $member_id = $_POST['member_id'];
    $plan = $_POST['plan'];

    $stmt = $conn->prepare("INSERT INTO diet_plans (member_id, nutritionist_id, plan) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $member_id, $nutritionist_id, $plan);

    if ($stmt->execute()) {
        header("Location: nutritionists_guidance.php?success=Diet plan assigned successfully.");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
