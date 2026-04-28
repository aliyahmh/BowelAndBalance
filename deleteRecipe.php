<?php
session_start();
require_once 'db_connect.php';

// check if logged in
if (!isset($_SESSION['userID'])) {
    echo "false";
    exit;
}

// check if regular user 
if ($_SESSION['userType'] !== 'user') {
    echo "false";
    exit;
}

// Check recipe's id from AJAX POST
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo "false";
    exit;
}

$recipeID = $_POST['id'];
$userID = $_SESSION['userID'];

try {
    // Fetch recipe details and make sure it belongs to this user
    $stmt = $pdo->prepare("SELECT photoFileName, videoFilePath FROM recipe WHERE id = ? AND userID = ?");
    $stmt->execute([$recipeID, $userID]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        echo "false";
        exit;
    }

    $pdo->beginTransaction();

    // Delete all associated data
    $pdo->prepare("DELETE FROM ingredients WHERE recipeID = ?")->execute([$recipeID]);
    $pdo->prepare("DELETE FROM instructions WHERE recipeID = ?")->execute([$recipeID]);
    $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
    $pdo->prepare("DELETE FROM likes WHERE recipeID = ?")->execute([$recipeID]);
    $pdo->prepare("DELETE FROM favourites WHERE recipeID = ?")->execute([$recipeID]);
    $pdo->prepare("DELETE FROM report WHERE recipeID = ?")->execute([$recipeID]);

    // Delete the recipe
    $pdo->prepare("DELETE FROM recipe WHERE id = ? AND userID = ?")->execute([$recipeID, $userID]);

    $pdo->commit();

    // Delete recipe photo
    if (!empty($recipe['photoFileName'])) {
        $photoPath = "uploads/images/" . $recipe['photoFileName'];
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
    }

    // Delete local video file only, not YouTube/link videos
    if (!empty($recipe['videoFilePath']) && str_starts_with($recipe['videoFilePath'], "uploads/videos/")) {
        if (file_exists($recipe['videoFilePath'])) {
            unlink($recipe['videoFilePath']);
        }
    }

    echo "true";
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "false";
    exit;
}
?>