<?php
session_start();

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
?>

<!DOCTYPE html>
<html>

    <head>
     <title>My Recipes</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="MergedStyle.css">
    </head>

    <body id="bd-bodyMyRecipe" >






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

       <table>
<thead>
<td>Recipe</td>
<td>Ingrediants</td>
<td>Instructions</td>
<td>Video</td>
<td>Number of Likes</td>
<td>Edit</td>
<td>Delete</td>
</thead>

<tbody>

<!-- Row 1 -->
<tr>
  <td >
    <a href="ViewRecipe.php">Acai Bowl</a>
    <a href="ViewRecipe.php"> <img class="bd-MyRecipePhoto" src="IMAGES/Recipe_3.png"></a>
  </td>

  <td>
    <ol>
      <li>Milk, 1/2 cup</li>
      <li>Banana, 1</li>
      <li>Acai, 100g</li>
    </ol>
  </td>

  <td>
    <ol>
      <li>Blend ingredients</li>
      <li>Pour mixture</li>
      <li>Add toppings</li>
      <li>Serve fresh</li>
    </ol>
  </td>

  <td>
    <a class="bd-MyRecipeVideo" href="https://youtu.be/SVxNvsaxAPU?si=AINa3l8e-kAEH3Sc">Acai video</a>
  </td>

  <td>150</td>

  <td><a class="bd-edit-btn" href="EditRecipe.php">Edit</a></td>

  <td><a  class="bd-delete-btn"href="MyRecipe.php">Delete</a></td>
</tr>


<!-- Row 2 -->
<tr>
  <td>
    <a href="ViewRecipe.php">Berry Yogurt</a>
      <a href="ViewRecipe.php"> <img  class="bd-MyRecipePhoto" src="IMAGES/Berry Yogurt .png"></a>
  </td>

  <td>
    <ol>
      <li>Yogurt, 1 cup</li>
      <li>Berries, 1/2 cup</li>
      <li>Honey, 1 tbsp</li>
    </ol>
  </td>

  <td>
    <ol>
      <li>Add yogurt</li>
      <li>Add berries</li>
      <li>Drizzle honey</li>
      <li>Serve cold</li>
    </ol>
  </td>

  <td>
    <a  class="bd-MyRecipeVideo" href="https://youtube.com/shorts/1ufsZRS4rn8?si=il2qnwnm_G3U0_MX">Berry video</a>
  </td>

  <td>120</td>

  <td><a class="bd-edit-btn"  href="EditRecipe.php">Edit</a></td>

  <td><a class="bd-delete-btn" href="MyRecipe.php">Delete</a></td>
</tr>


<!-- Row 3 -->
<tr>
  <td>
    <a href="ViewRecipe.php">Banana Granola</a>
    <a href="ViewRecipe.php"> <img  class="bd-MyRecipePhoto" src="IMAGES/Recipe_2.png"></a>
  </td>

  <td>
    <ol>
      <li>Banana, 2</li>
      <li>Milk, 1 cup</li>
      <li>Ice, few cubes</li>
    </ol>
  </td>

  <td>
    <ol>
      <li>Add banana</li>
      <li>Add milk</li>
      <li>Blend well</li>
      <li>Serve cold</li>
    </ol>
  </td>

  <td>
    <a class="bd-MyRecipeVideo" href="https://youtube.com/shorts/a-jysd75NyM?si=Pw733UCemOlYTI7i">Smoothie video</a>
  </td>

  <td>200</td>

  <td><a class="bd-edit-btn" href="EditRecipe.php">Edit</a></td>

  <td><a  class="bd-delete-btn" href="MyRecipe.php">Delete</a></td>
</tr>


<!-- Row 4 -->
<tr>
  <td>
    <a href="ViewRecipe.php">Chicken Curry </a>
    <a href="ViewRecipe.php"> <img class="bd-MyRecipePhoto" src="IMAGES/Recipe_1.png"></a>
  </td>

  <td>
    <ol>
      <li>Chicken, 1 plate</li>
      <li>Cream , 1/2 cup</li>
      <li>Curry sauce, 2 cups</li>
    </ol>
  </td>

  <td>
    <ol>
      <li>Cook Chicken</li>
      <li>Add Cream</li>
      <li>Add Curry cauce</li>
      <li>Serve it </li>
    </ol>
  </td>

  <td>
    <a  class="bd-MyRecipeVideo"href="https://youtube.com/shorts/uEjzv8y7XuY?si=VvjN-qyWDxN6oMfk">Chicken curry video</a>
  </td>

  <td>130</td>

  <td><a class="bd-edit-btn" href="EditRecipe.php">Edit</a></td>

  <td><a  class="bd-delete-btn"href="MyRecipe.php">Delete</a></td>
</tr>

</tbody>

       </table>

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
