<?php
include_once './header.php';
?>
<div class="registration-main">
    <div class="registration-content">
        <h1>Instantgram</h1>
        <p>login with facebook</p>
        <p>login with google</p>
        <form action="user_insert.php" method="post">
            <input type="text" name="name" class="form-control mb-4" placeholder="Name and surname" required="required" />
            <input type="email" name="email" class="form-control mb-4" placeholder="Email" required="required" />
            <input type="text" name="username" class="form-control mb-4" placeholder="Username" required="required" />
            <input type="text" name="phone" class="form-control mb-4" placeholder="Mobile number" />
            <!--<input type="date" name="birthday" class="form-control mb-4" value="2000-01-01" placeholder="Vnesi datum rojstva" />-->
            <input type="password" name="pass1" class="form-control mb-4" placeholder="Password" required="required" />
            <input type="password" name="pass2" class="form-control mb-4" placeholder="Reenter password" required="required" /><br>
            <input type="submit" value="Sign up" />
        </form>
    </div>
    <div class="registration-content">
        <p>Have an account? <a href="login.php">Log in</a></p>
    </div>
</div>
<?php
include_once './footer.php';
?>