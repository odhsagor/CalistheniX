<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php?error=Please log in first.");
    exit;
}

$member_id = $_SESSION['member_id'];
$nutritionist_id = $_POST['nutritionist_id'];

$conn = new mysqli('localhost', 'root', '', 'CalistheniX_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the member already selected a nutritionist
$sql = "SELECT * FROM nutritionists_guidance WHERE member_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update nutritionist selection
    $update_sql = "UPDATE nutritionists_guidance SET nutritionist_id = ? WHERE member_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $nutritionist_id, $member_id);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Insert new record
    $insert_sql = "INSERT INTO nutritionists_guidance (member_id, nutritionist_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ii", $member_id, $nutritionist_id);
    $insert_stmt->execute();
    $insert_stmt->close();
}

$stmt->close();
$conn->close();

header("Location: nutritionists_list.php?success=Nutritionist selected successfully.");
exit;
?>
