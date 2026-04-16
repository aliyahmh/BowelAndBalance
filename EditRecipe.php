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
    header("Location: index.php?error=unauthorized");
    exit;
}

// this page checks the recipe ID from query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid recipe ID.");
}

$recipeID = (int) $_GET['id'];
$userID = $_SESSION['userID'];

try {
    // this query gets all categories
    $sqlCategories = "SELECT id, categoryName FROM recipecategory";
    $stmtCategories = $pdo->query($sqlCategories);
    $categories = $stmtCategories->fetchAll();

    // this query gets the recipe information for this logged in user
    $sqlRecipe = "SELECT * FROM recipe WHERE id = ? AND userID = ?";
    $stmtRecipe = $pdo->prepare($sqlRecipe);
    $stmtRecipe->execute([$recipeID, $userID]);
    $recipe = $stmtRecipe->fetch();

    if (!$recipe) {
        die("Recipe not found or you are not allowed to edit it.");
    }

    // this query gets recipe ingredients
    $sqlIngredients = "SELECT * FROM ingredients WHERE recipeID = ? ORDER BY id ASC";
    $stmtIngredients = $pdo->prepare($sqlIngredients);
    $stmtIngredients->execute([$recipeID]);
    $ingredients = $stmtIngredients->fetchAll();

    // this query gets recipe instructions
    $sqlInstructions = "SELECT * FROM instructions WHERE recipeID = ? ORDER BY stepOrder ASC";
    $stmtInstructions = $pdo->prepare($sqlInstructions);
    $stmtInstructions->execute([$recipeID]);
    $instructions = $stmtInstructions->fetchAll();

} catch (PDOException $ex) {
    die("Error: " . $ex->getMessage());
}
?>

<!DOCTYPE html>
<html>

    <head>
     <title>Update Recipe</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="MergedStyle.css">
    </head>

    <body id="bd-body-EditRecipe">

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
        <h1 id="bd-first-heading">Update Recipe</h1>
        <h3 id="bd-second-heading">Update your recipe and add your personal touches</h3>

        <!-- this form sends updated data to update process page -->
        <form id="bd-addRecipeForm" method="post" action="update_recipe_process.php" enctype="multipart/form-data">

        <!-- this hidden input keeps recipe ID -->
        <input type="hidden" name="recipeID" value="<?php echo htmlspecialchars($recipe['id']); ?>">

        <!-- this hidden input keeps old photo file name -->
        <input type="hidden" name="oldPhotoFileName" value="<?php echo htmlspecialchars($recipe['photoFileName'] ?? ''); ?>">

        <!-- this hidden input keeps old video file path -->
        <input type="hidden" name="oldVideoFilePath" value="<?php echo htmlspecialchars($recipe['videoFilePath'] ?? ''); ?>">

        <div id="bd-container1-div">
            <label>Recipe Name:</label>
            <input type="text" id="bd-name" name="name" placeholder="input recipe name" value="<?php echo htmlspecialchars($recipe['name']); ?>">
    
            <label>Category:</label>
            <select id="bd-category" name="categoryID">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo ($category['id'] == $recipe['categoryID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div id="bd-description-div">
            <label>Description:</label>
            <textarea id="bd-description" name="description" rows="2" cols="60"><?php echo htmlspecialchars($recipe['description']); ?></textarea>
        </div>

<div id="bd-container3-div">

<div id="upload-recipe-pic">

  <div class="pic-left">
    <div class="pic-row">
      <label>Upload photo:</label>
      <input type="file"
             id="bd-photoFile"
             name="photoFile"
             accept="image/*">
    </div>
  </div>

  <div class="pic-right">
    <label>Current Picture:</label>

    <?php if (!empty($recipe['photoFileName'])): ?>
      <img id="bd-photoPreview"
           src="uploads/images/<?php echo htmlspecialchars($recipe['photoFileName']); ?>"
           style="display:block;">
    <?php else: ?>
      <img id="bd-photoPreview" style="display:none;">
    <?php endif; ?>
  </div>

</div>

       <div id="bd-ingrediants-div">
  <label>Ingredients:</label>

  <div id="ingredients-list">
    <?php foreach ($ingredients as $ingredient): ?>
      <div class="ingredient-row">
        <input class="ing-name" type="text" name="ingredient_name[]" placeholder="Ingredient name" value="<?php echo htmlspecialchars($ingredient['ingredientName']); ?>">
        <input class="ing-qty" type="text" name="ingredient_quantity[]" placeholder="Quantity" value="<?php echo htmlspecialchars($ingredient['ingredientQuantity']); ?>">
      </div>
    <?php endforeach; ?>
  </div>

  <button type="button" id="bd-addIngre-btn" class="addRecipe-btn">
    Add Another
  </button>
</div>

<div id="bd-instructions-div">

  <label>Instructions:</label>

  <div id="steps-list">
    <?php foreach ($instructions as $instruction): ?>
      <div class="step-row">
        <textarea class="step-text" name="steps[]" rows="2" cols="60" placeholder="Write the step here..."><?php echo htmlspecialchars($instruction['step']); ?></textarea>
      </div>
    <?php endforeach; ?>
  </div>

  <button type="button" id="bd-addStep-btn" class="addStep-btn">
    Add More Step
  </button>

</div>

       <div id="bd-uploadVid-div">
  <div class="vid-left">
    <label>Upload video:</label>
    <input type="file" id="bd-videoFile" name="videoFile" accept="video/*">

    <label>Video URL:</label>
    <textarea id="bd-videoUrl" rows="2" cols="60" placeholder="https://..."></textarea>
  </div>

  <div class="vid-right">
    <label class="currentVidLabel">Current Video:</label>

    <?php if (!empty($recipe['videoFilePath'])): ?>
      <video id="bd-videoPreview" controls style="display:block;">
        <source src="<?php echo htmlspecialchars($recipe['videoFilePath']); ?>">
      </video>
    <?php else: ?>
      <video id="bd-videoPreview" controls style="display:none;"></video>
    <?php endif; ?>
  </div>
</div>

       <button id="bd-updateRecipe-btn" class="updateRecipe-btn" type="submit">Update Recipe</button>
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