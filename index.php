<?php
include_once './header.php';
include_once './database.php';
$shownposts = array();
$j = 0;
$query = "SELECT profile_pic, username FROM users WHERE id =?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
if (empty($user['profile_pic'])) {
    $user['profile_pic'] = '/images/profile.png';
}
?>
<input type="text" value="<?php echo $user['profile_pic'] ?>" id="profile_pic1" hidden>
<input type="text" value="<?php echo $user['username'] ?>" id="username1" hidden>


<div class="d-flex justify-content-center custom-index-div">
    <div class="">
        <?php
        $query = "SELECT DISTINCT p.id AS post_id, u.profile_pic AS profile_pic, u.id AS id, u.username AS username, p.description AS description, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id
        INNER JOIN followers f ON u.id = f.user_id WHERE f.follower_id = ? ORDER BY p.date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        if ($stmt->rowCount() == 0) {
            $query = "SELECT DISTINCT p.id AS post_id, u.profile_pic AS profile_pic, u.id AS id, u.username AS username, p.description AS description, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id
            WHERE u.id != ? ORDER BY RAND() LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['user_id']]);
        }
        for (; $post = $stmt->fetch(); $j++) {
            $shownposts[$j] = $post['post_id'];
        ?>
            <div class="bg-white my-5 border">
                <form action="profile_session.php" method="POST">
                    <div class="m-2 align-middle" role="button" onclick="this.parentNode.submit();">
                        <input type=" number" name="id" value="<?php echo $post['id']; ?>" hidden>
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
                        <span class="font-weight-bolder fs-2 mt-1"><?php echo $post['username']; ?></span>
                    </div>
                </form>
                <div class="mt-2">
                    <img class="img-fluid custom-width" src="<?php echo $post['root']; ?>" alt="post-pic">
                </div>
                <div class="mt-2">
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
                </div>
                <div class="mt-2 ml-4">
                    <?php
                    $query1 = "SELECT * FROM likes WHERE post_id = ?";
                    $stmt1 = $pdo->prepare($query1);
                    $stmt1->execute([$post['post_id']]);
                    $likes = $stmt1->rowCount();
                    ?>
                    <p class="fs-1 mb-2">Liked by <span class="font-weight-bolder" id="likes<?php echo $post['post_id']; ?>"><?php echo $likes ?></span></p>
                </div>
                <div class="ml-4">
                    <p class="fs-1 mb-1"><span class="font-weight-bolder"><?php echo $post['username'] ?></span> <?php echo $post['description'] ?></p>
                </div>
                <div class="ml-4">
                    <p type="button" data-toggle="modal" data-target="#postmodal<?php echo $j; ?>" class="fs-2 mb-1 text-black-50">View comments</p>
                </div>
                <!--<div class="ml-4">
                    <p class="fs-1 mb-1"><span class="font-weight-bolder">user-404</span> Res lep sladoled</p>
                </div>
                <div class="ml-4">
                    <p class="fs-4 mb-1 text-black-50 text-uppercase">21 hours ago</p>
                </div>-->
            </div>
        <?php
        }
        ?>
    </div>
    <?php
    $query = "SELECT name, username, profile_pic FROM users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    ?>
    <div class="d-none d-lg-block ml-4 mt-5">
        <div class="ml-1 mb-3 line-height" type="button" onclick="window.location='profile.php';">
            <div class="float-left mb-0">
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
            </div>
            <div class="float-left ml-1">
                <div class="mt-2 pt-1">
                    <span class="font-weight-bolder"><?php echo $user['username']; ?></span><br>
                    <span class="text-black-50 fs-2"><?php echo $user['name']; ?></span>
                </div>
            </div>
            <div class="clearfix">

            </div>
        </div>
        <div class="">

            <div class="mb-3">
                <h6 class="text-black-50">Suggestions For You</h6>
            </div>
            <?php
            $query = "SELECT id, name, username, profile_pic FROM users WHERE id != ? ORDER BY RAND() LIMIT 5";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_SESSION['user_id']]);
            while ($user = $stmt->fetch()) {
            ?>
                <form action="profile_session.php" method="POST">
                    <input type="number" name="id" value="<?php echo $user['id']; ?>" hidden>
                    <div class=" mt-2 line-height" role="button" onclick="this.parentNode.submit();">
                        <div class="float-left">
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
                        </div>
                        <div class="float-left">
                            <span class="font-weight-bolder fs-2 mt-1"><?php echo $user['username']; ?></span><br>
                            <span class="text-black-50 fs-1"><?php echo $user['name']; ?></span>
                        </div>
                        <div class="clearfix">

                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<?php
for ($i = 0; $i < $j; $i++) {
    $query = "SELECT DISTINCT u.id AS user_id, u.profile_pic AS profile_pic, u.username AS username, p.id AS post_id, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE p.id = ? ORDER BY p.date DESC";
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
                                            <div class="mx-2">
                                                <img class="mb-1 custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                                                <span class="font-weight-bolder fs-2 mt-1 fs-custom">Marcel_matko_sotosek</span>
                                                <p class="ml-3 fs-custom">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis illum odit deleniti! Aliquam similique sint ipsam cupiditate sapiente, explicabo et numquam molestias nobis consectetur maxime, debitis mollitia! Velit, rerum assumenda!</p>
                                            </div>
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