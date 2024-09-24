<?php
session_start();


$servername = "localhost";  
$username = "root";  
$password = "";
$dbname = "vote_db";


try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$sql = "SELECT * FROM enregistrement2";
$result = $bdd->query($sql);


$_SESSION['userCards'] = [];
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['userCards'][] = [
            'profilePicture' => $row['profilePicture'],
            'lastName' => $row['lastName'],
            'firstName' => $row['firstName'],
            'postnom' => $row['postnom'],
            'poste' => $row['poste'],
            'uniqueCode' => $row['uniqueCode']
        ];
    }
}

$bdd = null; 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des cartes</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .search-bar {
            margin: 20px;
            width: 80%;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            max-height: 100vh;
            overflow-y: auto;
        }
        .card {
            background-color: #fff;
            width: calc(100% - 40px);
            max-width: 600px;
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
            border-radius: 10px;
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
            border-radius: 0px 0px 0 0;
        }
        .bottom-line {
            bottom: 0;
            border-radius: 0 0 0px 0px;
            padding: 10px 0;
        }
        .logo {
            width: 136px;
            height: 200px;
            object-fit: contain;
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="search-bar">
        <input type="text" id="searchInput" onkeyup="searchCards()" placeholder="Rechercher des cartes...">
    </div>
    <div class="container" id="cardsContainer">
        <?php if (isset($_SESSION['userCards']) && !empty($_SESSION['userCards'])): ?>
            <?php foreach ($_SESSION['userCards'] as $userData): ?>
                <div class="card">
                    <div class="top-line">Carte d'identité</div>
                    <img src="uploads/<?php echo $userData['profilePicture']; ?>" alt="Profile Picture" class="user-img">
                    <div class="user-info">
                        <p><strong>Nom:</strong> <?php echo $userData['lastName']; ?></p>
                        <p><strong>Prénom:</strong> <?php echo $userData['firstName']; ?></p>
                        <p><strong>Postnom:</strong> <?php echo $userData['postnom']; ?></p>
                        <p><strong>Poste:</strong> <?php echo $userData['poste']; ?></p>
                        <p><strong>Numéro d'identité:</strong> <?php echo $userData['uniqueCode']; ?></p>
                    </div>
                    <img src="vote1.png" alt="Logo" class="logo">
                    <div class="bottom-line">
                        <div>DigiVote - Système de Vote Electronique</div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune carte d'identité trouvée.</p>
        <?php endif; ?>
    </div>

    <script>
        function searchCards() {
            var input, filter, container, cards, card, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            container = document.getElementById('cardsContainer');
            cards = container.getElementsByClassName('card');

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                txtValue = card.textContent || card.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>

<?php

?>
