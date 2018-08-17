<?php

$host = 'test';
$db   = 'test';
$user = 'test';
$pass = 'test|test';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$stmt = $pdo->query('select sku from catalog_product_entity where type_id="simple" limit 999999;');
while ($row = $stmt->fetch())
{
    echo $row['id'] . "</br>";
}






 ?>
