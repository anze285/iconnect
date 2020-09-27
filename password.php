<?php
include_once './header.php';
include_once './database.php';

$query = "SELECT username FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<h2 class="mt-5 pt-5 text-center instantgram font-weight-normal">Change password</h2>
<div class="password-main mt-5 mb-4">
    <div class="password-content">
        <div class="d-flex justify-content-center mb-4">
            <img class="custom-img mr-3" src="images/profile.png" alt="profile-pic">
            <h4 class="font-weight-normal my-auto"><?php echo $user['username']; ?></h4>
        </div>
        <form action="change_password.php" method="post">
            <input type="password" name="oldpass" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Old password" required="required" />
            <input type="password" name="pass1" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="New password" required="required" />
            <input type="password" name="pass2" class="form-control mb-1 w-75 mx-auto border bg-fafafa fs-1 py-2" placeholder="Confirm new password" required="required" />
            <?php
            if (isset($_SESSION['password_error'])) {
                echo '<div class="w-75 mx-auto mt-3"><p class="text-danger fs-1">' . $_SESSION["password_error"] . '</p></div>';
            } elseif (isset($_SESSION['password_changed'])) {
                echo '<div class="w-75 mx-auto mt-3"><p class="text-success fs-1">' . $_SESSION["password_changed"] . '</p></div>';
            } else {
                echo "<br>";
            }
            unset($_SESSION['password_changed']);
            unset($_SESSION['password_error']);
            ?>
            <input type="submit" class="btn btn-primary w-75 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Change Password" /><br>
            <a href="edit_profile.php" class="fs-1 c-00376B">Edit profile</a>
        </form>
    </div>
</div>
<?php
include_once './footer.php';
?>