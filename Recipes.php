<?php
session_start();

// Check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// Check if regular user (not admin)
if ($_SESSION['userType'] !== 'user') {
    header("Location: index.php?error=unauthorized");
    exit;
}


require_once 'db_connect.php';

// Fetch all categories from RecipeCategory table
$catStmt = $pdo->query("SELECT id, categoryName FROM RecipeCategory");
$categories = $catStmt->fetchAll();

// GET vs POST logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $selectedCat = $_POST['categoryID'];

    // If "View All" is selected, categoryID will be empty
    // In that case, skip the WHERE filter and fetch all recipes instead
    if ($selectedCat === '') {

        $stmt = $pdo->query("
            SELECT r.id, r.name, r.photoFileName,
       rc.categoryName,
       CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
       u.photoFileName AS creatorPhoto,
       COUNT(l.recipeID) AS totalLikes
       FROM Recipe r
       JOIN RecipeCategory rc ON r.categoryID = rc.id
       JOIN User u ON r.userID = u.id
       LEFT JOIN Likes l ON l.recipeID = r.id
       GROUP BY r.id, r.name, r.photoFileName, rc.categoryName, u.firstName, u.lastName, u.photoFileName
        ");
    } else {

        // Prepared statement to filter recipes by category
        $stmt = $pdo->prepare("
            SELECT r.id, r.name, r.photoFileName,
       rc.categoryName,
       CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
       u.photoFileName AS creatorPhoto,
       COUNT(l.recipeID) AS totalLikes
FROM Recipe r
JOIN RecipeCategory rc ON r.categoryID = rc.id
JOIN User u ON r.userID = u.id
LEFT JOIN Likes l ON l.recipeID = r.id
WHERE r.categoryID = :catID
GROUP BY r.id, r.name, r.photoFileName, rc.categoryName, u.firstName, u.lastName, u.photoFileName
        ");

        $stmt->execute([':catID' => $selectedCat]);
    }
} else {

    // GET request — retrieve ALL recipes from the database
    $stmt = $pdo->query("
       SELECT r.id, r.name, r.photoFileName,
       rc.categoryName,
       CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
       u.photoFileName AS creatorPhoto,
       COUNT(l.recipeID) AS totalLikes
FROM Recipe r
JOIN RecipeCategory rc ON r.categoryID = rc.id
JOIN User u ON r.userID = u.id
LEFT JOIN Likes l ON l.recipeID = r.id
GROUP BY r.id, r.name, r.photoFileName, rc.categoryName, u.firstName, u.lastName, u.photoFileName
    ");

    $selectedCat = '';
}

// Store all fetched recipes into an array
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Recipes</title>
        <link rel="stylesheet" href="MergedStyle.css">
        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            /* No recipes found message */
            .ar-empty {
                grid-column: 1 / -1;
                text-align: center;
                font-size: 22px;
                font-weight: 800;
                color: rgb(1, 35, 28);
                padding: 40px 50px;
                border-radius: 24px;
                background: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(20px);
                box-shadow: 0 8px 32px rgba(4, 59, 3, 0.12);
                letter-spacing: -0.5px;
            }
        </style>
    </head>

    <body id="ar-body">

        <!-- Header unchanged from Phase 1 -->
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

        <main class="ar-page">

            <header class="ar-top">
                <h1 class="ar-title">Recipes</h1>

                <!-- Filter form submits to the same page using POST -->
                <div class="ar-filter">
                    <form action="" method="POST">

                        <select name="categoryID" id="arCat">

                            <option value="">View All</option>

                            <?php
                            // Loop through categories fetched from the database
                            foreach ($categories as $cat):
                                ?>
                                <option value="<?php echo $cat['id']; ?>"
                                <?php
                                // Keep the selected option highlighted after POST
                                if ($selectedCat == $cat['id']) {
                                    echo 'selected';
                                }
                                ?>
                                        >
                                            <?php echo $cat['categoryName']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                        <button type="submit" id="arGo">Filter</button>

                    </form>
                </div>
            </header>

            <section class="ar-list">

                <?php
// Check if any recipes were returned
                if (count($recipes) === 0):
                    ?>
                    <p class="ar-empty">No recipes found.</p>

                <?php else: ?>

                    <?php
                    // Loop through each recipe and build the HTML card
                    foreach ($recipes as $recipe):
                        ?>

                        <article class="ar-item">
                            <div class="ar-face">

                                <!-- Image from IMAGES folder using photoFileName -->
                                <img class="ar-pic"
                                     src="IMAGES/<?php echo $recipe['photoFileName']; ?>"
                                     alt="<?php echo $recipe['name']; ?>">
                            </div>

                            <h3 class="ar-name"><?php echo $recipe['name']; ?></h3>

                            <div class="ar-pop">
                                <div class="ar-popIn">
                                    <img class="ar-popPic"
                                         src="IMAGES/<?php echo $recipe['photoFileName']; ?>"
                                         alt="">

                                    <p class="ar-line">
                                        <span class="ar-key">Recipe name:</span>

                                        <!-- Link to ViewRecipe.php with the recipe id -->
                                        <a class="ar-popLink"
                                           href="ViewRecipe.php?id=<?php echo $recipe['id']; ?>">
                                               <?php echo $recipe['name']; ?>
                                        </a>
                                    </p>



                                      <!-- Creator -->
                                      <div class="ar-line ar-maker">
                                                  <span class="ar-key">Creator:</span>

                                              <div class="ar-makerContent">
                                                  <img class="ar-makerImg"
                                                       src="IMAGES/<?php echo $recipe['creatorPhoto']; ?>">

                                                  <span><?php echo $recipe['creatorName']; ?></span>
                                              </div>
                                        </div>
                                    <!-- Total likes counted from Likes table -->
                                    <p class="ar-line">
                                        <span class="ar-key">Total likes:</span>
                                        <span class="ar-value"><?php echo $recipe['totalLikes']; ?></span>
                                    </p>

                                    <!-- Category name from RecipeCategory table -->
                                    <p class="ar-line">
                                        <span class="ar-key">Category:</span>
                                        <span class="ar-value"><?php echo $recipe['categoryName']; ?></span>
                                    </p>

                                </div>
                            </div>
                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

            </section>
        </main>

        <!-- Footer unchanged from Phase 1 -->
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