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
$name = $_POST['name'] ?? '';
$categoryID = $_POST['categoryID'] ?? '';
$description = $_POST['description'] ?? '';

$ingredientNames = $_POST['ingredient_name'] ?? [];
$ingredientQuantities = $_POST['ingredient_quantity'] ?? [];
$steps = $_POST['steps'] ?? [];

// file variables
$photoFileName = null;
$videoFilePath = null;

// HANDLE IMAGE UPLOAD
if (isset($_FILES['photoFile']) && $_FILES['photoFile']['error'] === 0) {
    $photoFileName = time() . "_" . basename($_FILES['photoFile']['name']);
    $target = "uploads/images/" . $photoFileName;
    move_uploaded_file($_FILES['photoFile']['tmp_name'], $target);
}

// HANDLE VIDEO UPLOAD
if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === 0) {
    $videoName = time() . "_" . basename($_FILES['videoFile']['name']);
    $videoFilePath = "uploads/videos/" . $videoName;
    move_uploaded_file($_FILES['videoFile']['tmp_name'], $videoFilePath);
}










try {
    $pdo->beginTransaction();

    // insert recipe
    $sql = "INSERT INTO recipe (userID, categoryID, name, description, photoFileName, videoFilePath)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID, $categoryID, $name, $description, $photoFileName, $videoFilePath]);

    $recipeID = $pdo->lastInsertId();

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
    $pdo->rollBack();
    echo "Error: " . $ex->getMessage();
}
?>