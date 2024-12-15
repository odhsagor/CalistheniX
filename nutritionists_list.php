<?php
session_start();

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

// Fetch the nutritionist already chosen by the member, if any
$chosenNutritionistSql = "SELECT n.id, n.name, n.email FROM nutritionists n 
                          JOIN nutritionists_guidance ng ON n.id = ng.nutritionist_id 
                          WHERE ng.member_id = ?";
$stmt = $conn->prepare($chosenNutritionistSql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$chosenNutritionistResult = $stmt->get_result();
$chosenNutritionist = $chosenNutritionistResult->fetch_assoc();

// Fetch nutritionists if no nutritionist is chosen
if (!$chosenNutritionist) {
    $sql = "SELECT id, name, email FROM nutritionists";
    $result = $conn->query($sql);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nutritionist_id'])) {
    $nutritionist_id = $_POST['nutritionist_id'];

    // Check if the member already chose a nutritionist
    if ($chosenNutritionist) {
        $message = "You have already chosen a nutritionist.";
    } else {
        // Insert member-nutritionist relationship
        $insertSql = "INSERT INTO nutritionists_guidance (member_id, nutritionist_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ii", $member_id, $nutritionist_id);

        if ($stmt->execute()) {
            $message = "Nutritionist selected successfully!";
            header("Location: nutritionists_list.php"); // Refresh to show only the chosen nutritionist
            exit;
        } else {
            $message = "Failed to select nutritionist.";
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
    <title>Nutritionist List</title>
    <link rel="stylesheet" href="css/nutritionist_list.css">
</head>
<style>


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

        <?php if ($chosenNutritionist): ?>
        <h2>Your Nutritionist</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>View Plan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($chosenNutritionist['name']); ?></td>
                    <td><?php echo htmlspecialchars($chosenNutritionist['email']); ?></td>
                    <td>
                        <form action="view_diet_plan.php" method="POST">
                            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                            <input type="hidden" name="nutritionist_id" value="<?php echo $chosenNutritionist['id']; ?>">
                            <button type="submit">View Plan</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php else: ?>
        <h2>Available Nutritionists</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="nutritionist_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Choose</button>
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
