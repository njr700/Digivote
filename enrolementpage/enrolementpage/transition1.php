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
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            padding-left: 20px;
        }
        .card {
            background-color: #fff;
            width: 600px;
            height: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-align: left;
            position: relative;
            border-top: 30px solid #cce5ff;
            border-bottom: 30px solid #cce5ff;
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: auto;
        }
        .user-img {
            width: 200px;
            height: 300px;
            object-fit: cover;
            margin-right: 20px;
        }
        .user-info {
            flex: 1;
            padding-left: 20px;
        }
        .user-info p {
            margin-bottom: 20px;
        }
        .top-line, .bottom-line {
            position: absolute;
            width: 100%;
            background-color: #cce5ff;
            left: 0;
            text-align: center;
            padding: 10px 0;
            font-weight: bold;
            font-size: 24px;
            color: black;
        }
        .top-line {
            top: 0;
        }
        .bottom-line {
            bottom: 0;
        }
        .logo {
            width: 136px;
            height: 200px;
            object-fit: contain;
            margin-left: auto;
        }
        .print-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 9px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .overlay-container {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 100px;
        }
        .overlay {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .ok {
            font-size: 40px;
            color: green;
        }
        .ok-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }
        .ok-button:hover {
            background-color: #0056b3;
        }
        .hide {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card" id="cardContent">
            <div class="top-line">Carte d'identité</div>
            <img src="uploads/<?php echo $userData['profilePicture']; ?>" alt="Profile Picture" class="user-img">
            <div class="user-info">
                <p><strong>Nom:</strong> <?php echo $userData['lastName']; ?></p>
                <p><strong>Prénom:</strong> <?php echo $userData['firstName']; ?></p>
                <p><strong>Postnom:</strong> <?php echo $userData['postnom']; ?></p>
                <p><strong>Adresse:</strong> <?php echo $userData['Adress']; ?></p>
                <p><strong>Numéro d'identité:</strong> <?php echo $userData['uniqueCode']; ?></p>
            </div>
            <img src="vote1.png" alt="Logo" class="logo">
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
    <script>
        document.getElementById('continueButton').addEventListener('click', function() {
            window.location.href = 'connexion_enrol.php'; 
        });

        function imprimerCarte() {
           
            const cardContent = document.getElementById('cardContent');
           
            const printButton = document.querySelector('.print-button');

           
            printButton.classList.add('hide');

           
            const options = {
                margin: 10,
                filename: 'carte_identite.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

          
            html2pdf().from(cardContent).set(options).save();

            
            printButton.classList.remove('hide');
        }
    </script>
</body>
</html>

<?php
    
    unset($_SESSION['userData']);
} else {
    
    header("Location: enrolement_elect.html");
    exit;
}
?>
