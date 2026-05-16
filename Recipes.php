<?php
session_start();

// Make sure user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// Only regular users can access this page
if ($_SESSION['userType'] !== 'user') {
    header("Location: index.php?error=unauthorized");
    exit;
}

require_once 'db_connect.php';

// Get all categories for the dropdown
$catStmt = $pdo->query("SELECT id, categoryName FROM recipecategory");
$categories = $catStmt->fetchAll();

// Load all recipes when the page first opens (newest first)
$stmt = $pdo->prepare("
    SELECT 
        r.id,
        r.name,
        r.photoFileName,
        rc.categoryName,
        CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
        u.photoFileName AS creatorPhoto,
        (
            SELECT COUNT(*)
            FROM likes l
            WHERE l.recipeID = r.id
        ) AS totalLikes
    FROM recipe r
    JOIN recipecategory rc ON r.categoryID = rc.id
    JOIN user u ON r.userID = u.id
    ORDER BY r.id DESC
");

$stmt->execute();
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Recipes</title>
        <link rel="stylesheet" href="MergedStyle.css">

        <!-- jQuery for AJAX -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            /* Message shown when no recipes match the filter */
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
                
                .ar-top{
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    width:100%;
                }
            
        </style>
</head>
        
    <body id="ar-body">

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

        
            <main class="ar-page">

                     <header class="ar-top">
            
                <h1 class="ar-title">Recipes</h1>
                
                <!-- Category dropdown - AJAX runs automatically when changed -->
                <div class="ar-filter">

                    <form id="filterForm">

                        <select name="categoryID" id="arCat">
                            <option value="">View All</option>

                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo $cat['categoryName']; ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </form>

</div>
            
</header>
            <!-- Recipes are shown here. AJAX will refill this section -->
            <section class="ar-list" id="recipesList">

                <?php if (count($recipes) === 0): ?>
                    <p class="ar-empty">No recipes found.</p>
                <?php else: ?>
                    <?php foreach ($recipes as $recipe): ?>

                        <article class="ar-item">
                            <div class="ar-face">
                                <img class="ar-pic"
                                     src="uploads/images/<?php echo $recipe['photoFileName']; ?>"
                                     alt="<?php echo $recipe['name']; ?>">
                            </div>

                            <h3 class="ar-name"><?php echo $recipe['name']; ?></h3>

                            <div class="ar-pop">
                                <div class="ar-popIn">
                                    <img class="ar-popPic"
                                         src="uploads/images/<?php echo $recipe['photoFileName']; ?>"
                                         alt="">

                                    <p class="ar-line">
                                        <span class="ar-key">Recipe name:</span>
                                        <a class="ar-popLink"
                                           href="ViewRecipe.php?id=<?php echo $recipe['id']; ?>">
                                               <?php echo $recipe['name']; ?>
                                        </a>
                                    </p>

                                    <div class="ar-line ar-maker">
                                        <span class="ar-key">Creator:</span>
                                        <div class="ar-makerContent">
                                            <img class="ar-makerImg"
                                                 src="uploads/images/<?php echo $recipe['creatorPhoto']; ?>">
                                            <span><?php echo $recipe['creatorName']; ?></span>
                                        </div>
                                    </div>

                                    <p class="ar-line">
                                        <span class="ar-key">Total likes:</span>
                                        <span class="ar-value"><?php echo $recipe['totalLikes']; ?></span>
                                    </p>

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
     
        <script>
            $(document).ready(function () {

                // When the dropdown value changes, send AJAX request
                $('#arCat').on('change', function () {

                    var selectedCat = $(this).val();

                    $.ajax({
                        url: 'filter.php',
                        type: 'POST',
                        data: {categoryID: selectedCat},
                        dataType: 'json',
                        success: function (response) {

                            var $list = $('#recipesList');
                            $list.empty();

                            // Handle unauthorized response from the server
                            if (response.error) {
                                $list.html('<p class="ar-empty">' + response.error + '</p>');
                                return;
                            }

                            // No recipes in this category (or invalid response)
                            if (!Array.isArray(response) || response.length === 0) {
                                $list.html('<p class="ar-empty">No recipes found.</p>');
                                return;
                            }

                            // cards
                            $.each(response, function (i, recipe) {

                                var card = '<article class="ar-item">' +
                                        '<div class="ar-face">' +
                                        '<img class="ar-pic" src="uploads/images/' + recipe.photoFileName + '" alt="' + recipe.name + '">' +
                                        '</div>' +
                                        '<h3 class="ar-name">' + recipe.name + '</h3>' +
                                        '<div class="ar-pop">' +
                                        '<div class="ar-popIn">' +
                                        '<img class="ar-popPic" src="uploads/images/' + recipe.photoFileName + '" alt="">' +
                                        '<p class="ar-line">' +
                                        '<span class="ar-key">Recipe name:</span>' +
                                        '<a class="ar-popLink" href="ViewRecipe.php?id=' + recipe.id + '">' + recipe.name + '</a>' +
                                        '</p>' +
                                        '<div class="ar-line ar-maker">' +
                                        '<span class="ar-key">Creator:</span>' +
                                        '<div class="ar-makerContent">' +
                                        '<img class="ar-makerImg" src="uploads/images/' + recipe.creatorPhoto + '">' +
                                        '<span>' + recipe.creatorName + '</span>' +
                                        '</div>' +
                                        '</div>' +
                                        '<p class="ar-line">' +
                                        '<span class="ar-key">Total likes:</span>' +
                                        '<span class="ar-value">' + recipe.totalLikes + '</span>' +
                                        '</p>' +
                                        '<p class="ar-line">' +
                                        '<span class="ar-key">Category:</span>' +
                                        '<span class="ar-value">' + recipe.categoryName + '</span>' +
                                        '</p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</article>';

                                $list.append(card);
                            });
                        },
                        error: function () {
                            alert('Error loading recipes. Please try again.');
                        }
                    });
                });
            });
        </script>
    </body>
    </html>