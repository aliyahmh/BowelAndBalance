<?php
session_start();

// checking if user is logged in at all
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// checking if they're the right type
if ($_SESSION['userType'] !== 'user') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// fetching their data
$userID = $_SESSION['userID'];
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowl & Balance | Homepage</title>
    <link rel="stylesheet" href="MergedStyle.css">
    <style>
        /* General Setup */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body id="home-body">

    <header>
        <nav class="home-head">
            <div class="home-head-container">
                <div class="logo-area">
                    <img src="IMAGES/logo.png" alt="Logo" class="main-logo">
                    <span class="app-name">Bowl & Balance</span>
                </div>

                <div class="home-contact-container">
                    <a href="mailto:contact@bowlandbalance.com" class="home-contact">
                        <span class="home-icon">📧</span>
                    </a>
                    <a href="tel:+966501234567" class="home-contact">
                        <span class="home-icon">📞</span>
                    </a>
                    <a href="https://x.com/bowlandbalance" target="_blank" class="home-contact">
                        <span class="home-icon">𝕏</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="hero-container">

        <section class="hero-card glass">
            <div class="hero-content">
                <h1 class="fade-in">Healthy Eating, <br><span class="highlight">Perfectly Balanced.</span></h1>
                <p class="hero-subtitle">Your journey to a tastier, healthier lifestyle starts with a single bowl.</p>

                <div class="action-area">
                    <a href="login.php" class="btn-login">Log-in to Explore</a>
                    <p class="signup-text">New User? <a href="SignUp.php">Sign-up here</a></p>
                </div>
            </div>
        </section>
    </main>

    <footer class="home-footer">
        <p>© 2026 Bowl & Balance. All rights reserved.</p>
    </footer>

</body>

</html>
