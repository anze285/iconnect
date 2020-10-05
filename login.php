<?php
include_once './header.php';
?>
<div class="login-main m-4 p-4">
    <div class="login-content">
        <h1 class="instantgram pb-4 mb-4 big-text">iConnect</h1>

        <form action="login_check.php" method="post">
            <input id="login-email" type="text" name="email" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Username or email" required="required" />
            <input id="login-pass" type="password" name="pass" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Password" required="required" />
            <?php 
            if (isset($_SESSION['login_error'])) {
                echo '<div class="w-75 mx-auto"><p class="text-danger fs-1">'.$_SESSION["login_error"].'</p></div>';
            }
            ?>
            <input type="submit" class="btn btn-primary w-75 mb-2 <?php if (!isset($_SESSION['login_error'])) { 
            echo "mt-3"; } unset($_SESSION['login_error']); ?> fs-1 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Log In" />
        </form>

        <hr class="w-75 bc-dbdbdb mb-4">
        <?php
            include_once 'facebook_login.php';
            include_once './redirect.php';
        ?>
        <br>
        <a href="#" class="fs-1 c-00376B">Forgot password?</a>
        
    </div>
    <div class="login-content d-flex justify-content-center align-items-center flex-column p-3 mb-0">
        <div class="">
            <p class="fs-2 mb-0 font-weight-100">Don't have an account? <a href="registration.php" class="fs-2 font-weight-600 sign-a">Sign up</a></p>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
?>