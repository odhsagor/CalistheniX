<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalistheniX Fitness Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="images/CalistheniX.png" alt="Fitness Center Logo" class="logo-img">
    </div>
    <nav>
        <ul>
            <li><a href="#about">Home</a></li>
            <li><a href="#about">About</a></li>
            <li class="dropdown">
                <a href="#joinAs">JOIN AS</a>
                <ul class="dropdown-menu">
                    <li><a href="member_registration.php">Member</a></li>
                    <li><a href="trainer_login.php">Trainer</a></li>
                    <li><a href="nutritionist_login.php">Nutritionist</a></li>
                </ul>
            </li>
            <li><a href="authority_login.php">Authority</a></li>
        </ul>
    </nav>
</header>

<main>
    <!-- Slider Section -->
    <section class="slider">
        <div class="slides">
            <img src="images/2.png" alt="Fitness 1">
            <img src="images/2.png" alt="Fitness 2">
            <img src="images/2.png" alt="Fitness 3">
        </div>
    </section>

    <!-- Discount Section -->
    <section class="discount">
        <h2>Special Offer</h2>
        <p>Join today and get <strong>10% OFF</strong> on your first month!</p>
        <a href="member_registration.php" class="btn">Claim Offer</a>
    </section>

    <!-- Gym Photos Section -->
    <section class="gym-photos">
        <h2>Our Facilities</h2>
        <div class="photo-grid">
            <img src="images/01.png" alt="Gym Photo 1">
            <img src="images/02.png" alt="Gym Photo 2">
            <img src="images/03.png" alt="Gym Photo 3">
            <img src="images/04.png" alt="Gym Photo 4">
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> CalistheniX Fitness Center. All rights reserved.</p>
</footer>
</body>
</html>
