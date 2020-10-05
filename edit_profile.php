<?php
include_once './header.php';
include_once './database.php';

$query = "SELECT name, username, email, bio, phone_number, profile_pic FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<h2 class="mt-5 pt-5 text-center instantgram font-weight-normal">Edit profile</h2>
<div class="password-main mt-5 mb-4">
    <div class="password-content">
        <div class="d-flex justify-content-center mb-4">
            <?php
            if (!empty($user['profile_pic'])) {
            ?>
                <img class="custom-img mr-3" src="<?php echo $user['profile_pic']; ?>" alt="profile-pic">
            <?php
            } else {
            ?>
                <img class="custom-img mr-3" src="images/profile.png" alt="profile-pic">
            <?php
            }
            ?>
            <div class="text-left">
                <h4 class="font-weight-normal my-auto"><?php echo $user['username']; ?></h4>
                <span class="fs-5 font-weight-600 sign-a" type="button" data-toggle="modal" data-target="#changeprofilepic">Change Profile Photo</span>

                <div class="modal fade" id="changeprofilepic" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalCenterTitle">Change profile Photo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="upload_pic.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input class="" type="file" id="file" required="required" name="fileToUpload" accept="image/*">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="picture">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="update_profile.php" method="post">
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="colFormLabelSm1" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['name']; ?>" required="required" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="colFormLabelSm2" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['email']; ?>" required="required" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Phone</label>
                <div class="col-sm-10">
                    <input type="text" name="phone" id="colFormLabelSm3" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" value="<?php echo $user['phone_number']; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm pl-md-5">Bio</label>
                <div class="col-sm-10">
                    <textarea name="bio" id="colFormLabelSm4" class="form-control mb-1 w-75 border bg-fafafa fs-1 ml-md-4 mx-auto" style="height: 100px;"><?php echo $user['bio']; ?></textarea>
                </div>
            </div>
            <?php
            if (isset($_SESSION['profile_error'])) {
                echo '<div class="w-75 mx-auto"><p class="text-danger fs-1">' . $_SESSION["profile_error"] . '</p></div>';
            }
            if (isset($_SESSION['profile_changed'])) {
                echo '<div class="w-75 mx-auto"><p class="text-success fs-1">' . $_SESSION["profile_changed"] . '</p></div>';
            }
            unset($_SESSION['profile_changed']);
            unset($_SESSION['profile_error']);
            ?>
            <div class="w-100">
                <input type="submit" class="btn btn-primary w-35 mb-2 fs-1 mt-0 font-weight-bolder bg-0095F6 p-1 first-button fs-2" value="Submit" />
            </div>
            <a class="fs-1 c-00376B" href="password.php">Change password</a>
        </form>
    </div>
</div>
<?php
include_once './footer.php';
?>