<?php
// db.php - PDO database connection

$host = 'localhost';
$db   = 'herald_db';   
$user = 'root';             
$pass = '';                 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Don't expose sensitive details in production
    die("Database connection failed: " . $e->getMessage());
}
