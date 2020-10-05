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
    $user['profile_pic'] = 'images/profile.png';
}
?>
<input type="text" value="<?php echo $user['profile_pic'] ?>" id="profile_pic1" hidden>
<input type="text" value="<?php echo $user['username'] ?>" id="username1" hidden>

<div class="container mt-5 pt-4 mb-4">
    <h1 class="text-center mt-0 mb-3 instantgram font-weight-normal">Discoveries</h1>
    <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3'>
        <?php
        $query = "SELECT DISTINCT p.id AS post_id, u.profile_pic AS profile_pic, u.id AS id, u.username AS username, p.description AS description, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id WHERE u.id != ? ORDER BY RAND() LIMIT 18";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id']]);
        $count = $stmt->rowCount();
        for (; $post = $stmt->fetch(); $j++) {
            $shownposts[$j] = $post['post_id'];
            $query1 = "SELECT l.title AS title FROM locations l INNER JOIN posts p ON l.id=p.location_id WHERE p.id = ?";
            $stmt1 = $pdo->prepare($query1);
            $stmt1->execute([$post['post_id']]);
            $location = $stmt1->fetch();
        ?>
            <div class="col mb-4">
                <div class="bg-white border">
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
                            <span class="float-right mt-2 mr-3"><?php echo $location['title']; ?></span>
                        </div>
                    </form>
                    <img class="img-fluid img-strech" src="<?php echo $post['root']; ?>" alt="post-pic" type="button" data-toggle="modal" data-target="#postmodal<?php echo $j; ?>">

                </div>
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