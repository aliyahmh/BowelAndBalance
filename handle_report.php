<?php
session_start();
require_once 'db_connect.php';

// check if logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

// check if admin (not user)
if ($_SESSION['userType'] !== 'admin') {
    header("Location: index.php?error=unauthorized");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeID = $_POST['recipeID'];
    $reportID = $_POST['reportID'];
    $action = $_POST['action'];

    try {
        if ($action === 'block') {
            // Find creator
            $stmt = $pdo->prepare("SELECT userID FROM recipe WHERE id = ?");
            $stmt->execute([$recipeID]);
            $user = $stmt->fetch();
            $targetUID = $user['userID'];

            // Fetch details for blocked table
            $stmt = $pdo->prepare("SELECT firstName, lastName, emailAddress FROM user WHERE id = ?");
            $stmt->execute([$targetUID]);
            $uDetails = $stmt->fetch();

            // Fetch ALL recipes belonging to this user to capture their media file names before deletion
            $mediaStmt = $pdo->prepare("SELECT photoFileName, videoFilePath FROM recipe WHERE userID = ?");
            $mediaStmt->execute([$targetUID]);
            $userRecipes = $mediaStmt->fetchAll(PDO::FETCH_ASSOC);

            $pdo->beginTransaction();
            
            // Delete associated comments 
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
            
            // Delete all recipes 
            $pdo->prepare("DELETE FROM recipe WHERE userID = ?")->execute([$targetUID]);
            
            $stmt = $pdo->prepare("INSERT INTO blockeduser (firstName, lastName, emailAddress) VALUES (?, ?, ?)");
            $stmt->execute([$uDetails['firstName'], $uDetails['lastName'], $uDetails['emailAddress']]);

            $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$targetUID]);
            $pdo->commit();

            // Clear physical files from the system after database transaction succeeds
            foreach ($userRecipes as $recipe) {
                // Handle Image File Deletion
                if (!empty($recipe['photoFileName'])) {
                    $photoTarget = "uploads/images/" . $recipe['photoFileName'];
                    if (file_exists($photoTarget)) {
                        unlink($photoTarget);
                    }
                }

                // Handle Video File Deletion
                if (!empty($recipe['videoFilePath'])) {
                    if (!str_contains($recipe['videoFilePath'], 'http') && !str_contains($recipe['videoFilePath'], 'youtube')) {
                        $videoTarget = "uploads/videos/" . $recipe['videoFilePath'];
                        if (file_exists($videoTarget)) {
                            unlink($videoTarget);
                        }
                    }
                }
            }
        }

        // Delete the report regardless of action
        $pdo->prepare("DELETE FROM report WHERE id = ?")->execute([$reportID]);

        // Return true to the AJAX call
        header("Content-Type: text/plain"); 
        echo "true";
    } catch (Exception $e) {
        if ($pdo->inTransaction()){
            $pdo->rollBack();
        }
        echo "false: " . $e->getMessage();
    }
}