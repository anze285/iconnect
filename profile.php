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
            <h2 class="text-center mt-0 mb-3 instantgram font-weight-normal">My posts</h2>
            <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>
                <?php
                $query = "SELECT DISTINCT i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE u.id = ? ORDER BY p.date DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                $count = $stmt->rowCount();
                for ($i = 0; $post = $stmt->fetch(); $i++) {

                ?>
                    <div class="col mb-4">
                        <img class="img-fluid img-strech" src="<?php echo $post['root']; ?>" alt="post-pic" type="button" data-toggle="modal" data-target="#postmodal<?php echo $i; ?>">
                    </div>

                <?php

                }
                ?>
            </div>

        </div>
        <?php
        $query = "SELECT DISTINCT p.id AS post_id, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE u.id = ? ORDER BY p.date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        for ($i = 0; $post = $stmt->fetch(); $i++) {
            echo '<div class="modal fade mx-auto" id="postmodal' . $i . '" tabindex="-1" role="dialog" aria-hidden="true">'
        ?>
            <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
                <div class="modal-content w-model">
                    <div class="modal-body w-model p-0">
                        <div class="column w-model">
                            <div class="row h-auto">
                                <div class="d-none d-670-block col-8 pr-0">
                                    <img class="img-fluid img-cover" src="<?php echo $post['root']; ?>">
                                </div>
                                <div class="col col-md-4">
                                    <div class="">
                                        <div class="my-2 mx-3">
                                            <?php
                                            if (!empty($user['profile_pic'])) {
                                            ?>
                                                <img class="custom-img1 mr-3" src="<?php echo $user['profile_pic']; ?>" alt="profile-pic">
                                            <?php
                                            } else {
                                            ?>
                                                <img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                            <?php
                                            }
                                            ?>
                                            <span class="font-weight-bolder fs-2 mt-1"><?php echo $user['username']; ?></span>
                                        </div>
                                        <hr>
                                        <div id="wraper" class="pr-1">
                                            <div class="scrollbar" id="style-3">
                                                <div class="force-overflow">
                                                    <div class="mx-3">
                                                        <img class="mb-1 custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                        <span class="font-weight-bolder fs-2 mt-1">Marcel_matko_sotosek</span>
                                                        <p class="ml-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis illum odit deleniti! Aliquam similique sint ipsam cupiditate sapiente, explicabo et numquam molestias nobis consectetur maxime, debitis mollitia! Velit, rerum assumenda!</p>
                                                    </div>
                                                    <div class="mx-3">
                                                        <img class="mb-1 custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                        <span class="font-weight-bolder fs-2 mt-1">Marcel_matko_sotosek</span>
                                                        <p class="ml-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis rerum quibusdam eligendi adipisci inventore? Accusantium nulla reprehenderit maxime deleniti cupiditate, incidunt odit quos nihil voluptatem a aliquid voluptates quae. Nisi.</p>
                                                    </div>
                                                    <div class="mx-3">
                                                        <img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                        <span class="font-weight-bolder fs-2 mt-1">Marcel_matko_sotosek</span>
                                                        <p class="ml-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt ad harum saepe beatae ipsum quia, vero non labore magni ipsam quidem odio iste soluta laboriosam! Doloremque tempora non quia fuga!</p>
                                                    </div>
                                                    <div class="mx-3">
                                                        <img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                        <span class="font-weight-bolder fs-2 mt-1">Marcel_matko_sotosek</span>
                                                        <p class="ml-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore vitae magni nisi neque obcaecati laudantium eaque vero quia recusandae nobis, labore iusto quod quaerat aliquid ex, culpa esse accusantium laboriosam!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="float-left">
                                                <form action="like.php" method="POST">
                                                    <?php
                                                    $query1 = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
                                                    $stmt1 = $pdo->prepare($query1);
                                                    $stmt1->execute([$post['post_id'], $_SESSION['user_id']]);
                                                    if ($stmt1->rowCount() == 0) {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like"><span class="flaticon-heart"></span></span>';
                                                    } else {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like"><span class="flaticon-heart1"></span></span>';
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
                                                        echo '<span data-content_id="' . $post['post_id'] . '" class="mr-2 fs-2 font-weight-600 sign-a save" role="button">Save</span>';
                                                    } else {
                                                        echo '<span data-content_id="' . $post['post_id'] . '" class="mr-2 fs-2 font-weight-600 sign-a save" role="button">Saved</span>';
                                                    }
                                                    ?>
                                                </form>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="mx-4 mt-3">
                                                <?php
                                                $query1 = "SELECT * FROM likes WHERE post_id = ?";
                                                $stmt1 = $pdo->prepare($query1);
                                                $stmt1->execute([$post['post_id']]);
                                                $likes = $stmt1->rowCount();
                                                ?>
                                                <p class="fs-5 mb-2">Liked by <span class="font-weight-bolder" id="likes<?php echo $post['post_id']; ?>"><?php echo $likes; ?></span></p>
                                            </div>
                                            <div>
                                                <textarea name="comment" class="comment border-top px-2 pt-2" placeholder="Add a comment ..."></textarea>
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