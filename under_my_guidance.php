<?php
session_start();

// Check if trainer is logged in
if (!isset($_SESSION['trainer_id'])) {
    header("Location: trainer_login.php?error=Please log in first.");
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

// Fetch members under the logged-in trainer's guidance
$trainer_id = $_SESSION['trainer_id'];
$sql = "SELECT m.id, m.name, m.email, m.phone, m.dob 
        FROM members m
        JOIN member_trainer mt ON m.id = mt.member_id
        WHERE mt.trainer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $trainer_id);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under My Guidance</title>
    <link rel="stylesheet" href="css/trainer_dashboard.css">
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
                <li><a href="trainer_dashboard.php">Dashboard</a></li>
                <li><a href="under_my_guidance.php">Under My Guidance</a></li>
                <li><a href="my_salary.php">My Salary</a></li>
                <li><a href="trainer_login.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>Give plan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['dob']); ?></td>
                        <td>
                            <form action="assign_plan.php" method="POST">
                                <input type="hidden" name="member_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Assign Plan</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </main>
</body>
</html>
