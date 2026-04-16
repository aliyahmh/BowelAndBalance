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

// 1. Requirement: Check recipe's id that is sent in the query string
if (isset($_GET['id']) && is_numeric($_GET['id'])) { 
    $recipeID = $_GET['id'];

    try {
        // Fetch recipe details first to get file paths for deletion
        $stmt = $pdo->prepare("SELECT photoFileName, videoFilePath FROM recipe WHERE id = ?"); 
        $stmt->execute([$recipeID]); 
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($recipe) {
            // Start a transaction to ensure all database deletions succeed together
            $pdo->beginTransaction();

            // 2. Requirement: Delete all associated data
            // Order is important to avoid foreign key constraint issues
            $pdo->prepare("DELETE FROM ingredients WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM instructions WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM likes WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM favourites WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM report WHERE recipeID = ?")->execute([$recipeID]);

            // 3. Requirement: Delete the corresponding recipe in the database
            $pdo->prepare("DELETE FROM recipe WHERE id = ?")->execute([$recipeID]);

            // Commit database changes
            $pdo->commit();

            // 4. Requirement: Delete recipe photo and video from the system
            // Note: Your slides mention storing file locations on the filesystem [cite: 1294, 1299]
            if (!empty($recipe['photoFileName'])) {
                $photoPath = "IMAGES/" . $recipe['photoFileName'];
                if (file_exists($photoPath)) {
                    unlink($photoPath); // Deletes the physical image file
                }
            }

            // If videoFilePath is a local path and not a YouTube link
            if (!empty($recipe['videoFilePath']) && !str_contains($recipe['videoFilePath'], 'youtube.com')) {
                if (file_exists($recipe['videoFilePath'])) {
                    unlink($recipe['videoFilePath']); // Deletes the physical video file
                }
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error deleting recipe: " . $e->getMessage()); 
    }
}

// 5. Requirement: Redirects to the quiz page
header("Location: MyRecipe.php");
exit(); 
?>