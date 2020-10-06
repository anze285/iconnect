<?php
include_once './header.php';
?>
<div class="login-main m-4 p-4">
    <div class="login-content">
        <h1 class="instantgram pb-4 mb-4 big-text">iConnect</h1>

        <form action="recoverycode.php" method="post">
            <input id="login-email" type="text" name="email" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Username or email" required="required" />
            <input type="submit" class="btn btn-primary w-75 mb-2 fs-1 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Send recovery code" />
        </form>
    </div>
    <div class="registration-content d-flex justify-content-center align-items-center flex-column p-3 mb-0">
        <div>
            <p class="fs-2 mb-0 font-weight-100">Have an account? <a href="login.php" class="fs-2 font-weight-600 sign-a">Log in</a></p>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
?>