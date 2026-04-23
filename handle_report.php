<?php
session_start();
require_once 'db_connect.php';

// Authorization checks
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'admin') {
    die("false");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeID = $_POST['recipeID'];
    $reportID = $_POST['reportID'];
    $action = $_POST['action'];

    try {
        if ($action === 'block') {
            // Find creator
            $stmt = $pdo->prepare("SELECT userID FROM recipe WHERE id = ?");
            $stmt->execute([$recipeID]);
            $user = $stmt->fetch();
            $targetUID = $user['userID'];

            // Fetch details for blocked table
            $stmt = $pdo->prepare("SELECT firstName, lastName, emailAddress FROM user WHERE id = ?");
            $stmt->execute([$targetUID]);
            $uDetails = $stmt->fetch();

            $pdo->beginTransaction();
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
            $pdo->prepare("DELETE FROM recipe WHERE userID = ?")->execute([$targetUID]);
            
            $stmt = $pdo->prepare("INSERT INTO blockeduser (firstName, lastName, emailAddress) VALUES (?, ?, ?)");
            $stmt->execute([$uDetails['firstName'], $uDetails['lastName'], $uDetails['emailAddress']]);

            $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$targetUID]);
            $pdo->commit();
        }

        // Delete the report regardless of action
        $pdo->prepare("DELETE FROM report WHERE id = ?")->execute([$reportID]);

        // Return true to the AJAX call
        header("Content-Type: text/plain"); 
        echo "true";
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo "false: " . $e->getMessage();
    }
}
?>