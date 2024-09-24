<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $bdd = new PDO('mysql:host=localhost;dbname=vote_db;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $poste = htmlspecialchars($_POST['poste']);
    $uniqueCode = htmlspecialchars($_POST['uniqueCode']);

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
                'firstName' => $firstName,
                'lastName' => $lastName,
                'postnom' => $postnom,
                'poste' => $poste,
                'uniqueCode' => $uniqueCode,
                'profilePicture' => $profilePicture
            );

            try {
                $stmt = $bdd->prepare("INSERT INTO enregistrement2 (firstName, lastName, postnom, poste, uniqueCode, profilePicture) VALUES (:firstName, :lastName, :postnom, :poste, :uniqueCode, :profilePicture)");
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':postnom', $postnom);
                $stmt->bindParam(':poste', $poste);
                $stmt->bindParam(':uniqueCode', $uniqueCode);
                $stmt->bindParam(':profilePicture', $profilePicture);

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
