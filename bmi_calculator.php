<?php
session_start();

// Check if the member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Calculators</title>
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

        .calculator {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .calculator-box {
            flex: 1 1 calc(45% - 20px);
            background-color: #f4f4f4;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .calculator-box h3 {
            text-align: center;
            color: #3498db;
        }

        .calculator-box form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input {
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
            margin-top: 10px;
            font-weight: bold;
            color: green;
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
    <h2>Calculate BMI and Convert Heights</h2>
    <div class="calculator">
        <!-- BMI Calculator -->
        <div class="calculator-box">
            <h3>BMI Calculator</h3>
            <form method="POST">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" step="0.01" required>
                
                <label for="height">Height (m):</label>
                <input type="number" id="height" name="height" step="0.01" required>
                
                <button type="submit" name="bmi">Calculate BMI</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bmi'])) {
                $weight = $_POST['weight'];
                $height = $_POST['height'];
                if ($height > 0) {
                    $bmi = $weight / ($height * $height);
                    echo "<p class='result'>Your BMI: " . round($bmi, 2) . "</p>";
                }
            }
            ?>
        </div>

        <!-- Feet to Inches -->
        <div class="calculator-box">
            <h3>Feet to Inches</h3>
            <form method="POST">
                <label for="feet">Feet:</label>
                <input type="number" id="feet" name="feet" step="0.01" required>
                
                <button type="submit" name="feet_to_inches">Convert</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feet_to_inches'])) {
                $feet = $_POST['feet'];
                $inches = $feet * 12;
                echo "<p class='result'>$feet feet = $inches inches</p>";
            }
            ?>
        </div>

        <!-- Inches to Feet -->
        <div class="calculator-box">
            <h3>Inches to Feet</h3>
            <form method="POST">
                <label for="inches">Inches:</label>
                <input type="number" id="inches" name="inches" step="0.01" required>
                
                <button type="submit" name="inches_to_feet">Convert</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inches_to_feet'])) {
                $inches = $_POST['inches'];
                $feet = $inches / 12;
                echo "<p class='result'>$inches inches = " . round($feet, 2) . " feet</p>";
            }
            ?>
        </div>

        <!-- Feet to Meters -->
        <div class="calculator-box">
            <h3>Feet to Meters</h3>
            <form method="POST">
                <label for="feet_to_meter">Feet:</label>
                <input type="number" id="feet_to_meter" name="feet_to_meter" step="0.01" required>
                
                <button type="submit" name="feet_to_meter_btn">Convert</button>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feet_to_meter_btn'])) {
                $feet = $_POST['feet_to_meter'];
                $meters = $feet * 0.3048;
                echo "<p class='result'>$feet feet = " . round($meters, 2) . " meters</p>";
            }
            ?>
        </div>
    </div>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
