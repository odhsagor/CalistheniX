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

// Fetch subscription details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM subscriptions WHERE id = $id");
    if ($result->num_rows > 0) {
        $subscription = $result->fetch_assoc();
    } else {
        echo "Invalid subscription ID.";
        exit;
    }
} else {
    echo "No subscription ID provided.";
    exit;
}

// Update subscription details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $plan_name = htmlspecialchars($_POST['plan_name']);
    $details = htmlspecialchars($_POST['details']);
    $price = htmlspecialchars($_POST['price']);

    $update_sql = "UPDATE subscriptions SET plan_name = ?, details = ?, price = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssdi", $plan_name, $details, $price, $id);
    if ($stmt->execute()) {
        $message = "Subscription updated successfully!";
        header("Location: manage_subscriptions.php");
        exit;
    } else {
        $message = "Error updating subscription: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subscription</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
    <style>


        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input, textarea {
            font-size: 14px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        input:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            font-size: 16px;
            font-weight: bold;
            color: green;
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
        <input type="hidden" name="id" value="<?php echo $subscription['id']; ?>">

        <label for="plan_name">Subscription Plan Name:</label>
        <input type="text" id="plan_name" name="plan_name" value="<?php echo htmlspecialchars($subscription['plan_name']); ?>" required>

        <label for="details">Subscription Details:</label>
        <textarea id="details" name="details" rows="4" required><?php echo htmlspecialchars($subscription['details']); ?></textarea>

        <label for="price">Price (in BDT):</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($subscription['price']); ?>" required>

        <button type="submit">Update Plan</button>
    </form>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
