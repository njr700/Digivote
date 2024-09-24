<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $poste = htmlspecialchars($_POST['poste']);
    $uniqueCode = htmlspecialchars($_POST['uniqueCode']);

    
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=vote_db;charset=utf8', 'root', '');
        
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        $stmt = $bdd->prepare("INSERT INTO enregistrement (firstName, lastName, postnom, poste, uniqueCode) 
                               VALUES (:firstName, :lastName, :postnom, :poste, :uniqueCode)");
        
        
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':postnom', $postnom);
        $stmt->bindParam(':poste', $poste);
        $stmt->bindParam(':uniqueCode', $uniqueCode);
        
        
        $stmt->execute();
        
        
        echo "nouveau record enregistrer avec succès";
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
    }
}
?>
