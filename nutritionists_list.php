<?php
session_start();
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php?error=Please log in first.");
    exit;
}

$member_id = $_SESSION['member_id'];

$conn = new mysqli('localhost', 'root', '', 'CalistheniX_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all nutritionists
$sql = "SELECT id, name, email FROM nutritionists";
$result = $conn->query($sql);
$nutritionists = [];
while ($row = $result->fetch_assoc()) {
    $nutritionists[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="css/member_dashboard.css">
    <style>


    /* Table Styling */
    table {
        width: 80%;
        border-collapse: collapse;
        margin: 2rem 0;
        background-color: #bff1b2;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    thead {
        background-color: #4CAF50;
        color: white;
    }

    th, td {
        text-align: center;
        padding: 1rem;
        border: 1px solid black;
    }

    th {
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #b2b9f1 ;
    }

    tr:hover {
        background-color: #b2b9f1 ;
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
        <section>
            <h1>Choose Your Nutritionist</h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nutritionists as $nutritionist): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nutritionist['name']); ?></td>
                        <td><?php echo htmlspecialchars($nutritionist['email']); ?></td>
                        <td>
                            <form action="select_nutritionist.php" method="post">
                                <input type="hidden" name="nutritionist_id" value="<?php echo $nutritionist['id']; ?>">
                                <button type="submit">Choose</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
