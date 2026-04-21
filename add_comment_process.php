<?php
session_start();
require_once 'db_connect.php';


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

//Check if the form was actually submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $recipe_id = intval($_POST['recipeID']);
    $user_id = $_SESSION['userID'];
    $comment_text = trim($_POST['comment']);
    $current_date = date('Y-m-d H:i:s');

    // Only proceed if the comment isn't empty
    if (!empty($comment_text)) {
        try {
            //  Insert into the comment table
            //  columns: recipeID, userID, comment, date
            $sql = "INSERT INTO comment (recipeID, userID, comment, date) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$recipe_id, $user_id, $comment_text, $current_date]);

            // 4. Redirect back to the recipe page
            header("Location: ViewRecipe.php?id=" . $recipe_id);
            exit();

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        // If empty, just go back
        header("Location: ViewRecipe.php?id=" . $recipe_id);
        exit();
    }
} else {
    // If someone tries to access this file directly, send them home
    header("Location: UserPage.php");
    exit();
}

