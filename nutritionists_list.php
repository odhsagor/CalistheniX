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
    <title>Nutritionists List</title>
    <link rel="stylesheet" href="css/nutritionists_list.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/CalistheniX.png" alt="Fitness Center Logo">
        </div>
        <nav>
            <ul>
                <li><a href="member_dashboard.php">Dashboard</a></li>
                <li><a href="member_logout.php">Logout</a></li>
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
                                <button type="submit">Select</button>
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
