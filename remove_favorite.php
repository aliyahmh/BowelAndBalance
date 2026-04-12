<?php
session_start();
require_once 'db_connect.php';

// Check if ID is sent and user is logged in
if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_SESSION['userID'])) {
    $recipeID = $_GET['id'];
    $userID = $_SESSION['userID'];

    try {
        $stmt = $pdo->prepare("DELETE FROM favourites WHERE recipeID = ? AND userID = ?");
        $stmt->execute([$recipeID, $userID]);
    } catch (PDOException $e) {
        die("Error removing favorite: " . $e->getMessage());
    }
}

// Redirect back to user's page
header("Location: UserPage.php");
exit();
?>