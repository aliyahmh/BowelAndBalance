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

// Build the query - add WHERE clause only if a category was chosen
$sql = "
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
";

if ($selectedCat !== '') {
    $sql .= " WHERE r.categoryID = :catID";
}

$sql .= " ORDER BY r.id DESC";

$stmt = $pdo->prepare($sql);

if ($selectedCat !== '') {
    $stmt->execute([':catID' => $selectedCat]);
} else {
    $stmt->execute();
}

$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($recipes);
?>