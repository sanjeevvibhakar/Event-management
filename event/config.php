<?php
// config.php
define('ADMIN_USERNAME', 'chadhi');
define('ADMIN_PASSWORD', 'chadi');

try {
    $pdo = new PDO('mysql:host=srv1668.hstgr.io;dbname=u577526957_racaf', 'u577526957_racaf', 'Racaf#@4149');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
