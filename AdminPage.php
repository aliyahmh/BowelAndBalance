<?php
session_start();

// check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// check if regular admin (not user)
if ($_SESSION['userType'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Bowl & Balance | Admin Dashboard</title>
    <link rel="stylesheet" href="MergedStyle.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body id="hr-body">
    <!-- Header -->
    <header class="page-header">
        <div class="header-content">
            <div class="header-logo">
                <img src="IMAGES/logo.png" alt="Bowl & Balance Logo" class="logo-img">
                <span class="logo-text">Bowl & Balance</span>
            </div>
            <div class="header-right">
                <a href="signout_process.php" class="header-signout">Sign Out</a>
            </div>
        </div>
    </header>

    <main>
        <div class="user-container">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <h1 class="welcome-note">Hey there, Aroub!</h1>
                <!-- <p style="font-size: 1.2rem; color: #666; max-width: 800px;">
                Here's your personalized dashboard with all your recipes, favorites, and profile information.
            </p> -->
            </section>

            <!-- Profile Information Section -->
            <section class="hr-profile-section">
                <h2 class="section-title">Profile Information</h2>
                <div class="profile-grid">
                    <!-- Profile Picture -->
                    <img src="IMAGES/layla.jpg" alt="profile picture" class="profile-photo">

                    <!-- Profile Details -->
                    <div class="profile-details">
                        <!-- 1. Name -->
                        <div class="detail-item">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">Aroub Alswayyed</div>
                        </div>

                        <!-- 2. Email Address -->
                        <div class="detail-item">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value">aroub.alswayyed@example.com</div>
                        </div>
                        
                    </div>
                </div>
        </div>
        </section>





        <section class="moderation-feed">
            <h2>Pending Recipe Reports</h2>

            <div class="feed-item">
                <div class="recipe-details">
                    <a href="ViewRecipe.php" class="recipe-link"> Poke Bowl </a>

                </div>

                <div class="creator-info">
                    <img src="IMAGES/Sara.jpg" alt="Creator Photo" class="avatar">
                    <span>By: <strong>Joud BinFaris</strong></span>
                </div>

                <form action="" class="action-form">
                    <div class="radio-group">
                        <label><input type="radio" name="action" checked> Block User</label>
                        <label><input type="radio" name="action"> Dismiss</label>
                    </div>
                    <button type="submit" class="submit-btn">Submit Action</button>
                </form>
            </div>

            <div class="feed-item">
                <div class="recipe-details">
                    <a href="ViewRecipe.php" class="recipe-link">Acai Bowl</a>

                </div>

                <div class="creator-info">
                    <img src="IMAGES/Lina.jpg" alt="Creator Photo" class="avatar">
                    <span>By: <strong>Sara Abdullah</strong></span>
                </div>

                <form action="" class="action-form">
                    <div class="radio-group">
                        <label><input type="radio" name="action" checked> Block User</label>
                        <label><input type="radio" name="action"> Dismiss</label>
                    </div>
                    <button type="submit" class="submit-btn">Submit Action</button>
                </form>
            </div>
            <div class="feed-item">
                <div class="recipe-details">
                    <a href="ViewRecipe.php" class="recipe-link">Chicken Curry </a>

                </div>

                <div class="creator-info">
                    <img src="IMAGES/mona.jpg" alt="Creator Photo" class="avatar">
                    <span>By: <strong>Sami Omar</strong></span>
                </div>

                <form action="" class="action-form">
                    <div class="radio-group">
                        <label><input type="radio" name="action" checked> Block User</label>
                        <label><input type="radio" name="action"> Dismiss</label>
                    </div>
                    <button type="submit" class="submit-btn">Submit Action</button>
                </form>
            </div>
        </section>

        <section class="blocked-list">
            <h2>Blocked Users List</h2>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ahmad Saeed</td>
                        <td>ahmadsaeed@email.com</td>
                    </tr>
                    <tr>
                        <td>Omar Youssef</td>
                        <td>omaryoussef@email.com</td>
                    </tr>
                    <tr>
                        <td>Huda Ibrahim</td>
                        <td>hudaibrahim@email.com</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Footer -->
    <footer class="page-footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="mailto:contact@bowlandbalance.com" class="footer-link">
                        <span class="footer-icon">📧</span>
                        contact@bowlandbalance.com
                    </a>
                    <a href="tel:+966501234567" class="footer-link">
                        <span class="footer-icon">📞</span>
                        +966 50 123 4567
                    </a>
                    <a href="https://x.com/bowlandbalance" target="_blank" class="footer-link">
                        <span class="footer-icon">𝕏</span>
                        @bowlandbalance
                    </a>
                </div>
                <div class="footer-copyright">
                    <p>&copy; 2026 Bowl & Balance. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>