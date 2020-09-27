<?php
include_once './database.php';
include_once './session.php';

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$username = $_POST['username'];
//$birthday = $_POST['birthday'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
//preverim podatke, da so obvezi vnešeni

if (!empty($name) && !empty($email) 
    && !empty($pass1) && !empty($username) 
    && ($pass1 == $pass2)) {
    $pass = password_hash($pass1, PASSWORD_DEFAULT);

    $query = "SELECT email, username FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $verification = true;
    while ($email1 = $stmt->fetch()) {
        if ($email1['email'] == $email) {
            $verification = false;
            $_SESSION['register_error'] = "Account with that email already exists.";
            break;
        }
        if ($email1['username'] == $username) {
            $verification = false;
            $_SESSION['register_error'] = "Account with that username already exists.";
            break;
        }
    }
    if($verification){
        $query = "INSERT INTO users (name,username,email,phone_number,"
        . "password) "
        . "VALUES (?,?,?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $username, $email, $phone, $pass]);
        $_SESSION['register_successful'] = "Account was successfully created.";
        header("Location: login.php");
    }
    else {
        header("Location: registration.php");
    }
}
else {
    $_SESSION['register_error'] = "Passwords don't match.";
    header("Location: registration.php");
}
?>
