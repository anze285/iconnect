<?php
include_once './header.php';
include_once './database.php';

$query = "SELECT name, username, bio, profile_pic FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
$shownposts = array();
$j = 0;
if (empty($user['profile_pic'])) {
    $user['profile_pic'] = 'images/profile.png';
}
?>
<input type="text" value="<?php echo $user['profile_pic'] ?>" id="profile_pic1" hidden>
<input type="text" value="<?php echo $user['username'] ?>" id="username1" hidden>

<div class="container-fluid mt-5 pt-md-4 w-custom">
    <div class="row justify-content-md-center px-2 px-sm-5 pt-2">
        <div class="col-auto justify-content-center px-0 px-md-5">
            <?php
            if (!empty($user['profile_pic'])) {
            ?>
                <img class="custom-img2 mr-0 mr-md-3" src="<?php echo $user['profile_pic']; ?>" alt="profile-pic">
            <?php
            } else {
            ?>
                <img class="custom-img2 mr-0 mr-md-3" src="images/profile.png" alt="profile-pic">
            <?php
            }
            ?>
        </div>
        <div class="col ml-0 ml-md-4 my-auto">
            <div class="float-none ml-3 ml-sm-0 float-sm-right float-md-none">
                <div>

                    <span class="fs-3 font-weight-100 align-middle"><?php echo $user['username']; ?></span>
                    <a href="edit_profile.php" class="ml-4 btn btn-outline-dark btn-sm align-bottom mb-1 px-3 d-none d-lg-inline-block">Edit profile</a>
                    <!-- Button trigger modal -->
                    <a type="button" class="d-none d-lg-inline-block btn btn-outline-dark btn-sm align-bottom mb-1 px-3 ml-2" data-toggle="modal" data-target="#exampleModalCenter">
                        New post
                    </a>
                    <div class="mt-1">
                        <a href="edit_profile.php" class="fs-profile btn btn-outline-dark btn-sm align-bottom mb-1 px-2 px-sm-3 d-inline-block d-lg-none">Edit profile</a>
                        <!-- Button trigger modal -->
                        <a type="button" class="fs-profile d-inline-block btn btn-outline-dark btn-sm align-bottom mb-1 px-2 px-sm-3 ml-2 d-lg-none" data-toggle="modal" data-target="#exampleModalCenter">
                            New post
                        </a>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">New post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="new_post.php" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type=" text" placeholder="Description" name="description" class="mb-2"><br>
                                        <input type="text" placeholder="Destination" name="destination" maxlength="20" class="mb-2"><br>
                                        <input type="file" required="required" name="fileToUpload" accept="image/*">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="post">Publish post</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-2">
                    <?php
                    $query = "SELECT COUNT(*) AS count FROM posts WHERE user_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_SESSION['user_id']]);
                    $post = $stmt->fetch();
                    ?>
                    <span class="fs-profile"><span class="font-weight-bolder"><?php echo $post["count"]; ?></span><span class="mr-1 mr-sm-3"> posts</span></span>
                    <?php
                    $query = "SELECT COUNT(*) AS count FROM followers WHERE user_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_SESSION['user_id']]);
                    $followers = $stmt->fetch();
                    ?>
                    <span type="button" data-toggle="modal" data-target="#modalfollowers" class="fs-profile"><span class="font-weight-bolder"><?php echo $followers["count"]; ?></span><span class="mr-1 mr-sm-3"> followers</span></span>
                    <div class="modal fade" id="modalfollowers" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Followers</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $query = "SELECT u.id AS id, u.username AS username, u.profile_pic AS profile_pic FROM users u INNER JOIN followers f ON u.id=f.follower_id WHERE f.user_id = ?";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute([$_SESSION['user_id']]);
                                    if ($stmt->rowCount() == 0) {
                                        echo "No one follows you yet.";
                                    }
                                    for ($i = 0; $followers = $stmt->fetch(); $i++) {
                                        if (empty($followers['profile_pic'])) {
                                            $followers['profile_pic'] = 'images/profile.png';
                                        }
                                        if ($i != 0) {
                                            echo '<div class="dropdown-divider my-0"></div>';
                                        }
                                        echo '<form action="profile_session.php" method="POST">';
                                        echo '<div role="button" onclick="this.parentNode.submit();" class="d-flex justify-content-start px-1 py-1 max-content"><div>';
                                        echo '<img class="custom-img1 mr-3" src="' . $followers['profile_pic'] . '" alt="profile-pic">';
                                        echo '</div><div class="my-auto pb-1"><span><span class="px-0 font-weight-bold py-0" href="">' . $followers['username'] . '</span></span></div></div>';
                                        echo '<input type="number" name="id" value="' . $followers['id'] . '" hidden>';
                                        echo '</form>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query = "SELECT COUNT(*) AS count FROM followers WHERE follower_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_SESSION['user_id']]);
                    $following = $stmt->fetch();
                    ?>
                    <span type="button" data-toggle="modal" data-target="#modalfollowing" class="fs-profile"><span class="font-weight-bolder"><?php echo $following["count"]; ?></span><span> following</span></span>
                    <div class="modal fade" id="modalfollowing" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Following</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $query = "SELECT u.id AS id, u.username AS username, u.profile_pic AS profile_pic FROM users u INNER JOIN followers f ON u.id=f.user_id WHERE f.follower_id = ?";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute([$_SESSION['user_id']]);
                                    if ($stmt->rowCount() == 0) {
                                        echo "You don't follow anyone yet.";
                                    }
                                    for ($i = 0; $following = $stmt->fetch(); $i++) {
                                        if (empty($following['profile_pic'])) {
                                            $following['profile_pic'] = 'images/profile.png';
                                        }
                                        if ($i != 0) {
                                            echo '<div class="dropdown-divider my-0"></div>';
                                        }
                                        echo '<form action="profile_session.php" method="POST">';
                                        echo '<div role="button" onclick="this.parentNode.submit();" class="d-flex justify-content-start px-1 py-1 max-content"><div>';
                                        echo '<img class="custom-img1 mr-3" src="' . $following['profile_pic'] . '" alt="profile-pic">';
                                        echo '</div><div class="my-auto pb-1"><span><span class="px-0 font-weight-bold py-0" href="">' . $following['username'] . '</span></span></div></div>';
                                        echo '<input type="number" name="id" value="' . $following['id'] . '" hidden>';
                                        echo '</form>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="fs-profile font-weight-600"><?php echo $user['name']; ?></span>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <p class="fs-profile-sm"><?php echo $user['bio']; ?></p>
        </div>
    </div>
    <hr>
    <div>
        <div class="container">
            <h2 class="text-center mt-0 mb-3 instantgram font-weight-normal">My posts</h2>
            <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>
                <?php
                $query = "SELECT DISTINCT p.id AS post_id, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE u.id = ? ORDER BY p.date DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                $count = $stmt->rowCount();
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