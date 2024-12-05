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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $plan_name = htmlspecialchars($_POST['plan_name']);
    $details = htmlspecialchars($_POST['details']);
    $price = htmlspecialchars($_POST['price']);

    // Insert or update subscription
    $sql = "INSERT INTO subscriptions (plan_name, details, price, currency) 
            VALUES (?, ?, ?, 'BDT') 
            ON DUPLICATE KEY UPDATE details = VALUES(details), price = VALUES(price)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $plan_name, $details, $price);
    if ($stmt->execute()) {
        $message = "Subscription plan saved successfully!";
    } else {
        $message = "Error saving subscription plan: " . $conn->error;
    }
}

// Fetch all plans
$subscriptions = $conn->query("SELECT * FROM subscriptions");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subscriptions</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
    <style>
        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
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
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    <form method="POST" action="">
        <label for="plan_name">Subscription Plan Name:</label>
        <select id="plan_name" name="plan_name" required>
            <option value="1 Month">1 Month</option>
            <option value="3 Months">3 Months</option>
            <option value="6 Months">6 Months</option>
            <option value="12 Months">12 Months</option>
        </select>

        <label for="details">Subscription Details:</label>
        <textarea id="details" name="details" rows="4" required></textarea>

        <label for="price">Price (in BDT):</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <button type="submit">Save Plan</button>
    </form>

    <h2>Current Subscription Plans</h2>
    <table>
        <thead>
            <tr>
                <th>Plan Name</th>
                <th>Details</th>
                <th>Price (BDT)</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $subscriptions->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['plan_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['details']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                    <td>
                        <form action="edit_subscription_authority.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="edit-btn">Edit</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
