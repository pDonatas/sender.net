<?php
$host = 'localhost';
$user = 'root';
$db = 'parodomas_projektas';
$pass = '';

try{
    $pdo = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
}catch (PDOException $e){
    die($e->getMessage());
}