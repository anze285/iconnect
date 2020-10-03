<?php
include_once './header.php';
include_once './database.php';
$shownposts = array();
$j = 0
?>

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
                    <p class="fs-1 mb-1"><span class="font-weight-bolder">anze_gorsek</span> Sprostitev po šoli</p>
                </div>
                <div class="ml-4">
                    <p type="button" data-toggle="modal" data-target="#postmodal<?php echo $j; ?>" class="fs-2 mb-1 text-black-50">View all <span>21</span> comments</p>
                </div>
                <div class="ml-4">
                    <p class="fs-1 mb-1"><span class="font-weight-bolder">user-404</span> Res lep sladoled</p>
                </div>
                <div class="ml-4">
                    <p class="fs-4 mb-1 text-black-50 text-uppercase">21 hours ago</p>
                </div>
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
        <div class="modal-content w-model p-2">
            <div class="modal-body w-model p-0">
                <div class="column w-model">
                    <div class="row h-auto">
                        <div class="d-none d-670-block col-8 pr-0">
                            <img class="img-fluid img-cover" src="<?php echo $post['root']; ?>">
                        </div>
                        <div class="col col-md-4 pl-0">
                            <div class="">
                                <form action="profile_session.php" method="POST">
                                    <input type="number" name="id" value="<?php echo $post['user_id']; ?>" hidden>
                                    <div class="my-2 mx-3" role="button" onclick="this.parentNode.submit();">
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
                                        <p class="fs-5 mb-2">Liked by <span class="font-weight-bolder" id="likes_p<?php echo $post['post_id']; ?>"><?php echo $likes; ?></span></p>
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