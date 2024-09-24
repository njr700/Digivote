<?php
include_once("../../../database/dbconnect.php");

function generateUniqueCode($bdd) {
    $uniqueCode = bin2hex(random_bytes(5)); // 10 caractères hexadécimaux
    $stmt = $bdd->prepare("INSERT INTO unique_codes (code) VALUES (?)");
    $stmt->bind_param("s", $uniqueCode);
    $stmt->execute();
    $stmt->close();
    return $uniqueCode;
}

function verifyIdentityNumber($bdd, $identityNumber) {
    $stmt = $bdd->prepare("SELECT * FROM electeur, candidat WHERE numero_identite = ?");
    $stmt->bind_param("s", $identityNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $isValid = $result->num_rows > 0;
    $stmt->close();
    return $isValid;
}

function getVoteCounts($bdd) {
    $voteCounts = ["Option 1" => 0, "Option 2" => 0, "Option 3" => 0];
    $result = $conn->query("SELECT option_name, COUNT(*) as count FROM votes GROUP BY option_name");

    while ($row = $result->fetch_assoc()) {
        $voteCounts[$row['option_name']] = (int)$row['count'];
    }
    
    return $voteCounts;
}

function getTotalVotes($bdd) {
    $result = $bdd->query("SELECT COUNT(*) as total FROM votes");
    $row = $result->fetch_assoc();
    return (int)$row['total'];
}

function getTotalVoters($bdd) {
    $result = $bdd->query("SELECT COUNT(DISTINCT numero_identite) as total FROM electeur, candidat");
    $row = $result->fetch_assoc();
    return (int)$row['total'];
}

function getVotes($bdd) {
    $votes = getVoteCounts($bdd);
    return $votes;
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'generate_code':
            $uniqueCode = generateUniqueCode($bdd);
            echo json_encode(["uniqueCode" => $uniqueCode]);
            break;
        
        case 'check_identity':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $identityNumber = $_POST['identityNumber'];
        
                if (verifyIdentityNumber($bdd, $identityNumber)) {
                    echo json_encode(["valid" => true]);
                } else {
                    echo json_encode(["valid" => false, "message" => "Numéro d'identité invalide."]);
                }
            } else {
                echo json_encode(["valid" => false, "message" => "Méthode de requête non valide."]);
            }
            break;
        
        case 'vote':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $option = $_POST['option'];
                $uniqueCode = $_POST['uniqueCode'];
                $identityNumber = $_POST['identityNumber'];

                // Vérifier si le code unique est valide
                $stmt = $bdd->prepare("SELECT * FROM unique_codes WHERE code = ?");
                $stmt->bind_param("s", $uniqueCode);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    echo json_encode(["success" => false, "message" => "Numéro unique invalide."]);
                    
                    exit();
                }

                $stmt->close();

                // Vérifier si l'utilisateur a déjà voté avec ce numéro d'identité
                $stmt = $bdd->prepare("SELECT * FROM votes WHERE numero_identite = ?");
                $stmt->bind_param("s", $identityNumber);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo json_encode(["success" => false, "message" => "Vous avez déjà voté."]);
                    exit();
                }

                $stmt->close();

                // Enregistrer le vote
                $stmt = $bdd->prepare("INSERT INTO votes (option_name, unique_code, numero_identite) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $option, $uniqueCode, $identityNumber);
                $stmt->execute();
                $stmt->close();

                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Méthode de requête non valide."]);
            }
            break;

        case 'results':
            $votes = getVotes($bdd);
            $totalVotes = getTotalVotes($bdd);
            $totalVoters = getTotalVoters($bdd);
            echo json_encode([
                "votes" => $votes,
                "totalVotes" => $totalVotes,
                "totalVoters" => $totalVoters
            ]);
            break;

        default:
            echo json_encode(["success" => false, "message" => "Action non valide."]);
            break;
    }
    $bdd->close();
    exit();
}
