<?php
include_once './database.php';
include_once './session.php';

$query = "SELECT username FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$username = $stmt->fetch();

$target_dir = "images/";
$tmp = explode('.', $_FILES["fileToUpload"]["name"]);
$ext = end($tmp);
$name = $username['username'].".".$ext;
$target_file = $target_dir . basename($name);
$uploadOk = 0;

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["picture"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
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
} else {
    $query = "UPDATE users SET profile_pic = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$target_file,$_SESSION['user_id']]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
header("Location: edit_profile.php")
?>