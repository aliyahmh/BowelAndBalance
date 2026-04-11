<?php
session_start();

// Check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// Check if regular user (not admin)
if ($_SESSION['userType'] !== 'user') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Database connection
require_once 'db_connect.php';

// Retrieve all recipes belonging to the logged-in user
$userID = $_SESSION['userID'];

$stmt = $pdo->prepare("SELECT * FROM Recipe WHERE userID = ?");
$stmt->execute([$userID]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get the like count for a given recipe
function getLikeCount(PDO $pdo, int $recipeID): int {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Likes WHERE recipeID = ?");
    $stmt->execute([$recipeID]);
    return (int) $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html>

    <head>
        <title>My Recipes</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="MergedStyle.css">

        <style>
            /* Empty state message */
            #bd-no-recipes-msg {
                text-align: center;
                font-size: 1.2rem;
                font-weight: 600;
                color: rgb(1, 35, 28);
                margin: 60px auto;
                padding: 30px 40px;
                background: rgba(255, 255, 255, 0.35);
                backdrop-filter: blur(10px);
                border-radius: 18px;
                box-shadow: 0 6px 18px rgba(3, 59, 47, 0.1);
                max-width: 500px;
                font-family: 'Inter', system-ui, sans-serif;
            }
        </style>
    </head>

    <body id="bd-bodyMyRecipe">

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

        <h1 id="bd-third-heading">Here where you can check your recipes:</h1>

        <main id="bd-page2">

            <a href="AddNewRecipe.php" id="bd-addRecipe-link-btn">Add New Recipe</a>

            <?php if (empty($recipes)): ?>

                <p id="bd-no-recipes-msg">
                    You have not added any recipes yet.<br> Click "Add New Recipe" to get started!
                </p>

            <?php else: ?>

                <table>
                    <thead>
                        <tr>
                            <td>Recipe</td>
                            <td>Ingredients</td>
                            <td>Instructions</td>
                            <td>Video</td>
                            <td>Number of Likes</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        foreach ($recipes as $recipe):
                            $recipeID = $recipe['id'];
                            $likeCount = getLikeCount($pdo, $recipeID);

                            // Fetch ingredients for this recipe
                            $ingStmt = $pdo->prepare("SELECT * FROM Ingredients WHERE recipeID = ?");
                            $ingStmt->execute([$recipeID]);
                            $ingredients = $ingStmt->fetchAll(PDO::FETCH_ASSOC);

                            // Fetch instructions for this recipe
                            $insStmt = $pdo->prepare("SELECT * FROM Instructions WHERE recipeID = ? ORDER BY stepOrder ASC");
                            $insStmt->execute([$recipeID]);
                            $instructions = $insStmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <tr>

                                <!-- Recipe Name & Photo -->
                                <td>
                                    <a href="ViewRecipe.php?id=<?= htmlspecialchars($recipeID) ?>">
                                                <?= htmlspecialchars($recipe['name']) ?>
                                    </a>
                                    <a href="ViewRecipe.php?id=<?= htmlspecialchars($recipeID) ?>">
                                        <img class="bd-MyRecipePhoto"
                                             src="IMAGES/<?= htmlspecialchars($recipe['photoFileName']) ?>"
                                             alt="<?= htmlspecialchars($recipe['name']) ?>">
                                    </a>
                                </td>

                                <!-- Ingredients -->
                                <td>
                                    <ol>
                                        <?php foreach ($ingredients as $ingredient): ?>
                                            <li><?= htmlspecialchars($ingredient['ingredientName']) ?>, <?= htmlspecialchars($ingredient['ingredientQuantity']) ?></li>
        <?php endforeach; ?>
                                    </ol>
                                </td>

                                <!-- Instructions -->
                                <td>
                                    <ol>
                                        <?php foreach ($instructions as $instruction): ?>
                                            <li><?= htmlspecialchars($instruction['step']) ?></li>
        <?php endforeach; ?>
                                    </ol>
                                </td>

                                <!-- Video -->
                                <td>
        <?php if (!empty($recipe['videoFilePath'])): ?>
                                        <a class="bd-MyRecipeVideo"
                                           href="<?= htmlspecialchars($recipe['videoFilePath']) ?>"
                                           target="_blank">
                                            Watch Video
                                        </a>
                                    <?php else: ?>
                                        <span>No video</span>
        <?php endif; ?>
                                </td>

                                <!-- Number of Likes -->
                                <td><?= $likeCount ?></td>

                                <!-- Edit -->
                                <td>
                                    <a class="bd-edit-btn"
                                       href="EditRecipe.php?id=<?= htmlspecialchars($recipeID) ?>">
                                        Edit
                                    </a>
                                </td>

                                <!-- Delete -->
                                <td>
                                    <a class="bd-delete-btn"
                                       href="deleteRecipe.php?id=<?= htmlspecialchars($recipeID) ?>"
                                       onclick="return confirm('Are you sure you want to delete this recipe?')">
                                        Delete
                                    </a>
                                </td>

                            </tr>

    <?php endforeach; ?>

                    </tbody>
                </table>

<?php endif; ?>

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