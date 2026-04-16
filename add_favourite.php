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

$recipe_id = $_GET['id'];
$user_id = $_SESSION['userID'];

$sql = "INSERT IGNORE INTO favourites (userID, recipeID) VALUES (?, ?)";
$pdo->prepare($sql)->execute([$user_id, $recipe_id]);

header("Location: ViewRecipe.php?id=" . $recipe_id);
exit();