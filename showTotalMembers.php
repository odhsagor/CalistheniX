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

// Fetch all members and their assigned trainers
$sql = "SELECT m.id AS member_id, m.name AS member_name, m.email AS member_email, m.phone AS member_phone, m.dob AS member_dob, 
               t.id AS trainer_id, t.name AS trainer_name
        FROM members m
        LEFT JOIN member_trainer mt ON m.id = mt.member_id
        LEFT JOIN trainers t ON mt.trainer_id = t.id";
$result = $conn->query($sql);

// Fetch all trainers for the dropdown
$trainers_sql = "SELECT id, name FROM trainers";
$trainers_result = $conn->query($trainers_sql);
$trainers = $trainers_result->fetch_all(MYSQLI_ASSOC);

// Handle trainer update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['member_id'], $_POST['trainer_id'])) {
    $member_id = $_POST['member_id'];
    $new_trainer_id = $_POST['trainer_id'];

    // Check if the member already has a trainer assigned
    $checkSql = "SELECT * FROM member_trainer WHERE member_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update trainer assignment
        $updateSql = "UPDATE member_trainer SET trainer_id = ? WHERE member_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ii", $new_trainer_id, $member_id);
    } else {
        // Insert new trainer assignment
        $insertSql = "INSERT INTO member_trainer (member_id, trainer_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $new_trainer_id);
    }

    if ($stmt->execute()) {
        // Add notification
        $notifSql = "INSERT INTO notifications (member_id, message, link) VALUES (?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        $notifMessage = "Admin updated your trainer. Your trainer has been changed.";
        $notifLink = "trainer_list.php";
        $notifStmt->bind_param("iss", $member_id, $notifMessage, $notifLink);
        $notifStmt->execute();

        $message = "Trainer updated successfully!";
    } else {
        $message = "Failed to update trainer.";
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
    <h1>List of Members and Their Trainers</h1>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Assigned Trainer</th>
                <th>Assign Trainer</th>
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
                        <td>" . htmlspecialchars($row['trainer_name'] ?? 'Unassigned') . "</td>
                        <td>
                            <form method='POST'>
                                <input type='hidden' name='member_id' value='" . htmlspecialchars($row['member_id']) . "'>
                                <select name='trainer_id'>
                                    <option value='' disabled selected>Select Trainer</option>";
                                    foreach ($trainers as $trainer) {
                                        $selected = $trainer['id'] == $row['trainer_id'] ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($trainer['id']) . "' $selected>" . htmlspecialchars($trainer['name']) . "</option>";
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
