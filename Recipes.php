<?php
// put your code here
        
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
                <a href="index.php" class="header-signout">Sign Out</a>
          </div>
      </div>
  </header>
<main class="ar-page">

  <header class="ar-top">
    <h1 class="ar-title">Recipes</h1>
    <div class="ar-filter">
      <select id="arCat">
        <option value="ALL">View All</option>
        <option value="Breakfast">Breakfast</option>
        <option value="Lunch">Lunch</option>
        <option value="Dinner">Dinner</option>
      </select>
      <button id="arGo" type="button">Filter</button>
    </div>
  </header>

  <section class="ar-list">

    <!-- 1 -->
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Acai Bowl_3.png" alt="Acai Bowl">
      </div>
      <h3 class="ar-name">Acai Bowl</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Acai Bowl_3.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Acai Bowl</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/Sara.jpg" alt="">
              <span>Joud BinFaris</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">150</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article>

    <!-- 2 -->
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Berry Yogurt .PNG" alt="Berry Yogurt">
      </div>
      <h3 class="ar-name">Berry Yogurt</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Berry Yogurt .PNG" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Berry Yogurt</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/noor.jpg" alt="">
              <span>Noor Hassan</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">120</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article>

    <!-- 3 -->
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Banana Granola.png" alt="Banana Granola">
      </div>
      <h3 class="ar-name">Banana Granola</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Banana Granola.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Banana Granola</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/ali.jpg" alt="">
              <span>Ali Mohammed</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">210</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article>

    <!-- 4 
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Apple Muesli.png" alt="Apple Muesli">
      </div>
      <h3 class="ar-name">Apple Muesli</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Apple Muesli.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Apple Muesli</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/fahad.jpg" alt="">
              <span>Fahad Khalid</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">185</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article>-->

    <!-- 5 
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Shakshuka.png" alt="Shakshuka">
      </div>
      <h3 class="ar-name">Shakshuka</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Shakshuka.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Shakshuka</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/omar.jpg" alt="">
              <span>Omar Youssef</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">245</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article> -->

    <!-- 6 
    <article class="ar-item" data-cat="Breakfast">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Scrambled Eggs.png" alt="Scrambled Eggs">
      </div>
      <h3 class="ar-name">Scrambled Eggs</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Scrambled Eggs.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Scrambled Eggs</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/layla.jpg" alt="">
              <span>Layla Ahmed</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">178</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Breakfast</span></p>
        </div>
      </div>
    </article> -->

    <!-- 7 -->
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Grilled Chicken Bowl .png" alt="Grilled Chicken Bowl">
      </div>
      <h3 class="ar-name">Grilled Chicken Bowl</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Grilled Chicken Bowl .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Grilled Chicken Bowl</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/reem.jpg" alt="">
              <span>Reem Saleh</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">198</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article>

    <!-- 8 -->
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Bibim.png" alt="Bibimbap">
      </div>
      <h3 class="ar-name">Bibimbap</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Bibim.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Bibimbap</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/saad.jpg" alt="">
              <span>Saad Mansour</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">265</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article>

    <!-- 9 -->
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Copy of Bowl & Balance.png" alt="Poke Bowl">
      </div>
      <h3 class="ar-name">Poke Bowl</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Copy of Bowl & Balance.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Poke Bowl</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/Lina.jpg" alt="">
              <span>Lina Mahmoud</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">254</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article>

    <!-- 10 
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Shrimp Noodles .png" alt="Shrimp Noodles">
      </div>
      <h3 class="ar-name">Shrimp Noodles</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Shrimp Noodles .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Shrimp Noodles</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/khaled.jpg" alt="">
              <span>Khalid Nasser</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">289</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article> -->

    <!-- 11 
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Carbonara .png" alt="Carbonara">
      </div>
      <h3 class="ar-name">Carbonara</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Carbonara .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Carbonara</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/mona.jpg" alt="">
              <span>Mona Rashid</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">312</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article> -->

    <!-- 12 
    <article class="ar-item" data-cat="Lunch">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Salmon Bowl.png" alt="Salmon Bowl">
      </div>
      <h3 class="ar-name">Salmon Bowl</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Salmon Bowl.png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Salmon Bowl</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/yasser.jpg" alt="">
              <span>Yasser Karim</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">225</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Lunch</span></p>
        </div>
      </div>
    </article> -->

    <!-- 13 -->
    <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Chicken Stir-Fry .png" alt="Chicken Stir-Fry">
      </div>
      <h3 class="ar-name">Chicken Stir-Fry</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Chicken Stir-Fry .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Chicken Stir-Fry</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/Tariq.jpg" alt="">
              <span>Tariq Hassan</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">167</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article> 

    <!-- 14 -->
    <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Butter Chicken .png" alt="Butter Chicken">
      </div>
      <h3 class="ar-name">Butter Chicken</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Butter Chicken .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Butter Chicken</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/Faisal.jpg" alt="">
              <span>Faisal Malik</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">294</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article>

    <!-- 15 -->
    <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="IMAGES/Chicken Curry .png" alt="Chicken Curry">
      </div>
      <h3 class="ar-name">Chicken Curry</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="IMAGES/Chicken Curry .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.php">Chicken Curry</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="IMAGES/Sami.jpg" alt="">
              <span>Sami Omar</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">331</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article>

    <!-- 16 
    <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Kung Pao Chicken .png" alt="Kung Pao Chicken">
      </div>
      <h3 class="ar-name">Kung Pao Chicken</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Kung Pao Chicken .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Kung Pao Chicken</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/Moha.jpg" alt="">
              <span>Mohammed Fahad</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">203</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article> -->

    <!-- 17 
    <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Pasta Bolognese .png" alt="Pasta Bolognese">
      </div>
      <h3 class="ar-name">Pasta Bolognese</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Pasta Bolognese .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Pasta Bolognese</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/Ahmed.jpg" alt="">
              <span>Ahmed Saeed</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">276</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article> -->

    <!-- 18 


     <article class="ar-item" data-cat="Dinner">
      <div class="ar-face">
        <img class="ar-pic" src="../IMAGES/Kimchi Greens .png" alt="Kimchi Greens">
      </div>
      <h3 class="ar-name">Kimchi Greens</h3>

      <div class="ar-pop">
        <div class="ar-popIn">
          <img class="ar-popPic" src="../IMAGES/Kimchi Greens .png" alt="">
          <p class="ar-line">
            <span class="ar-key">Recipe name:</span>
            <a class="ar-popLink" href="ViewRecipe.html">Kimchi Greens</a>
          </p>
          <div class="ar-line ar-maker">
            <span class="ar-key">Creator:</span>
            <div class="ar-makerContent">
              <img class="ar-makerImg" src="../IMAGES/huda.jpg" alt="">
              <span>Huda Ibrahim</span>
            </div>
          </div>
          <p class="ar-line"><span class="ar-key">Total likes:</span><span class="ar-value">142</span></p>
          <p class="ar-line"><span class="ar-key">Category:</span><span class="ar-value">Dinner</span></p>
        </div>
      </div>
    </article> -->

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
</body>
</html>

