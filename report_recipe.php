<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['userID'])) die(json_encode(['success' => false]));

$recipe_id = $_POST['recipeID'];
$user_id = $_SESSION['userID'];

// Use IGNORE or a check to prevent duplicate reports if your DB constraints allow it
$sql = "INSERT IGNORE INTO report (userID, recipeID) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute([$user_id, $recipe_id]);

echo json_encode(['success' => $success]);