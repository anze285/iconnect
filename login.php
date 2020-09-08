<?php
include_once './header.php';
?>
<div class="login-main">
    <div class="login-content">
        <h1>Instantgram</h1>

        <form action="login_check.php" method="post">
            <input type="text" name="email" class="form-control mb-4" placeholder="Username or email" required="required" />
            <input type="password" name="pass" class="form-control mb-4" placeholder="Password" required="required" /><br>
            <input type="submit" class="btn btn-primary" value="Log In" />
        </form>
        <br>
        <p>login with facebook</p>
        <p>login with google</p>
        <p>forgot password</p>
    </div>
    <div class="login-content">
        <p>Don't have an account? <a href="registration.php">Sing up</a></p>
    </div>
</div>
<?php
include_once './footer.php';
?>