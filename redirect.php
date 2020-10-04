<?php
require_once 'vendor/autoload.php';
include_once 'database.php';
 
// init configuration
$clientID = '2234109466-51ilt55571258irkff213j3rorm3g9r2.apps.googleusercontent.com';
$clientSecret = 'blwf1pkQYOdX0w4O-3ayvAha';
$redirectUri = 'https://iconnect.gorsek.si/redirect.php';
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    session_start();
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
  
  // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;
    $username = str_replace(' ', '_', $name);
    $pass = "tsgdst&DGHNBS##gkdnl??jaks*sj+sjdls-sdugh%";
    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $query = "SELECT password FROM users WHERE username = ? AND email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $email]);
    $password = $stmt->fetch();
    if ($stmt->rowCount() == 0) {
        $query = "INSERT INTO users (name,username,email, password) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $username, $email, $pass]);
    }
    $query = "SELECT id FROM users WHERE email = ? AND username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $username]);
    $user = $stmt->fetch();
    echo $stmt->rowCount();  
    if ($stmt->rowCount() == 1) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    }
    else{
        $_SESSION['login_error'] = "Something went wrong with google login";
    }
    header("Location: index.php");
  // now you can use this profile info to create account in your website and make user logged in.
} else {
    echo "<a class='btn btn-large btn-google w-75' href='".$client->createAuthUrl(). "'><i class='fab fa-google'></i> Google Login</a>";
}
?>
