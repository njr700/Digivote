<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('database/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uniqueCode = htmlspecialchars($_POST['uniqueCode']);
    $password = htmlspecialchars($_POST['password']);

    // Vérification des électeurs
    try {
        $stmt = $bdd->prepare("SELECT * FROM electeur WHERE numero_identite = :uniqueCode AND (defaultPassword = :password OR newPassword = :password)");
        $stmt->bindParam(':uniqueCode', $uniqueCode);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "electeur";
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Vérification des candidats
    try {
        $stmt = $bdd->prepare("SELECT * FROM candidat WHERE numero_identite = :uniqueCode AND (defaultPassword = :password OR newPassword = :password)");
        $stmt->bindParam(':uniqueCode', $uniqueCode);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "candidat";
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Vérification des administrateur
    try {
        $stmt = $bdd->prepare("SELECT * FROM admin WHERE matricule = :uniqueCode AND pwd = :password");
        $stmt->bindParam(':uniqueCode', $uniqueCode);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "admin";
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Vérification du staff
    try {
        $stmt = $bdd->prepare("SELECT * FROM staff WHERE matricule = :uniqueCode AND pwd = :password");
        $stmt->bindParam(':uniqueCode', $uniqueCode);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "staff";
            exit;
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Si aucun utilisateur trouvé
    echo "Numéro unique ou mot de passe incorrect.";
}
?>