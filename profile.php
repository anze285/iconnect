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
                <a href="edit_profile.php" class="ml-4 btn btn-outline-dark btn-sm align-bottom mb-1 px-3">Edit profile</a>
                <!-- Button trigger modal -->
                <a type="button" class="btn btn-outline-dark btn-sm align-bottom mb-1 px-3 ml-2" data-toggle="modal" data-target="#exampleModalCenter">
                    New post
                </a>
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
                                    <input type="file" required="required" name="fileToUpload" accept="image/*">
                                    <input type=" text" placeholder="Description" name="description">
                                    <input type="text" placeholder="Destination" name="destination" maxlength="20">
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
                <span class="font-weight-bolder"><?php echo $post["count"]; ?></span><span class="mr-3"> posts</span>
                <?php
                $query = "SELECT COUNT(*) AS count FROM followers WHERE user_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                $followers = $stmt->fetch();
                ?>
                <span class="font-weight-bolder"><?php echo $followers["count"]; ?></span><span class="mr-3"> followers</span>
                <?php
                $query = "SELECT COUNT(*) AS count FROM followers WHERE follower_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
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
        for ($i = 0; $i < $j; $i++) {
            $query = "SELECT u.id AS user_id, u.profile_pic AS profile_pic, u.username AS username, p.id AS post_id, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE p.id = ? ORDER BY p.date DESC";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$shownposts[$i]]);
            $post = $stmt->fetch();
            echo '<div class="modal fade mx-auto" id="postmodal' . $i . '" tabindex="-1" role="dialog" aria-hidden="true">'
        ?>
            <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
                <div class="modal-content w-model p-0">
                    <div class="modal-body w-model p-0">
                        <div class="column w-model ">
                            <div class="row h-auto">
                                <div class="d-none d-670-block col-8 pr-0">
                                    <img class="img-fluid img-cover" src="<?php echo $post['root']; ?>">
                                </div>
                                <div class="col col-md-4 pl-0">
                                    <div class="">
                                        <form action="profile_session.php" method="POST">
                                            <input type="number" name="id" value="<?php echo $post['user_id']; ?>" hidden>
                                            <div class="mb-1 px-3 mt-3" role="button" onclick="this.parentNode.submit();">
                                                <?php
                                                if (!empty($post['profile_pic'])) {
                                                ?>
                                                    <img class="custom-img1 mr-3" src="<?php echo $post['profile_pic']; ?>" alt="profile-pic">
                                                <?php
                                                } else {
                                                ?>
                                                    <img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                <?php
                                                }
                                                ?>
                                                <span class="font-weight-bolder fs-custom mt-1"><?php echo $post['username']; ?></span>
                                            </div>
                                        </form>
                                        <hr>
                                        <div id="wraper" class="pr-1 pl-2">
                                            <div class="scrollbar" id="style-3">
                                                <div class="force-overflow" id="commentstext<?php echo $post['post_id']; ?>">
                                                    <?php
                                                    $query1 = "SELECT u.profile_pic AS profile_pic, u.username AS username, c.message AS message FROM users u INNER JOIN comments c ON u.id=c.user_id INNER JOIN posts p ON p.id=c.post_id WHERE post_id = ?";
                                                    $stmt1 = $pdo->prepare($query1);
                                                    $stmt1->execute([$post['post_id']]);
                                                    while ($comment = $stmt1->fetch()) {
                                                    ?>
                                                        <div class="mx-2">
                                                            <img class="mb-1 custom-img1 mr-3" src="<?php echo $comment['profile_pic']; ?>" alt="profile-pic">
                                                            <span class="font-weight-bolder fs-2 mt-1 fs-custom"><?php echo $comment['username']; ?></span>
                                                            <p class="ml-3 fs-custom"><?php echo $comment['message']; ?></p>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="float-left ml-2 ml-sm-0">
                                                <form action="like.php" method="POST">
                                                    <?php
                                                    $query1 = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
                                                    $stmt1 = $pdo->prepare($query1);
                                                    $stmt1->execute([$post['post_id'], $_SESSION['user_id']]);
                                                    if ($stmt1->rowCount() == 0) {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like fs-custom"><span class="flaticon-heart"></span></span>';
                                                    } else {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like fs-custom"><span class="flaticon-heart1"></span></span>';
                                                    }
                                                    ?>
                                                </form>
                                            </div>
                                            <div class="float-right mr-2">
                                                <form action="save.php" method="POST">
                                                    <?php
                                                    $query1 = "SELECT * FROM saved_posts WHERE post_id = ? AND user_id = ?";
                                                    $stmt1 = $pdo->prepare($query1);
                                                    $stmt1->execute([$post['post_id'], $_SESSION['user_id']]);
                                                    if ($stmt1->rowCount() == 0) {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" class="fs-custom mr-2 fs-2 font-weight-600 sign-a save" role="button">Save</span>';
                                                    } else {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" class="fs-custom mr-2 fs-2 font-weight-600 sign-a save" role="button">Saved</span>';
                                                    }
                                                    ?>
                                                </form>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="mx-3 mt-3">
                                                <?php
                                                $query1 = "SELECT * FROM likes WHERE post_id = ?";
                                                $stmt1 = $pdo->prepare($query1);
                                                $stmt1->execute([$post['post_id']]);
                                                $likes = $stmt1->rowCount();
                                                ?>
                                                <p class="fs-custom mb-2 float-left">Liked by <span class="font-weight-bolder" id="likes_p<?php echo $post['post_id']; ?>"><?php echo $likes; ?></span></p>
                                                <span data-content_id="<?php echo $post['post_id']; ?>" class="fs-custom fs-2 font-weight-600 sign-a float-right commenttext" role="button">Comment</span>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="pl-5 pl-md-1">
                                                <textarea id="comment<?php echo $post['post_id']; ?>" class="fs-custom comment border-top px-2 pt-2" placeholder="Add a comment ..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<?php
        }
?>
<?php
include_once './footer.php';
?>