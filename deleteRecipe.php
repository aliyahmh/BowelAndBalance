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

//  Check recipe's id 
if (isset($_GET['id']) && is_numeric($_GET['id'])) { 
    $recipeID = $_GET['id'];

    try {
        // Fetch recipe details 
        $stmt = $pdo->prepare("SELECT photoFileName, videoFilePath FROM recipe WHERE id = ?"); 
        $stmt->execute([$recipeID]); 
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($recipe) {
            
            $pdo->beginTransaction();

            //Delete all associated data
            $pdo->prepare("DELETE FROM ingredients WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM instructions WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM likes WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM favourites WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM report WHERE recipeID = ?")->execute([$recipeID]);

            //Delete the corresponding recipe in the database
            $pdo->prepare("DELETE FROM recipe WHERE id = ?")->execute([$recipeID]);

           
            $pdo->commit();

            // Delete recipe photo and video from the system
            if (!empty($recipe['photoFileName'])) {
                $photoPath = "uploads/images/" . $recipe['photoFileName'];
                if (file_exists($photoPath)) {
                    unlink($photoPath); 
                }
            }

            // If videoFilePath is a local path 
            if (!empty($recipe['videoFilePath']) && !str_contains($recipe['videoFilePath'], 'youtube.com')) {
                 $videoPath = "uploads/images/" . $recipe['videoFileName'];
                if (file_exists($recipe[$videoPath])) {
                    unlink($recipe['videoFilePath']); 
                }
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error deleting recipe: " . $e->getMessage()); 
    }
}

// Redirects to MyRecipe page
header("Location: MyRecipe.php");
exit(); 
