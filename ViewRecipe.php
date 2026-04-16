<?php
session_start();
require_once 'db_connect.php'; // Includes the $pdo connection

// check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// check if regular user 
if ($_SESSION['userType'] !== 'user') {
    header("Location: index.php?error=unauthorized");
    exit;
}

//Check recipe ID from query string 
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: MyRecipe.php"); // Redirecting if ID is invalid
    exit();
}

$recipe_id = intval($_GET['id']);
$user_id = $_SESSION['userID']; // Accessing session data 

try {
    // Check if current viewer is Admin 
    $userTypeQuery = $pdo->prepare("SELECT userType FROM user WHERE id = ?");
    $userTypeQuery->execute([$user_id]);
    $current_user = $userTypeQuery->fetch();
    $is_admin = ($current_user['userType'] === 'admin');

    //Retrieve recipe and creator information using JOIN 

    $query = "SELECT r.*, u.firstName, u.lastName, u.photoFileName AS userPhoto, c.categoryName
              FROM recipe r
              JOIN user u ON r.userID = u.id
              JOIN recipecategory c ON r.categoryID = c.id
              WHERE r.id = ?";
    $recipeStatement = $pdo->prepare($query);
    $recipeStatement->execute([$recipe_id]);
    $recipe = $recipeStatement->fetch();

    if (!$recipe) {
        header("Location: MyRecipe.php");
        exit();
    }

    // Logic for button visibility (Not creator and Not admin)
    $is_creator = ($recipe['userID'] == $user_id);
    $show_buttons = (!$is_creator && !$is_admin);

    //Check status for disabling buttons 
    $liked_check = $pdo->prepare("SELECT 1 FROM likes WHERE userID = ? AND recipeID = ?");
    $liked_check->execute([$user_id, $recipe_id]);
    $has_liked = $liked_check->fetch() !== false;

    $fav_check = $pdo->prepare("SELECT 1 FROM favourites WHERE userID = ? AND recipeID = ?");
    $fav_check->execute([$user_id, $recipe_id]);
    $has_favourited = $fav_check->fetch() !== false;

    $rep_check = $pdo->prepare("SELECT 1 FROM report WHERE userID = ? AND recipeID = ?");
    $rep_check->execute([$user_id, $recipe_id]);
    $has_reported = $rep_check->fetch() !== false;

    // Fetch total likes count 
    $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE recipeID = ?");
    $count_stmt->execute([$recipe_id]);
    $likes_count = $count_stmt->fetchColumn();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bowl & Balance - <?php echo $recipe['name']; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="MergedStyle.css"> <style>
            body {
                background-image: url('IMAGES/background.png');
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
    </head>

    <body id="bg">
        <header class="page-header">
            <div class="header-content">
                <div class="header-logo">
                    <img src="IMAGES/logo.png" alt="Logo" class="logo-img">
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
                        <h1 class="rname"><?php echo $recipe['name']; ?></h1>
                        <img id="bowlImg" src="uploads/images/<?php echo $recipe['photoFileName']; ?>" alt="Recipe Image">
                    </div>

                    <div class="flexRow">
                        <h2>By <?php echo $recipe['firstName'] . ' ' . $recipe['lastName']; ?></h2>

                        <?php if ($show_buttons): ?>
                            <div class="interaction-buttons">
                                <button id="fav" onclick="location.href = 'add_favourite.php?id=<?php echo $recipe_id; ?>'" <?php if ($has_favourited) echo 'disabled'; ?>>
                                    <?php echo $has_favourited ? '⭐ Favourited' : '☆ Favourite'; ?>
                                </button>

                                <button id="like" onclick="location.href = 'add_like.php?id=<?php echo $recipe_id; ?>'" <?php if ($has_liked) echo 'disabled'; ?>>
                                    <?php echo $has_liked ? '❤️ Liked' : '🤍 Like'; ?> (<?php echo $likes_count; ?>)
                                </button>

                                <button id="report" onclick="if (confirm('Report this recipe?'))
                                                location.href = 'add_report.php?id=<?php echo $recipe_id; ?>'" <?php if ($has_reported) echo 'disabled'; ?>>
                                            <?php echo $has_reported ? '🚩 Already Reported' : '🚩 Report'; ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="rcategory"><?php echo $recipe['categoryName']; ?></p>
                    <p class="rdescription"><?php echo $recipe['description']; ?></p>

                    <h2 class="j-sectionHeader">Ingredients:</h2>
                    <ul class="j-sectionText" id="indent">
                        <?php
// Fetch and loop through ingredients 
                        $ingredientsQuery = $pdo->prepare("SELECT ingredientName, ingredientQuantity FROM ingredients WHERE recipeID = ?");
                        $ingredientsQuery->execute([$recipe_id]);
                        while ($ingredient = $ingredientsQuery->fetch()):
                            ?>
                            <li><?php echo $ingredient['ingredientQuantity'] . " " . $ingredient['ingredientName']; ?></li>
                        <?php endwhile; ?>
                    </ul>

                    <h2 class="j-sectionHeader">Instructions:</h2>
                    <ol class="j-sectionText" id="indent2">
                        <?php
                        // Fetch and loop through instructions 
                        $instructionsQuery = $pdo->prepare("SELECT step FROM instructions WHERE recipeID = ? ORDER BY stepOrder ASC");
                        $instructionsQuery->execute([$recipe_id]);
                        while ($instruction = $instructionsQuery->fetch()):
                            ?>
                            <li><?php echo $instruction['step']; ?></li>
                        <?php endwhile; ?>
                    </ol>

                    <h2 class="j-sectionHeader">Comments:</h2>
                    <form id="j-form" action="add_comment_process.php" method="POST">
                        <input type="hidden" name="recipeID" value="<?php echo $recipe_id; ?>">
                        <input type="text" name="comment" placeholder="Add a comment.." size="60" id="comment" required>
                        <input type="submit" value="Post" id="post">
                    </form>

                    <div id="comments">
                        <?php
                        // Fetch and display comments 
                        $commentsQuery = $pdo->prepare("SELECT c.comment, c.date, u.firstName FROM comment c JOIN user u ON c.userID = u.id WHERE c.recipeID = ? ORDER BY c.date DESC");
                        $commentsQuery->execute([$recipe_id]);
                        while ($comment = $commentsQuery->fetch()):
                            ?>
                            <div class="flexRow comment-box">
                                <p class="j-sectionText"><strong><?php echo $comment['firstName']; ?>:</strong> <?php echo $comment['comment']; ?></p>
                                <span class="date"><?php echo date('d-m-Y', strtotime($comment['date'])); ?></span>
                            </div>
                        <?php endwhile; ?>
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
                    <p class="footer-copyright">&copy; 2026 Bowl & Balance. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>