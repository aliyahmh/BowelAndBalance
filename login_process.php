<?php
session_start();
require 'db_connect.php';

$email    = $_POST['email'];
$password = $_POST['password'];

// checking if email belongs to a blocked user
$stmt = $pdo->prepare("SELECT id FROM BlockedUser WHERE emailAddress = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header("Location: login.php?error=blocked");
    exit;
}

// searching for a user with this email
$stmt = $pdo->prepare("SELECT id, userType, password FROM User WHERE emailAddress = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// ensuring user exists and password is correct
if (!$user || !password_verify($password, $user['password'])) {
    header("Location: login.php?error=invalid");
    exit;
}


// login success -> storing user's info in session variables
$_SESSION['userID']   = $user['id'];
$_SESSION['userType'] = $user['userType'];


// redirecting to the correct page
if ($user['userType'] === 'admin') {
    header("Location: AdminPage.php");
} else {
    header("Location: UserPage.php");
}
exit;
?>