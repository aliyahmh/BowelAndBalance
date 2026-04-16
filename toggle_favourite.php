<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['userID'])) die(json_encode(['success' => false]));

$recipe_id = $_POST['recipeID'];
$user_id = $_SESSION['userID'];

$stmt = $pdo->prepare("SELECT 1 FROM favourites WHERE userID = ? AND recipeID = ?");
$stmt->execute([$user_id, $recipe_id]);
$exists = $stmt->fetch();

if ($exists) {
    $pdo->prepare("DELETE FROM favourites WHERE userID = ? AND recipeID = ?")->execute([$user_id, $recipe_id]);
    $favorited = false;
} else {
    $pdo->prepare("INSERT INTO favourites (userID, recipeID) VALUES (?, ?)")->execute([$user_id, $recipe_id]);
    $favorited = true;
}

echo json_encode(['success' => true, 'favorited' => $favorited]);
