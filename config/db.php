<?php
// File: config/db.php
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 
// Description: Database connection file. 
// Creates a PDO instance for use throughout the application.

$dsn = 'mysql:host=db;dbname=ctf_platform;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}