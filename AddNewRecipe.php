<?php
session_start();

// include database connection
require 'db_connect.php';

// check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// check if regular user (not admin)
if ($_SESSION['userType'] !== 'user') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// get recipe categories from database
try {
    $sql = "SELECT id, categoryName FROM recipecategory";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll();
} catch (PDOException $ex) {
    $categories = [];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Recipe</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="MergedStyle.css">
</head>

<body id="bd-body-AddRecipe">

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

    <main id="bd-page1">

        <!-- the heading of the page -->
        <h1 id="bd-first-heading">Add New Recipe</h1>
        <h3 id="bd-second-heading">Reach out and we will get in touch within 24 hours,</h3>

        <!-- recipe form -->
        <!-- changed method to POST -->
        <!-- changed action to process page -->
        <!-- added enctype because the form contains file upload -->
        <form id="bd-addRecipeForm" method="post" action="add_recipe_process.php" enctype="multipart/form-data">

            <div id="bd-container1-div">
                <label>Recipe Name:</label>

                <!-- added name so PHP can receive the recipe name -->
                <input type="text" id="bd-name" name="name" placeholder="input recipe name">

                <label>Category:</label>

                <!-- categories are loaded dynamically from RecipeCategory table -->
                <select id="bd-category" name="categoryID">
                    <option value="">Select Category</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="bd-description-div">
                <label>Description:</label>

                <!-- added name so PHP can receive the description -->
                <textarea id="bd-description" name="description" rows="2" cols="60"></textarea>
            </div>

            <div id="bd-container3-div">
                <div id="upload-recipe-pic">

                    <div class="pic-left">
                        <label>Upload photo:</label>

                        <!-- changed name for photo upload -->
                        <input type="file" id="bd-photoFile" name="photoFile" accept="image/*">
                    </div>

                    <div class="pic-right">
                        <label>Current Picture:</label>
                        <img id="bd-photoPreview" style="display:none;">
                    </div>

                </div>

                <div id="bd-ingrediants-div">
                    <label>Ingredients:</label>

                    <div id="ingredients-list">
                        <!-- default ingredient inputs -->
                        <div class="ingredient-row">
                            <input type="text" name="ingredient_name[]" placeholder="Ingredient name">
                            <input type="text" name="ingredient_quantity[]" placeholder="Quantity">
                        </div>
                    </div>

                    <button type="button" id="bd-addIngre-btn" class="addRecipe-btn">
                        Add Another
                    </button>
                </div>

                <div id="bd-instructions-div">

                    <label>Instructions:</label>

                    <div id="steps-list">
                        <!-- default instruction input -->
                        <div class="step-row">
                            <textarea name="steps[]" rows="2" cols="60" placeholder="Write the step here"></textarea>
                        </div>
                    </div>

                    <button type="button" id="bd-addStep-btn" class="addRecipe-btn">
                        Add More Step
                    </button>

                </div>

                <div id="bd-uploadVid-div">
                    <div class="vid-left">
                        <label>Upload video:</label>

                        <!-- added name for video upload -->
                        <input type="file" id="bd-videoFile" name="videoFile" accept="video/*">

                        <label>Video URL:</label>
                        <textarea id="bd-videoUrl" rows="2" cols="60" placeholder="https://..."></textarea>
                    </div>

                    <div class="vid-right">
                        <label class="currentVidLabel">Current Video:</label>
                        <video id="bd-videoPreview" controls style="display:none;"></video>
                    </div>
                </div>
            </div>

            <button id="bd-addRecipe-btn" class="addRecipe-btn" type="submit">Add Recipe</button>
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

    <script src="js/JavaScriptFile.js"></script>

</body>

</html>