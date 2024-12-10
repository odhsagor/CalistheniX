<?php
session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
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

$member_id = $_SESSION['member_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['log_item'])) {
    $item_name = htmlspecialchars($_POST['item_name']);
    $protein = (float)$_POST['protein'];
    $carbs = (float)$_POST['carbs'];
    $fat = (float)$_POST['fat'];
    $calories = (float)$_POST['calories'];
    $water = (float)$_POST['water'];

    // Insert the log into the database
    $stmt = $conn->prepare("INSERT INTO calorie_logs (member_id, item_name, protein, carbs, fat, calories, water) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdddd", $member_id, $item_name, $protein, $carbs, $fat, $calories, $water);
    if ($stmt->execute()) {
        $message = "Item logged successfully!";
    } else {
        $message = "Error logging item: " . $conn->error;
    }
    $stmt->close();
}

// Fetch daily logs for the member
$logs = [];
$total_calories = $total_protein = $total_carbs = $total_fat = $total_water = 0;

$sql = "SELECT * FROM calorie_logs WHERE member_id = ? AND log_date = CURRENT_DATE";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
    $total_calories += $row['calories'];
    $total_protein += $row['protein'];
    $total_carbs += $row['carbs'];
    $total_fat += $row['fat'];
    $total_water += $row['water'];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calorie Tracker</title>
    <link rel="stylesheet" href="css/member_dashboard.css">
    <style>


        main {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .result {
            margin-top: 20px;
            font-weight: bold;
            color: green;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: white;
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
                <li><a href="member_dashboard.php">Home</a></li>
                <li><a href="trainer_list.php">Trainer</a></li>
                <li><a href="nutritionists_list.php">Nutritionist</a></li>
                <li><a href="bmi_calculator.php">BMI</a></li>
                <li><a href="view_diet_plan.php">Diet Plan</a></li>
                <li><a href="memberSubscription.php">Subscription</a></li>
                <li><a href="calorie_tracker.php">Consume Calories</a></li>
                <li><a href="member_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<main>
    <h2>Track Your Daily Nutrition</h2>
    <form method="POST">
        <label for="item_name">Food/Drink Name:</label>
        <input type="text" id="item_name" name="item_name" required>

        <label for="protein">Protein (g):</label>
        <input type="number" id="protein" name="protein" step="0.01" required>

        <label for="carbs">Carbohydrates (g):</label>
        <input type="number" id="carbs" name="carbs" step="0.01" required>

        <label for="fat">Fat (g):</label>
        <input type="number" id="fat" name="fat" step="0.01" required>

        <label for="calories">Calories (kcal):</label>
        <input type="number" id="calories" name="calories" step="0.01" required>

        <label for="water">Water (L):</label>
        <input type="number" id="water" name="water" step="0.01">

        <button type="submit" name="log_item">Log Item</button>
    </form>

    <?php if (isset($message)) echo "<p class='result'>$message</p>"; ?>
    <h3>Today's Logs</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Protein (g)</th>
                <th>Carbs (g)</th>
                <th>Fat (g)</th>
                <th>Calories (kcal)</th>
                <th>Water (L)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['item_name']); ?></td>
                    <td><?= $log['protein']; ?></td>
                    <td><?= $log['carbs']; ?></td>
                    <td><?= $log['fat']; ?></td>
                    <td><?= $log['calories']; ?></td>
                    <td><?= $log['water']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th><?= $total_protein; ?> g</th>
                <th><?= $total_carbs; ?> g</th>
                <th><?= $total_fat; ?> g</th>
                <th><?= $total_calories; ?> kcal</th>
                <th><?= $total_water; ?> L</th>
            </tr>
        </tfoot>
    </table>
</main>
<h2>      .              </h2>
<h2>      .              </h2>
<footer>
    <p>&copy; <?= date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
