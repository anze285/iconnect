<?php
require("vendor/autoload.php");
include_once 'database.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['state'])) {
    $_SESSION['FBRLH_state'] = $_GET['state'];
}

/*Step 1: Enter Credentials*/
$fb = new \Facebook\Facebook([
    'app_id' => '1798697700282963',
    'app_secret' => 'b11c81ea6e08ff69ddd6347418222329',
    'default_graph_version' => 'v8.0',
    //'default_access_token' => '{access-token}', // optional
]);


/*Step 2 Create the url*/
if (empty($access_token)) {

    echo "<a class='btn btn-large btn-facebook mb-2 w-75' href='{$fb->getRedirectLoginHelper()->getLoginUrl("https://iconnect.gorsek.si/facebook_login.php")}'><i class='fab fa-facebook-f mr-2'></i>Login with Facebook </a>";

}

/*Step 3 : Get Access Token*/
$access_token = $fb->getRedirectLoginHelper()->getAccessToken();


/*Step 4: Get the graph user*/
if (isset($access_token)) {

    try {
        $response = $fb->get('/me', $access_token);

        $fb_user = $response->getGraphUser();
        $name = $fb_user->getName();
        $username = str_replace(' ', '_', $name);
        $pass = "tsgdst&DGHNBS##gkdnl??jaks*sj+sjdls-sdugh%wertrzt";
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $email = 'facebook@facebook.com';

        $query = "SELECT password FROM users WHERE username = ? AND email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() == 0) {
            $query = "INSERT INTO users (name,username,email, password) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $username, $email, $pass]);
        }
        $query = "SELECT id FROM users WHERE email = ? AND username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email, $username]);
        $user = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
        } else {
            $_SESSION['login_error'] = "Something went wrong with facebook login";
            header("Location: login.php");
        }




        //  var_dump($fb_user);
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo  'Graph returned an error: ' . $e->getMessage();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
}
