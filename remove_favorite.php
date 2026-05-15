<?php

session_start();
require_once 'db_connect.php';

// check if logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false]);
    exit;
}

// check if regular user 
if ($_SESSION['userType'] !== 'user') {
    echo json_encode(['success' => false]);
    exit;
}

// Check if ID is sent and user is logged in
if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_SESSION['userID'])) {
    $recipeID = $_GET['id'];
    $userID = $_SESSION['userID'];

    try {
        $stmt = $pdo->prepare("DELETE FROM favourites WHERE recipeID = ? AND userID = ?");
        $stmt->execute([$recipeID, $userID]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}

exit();
