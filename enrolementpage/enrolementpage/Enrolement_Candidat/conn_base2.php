<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=vote_db;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
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
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedFormats = array("jpg", "jpeg", "png", "gif");

        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        if (file_exists($target_file)) {
            die("Sorry, file already exists.");
        }

        if (!in_array($imageFileType, $allowedFormats)) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

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

            $stmt = $bdd->prepare("INSERT INTO enregistrement2 (firstName, lastName, postnom, poste, uniqueCode, profilePicture) VALUES (:firstName, :lastName, :postnom, :poste, :uniqueCode, :profilePicture)");
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':postnom', $postnom);
            $stmt->bindParam(':poste', $poste);
            $stmt->bindParam(':uniqueCode', $uniqueCode);
            $stmt->bindParam(':profilePicture', $profilePicture);

            if ($stmt->execute()) {
                header("Location: transition.php");
                exit();
            } else {
                echo "Error inserting data into the enregistrement2 table.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
