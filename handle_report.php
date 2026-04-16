<?php
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

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $recipeID = $_POST['recipeID'];
    $reportID = $_POST['reportID'];
    $action = $_POST['action'];

    if ($action === 'block') {
        try {
            // 1. Identify the user who created the reported recipe
            $stmt = $pdo->prepare("SELECT userID FROM recipe WHERE id = ?");
            $stmt->execute([$recipeID]);
            $user = $stmt->fetch();
            $targetUID = $user['userID'];

            // 2. Fetch user details using your specific column names
            $stmt = $pdo->prepare("SELECT firstName, lastName, emailAddress FROM user WHERE id = ?");
            $stmt->execute([$targetUID]);
            $uDetails = $stmt->fetch();

            $pdo->beginTransaction();

            // 3. Delete associated data
            $pdo->prepare("DELETE FROM comment WHERE recipeID = ?")->execute([$recipeID]);
            
            // 4. Delete all recipes belonging to this user 
            $pdo->prepare("DELETE FROM recipe WHERE userID = ?")->execute([$targetUID]);

            // 5. INSERT into blockeduser using YOUR exact columns: firstName, lastName, emailAddress
            $stmt = $pdo->prepare("INSERT INTO blockeduser (firstName, lastName, emailAddress) VALUES (?, ?, ?)");
            $stmt->execute([
                $uDetails['firstName'], 
                $uDetails['lastName'], 
                $uDetails['emailAddress']
            ]);

            // 6. Delete from main user table
            $pdo->prepare("DELETE FROM user WHERE id = ?")->execute([$targetUID]);
            
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            die("Transaction failed: " . $e->getMessage()); 
        }
    }

    // 7. Delete the report and return to dashboard 
    $pdo->prepare("DELETE FROM report WHERE id = ?")->execute([$reportID]);
    header("Location: AdminPage.php");
    exit();
}
?>