<?php
$servername = 'localhost';
$dbname = 'vote_db';
$username = 'root';
$password = ''; 

try {
    $bdd = new PDO("mysql:host=$servername; dbname=$dbname; charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Échec de la connexion :  " . $e -> getMessage());

}