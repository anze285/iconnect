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

    $query = "SELECT id, email, username FROM users";
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

        $query = "SELECT id FROM users WHERE email = ? AND username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email, $username]);
        $user = $stmt->fetch();
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
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
