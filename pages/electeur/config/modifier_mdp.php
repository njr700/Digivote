<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../../../database/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_identite = isset($_POST['uniqueCode']) ? htmlspecialchars($_POST['uniqueCode']) : '';
    $defaultPassword = isset($_POST['defaultPassword']) ? htmlspecialchars($_POST['defaultPassword']) : '';
    $newPassword = isset($_POST['newPassword']) ? htmlspecialchars($_POST['newPassword']) : '';

    if (!empty($numero_identite) && !empty($defaultPassword)) {
        try {
            $stmt1 = $bdd->prepare("SELECT * FROM electeur WHERE numero_identite = :numero_identite AND defaultPassword = :defaultPassword");
            $stmt1->bindParam(':numero_identite', $numero_identite);
            $stmt1->bindParam(':defaultPassword', $defaultPassword);
            $stmt1->execute();
            $user1 = $stmt1->fetch(PDO::FETCH_ASSOC);
             
            $stmt2 = $bdd->prepare("SELECT * FROM candidat WHERE numero_identite = :numero_identite AND defaultPassword = :defaultPassword");
            $stmt2->bindParam(':numero_identite', $numero_identite);
            $stmt2->bindParam(':defaultPassword', $defaultPassword);
            $stmt2->execute();
            $user2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($user1) {
                $stmt1 = $bdd->prepare("UPDATE electeur SET defaultPassword = :newPassword WHERE numero_identite = :numero_identite");
                $stmt1->bindParam(':newPassword', $newPassword);
                $stmt1->bindParam(':numero_identite', $numero_identite);

                if ($stmt1->execute()) {
                    echo "success";
                } else {
                    echo "Erreur lors de la mise à jour du mot de passe.";
                }
            } else if($user2) {
                $stmt2 = $bdd->prepare("UPDATE candidat SET defaultPassword = :newPassword WHERE numero_identite = :numero_identite");
                $stmt2->bindParam(':newPassword', $newPassword);
                $stmt2->bindParam(':numero_identite', $numero_identite);

                if ($stmt2->execute()) {
                    echo "success";
                } else {
                    echo "Erreur lors de la mise à jour du mot de passe.";
                }

            } else {
                echo "Numéro unique ou mot de passe par défaut incorrect.";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs requis.";
    }
}
?>
