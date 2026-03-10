<?php
// put your code here
        
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Bowl & Balance</title>
    <link rel="stylesheet" href="MergedStyle.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

    </style>
    
</head>

<body id="al-body">
   <!-- Header -->
     <header class="page-header">
      <div class="header-content">
          <div class="header-logo">
              <img src="IMAGES/logo.png" alt="Bowl & Balance Logo" class="logo-img">
              <span class="logo-text">Bowl & Balance</span>
          </div>
          <div class="header-right">
              <nav class="header-nav">
                  <a href="UserPage.php" class="nav-link">Home</a>
                  <a href="Recipes.php" class="nav-link">Recipes</a>
                  <a href="MyRecipe.php" class="nav-link">My Recipes</a>
              </nav>
              <a href="index.php" class="header-signout">Sign Out</a>
          </div>
      </div>
  </header>

    <div class="user-container">
        <!-- Welcome Section -->
        <section class="welcome-section">
            <h1 class="welcome-note">Hey there, Sarah!</h1>
        </section>

        <!-- Profile Information Section -->
        <section class="profile-section">
        <h2 class="section-title">Profile Information</h2>
        <div class="profile-grid">
            <!-- Profile Picture -->
            <img src="IMAGES/Sara.jpg" alt="profile picture" class="profile-photo">
            
            <!-- Profile Details -->
            <div class="profile-details">
                <!-- 1. Name -->
                <div class="detail-item">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">Sarah Mohammed</div>
                </div>
                
                <!-- 2. Email Address -->
                <div class="detail-item">
                    <div class="detail-label">Email Address</div>
                    <div class="detail-value">sarah.mohammed@example.com</div>
                </div>
                
                <!-- 3. Member Since -->
                <div class="detail-item">
                    <div class="detail-label">Member Since</div>
                    <div class="detail-value">March 15, 2023</div>
                </div>
            </div>
        </div>
    </section>

        <!-- My Recipes Section -->
        <section class="up-stats">
            <h2 class="section-title"><a href="MyRecipe.html" class="my-recipes">My Recipes</a></h2>
            <div class="stats-grid">
                <div class="up-stat-card">
                    <div class="up-stat-icon"><img src="IMAGES/book.png" alt=""></div>
                    <div class="up-stat-content">
                        <span class="up-stat-label">My Recipes</span>
                        <span class="up-stat-number">4</span>
                    </div>
                    <a href="MyRecipe.php" class="up-stat-link">View All</a>
                </div>
                <div class="up-stat-card">
                    <div class="up-stat-icon"><img src="IMAGES/heart.png" alt=""></div>
                    <div class="up-stat-content">
                        <span class="up-stat-label">Total Likes</span>
                        <span class="up-stat-number">102</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Favorites Section -->
        <section class="favorites-section">
            <h2 class="section-title">My Favorite Recipes</h2>
            <table class="favorites-table">
                <thead>
                    <tr>
                        <th>Recipe Name</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a href="ViewRecipe.php" class="recipe-name-link">Acai Bowl</a>
                            <div style="font-size: 0.9rem; color: rgba(3, 59, 47, 0.9);; margin-top: 5px;">Breakfast • 150 likes</div>
                        </td>
                        <td>
                            <img src="IMAGES/Acai Bowl_3.png" alt="Acai Bowl" class="recipe-photo">
                        </td>
                        <td>
                            <a href="#" class="remove-link">Remove from Favorites</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="ViewRecipe.php" class="recipe-name-link">Berry Yogurt</a>
                            <div style="font-size: 0.9rem; color: rgba(3, 59, 47, 0.9);; margin-top: 5px;">Breakfast • 120 likes</div>
                        </td>
                        <td>
                            <img src="IMAGES/Berry Yogurt .PNG" alt="Berry Yogurt" class="recipe-photo">
                        </td>
                        <td>
                            <a href="#" class="remove-link">Remove from Favorites</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="ViewRecipe.php" class="recipe-name-link">Grilled Chicken Bowl</a>
                            <div style="font-size: 0.9rem; color:rgba(3, 59, 47, 0.9);; margin-top: 5px;">Lunch • 198 likes</div>
                        </td>
                        <td>
                            <img src="IMAGES/Grilled Chicken Bowl .png" alt="Grilled Chicken Bowl" class="recipe-photo">
                        </td>
                        <td>
                            <a href="#" class="remove-link">Remove from Favorites</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="ViewRecipe.php" class="recipe-name-link">Butter Chicken</a>
                            <div style="font-size: 0.9rem; color: rgba(3, 59, 47, 0.9);; margin-top: 5px;">Dinner • 294 likes</div>
                        </td>
                        <td>
                            <img src="IMAGES/Butter Chicken .png" alt="Butter Chicken" class="recipe-photo">
                        </td>
                        <td>
                            <a href="#" class="remove-link">Remove from Favorites</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

       
        
    </div>


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
