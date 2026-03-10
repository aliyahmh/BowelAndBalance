<?php
// put your code here
        
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bowl & Balance | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="MergedStyle.css">
    <script src="js/sub.js"></script>
    
</head>

<body id="auth-body">

    <!-- Header -->
    <header class="page-header">
        <div class="header-content">
            <div class="header-logo">
                <img src="IMAGES/logo.png" alt="Bowl & Balance Logo" class="logo-img">
                <span class="logo-text">Bowl & Balance</span>
            </div>

        </div>
    </header>

    <main class="auth-container">
        <form action="" method="POST" class="auth-form" id="login-form">
            <h1>Login</h1>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="auth-button" id="user-submit">User</button>
            <button type="submit" class="auth-button" id="admin-submit">Admin</button>

            <p class="auth-link">
                Don't have an account? <a href="signup.html">Sign up here</a>
            </p>
        </form>
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