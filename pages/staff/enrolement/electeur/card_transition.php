<?php
session_start();

if (isset($_SESSION['userData'])) {
    $userData = $_SESSION['userData'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver License</title>
    <link rel="stylesheet" href="card_transition.css" />
</head>
<body>
    <div class="container">
        <div class="card" id="cardContent">
            <div class="top-line">Carte d'identité</div>
            <img src="uploads/<?php echo $userData['photo']; ?>" alt="Profile Picture" class="user-img">
            <div class="user-info">
                <p><strong>Nom:</strong> <?php echo $userData['nom']; ?></p>
                <p><strong>Prénom:</strong> <?php echo $userData['prenom']; ?></p>
                <p><strong>Postnom:</strong> <?php echo $userData['postnom']; ?></p>
                <p><strong>Adresse:</strong> <?php echo $userData['adresse']; ?></p>
                <p><strong>Numéro d'identité:</strong> <?php echo $userData['numero_identite']; ?></p>
            </div>
            <img src="../../../../assets/images/vote1.png" alt="Logo" class="logo">
            <div class="bottom-line">
                <div>DigiVote - Système de Vote Electronique</div>
                <button class="print-button" onclick="imprimerCarte()">Imprimer</button>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="ok">✔</div>
                <p>Enregistrement effectué avec succès !</p>
                <p>Cliquez sur OK pour continuer</p><br>
                <button id="continueButton" class="ok-button">OK</button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="card_transition.js"></script>
</body>
</html>

<?php
    
    unset($_SESSION['userData']);
} else {
    
    header("Location: enrolement_elect.html");
    exit;
}

