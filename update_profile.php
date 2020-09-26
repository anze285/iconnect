<?php
include_once './database.php';
include_once './session.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bio = $_POST['bio'];

if (!empty($name) && !empty($email)) {
    $query = "SELECT email FROM users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    $originalemail = $stmt->fetch();
    $verification = true;
    if ($originalemail['email'] == $email) {
    }
    else {
        $query = "SELECT email FROM users";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($email1 = $stmt->fetch()) {
            if ($email1['email'] == $email) {
                $verification = false;
                break;
            }
        }
    }
    if ($verification) {
        $query = "UPDATE users SET name = ?, email = ?, phone_number = ?, bio = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $email, $phone, $bio, $_SESSION['user_id']]);
        header("Location: edit_profile.php");
    }
    else {
        header("Location: edit_profile.php");
    }
}
else {
    header("Location: edit_profile.php");
}
