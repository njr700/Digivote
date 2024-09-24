<?php
$servername = 'localhost';
$dbname = 'vote_db';
$username = 'root';
$password = '';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $heureDebut = $_POST['heureDebut'];
    $heureFin = $_POST['heureFin'];

    try {
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $bdd->prepare("UPDATE election SET heure_debut = ?, heure_fin = ? WHERE nom = ?");
        $stmt->execute([$heureDebut, $heureFin, $nom]);

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
