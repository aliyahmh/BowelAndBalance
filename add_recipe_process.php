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

// allow only POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: AddNewRecipe.php");
    exit;
}

// get user ID from session
$userID = $_SESSION['userID'];

// get form data
$name = trim($_POST['name'] ?? '');
$categoryID = $_POST['categoryID'] ?? '';
$description = trim($_POST['description'] ?? '');
$videoUrl = trim($_POST['videoUrl'] ?? '');

$ingredientNames = $_POST['ingredient_name'] ?? [];
$ingredientQuantities = $_POST['ingredient_quantity'] ?? [];
$steps = $_POST['steps'] ?? [];

// validate category
if ($categoryID === '' || !is_numeric($categoryID)) {
    die("You must select a category.");
}

$categoryID = (int) $categoryID;

// file variables
$photoFileName = "";
$videoFilePath = "";

try {
    $pdo->beginTransaction();

    // insert recipe first without files, so we can get recipe ID
    $sql = "INSERT INTO recipe (userID, categoryID, name, description, photoFileName, videoFilePath)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID, $categoryID, $name, $description, $photoFileName, $videoFilePath]);

    $recipeID = $pdo->lastInsertId();

    // HANDLE IMAGE UPLOAD AFTER GETTING RECIPE ID
    if (isset($_FILES['photoFile']) && $_FILES['photoFile']['error'] === 0) {
        $photoExt = strtolower(pathinfo($_FILES['photoFile']['name'], PATHINFO_EXTENSION));
        $photoFileName = "recipe_" . $recipeID . "_user_" . $userID . "_photo_" . time() . "." . $photoExt;

        $photoTarget = "uploads/images/" . $photoFileName;
        move_uploaded_file($_FILES['photoFile']['tmp_name'], $photoTarget);
    }

    // HANDLE VIDEO FILE UPLOAD AFTER GETTING RECIPE ID
    if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === 0) {
        $videoExt = strtolower(pathinfo($_FILES['videoFile']['name'], PATHINFO_EXTENSION));
        $videoFilePath = "recipe_" . $recipeID . "_user_" . $userID . "_video_" . time() . "." . $videoExt;

        $videoTarget = "uploads/videos/" . $videoFilePath;
        move_uploaded_file($_FILES['videoFile']['tmp_name'], $videoTarget);
    }
    // IF NO FILE, SAVE VIDEO URL
    elseif ($videoUrl !== '') {
        $videoFilePath = $videoUrl;
    }

    // update recipe with file names only
    $sqlUpdateFiles = "UPDATE recipe 
                       SET photoFileName = ?, videoFilePath = ? 
                       WHERE id = ? AND userID = ?";
    $stmtUpdateFiles = $pdo->prepare($sqlUpdateFiles);
    $stmtUpdateFiles->execute([$photoFileName, $videoFilePath, $recipeID, $userID]);

    // insert ingredients
    $sqlIng = "INSERT INTO ingredients (recipeID, ingredientName, ingredientQuantity)
               VALUES (?, ?, ?)";
    $stmtIng = $pdo->prepare($sqlIng);

    for ($i = 0; $i < count($ingredientNames); $i++) {
        $ingName = trim($ingredientNames[$i]);
        $ingQty = trim($ingredientQuantities[$i] ?? '');

        if ($ingName !== '') {
            $stmtIng->execute([$recipeID, $ingName, $ingQty]);
        }
    }

    // insert instructions
    $sqlStep = "INSERT INTO instructions (recipeID, step, stepOrder)
                VALUES (?, ?, ?)";
    $stmtStep = $pdo->prepare($sqlStep);

    for ($i = 0; $i < count($steps); $i++) {
        $stepText = trim($steps[$i]);

        if ($stepText !== '') {
            $stmtStep->execute([$recipeID, $stepText, $i + 1]);
        }
    }

    $pdo->commit();

    header("Location: MyRecipe.php");
    exit;

} catch (PDOException $ex) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Error: " . $ex->getMessage();
}
?>