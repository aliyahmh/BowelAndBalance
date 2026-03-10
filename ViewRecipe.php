<?php
// put your code here
        
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bowl & Balance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url(MergedStyle.css);
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body id ="bg">
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




    <main>

        <div id="Sheet">
            <div class="container">

                <div class="flexRow">
                    <h1 class="rname">Poke Bowl Recipe</h1>

                    <img id=bowlImg src="IMAGES/Copy of Bowl & Balance.png" alt="Poke Bowl">
                </div>



                <div class="flexRow">
                    <h2><img class="j-makerImg" src="IMAGES/Sara.jpg" alt=""> By Joud BinFaris</h2>

                    <button id="like">Like</button> <button id="fav">Favorite</button> <button
                        id="report">Report</button>
                </div>


                <p class="rcategory">Lunch</p>

                <p class="rdescription">This easy Poke Bowl Recipe is packed
                    with sushi-grade ahi tuna seasoned with
                    soy, honey, and plenty of sesame. It's
                    served with sticky white rice and tons of
                    veggies. </p>
                <h2 class="j-sectionHeader">Ingredients:</h2>
                <ul class="j-sectionText" id="indent">
                    <li>1 lb sushi-grade ahi tuna</li>
                    <li>2 tbsp soy sauce</li>
                    <li>1 tbsp sesame oil</li>
                    <li>1 tbsp rice vinegar</li>
                    <li>1 tsp honey</li>
                    <li>4 cups cooked white rice</li>
                    <li>1 cup diced cucumber</li>
                    <li>1/2 cup shelled edamame</li>
                    <li>1 tbsp black sesame seeds</li>
                    <li>2 large avocados, peeled and sliced</li>

                </ul>
                <h2 class="j-sectionHeader">Instructions:</h2>
                <ol class="j-sectionText" id="indent2">
                    <li>Use a sharp knife to cut tuna into a dice. Add tuna, soy sauce, sesame oil,
                        rice vinegar, and honey to a medium bowl. Toss to combine. Let the tuna sit
                        while you prepare the rest of the ingredients.</li>
                    <li>Add mayo and sriracha to a bowl. Stir to combine.
                        Season with salt and pepper. Soon into a ziplock bag.
                        Cut the tip off.</li>
                    <li>Divide cooked rice between four bowls. Spoon tuna on one part of the rice.
                        Surround with a pile of the cucumber, edamae, and carrot. Spread half of an
                        avocado on top of the bowl. Drizzle the spicy mayo over the bowl. Sprinle with
                        green onon and sesame seeds.</li>

                </ol>
                <h2 class="j-sectionHeader">Video:</h2>
                <p class="j-sectionText">No Video Provided.</p>
                <h2 class="j-sectionHeader">Comments:</h2>
                <form id="j-form">
                    <input type="text" name="comment" placeholder="Add a comment.." size="60" id="comment" required>
                    <input type="submit" value="Post" id="post">
                </form>
                <div id="comments">
                    <div class="flexRow"  ><img class="profile" src="IMAGES/profile.png" alt="">
                        <p class="j-sectionText">User234452: so yummy.</p><span class=date>7-1-2026</span>
                    </div>
                    <div class="flexRow"  ><img class="profile" src="IMAGES/profile.png" alt="">
                        <p class="j-sectionText">User912736: 10/10.</p><span class=date>24-12-2025</span>
                    </div>
                    <div class="flexRow"  ><img  class="profile" src="IMAGES/profile.png" alt="">
                        <p class="j-sectionText">User492038: I used salmon instead. recommended.</p><span class=date>10-11-2025</span>
                    </div>



                </div>

            </div>





        </div>
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