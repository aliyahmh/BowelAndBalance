<?php

$host = "sql201.infinityfree.com";
$db = "if0_41928799_recipe_db";

try {

    $connectionString = "mysql:host=$host;port=3306;dbname=$db";
    $user = "if0_41928799";
    $pass = "nLz2VTvUyZ3P";
    $pdo = new PDO($connectionString, $user, $pass);
    
    
    // error & fetch mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $ex) {
    die($ex->getMessage());
}

