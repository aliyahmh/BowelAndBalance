<?php
session_start();
require_once 'db_connect.php'; // This provides the $pdo connection
// 1. Authentication Check
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// 2. Validate Recipe ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: MyRecipe.php");
    exit();
}

$recipe_id = intval($_GET['id']);
$user_id = $_SESSION['userID'];

try {
    // 3. Fetch Recipe, Creator, and Category details
    // Table: recipe (id, userID, categoryID, name, description, photoFileName, videoFilePath)
    // Table: user (id, firstName, lastName, photoFileName)
    $query = "SELECT r.*, u.firstName, u.lastName, u.photoFileName AS userPhoto, c.categoryName,
              (SELECT COUNT(*) FROM likes WHERE recipeID = r.id) AS likes_count
              FROM recipe r
              JOIN user u ON r.userID = u.id
              JOIN recipecategory c ON r.categoryID = c.id
              WHERE r.id = ?";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();

    if (!$recipe) {
        header("Location: MyRecipe.php");
        exit();
    }

    // 4. Fetch Ingredients
    // Table: ingredients (id, recipeID, ingredientName, ingredientQuantity)
    $ing_stmt = $pdo->prepare("SELECT ingredientName, ingredientQuantity FROM ingredients WHERE recipeID = ? ORDER BY id");
    $ing_stmt->execute([$recipe_id]);
    $ingredients = $ing_stmt->fetchAll();

    // 5. Fetch Instructions
    // Table: instructions (id, recipeID, step, stepOrder)
    $inst_stmt = $pdo->prepare("SELECT step FROM instructions WHERE recipeID = ? ORDER BY stepOrder ASC");
    $inst_stmt->execute([$recipe_id]);
    $instructions = $inst_stmt->fetchAll();

    // 6. Fetch Comments
    // Table: comment (id, recipeID, userID, comment, date)
    $comm_stmt = $pdo->prepare("SELECT c.comment, c.date, u.firstName, u.lastName 
                                FROM comment c 
                                JOIN user u ON c.userID = u.id 
                                WHERE c.recipeID = ? 
                                ORDER BY c.date DESC");
    $comm_stmt->execute([$recipe_id]);
    $comments = $comm_stmt->fetchAll();

    // 7. Check if logged-in user liked or favorited
    $like_stmt = $pdo->prepare("SELECT 1 FROM likes WHERE userID = ? AND recipeID = ?");
    $like_stmt->execute([$user_id, $recipe_id]);
    $user_liked = $like_stmt->fetch() !== false;

    $fav_stmt = $pdo->prepare("SELECT 1 FROM favourites WHERE userID = ? AND recipeID = ?");
    $fav_stmt->execute([$user_id, $recipe_id]);
    $user_favorited = $fav_stmt->fetch() !== false;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bowl & Balance - <?php echo htmlspecialchars($recipe['name']); ?></title>
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

    <body id="bg">
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

        <main>
            <div id="Sheet">
                <div class="container">
                    <div class="flexRow">
                        <h1 class="rname"><?php echo htmlspecialchars($recipe['name']); ?></h1>
<?php
$recipe_img = !empty($recipe['photoFileName']) ? "IMAGES/" . $recipe['photoFileName'] : "IMAGES/default-recipe.png";
?>
                        <img id="bowlImg" src="<?php echo $recipe_img; ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                    </div>

                    <div class="flexRow">
<?php
$creator_img = !empty($recipe['userPhoto']) ? "IMAGES/" . $recipe['userPhoto'] : "IMAGES/profile.png";
?>
                        <h2><img class="j-makerImg" src="<?php echo $creator_img; ?>" alt="Creator"> 
                            By <?php echo htmlspecialchars($recipe['firstName'] . ' ' . $recipe['lastName']); ?>
                        </h2>

                        <div class="interaction-buttons">
                            <button id="like"><?php echo $user_liked ? '❤️ Liked' : '🤍 Like'; ?> (<?php echo $recipe['likes_count']; ?>)</button> 
                            <button id="fav"><?php echo $user_favorited ? '⭐ Favorited' : '☆ Favorite'; ?></button> 
                            <button id="report">🚩 Report</button>
                        </div>
                    </div>

                    <p class="rcategory"><?php echo htmlspecialchars($recipe['categoryName']); ?></p>

                    <p class="rdescription"><?php echo htmlspecialchars($recipe['description']); ?></p>

                    <h2 class="j-sectionHeader">Ingredients:</h2>
                    <ul class="j-sectionText" id="indent">
<?php foreach ($ingredients as $ing): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($ing['ingredientQuantity']); ?></strong> 
    <?php echo htmlspecialchars($ing['ingredientName']); ?>
                            </li>
                            <?php endforeach; ?>
                    </ul>

                    <h2 class="j-sectionHeader">Instructions:</h2>
                    <ol class="j-sectionText" id="indent2">
<?php foreach ($instructions as $inst): ?>
                            <li><?php echo htmlspecialchars($inst['step']); ?></li>
                        <?php endforeach; ?>
                    </ol>

                    <h2 class="j-sectionHeader">Video:</h2>
<?php if (!empty($recipe['videoFilePath'])): ?>
                        <p class="j-sectionText">
                            <a href="<?php echo htmlspecialchars($recipe['videoFilePath']); ?>" target="_blank" style="color: #d35400; font-weight: bold;">
                                ▶ Watch Recipe Tutorial
                            </a>
                        </p>
<?php else: ?>
                        <p class="j-sectionText">No Video Provided.</p>
                    <?php endif; ?>

                    <h2 class="j-sectionHeader">Comments:</h2>
                    <form id="j-form" action="add_comment_process.php" method="POST">
                        <input type="hidden" name="recipeID" value="<?php echo $recipe_id; ?>">
                        <input type="text" name="comment" placeholder="Add a comment.." size="60" id="comment" required>
                        <input type="submit" value="Post" id="post">
                    </form>

                    <div id="comments">
<?php if (empty($comments)): ?>
                            <p class="j-sectionText" style="padding: 10px; color: #777;">Be the first to comment!</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comm): ?>
                                <div class="flexRow" style="margin-bottom: 15px; align-items: flex-start;">
                                    <img class="profile" src="IMAGES/profile.png" alt="User">
                                    <div style="margin-left: 10px;">
                                        <p class="j-sectionText">
                                            <strong><?php echo htmlspecialchars($comm['firstName']); ?>:</strong> 
        <?php echo htmlspecialchars($comm['comment']); ?>
                                        </p>
                                        <span class="date" style="font-size: 0.8em; color: #888;">
        <?php echo date('d-m-Y', strtotime($comm['date'])); ?>
                                        </span>
                                    </div>
                                </div>
    <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>

        <footer class="page-footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-links">
                        <a href="mailto:contact@bowlandbalance.com" class="footer-link">📧 contact@bowlandbalance.com</a>
                        <a href="tel:+966501234567" class="footer-link">📞 +966 50 123 4567</a>
                    </div>
                    <div class="footer-copyright">
                        <p>&copy; 2026 Bowl & Balance. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <script>
// Get IDs from PHP context
const recipeId = <?php echo $recipe_id; ?>;

document.getElementById('like').addEventListener('click', function() {
    fetch('toggle_like.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'recipeID=' + recipeId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.innerHTML = (data.liked ? '❤️ Liked' : '🤍 Like') + ' (' + data.likes_count + ')';
        }
    });
});

document.getElementById('fav').addEventListener('click', function() {
    fetch('toggle_favourite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'recipeID=' + recipeId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.innerText = data.favorited ? '⭐ Favorited' : '☆ Favorite';
        }
    });
});

document.getElementById('report').addEventListener('click', function() {
    if (confirm('Are you sure you want to report this recipe?')) {
        fetch('report_recipe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'recipeID=' + recipeId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Recipe reported.');
                this.innerText = '🚩 Reported';
                this.disabled = true;
            }
        });
    }
});
</script>
    </body>
</html>