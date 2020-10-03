<?php
include_once './header.php';
include_once './database.php';

$query = "SELECT name, username, bio, profile_pic FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
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
                                    <input type="text" placeholder="Destination" name="destination">
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
            <h2 class="text-center mt-0 mb-3 instantgram font-weight-normal">Saved posts</h2>
            <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>

                <?php
                $query = "SELECT post_id AS id FROM saved_posts WHERE user_id = ? ORDER BY date DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                while ($post_id = $stmt->fetch()) {
                    $query1 = "SELECT DISTINCT i.root AS root FROM  posts p INNER JOIN images i ON p.id=i.post_id WHERE p.id = ?";
                    $stmt1 = $pdo->prepare($query1);
                    $stmt1->execute([$post_id['id']]);
                    $post = $stmt1->fetch();
                ?>
                    <div class="col mb-4">
                        <img class="img-fluid img-strech" src="<?php echo $post['root']; ?>" alt="post-pic">
                    </div>

                <?php

                }
                ?>
            </div>

        </div>

        <?php
        include_once './footer.php';
        ?>