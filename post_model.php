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
                                            $query1 = "SELECT u.profile_pic AS profile_pic, u.username AS username, c.message AS message FROM users u INNER JOIN comments c ON u.id=c.user_id INNER JOIN posts p ON p.id=c.post_id WHERE c.post_id = ? ORDER BY c.date DESC";
                                            $stmt1 = $pdo->prepare($query1);
                                            $stmt1->execute([$post['post_id']]);
                                            while ($comment = $stmt1->fetch()) {
                                                if (empty($comment['profile_pic'])) {
                                                    $comment['profile_pic'] = 'images/profile.png';
                                                }
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
                                                echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like fs-custom" id="like' . $post['post_id'] . '"><span class="flaticon-heart"></span></span>';
                                            } else {
                                                echo '<span data-content_id="' . $post['post_id'] . '" role="button" class="like fs-custom" id="like' . $post['post_id'] . '"><span class="flaticon-heart1"></span></span>';
                                            }
                                            ?>
                                        </form>
                                    </div>
                                    <div class="float-right mr-2">
                                        <form action="delete_post.php" method="POST">
                                            <input type=" number" name="id" value="<?php echo $post['post_id']; ?>" hidden>
                                            <span class=" fs-custom mr-2 fs-2 font-weight-600 sign-a save" role="button" onclick="this.parentNode.submit();">Delete</span>
                                        </form>
                                    </div>
                                    <div class="float-right mr-2">
                                        <form action=" save.php" method="POST">
                                            <?php
                                            $query1 = "SELECT * FROM saved_posts WHERE post_id = ? AND user_id = ?";
                                            $stmt1 = $pdo->prepare($query1);
                                            $stmt1->execute([$post['post_id'], $_SESSION['user_id']]);
                                            if ($stmt1->rowCount() == 0) {
                                                echo '<span data-content_id="' . $post['post_id'] . '" class="fs-custom mr-2 fs-2 font-weight-600 sign-a save" role="button" id="save' . $post['post_id'] . '">Save</span>';
                                            } else {
                                                echo '<span data-content_id="' . $post['post_id'] . '" class="fs-custom mr-2 fs-2 font-weight-600 sign-a save" role="button" id="save' . $post['post_id'] . '">Saved</span>';
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