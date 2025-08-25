<?php
$host = 'db.fr-pari1.bengt.wasmernet.com';
$dbname = 'event';
$username = 'caa871817e3f80000075be0ff55c';
$password = '068acaa8-7182-708c-8000-7bb7aecf5e1e';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
