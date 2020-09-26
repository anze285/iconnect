<?php
include_once './header.php';
include_once './database.php';

$query = "SELECT name, username, email, bio, phone_number FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<h2 class="mt-5 pt-5 text-center instantgram font-weight-normal">Edit profile</h2>
<div class="password-main mt-5 mb-4">
    <div class="password-content">
        <h4 class="mb-4 font-weight-normal"><?php echo $user['username']; ?></h4>
        <form action="update_profile.php" method="post">
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="colFormLabelSm" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['name']; ?>" required="required" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="colFormLabelSm" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['email']; ?>" required="required" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Phone</label>
                <div class="col-sm-10">
                    <input type="text" name="phone" id="colFormLabelSm" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['phone_number']; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Bio</label>
                <div class="col-sm-10">
                    <textarea name="bio" id="colFormLabelSm" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" style="height: 100px;"><?php echo $user['bio']; ?></textarea>
                </div>
            </div>
            <div class="w-75 ml-5 pl-4">
                <input type="submit" class="btn btn-primary w-35 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2 ml-md-4" value="Submit" />
                <a class="btn btn-primary w-60 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2" href="password.php">Change password</a>
            </div>
        </form>
    </div>
</div>
<?php
include_once './footer.php';
?>