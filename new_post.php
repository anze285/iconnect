<?php
include_once './database.php';
include_once './session.php';

$description = $_POST['description'];
$destination = $_POST['destination'];
//preverim podatke, da so obvezi vnešeni

if (
    true
) {
    $query = "SELECT * FROM images i INNER JOIN posts p ON p.id=i.post_id WHERE p.user_id =?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    $count = $stmt->rowCount();
    $target_dir = "images/";
    $tmp = explode('.', $_FILES["fileToUpload"]["name"]);
    $ext = end($tmp);
    $name = $_SESSION['user_id']."-".$count . "." . $ext;
    $target_file = $target_dir . basename($name);
    $uploadOk = 0;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["post"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } 
    else {
        $query = "INSERT INTO posts (description, user_id, date) VALUES (?,?,CURRENT_TIMESTAMP())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$description, $_SESSION['user_id']]);

        $query = "SELECT id FROM posts WHERE user_id=? ORDER BY id DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $post_id1 = $stmt->fetch();

        $query = "INSERT INTO images (root, date, post_id) VALUES (?,CURRENT_TIMESTAMP(),?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$target_file, $post_id1['id']]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    //header("Location: login.php");
} else {
    //header("Location: registration.php");
}
?>