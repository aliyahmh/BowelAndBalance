<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(false); 
    exit;
}


$recipe_id = intval($_POST['id']);
$user_id = $_SESSION['userID'];

$sql = "INSERT IGNORE INTO likes (userID, recipeID) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $recipe_id]);

echo json_encode($stmt->rowCount() > 0);