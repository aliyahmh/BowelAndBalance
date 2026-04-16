<?php
session_start();

require_once 'db_connect.php'; 

// check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// check if regular user 
if ($_SESSION['userType'] !== 'user') {
    header("Location: index.php?error=unauthorized");
    exit;
}

$userID = $_SESSION['userID'];

try {
// Retrieve user's information and photo
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

// Retrieve totals (Number of recipes and total likes)
// Total recipes
    $recipeCountStmt = $pdo->prepare("SELECT COUNT(*) FROM recipe WHERE userID = ?");
    $recipeCountStmt->execute([$userID]);
    $totalRecipes = $recipeCountStmt->fetchColumn();

// Total likes for ALL user's recipes
    $likesStmt = $pdo->prepare("SELECT COUNT(l.recipeID) 
                                FROM likes l 
                                JOIN recipe r ON l.recipeID = r.id 
                                WHERE r.userID = ?");
    $likesStmt->execute([$userID]);
    $totalLikes = $likesStmt->fetchColumn();

// Retrieve favorites
   $favStmt = $pdo->prepare("SELECT r.id, r.name, r.photoFileName, c.categoryName, 
                              COUNT(l.recipeID) AS recipeLikes
                              FROM favourites f 
                              JOIN recipe r ON f.recipeID = r.id 
                              JOIN recipecategory c ON r.categoryID = c.id 
                              LEFT JOIN likes l ON r.id = l.recipeID
                              WHERE f.userID = ?
                              GROUP BY r.id, r.name, r.photoFileName, c.categoryName");
    $favStmt->execute([$userID]);
    $favorites = $favStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
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
                <a href="signout_process.php" class="header-signout">Sign Out</a>
            </div>
        </div>
    </header>

    <div class="user-container">
        <!-- Welcome Section -->
        <section class="welcome-section">
            <h1 class="welcome-note">Hey there, <?php echo htmlspecialchars($user['firstName']); ?>!</h1>
        </section>

        <!-- Profile Information Section -->
        <section class="profile-section">
            <h2 class="section-title">Profile Information</h2>
            <div class="profile-grid">
                <!-- Profile Picture -->
                <img src="uploads/images/<?php echo htmlspecialchars($user['photoFileName']); ?>" alt="profile picture" class="profile-photo">

                <!-- Profile Details -->
                <div class="profile-details">
                    <!-- 1. Name -->
                    <div class="detail-item">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value"><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></div>
                    </div>

                    <!-- 2. Email Address -->
                    <div class="detail-item">
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value"><?php echo htmlspecialchars($user['emailAddress']); ?></div>
                    </div>

                </div>
            </div>
        </section>

        <!-- My Recipes Section -->
        <section class="up-stats">
            <h2 class="section-title"><a href="MyRecipe.php" class="my-recipes">My Recipes</a></h2>
            <div class="stats-grid">
                <div class="up-stat-card">
                    <div class="up-stat-icon"><img src="IMAGES/book.png" alt=""></div>
                    <div class="up-stat-content">
                        <span class="up-stat-label">My Recipes</span>
                        <span class="up-stat-number"><?php echo $totalRecipes; ?></span>
                    </div>
                    <a href="MyRecipe.php" class="up-stat-link">View All</a>
                </div>
                <div class="up-stat-card">
                    <div class="up-stat-icon"><img src="IMAGES/heart.png" alt=""></div>
                    <div class="up-stat-content">
                        <span class="up-stat-label">Total Likes</span>
                        <span class="up-stat-number"><?php echo $totalLikes; ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Favorites Section -->
        <section class="favorites-section">
            <h2 class="section-title">My Favorite Recipes</h2>
            <?php if (empty($favorites)): ?>
                <p id="bd-no-recipes-msg">You do not have any favorites yet. Start exploring recipes!</p>
            <?php else: ?>
                <table class="favorites-table">
                    <thead>
                        <tr>
                            <th>Recipe Name</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($favorites as $fav): ?>
                            <tr>
                                <td>
                                    <a href="ViewRecipe.php?id=<?php echo $fav['id']; ?>" class="recipe-name-link">
                                        <?php echo htmlspecialchars($fav['name']); ?>
                                    </a>
                                    <div style="font-size: 0.9rem; color: rgba(3, 59, 47, 0.9); margin-top: 5px;">
                                        <?php echo htmlspecialchars($fav['categoryName']); ?>  • 
                                        <?php echo $fav['recipeLikes']; ?> likes
                                    </div>
                                </td>
                                <td>
                                    <img src="IMAGES/<?php echo htmlspecialchars($fav['photoFileName']); ?>" alt="<?php echo htmlspecialchars($fav['name']); ?>" class="recipe-photo">
                                </td>
                                <td>
                                    <a href="remove_favorite.php?id=<?php echo $fav['id']; ?>" 
                                       class="remove-link" 
                                       onclick="return confirm('Remove this recipe from favorites?');">
                                        Remove from Favorites
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
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
