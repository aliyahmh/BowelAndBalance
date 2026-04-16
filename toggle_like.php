<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['userID'])) die(json_encode(['success' => false]));

$recipe_id = $_POST['recipeID'];
$user_id = $_SESSION['userID'];

// Check if already liked
$stmt = $pdo->prepare("SELECT 1 FROM likes WHERE userID = ? AND recipeID = ?");
$stmt->execute([$user_id, $recipe_id]);
$exists = $stmt->fetch();

if ($exists) {
    $pdo->prepare("DELETE FROM likes WHERE userID = ? AND recipeID = ?")->execute([$user_id, $recipe_id]);
    $liked = false;
} else {
    $pdo->prepare("INSERT INTO likes (userID, recipeID) VALUES (?, ?)")->execute([$user_id, $recipe_id]);
    $liked = true;
}

// Get new count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE recipeID = ?");
$stmt->execute([$recipe_id]);
$count = $stmt->fetchColumn();

echo json_encode(['success' => true, 'liked' => $liked, 'likes_count' => $count]);
