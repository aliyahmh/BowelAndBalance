<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeID = $_POST['recipeID'];
    $reportID = $_POST['reportID'];
    $action = $_POST['action'];

    if ($action === 'block') {
        // Find the user associated with this recipe
        $stmt = $pdo->prepare("SELECT userID FROM recipe WHERE id = ?");
        $stmt->execute([$recipeID]);
        $user = $stmt->fetch();
        $targetUID = $user['userID'];

        // Get user details for the blocked table
        $stmt = $pdo->prepare("SELECT firstName, lastName, emailAddress FROM user WHERE id = ?");
        $stmt->execute([$targetUID]);
        $uDetails = $stmt->fetch();

        // Transactional logic: Delete data and move to blockeduser
        $pdo->beginTransaction();
        try {
            // 1. Delete associated data
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);

            // 2. Delete all the user's recipes
            $pdo->prepare("DELETE FROM recipe WHERE userID = ?")->execute([$targetUID]);

            // 3. Add the user to the blockeduser table
            // IMPORTANT: Verify these column names ('name', 'email') in phpMyAdmin
            $stmt = $pdo->prepare("INSERT INTO blockeduser (name, email) VALUES (?, ?)");
            $fullName = $uDetails['firstName'] . ' ' . $uDetails['lastName'];
            $stmt->execute([$fullName, $uDetails['emailAddress']]);

            // 4. Finally, delete the user from the main user table
            $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$targetUID]);

            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            // This will print the exact SQL error to help you debug
            die("Transaction failed: " . $e->getMessage());
        }
    }

    // Delete the report and redirect
    $pdo->prepare("DELETE FROM report WHERE id = ?")->execute([$reportID]);
    header("Location: AdminPage.php");
}
?>