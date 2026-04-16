<?php
session_start();
require_once 'db_connect.php';
$recipe_id = $_GET['id'];
$user_id = $_SESSION['userID'];

$sql = "INSERT IGNORE INTO favourites (userID, recipeID) VALUES (?, ?)";
$pdo->prepare($sql)->execute([$user_id, $recipe_id]);

header("Location: ViewRecipe.php?id=" . $recipe_id);
exit();