<?php

session_start();
require 'db_connect.php';




$firstName = $_POST['first_name'];
$lastName  = $_POST['last_name'];
$email     = $_POST['email'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);


// checking if email is exists in the db
$stmt = $pdo->prepare("SELECT id FROM User WHERE emailAddress = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header("Location: SignUp.php?error=email_exists"); // redirects the user with an error code in the URL
    exit;
}


// checking if user is blocked
$stmt = $pdo->prepare("SELECT id FROM BlockedUser WHERE emailAddress = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header("Location: SignUp.php?error=email_blocked");
    exit;
}

// handling photo upload
$photoFileName = "default.jpg";
if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    // We'll name it properly after we get the user's ID
}



// inserting a new user (without pfp yet)
$stmt = $pdo->prepare("INSERT INTO User (userType, firstName, lastName, emailAddress, password, photoFileName) 
                        VALUES ('user', ?, ?, ?, ?, ?)");
$stmt->execute([$firstName, $lastName, $email, $password, $photoFileName]);


// handling photo with id in filename
$userID = $pdo->lastInsertId(); 
if (!empty($_FILES['photo']['name'])) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoFileName = "user_{$userID}." . $ext;
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/images/" . $photoFileName);
    
    // updating the user record with the real photo name
    $stmt = $pdo->prepare("UPDATE User SET photoFileName = ? WHERE id = ?");
    $stmt->execute([$photoFileName, $userID]);
}


// setting session variables
$_SESSION['userID']   = $userID;
$_SESSION['userType'] = 'user';

header("Location: UserPage.php");
exit;

