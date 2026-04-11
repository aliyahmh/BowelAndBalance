<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


require_once 'db_connect.php';

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
// Retrive Admin info
$adminID = $_SESSION['userID'];
try {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->bindValue(':id', $adminID);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching admin info: " . $e->getMessage());
}

// Retrieve Reports and Blocked Users
try {
    $reportSQL = "SELECT r.*, rec.name AS recipeName, u.firstName, u.lastName, u.photoFileName
                  FROM report r 
                  JOIN recipe rec ON r.recipeID = rec.id 
                  JOIN user u ON rec.userID = u.id";
    $reports = $pdo->query($reportSQL)->fetchAll(PDO::FETCH_ASSOC);
    $blockedUsers = $pdo->query("SELECT * FROM blockeduser")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Data retrieval error: " . $e->getMessage());
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
                    <h1 class="welcome-note">Hey there, <?php echo $admin['firstName']; ?>!</h1>
                    <!-- <p style="font-size: 1.2rem; color: #666; max-width: 800px;">
                    Here's your personalized dashboard with all your recipes, favorites, and profile information.
                </p> -->
                </section>

                <!-- Profile Information Section -->
                <section class="hr-profile-section">
                    <h2 class="section-title">Profile Information</h2>
                    <div class="profile-grid">
                        <!-- Profile Picture -->
                        <img src="IMAGES/<?php echo $admin['photoFileName']; ?>" alt="profile picture" class="profile-photo">

                        <!-- Profile Details -->
                        <div class="profile-details">
                            <!-- 1. Name -->
                            <div class="detail-item">
                                <div class="detail-label">Full Name</div>
                                <div class="detail-value"><?php echo $admin['firstName'] . " " . $admin['lastName']; ?></div>
                            </div>

                            <!-- 2. Email Address -->
                            <div class="detail-item">
                                <div class="detail-label">Email Address</div>
                                <div class="detail-value"><?php echo $admin['emailAddress']; ?></div>
                            </div>

                        </div>
                    </div>
            </div>
        </section>





        <section class="moderation-feed">
            <h2>Pending Recipe Reports</h2>

            <?php if (empty($reports)): ?>
                <p>No pending reports at this time.</p>
            <?php else: ?>
                <?php foreach ($reports as $report): ?>
                    <div class="feed-item">
                        <div class="recipe-details">
                            <a href="ViewRecipe.php?id=<?php echo $report['recipeID']; ?>" class="recipe-link">
                                <?php echo $report['recipeName']; ?>
                            </a>
                        </div>

                        <div class="creator-info">
                            <img src="IMAGES/<?php echo $report['photoFileName']; ?>" alt="Creator Photo" class="avatar">
                            <span>By: <strong><?php echo $report['firstName'] . " " . $report['lastName']; ?></strong></span>
                        </div>

                        <form action="handle_report.php" method="POST" class="action-form">
                            <input type="hidden" name="recipeID" value="<?php echo $report['recipeID']; ?>">
                            <input type="hidden" name="reportID" value="<?php echo $report['id']; ?>">

                            <div class="radio-group">
                                <label><input type="radio" name="action" value="block" checked> Block User</label>
                                <label><input type="radio" name="action" value="dismiss"> Dismiss</label>
                            </div>
                            <button type="submit" class="submit-btn">Submit Action</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
                    <?php foreach ($blockedUsers as $user): ?>
                        <tr>
                            <td><?php echo $user['firstName']; ?></td>
                            <td><?php echo $user['emailAddress']; ?></td>
                        </tr>
                    <?php endforeach; ?>
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