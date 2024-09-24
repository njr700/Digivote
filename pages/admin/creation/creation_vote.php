<?php
$servername = 'localhost';
$dbname = 'vote_db';
$username = 'root';
$password = ''; 

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si la table 'election' existe
    $tableExists = $bdd->query("SHOW TABLES LIKE 'election'")->rowCount() > 0;

    if (!$tableExists) {
        // SQL pour créer la table si elle n'existe pas
        $sql = "CREATE TABLE election (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            date_creation DATETIME NOT NULL,
            heure_debut TIME NOT NULL,
            heure_fin TIME NOT NULL
        )";

        // Exécution de la requête SQL
        $bdd->exec($sql);
        $message = "Table 'election' créée avec succès.";
    } else {
        $message = "Table 'election' existe déjà.";
    }

    // Récupérer les données du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $electionType = $_POST['electionType'];

        // Insérer les données dans la table
        $stmt = $bdd->prepare("INSERT INTO election (nom, date_creation, heure_debut, heure_fin) VALUES (:nom, NOW(), NOW(), NOW())");
        $stmt->bindParam(':nom', $electionType);
        $stmt->execute();

        $message = "Détails du vote enregistrés avec succès.";
    }

    echo $message;

} catch (PDOException $e) {
    echo "Échec de la connexion : " . $e->getMessage();
}
?>
