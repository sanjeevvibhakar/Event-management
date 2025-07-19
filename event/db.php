<?php
$host = 'srv1668.hstgr.io';
$dbname = 'u577526957_racaf';
$username = 'u577526957_racaf';
$password = 'Racaf#@4149';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
