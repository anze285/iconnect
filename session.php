<?php
session_start();

if(!isset($_SESSION['user_id'])
        && $_SERVER['REQUEST_URI'] !='/instantgram/login.php'
        && $_SERVER['REQUEST_URI'] !='/instantgram/registration.php'
        && $_SERVER['REQUEST_URI'] !='/instantgram/login_check.php'
        && $_SERVER['REQUEST_URI'] != '/instantgram/user_insert.php'
        && $_SERVER['REQUEST_URI'] != '/instantgram/forgoten_password.php') {
    header("Location: login.php");
    die();
}
if (isset($_SESSION['user_id'])
    && ($_SERVER['REQUEST_URI'] == '/instantgram/login.php'
    || $_SERVER['REQUEST_URI'] == '/instantgram/registration.php'
    || $_SERVER['REQUEST_URI'] == '/instantgram/login_check.php'
    || $_SERVER['REQUEST_URI'] == '/instantgram/user_insert.php'
    || $_SERVER['REQUEST_URI'] == '/instantgram/forgoten_password.php')) {
    header("Location: index.php");
}
// SERVER
/*if (
    !isset($_SESSION['user_id'])
    && $_SERVER['REQUEST_URI'] != '/login.php'
    && $_SERVER['REQUEST_URI'] != '/registration.php'
    && $_SERVER['REQUEST_URI'] != '/login_check.php'
    && $_SERVER['REQUEST_URI'] != '/user_insert.php'
    && $_SERVER['REQUEST_URI'] != '/forgoten_password'
) {
    header("Location: login.php");
    die();
}
if (
    isset($_SESSION['user_id'])
    && ($_SERVER['REQUEST_URI'] == '/login.php'
        || $_SERVER['REQUEST_URI'] == '/registration.php'
        || $_SERVER['REQUEST_URI'] == '/login_check.php'
        || $_SERVER['REQUEST_URI'] == '/user_insert.php'
        || $_SERVER['REQUEST_URI'] != '/forgoten_password.php')
) {
    header("Location: index.php");
}*/


function isAdmin() {
    $result = false;
    if (isset($_SESSION['user_id']) && ($_SESSION['user_id']==0)) {
        $result = true;
    }
    return $result;
}

function adminOnly() {
    //če ni admin, ga preusmeri na index
    if (!isAdmin()) {
        header("Location: index.php");
        die();
    }
}



?>