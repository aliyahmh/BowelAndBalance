<?php
session_start();

require_once 'db_connect.php';


header('Content-Type: application/json');


// Block access if the user is not logged in as a regular user
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'user') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// Get the selected category from the AJAX request
$selectedCat = isset($_POST['categoryID']) ? $_POST['categoryID'] : '';

// If "View All" was chosen, get all recipes
if ($selectedCat === '') {

    $stmt = $pdo->prepare("
    SELECT 
        r.id,
        r.name,
        r.photoFileName,
        rc.categoryName,
        CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
        u.photoFileName AS creatorPhoto,

        (
            SELECT COUNT(*)
            FROM likes l
            WHERE l.recipeID = r.id
        ) AS totalLikes

    FROM recipe r

    JOIN recipecategory rc ON r.categoryID = rc.id
    JOIN user u ON r.userID = u.id

    ORDER BY r.id DESC
");

    $stmt->execute();
} else {

    // Otherwise filter by the selected category
    $stmt = $pdo->prepare("
    SELECT 
        r.id,
        r.name,
        r.photoFileName,
        rc.categoryName,
        CONCAT(u.firstName, ' ', u.lastName) AS creatorName,
        u.photoFileName AS creatorPhoto,

        (
            SELECT COUNT(*)
            FROM likes l
            WHERE l.recipeID = r.id
        ) AS totalLikes

    FROM recipe r

    JOIN recipecategory rc ON r.categoryID = rc.id
    JOIN user u ON r.userID = u.id

    WHERE r.categoryID = :catID

    ORDER BY r.id DESC
");

    $stmt->execute([':catID' => $selectedCat]);
}

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send the result back to Recipes.php as JSON
echo json_encode($recipes);
?>