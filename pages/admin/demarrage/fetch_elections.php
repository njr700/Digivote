<?php
$servername = 'localhost';
$dbname = 'vote_db';
$username = 'root';
$password = ''; 

header('Content-Type: application/json');

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $bdd->query("SELECT id, nom FROM election");
    $elections = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($elections);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
