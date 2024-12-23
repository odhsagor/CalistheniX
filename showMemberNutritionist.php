<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['authority_id'])) {
    header("Location: authority_login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all members and their assigned nutritionists
$sql = "SELECT m.id AS member_id, m.name AS member_name, m.email AS member_email, m.phone AS member_phone, m.dob AS member_dob, 
               n.id AS nutritionist_id, n.name AS nutritionist_name
        FROM members m
        LEFT JOIN nutritionists_guidance ng ON m.id = ng.member_id
        LEFT JOIN nutritionists n ON ng.nutritionist_id = n.id";
$result = $conn->query($sql);

// Fetch all nutritionists for the dropdown
$nutritionists_sql = "SELECT id, name FROM nutritionists";
$nutritionists_result = $conn->query($nutritionists_sql);
$nutritionists = $nutritionists_result->fetch_all(MYSQLI_ASSOC);

// Handle nutritionist update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['member_id'], $_POST['nutritionist_id'])) {
    $member_id = $_POST['member_id'];
    $new_nutritionist_id = $_POST['nutritionist_id'];

    // Check if the member already has a nutritionist assigned
    $checkSql = "SELECT * FROM nutritionists_guidance WHERE member_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update nutritionist assignment
        $updateSql = "UPDATE nutritionists_guidance SET nutritionist_id = ? WHERE member_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $new_nutritionist_id, $member_id);
    } else {
        // Insert new nutritionist assignment
        $insertSql = "INSERT INTO nutritionists_guidance (member_id, nutritionist_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $new_nutritionist_id);
    }

    if ($stmt->execute()) {
        // Add notification
        $notifSql = "INSERT INTO notifications (member_id, message, link) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifMessage = "Admin updated your nutritionist. Your nutritionist has been changed.";
        $notifLink = "nutritionists_list.php";
        $notifStmt->bind_param("iss", $member_id, $notifMessage, $notifLink);
        $notifStmt->execute();

        $message = "Nutritionist updated successfully!";
    } else {
        $message = "Failed to update nutritionist.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
    <style>
        main {
            padding: 20px;
            margin: 20px auto;
            max-width: 1200px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .message {
            text-align: center;
            font-size: 1.2rem;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="authority_dashboard.php">Dashboard</a></li>
                <li><a href="showTotalMembers.php">Show Members by Trainer</a></li>
                <li><a href="showMemberNutritionist.php">Show Members by Nutritionist</a></li>
                <li><a href="AuthorityGiveSubscription.php">Subscription</a></li>
                <li><a href="authority_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<main>
    <h1>List of Members and Their Nutritionists</h1>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Assigned Nutritionist</th>
                <th>Assign Nutritionist</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['member_id']) . "</td>
                        <td>" . htmlspecialchars($row['member_name']) . "</td>
                        <td>" . htmlspecialchars($row['member_email']) . "</td>
                        <td>" . htmlspecialchars($row['member_phone']) . "</td>
                        <td>" . htmlspecialchars($row['member_dob']) . "</td>
                        <td>" . htmlspecialchars($row['nutritionist_name'] ?? 'Unassigned') . "</td>
                        <td>
                            <form method='POST'>
                                <input type='hidden' name='member_id' value='" . htmlspecialchars($row['member_id']) . "'>
                                <select name='nutritionist_id'>
                                    <option value='' disabled selected>Select Nutritionist</option>";
                                    foreach ($nutritionists as $nutritionist) {
                                        $selected = $nutritionist['id'] == $row['nutritionist_id'] ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($nutritionist['id']) . "' $selected>" . htmlspecialchars($nutritionist['name']) . "</option>";
                                    }
                    echo "</select>
                                <button type='submit'>Update</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No members found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
