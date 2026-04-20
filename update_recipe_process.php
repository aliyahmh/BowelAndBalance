<?php
session_start();

// include database connection
require 'db_connect.php';

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

// this page only accepts POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: MyRecipe.php");
    exit;
}

// get logged in user ID
$userID = $_SESSION['userID'];

// get form data
$recipeID = $_POST['recipeID'] ?? '';
$name = trim($_POST['name'] ?? '');
$categoryID = $_POST['categoryID'] ?? '';
$description = trim($_POST['description'] ?? '');
$videoUrl = trim($_POST['videoUrl'] ?? '');

// get ingredients and instructions arrays
$ingredientNames = $_POST['ingredient_name'] ?? [];
$ingredientQuantities = $_POST['ingredient_quantity'] ?? [];
$steps = $_POST['steps'] ?? [];

// get old file values
$oldPhotoFileName = $_POST['oldPhotoFileName'] ?? '';
$oldVideoFilePath = $_POST['oldVideoFilePath'] ?? '';

// validate recipe ID
if (empty($recipeID) || !is_numeric($recipeID)) {
    die("Invalid recipe ID.");
}

// validate category
if ($categoryID === '' || !is_numeric($categoryID)) {
    die("You must select a category.");
}

$recipeID = (int) $recipeID;
$categoryID = (int) $categoryID;

// keep old files by default
$newPhotoFileName = $oldPhotoFileName;
$newVideoFilePath = $oldVideoFilePath;

try {
    // this query checks if the recipe belongs to the logged in user
    $sqlCheck = "SELECT * FROM recipe WHERE id = ? AND userID = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$recipeID, $userID]);
    $recipe = $stmtCheck->fetch();

    if (!$recipe) {
        die("Recipe not found or you are not allowed to update it.");
    }

    // this part handles new photo upload
    if (isset($_FILES['photoFile']) && $_FILES['photoFile']['error'] === 0) {
        $newPhotoFileName = time() . "_" . basename($_FILES['photoFile']['name']);
        $photoTargetPath = "uploads/images/" . $newPhotoFileName;

        if (move_uploaded_file($_FILES['photoFile']['tmp_name'], $photoTargetPath)) {
            if (!empty($oldPhotoFileName)) {
                $oldPhotoPath = "uploads/images/" . $oldPhotoFileName;
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
        }
    }

    // this part handles new video file upload
    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === 0) {
        $videoFileName = time() . "_" . basename($_FILES['videoFile']['name']);
        $newVideoFilePath = "uploads/videos/" . $videoFileName;

        if (move_uploaded_file($_FILES['videoFile']['tmp_name'], $newVideoFilePath)) {
            if (!empty($oldVideoFilePath) && str_starts_with($oldVideoFilePath, 'uploads/videos/') && file_exists($oldVideoFilePath)) {
                unlink($oldVideoFilePath);
            }
        }
    }
    // if no new file but user entered a URL, save the URL
    elseif ($videoUrl !== '') {
        $newVideoFilePath = $videoUrl;
    }

    $pdo->beginTransaction();

    // update recipe main information
    $sqlUpdateRecipe = "UPDATE recipe
                        SET categoryID = ?, name = ?, description = ?, photoFileName = ?, videoFilePath = ?
                        WHERE id = ? AND userID = ?";
    $stmtUpdateRecipe = $pdo->prepare($sqlUpdateRecipe);
    $stmtUpdateRecipe->execute([
        $categoryID,
        $name,
        $description,
        $newPhotoFileName,
        $newVideoFilePath,
        $recipeID,
        $userID
    ]);

    // delete old ingredients
    $sqlDeleteIngredients = "DELETE FROM ingredients WHERE recipeID = ?";
    $stmtDeleteIngredients = $pdo->prepare($sqlDeleteIngredients);
    $stmtDeleteIngredients->execute([$recipeID]);

    // insert updated ingredients
    $sqlInsertIngredient = "INSERT INTO ingredients (recipeID, ingredientName, ingredientQuantity)
                            VALUES (?, ?, ?)";
    $stmtInsertIngredient = $pdo->prepare($sqlInsertIngredient);

    for ($i = 0; $i < count($ingredientNames); $i++) {
        $ingredientName = trim($ingredientNames[$i]);
        $ingredientQuantity = trim($ingredientQuantities[$i] ?? '');

        if ($ingredientName !== '') {
            $stmtInsertIngredient->execute([$recipeID, $ingredientName, $ingredientQuantity]);
        }
    }

    // delete old instructions
    $sqlDeleteInstructions = "DELETE FROM instructions WHERE recipeID = ?";
    $stmtDeleteInstructions = $pdo->prepare($sqlDeleteInstructions);
    $stmtDeleteInstructions->execute([$recipeID]);

    // insert updated instructions
    $sqlInsertInstruction = "INSERT INTO instructions (recipeID, step, stepOrder)
                             VALUES (?, ?, ?)";
    $stmtInsertInstruction = $pdo->prepare($sqlInsertInstruction);

    for ($i = 0; $i < count($steps); $i++) {
        $stepText = trim($steps[$i]);
        $stepOrder = $i + 1;

        if ($stepText !== '') {
            $stmtInsertInstruction->execute([$recipeID, $stepText, $stepOrder]);
        }
    }

    $pdo->commit();

    header("Location: MyRecipe.php");
    exit;

} catch (PDOException $ex) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Error: " . $ex->getMessage());
}
?>