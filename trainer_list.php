<?php
session_start();

// Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php?error=Please log in first.");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CalistheniX_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch trainers from the database
$sql = "SELECT id, name, email FROM trainers";
$result = $conn->query($sql);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trainer_id'])) {
    $member_id = $_SESSION['member_id'];
    $trainer_id = $_POST['trainer_id'];

    // Check if member already chose a trainer
    $checkSql = "SELECT * FROM member_trainer WHERE member_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        $message = "You have already chosen a trainer.";
    } else {
        // Insert member-trainer relationship
        $insertSql = "INSERT INTO member_trainer (member_id, trainer_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $trainer_id);

        if ($stmt->execute()) {
            $message = "Trainer selected successfully!";
        } else {
            $message = "Failed to select trainer.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer List</title>
    <link rel="stylesheet" href="css/authoritydashboard.css">
</head>

<style>


/* Table Styling */
table {
    width: 80%;
    border-collapse: collapse;
    margin: 2rem 0;
    background-color: #ffffff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

thead {
    background-color: #4CAF50;
    color: white;
}

th, td {
    text-align: center;
    padding: 1rem;
    border: 1px solid #ddd;
}

th {
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #eaf8e6;
    cursor: pointer;
}

/* Button Styling */
button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

/* Message Styling */
p {
    text-align: center;
    font-size: 1.2rem;
    color: #4CAF50;
    font-weight: bold;
    margin: 1rem 0;
} 
</style>

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
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>view Plan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="trainer_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Choose</button>
                            </form>
                        </td>
                        <td>
                            <form action="view_plan.php" method="POST">
                                <input type="hidden" name="member_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">view Plan</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
