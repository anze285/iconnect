<?php
include_once './header.php';
?>
<div class="password-main m-4 p-4">
    <div class="password-content">
        <form action="change_password.php" method="post">
            <input type="password" name="oldpass" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Password" required="required" />
            <input type="password" name="pass1" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Password" required="required" />
            <input type="password" name="pass2" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Confirm password" required="required" /><br>
            <input type="submit" class="btn btn-primary w-75 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Change Password" /><br>
            <a href="#" class="fs-1 c-00376B">Forgot password?</a>
        </form>
    </div>
</div>
<?php
include_once './footer.php';
?>