<?php
session_start();
include_once './database.php';
$email = $_POST['email'];
$pass = $_POST['pass'];
$email = str_replace('<', '', $email);
$email = str_replace('>', '', $email);
//preverim, če sem prejel podatke
if (!empty($email) && !empty($pass)) {
    
    $query = "SELECT * FROM users WHERE email=? OR username=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $email]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            //$_SESSION['admin'] = $user['admin'];        
            header("Location: index.php");
            die();
        }
        else {
            $_SESSION['login_error'] = "Incorecct password.";
            header("Location: login.php");
        }
    }
    else {
        $_SESSION['login_error'] = "Account with this email/username does not exist.";
        header("Location: login.php");
    }
}
else {
    header("Location: login.php");   
}
