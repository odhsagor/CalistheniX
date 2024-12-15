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

$member_id = $_SESSION['member_id'];

// Fetch the trainer already chosen by the member, if any
$chosenTrainerSql = "SELECT t.id, t.name, t.email FROM trainers t 
                     JOIN member_trainer mt ON t.id = mt.trainer_id 
                     WHERE mt.member_id = ?";
$stmt = $conn->prepare($chosenTrainerSql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$chosenTrainerResult = $stmt->get_result();
$chosenTrainer = $chosenTrainerResult->fetch_assoc();

// Fetch trainers if no trainer is chosen
if (!$chosenTrainer) {
    $sql = "SELECT id, name, email FROM trainers";
    $result = $conn->query($sql);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trainer_id'])) {
    $trainer_id = $_POST['trainer_id'];

    // Check if member already chose a trainer
    if ($chosenTrainer) {
        $message = "You have already chosen a trainer.";
    } else {
        // Insert member-trainer relationship
        $insertSql = "INSERT INTO member_trainer (member_id, trainer_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $trainer_id);

        if ($stmt->execute()) {
            $message = "Trainer selected successfully!";
            header("Location: trainer_list.php"); // Refresh to show only the chosen trainer
            exit;
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
    <link rel="stylesheet" href="css/trainer_list.css">
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
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <?php if ($chosenTrainer): ?>
    <h2>Your Trainer</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>View Plan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo htmlspecialchars($chosenTrainer['name']); ?></td>
                <td><?php echo htmlspecialchars($chosenTrainer['email']); ?></td>
                <td>
                    <form action="view_plan.php" method="POST">
                        <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                        <input type="hidden" name="trainer_id" value="<?php echo $chosenTrainer['id']; ?>">
                        <button type="submit">View Plan</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <h2>Available Trainers</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
                <th>View Plan</th>
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
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="trainer_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">View Plan</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

    </main>
</body>
</html>
