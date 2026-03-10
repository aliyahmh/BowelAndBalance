<?php
// put your code here
        
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bowl & Balance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="MergedStyle.css">
    <script src="js/img.js"></script>

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
        <form action="" method="POST" class="auth-form" id="signup-form">
            <h1>Create Account</h1>


            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="file-upload-section">
                <label id="file-upload-label" for="profile-img">
                    <span class="icon-wrapper">
                        <i class="fas fa-image main-icon"></i>
                        <i class="fas fa-plus badge-icon"></i>
                    </span>
                </label>

                <div class="form-group">
                    <label for="file-upload"> Profile Image: </label>
                    <input id="file-upload" name="file-upload" type="text" placeholder="Chossen File" readonly>
                    <input type="file" id="profile-img" accept="image/*"><br>
                </div>

            </div>

            <button type="submit" class="auth-button" id="sign-submit">Sign Up</button>

            <p class="auth-link">
                Already have an account? <a href="login.php">Login here</a>
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