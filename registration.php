<?php
include_once './header.php';
?>
<div class="registration-main m-4 p-4">
    <div class="registration-content">
        <h1 class="instantgram pb-4 mb-4 big-text">iConnect</h1>

        <form action="user_insert.php" method="post">
            <input type="text" name="name" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Name and surname" required="required" maxlength="20"/>
            <input type="email" name="email" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Email" required="required" />
            <input type="text" name="username" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Username" required="required" maxlength="20"/>
            <input type="text" name="phone" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Mobile number" />
            <!--<input type="date" name="birthday" class="form-control mb-4" value="2000-01-01" placeholder="Vnesi datum rojstva" />-->
            <input type="password" name="pass1" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Password" required="required" />
            <input type="password" name="pass2" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Confirm password" required="required" />
            <?php
            if (isset($_SESSION['register_error'])) {
            echo '<div class="w-75 mx-auto mt-3"><p class="text-danger fs-1">'.$_SESSION["register_error"].'</p></div>';
            }
            else{
                echo "<br>";
            }
            unset($_SESSION['register_error']);
            ?>
            <input type="submit" class="btn btn-primary w-75 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Sign up" />
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