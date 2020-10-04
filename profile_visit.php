<?php
include_once './header.php';
include_once './database.php';
$query = "SELECT name, username, bio, profile_pic FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['profile_id']]);
$user = $stmt->fetch();
$shownposts = array();
$j = 0;
if (empty($user['profile_pic'])) {
    $user['profile_pic'] = '/images/profile.png';
}
?>
<input type="text" value="<?php echo $user['profile_pic'] ?>" id="profile_pic1" hidden>
<input type="text" value="<?php echo $user['username'] ?>" id="username1" hidden>

<div class="container-fluid mt-5 pt-md-4 w-custom">
    <div class="row justify-content-md-center px-5 pt-2">
        <div class="col-auto justify-content-center px-5">
            <?php
            if (!empty($user['profile_pic'])) {
            ?>
                <img class="custom-img2 mr-3" src="<?php echo $user['profile_pic']; ?>" alt="profile-pic">
            <?php
            } else {
            ?>
                <img class="custom-img2 mr-3" src="images/profile.png" alt="profile-pic">
            <?php
            }
            ?>
        </div>
        <div class="col ml-4 my-auto">
            <div>
                <span class="fs-3 font-weight-100 align-middle"><?php echo $user['username']; ?></span>
                <?php
                $query = "SELECT id FROM followers WHERE user_id = ? AND follower_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['profile_id'], $_SESSION['user_id']]);
                if ($stmt->rowCount() == 1) {
                ?>
                    <a href="unfollowed.php" class="ml-4 btn btn-outline-dark btn-sm align-bottom mb-1 px-3">Unfollow</a>
                <?php
                } else {
                ?>
                    <a href="followed.php" class="ml-4 btn btn-outline-dark btn-sm align-bottom mb-1 px-3">Follow</a>
                <?php
                }
                ?>
            </div>
            <div class="my-2">
                <?php
                $query = "SELECT COUNT(*) AS count FROM posts WHERE user_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['profile_id']]);
                $post = $stmt->fetch();
                ?>
                <span class="font-weight-bolder"><?php echo $post["count"]; ?></span><span class="mr-3"> posts</span>
                <?php
                $query = "SELECT COUNT(*) AS count FROM followers WHERE user_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['profile_id']]);
                $followers = $stmt->fetch();
                ?>
                <span class="font-weight-bolder"><?php echo $followers["count"]; ?></span><span class="mr-3"> followers</span>
                <?php
                $query = "SELECT COUNT(*) AS count FROM followers WHERE follower_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['profile_id']]);
                $following = $stmt->fetch();
                ?>
                <span class="font-weight-bolder"><?php echo $following["count"]; ?></span><span> following</span>
            </div>
            <div>
                <span class="font-weight-600"><?php echo $user['name']; ?></span>
            </div>
            <div class="mt-1">
                <p class=" fs-2"><?php echo $user['bio']; ?></p>
            </div>
        </div>
    </div>
    <hr>
    <div>
        <div class="container">
            <h2 class="text-center mt-0 mb-3 instantgram font-weight-normal text-capitalize"><?php echo $user['username']; ?>'s posts</h2>
            <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>
                <?php
                $query = "SELECT DISTINCT p.id AS post_id, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE u.id = ? ORDER BY p.date DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['profile_id']]);
                for (; $post = $stmt->fetch(); $j++) {
                    $shownposts[$j] = $post['post_id'];

                ?>
                    <div class="col mb-4">
                        <img class="img-fluid img-strech" src="<?php echo $post['root']; ?>" alt="post-pic" type="button" data-toggle="modal" data-target="#postmodal<?php echo $j; ?>">
                    </div>

                <?php

                }
                ?>
            </div>

        </div>

        <?php
        include_once 'post_model.php';
        include_once './footer.php';
        ?>