<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../../../database/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $prenom = htmlspecialchars($_POST['firstName']);
    $nom = htmlspecialchars($_POST['lastName']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $adresse = htmlspecialchars($_POST['adress']); // Notez le changement ici pour correspondre à l'entrée HTML
    $numero_identite = htmlspecialchars($_POST['uniqueCode']);
    $defaultPassword = htmlspecialchars($_POST['defaultPassword']);

    $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    if (file_exists($target_file)) {
        die("Sorry, file already exists.");
    }

    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded.");
    } else {
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            $profilePicture = basename($_FILES["profilePicture"]["name"]);

            $_SESSION['userData'] = array(
                'nom' => $nom,
                'prenom' => $prenom,
                'postnom' => $postnom,
                'adresse' => $adresse,
                'numero_identite' => $numero_identite,
                'photo' => $profilePicture,
                'defaultPassword' => $defaultPassword
            );

            try {
                $stmt = $bdd->prepare("INSERT INTO electeur (nom, prenom, postnom, adresse, numero_identite, photo, defaultPassword) VALUES (:nom, :prenom, :postnom, :adresse, :numero_identite, :photo, :defaultPassword)");
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':postnom', $postnom);
                $stmt->bindParam(':adresse', $adresse); // Notez le changement ici pour correspondre à l'entrée HTML
                $stmt->bindParam(':numero_identite', $numero_identite);
                $stmt->bindParam(':photo', $profilePicture);
                $stmt->bindParam(':defaultPassword', $defaultPassword);

                if ($stmt->execute()) {
                    echo "success";
                } else {
                    echo "Error inserting data into the enregistrement table.";
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
