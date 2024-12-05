<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Website</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
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
        <section id="home">
            <h2>Welcome to Fitness Center</h2>
            <p>Your health, our priority. Join us today!</p>
            <button>Get Started</button>
        </section>

        <section id="about">
            <h2>About Us</h2>
            <p>We provide state-of-the-art facilities and personalized training programs.</p>
        </section>

        <section id="services">
            <h2>Our Services</h2>
            <ul>
                <li>Personal Training</li>
                <li>Group Classes</li>
                <li>Dietary Advice</li>
            </ul>
        </section>

        <section id="membership">
            <h2>Membership Plans</h2>
            <p>Choose the plan that fits you best.</p>
        </section>

        <section id="contact">
            <h2>Contact Us</h2>
            <form action="process_form.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Fitness Center. All rights reserved.</p>
    </footer>
</body>
</html>
