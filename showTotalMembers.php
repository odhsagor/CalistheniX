<?php
session_start();

// Check if the authority is logged in
if (!isset($_SESSION['authority_id'])) {
    header("Location: authority_login.php");
    exit;
}

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

// Fetch all members from the database
$sql = "SELECT id, name, email, phone, dob, password FROM members";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Members</title>
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
                <li><a href="showTotalMembers.php">Show Total Member</a></li>
                <li><a href="AuthorityGiveSubscription.php">Create And Update Subscription Price</a></li>
                <li><a href="authority_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<main>
    <h2>List of Members</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                        <td>" . htmlspecialchars($row['dob']) . "</td>
                        <td>" . htmlspecialchars($row['password']) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No members found.</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
