<?php
// put your code here
        
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
                <a href="index.php" class="header-signout">Sign Out</a>
          </div>
      </div>
  </header>










        <main id="bd-page1">
        <h1 id="bd-first-heading">Update Recipe</h1>
        <h3 id="bd-second-heading">Update your recipe and add your personal touches</h3>

        <form id="bd-addRecipeForm" method="get" action="AddNewRecipe.php">
        <div id="bd-container1-div">
            <label>Recipe Name:</label>
            <input type="text" id="bd-name" name="name" placeholder="input recipe name" value="Berry Yogurt">
    
            <label>Category:</label>
            <select id="bd-category" name="bd-category">
                <option selected>BreakFast</option>
                <option >Lunch</option>
                <option>Dinner</option>
            </select>
        </div>
        
        <div id="bd-description-div">
            <label>Description:</label>
            <textarea id="bd-description" rows="2" cols="60">Berry Yogurt Bowl is a refreshing and nutritious blend of creamy yogurt topped with fresh mixed berries. It combines the natural sweetness of strawberries, blueberries, and raspberries with smooth, protein-rich yogurt to create a light yet satisfying meal. This bowl is perfect for breakfast or a healthy snack, offering a balance of flavor, texture, and energy in every bite.</textarea>
        </div>

<div id="bd-container3-div">

<div id="upload-recipe-pic">

  <div class="pic-left">
    <div class="pic-row">
      <label>Upload photo:</label>
      <input type="file"
             id="bd-photoFile"
             name="upload-recipe-pic"
             accept="image/*">
    </div>
  </div>

  <div class="pic-right">
    <label>Current Picture:</label>

    <img id="bd-photoPreview"
         src="IMAGES/Berry Yogurt .png"
         style="display:block;">
  </div>

</div>





       
        
       

       <div id="bd-ingrediants-div">
  <label>Ingredients:</label>

  <div id="ingredients-list">
    <!-- هنا بتنضاف الخانات -->
  </div>

  <button type="button" id="bd-addIngre-btn" class="addRecipe-btn">
    Add Another
  </button>
</div>


<div id="bd-instructions-div">

  <label>Instructions:</label>

  <div id="steps-list">
    <!-- هنا تنضاف الخطوات -->
  </div>

  <button type="button" id="bd-addStep-btn" class="addStep-btn">
    Add More Step
  </button>

</div>


       <div id="bd-uploadVid-div">
  <div class="vid-left">
    <label>Upload video:</label>
    <input type="file" id="bd-videoFile" accept="video/*">

    <label>Video URL:</label>
    <textarea id="bd-videoUrl" rows="2" cols="60" placeholder="https://..."></textarea>
  </div>

  <div class="vid-right">
    <label class="currentVidLabel">Current Video:</label>
    <video id="bd-videoPreview" controls style="display:none;"></video>
  </div>
</div>

       <button id="bd-updateRecipe-btn" class="updateRecipe-btn">Update Recipe</button>
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
