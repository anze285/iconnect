<?php
include_once './database.php';

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
    
    $query = "INSERT INTO users (name,username,email,phone_number,"
            . "password) "
            . "VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name,$username,$email,$phone,$pass]);
    
    header("Location: login.php");
}
else {
    header("Location: registration.php");
}
?>
