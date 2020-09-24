<?php
include_once './database.php';
include_once './session.php';
$oldpass = $_POST['oldpass'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
//preverim, če sem prejel podatke
if (!empty($oldpass) && !empty($pass1) && ($pass1 == $pass2)) {

    $query = "SELECT * FROM users WHERE id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    $pass = password_hash($pass1, PASSWORD_DEFAULT);
    
    $user = $stmt->fetch();
    if (password_verify($oldpass, $user['password'])) {
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pass, $_SESSION['user_id']]);
    }
    header("Location: password.php");
}
header("Location: password.php");
?>