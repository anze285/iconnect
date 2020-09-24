<?php
include_once './header.php';
include_once './database.php';
?>

<div class="d-flex justify-content-center custom-index-div">
    <div class="">
        <?php
        $query = "SELECT u.username AS username, p.description AS description, i.root AS root FROM users u INNER JOIN posts p ON u.id=p.user_id INNER JOIN images i ON p.id=i.post_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while ($post = $stmt->fetch()) {
        ?>
            <div class="bg-white my-5 border">
                <div class="m-2 align-middle">
                    <img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">
                    <span class="font-weight-bolder fs-2 mt-1"><?php echo $post['username']; ?></span>
                </div>
                <div class="mt-2">
                    <img class="img-fluid custom-width" src="<?php echo $post['root']; ?>" alt="post-pic">
                </div>
                <div class="mt-2">
                    <div class="float-left">
                        <a class="" href="#"><span class="flaticon-heart"></span></a>
                    </div>
                    <div class="float-left">
                        <a class="" href="#"><span class="flaticon-heart"></span></a>
                    </div>
                    <div class="float-left">
                        <a class="" href="#"><span class="flaticon-heart"></span></a>
                    </div>
                    <div class="float-right mr-2">
                        <a class="" href="#"><span class="flaticon-heart"></span></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="mt-2 ml-4">
                    <p class="fs-1 mb-2">Liked by <span class="font-weight-bolder">1024</span></p>
                </div>
                <div class="ml-4">
                    <p class="fs-1 mb-1"><span class="font-weight-bolder">anze_gorsek</span> Sprostitev po šoli ;)</p>
                </div>
                <div class="ml-4">
                    <p class="fs-2 mb-1 text-black-50">View all <span>21</span> comments</p>
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
    <div class="d-none d-lg-block ml-4 mt-5">
        <div class="ml-1 mb-3 line-height">
            <img class="custom-img float-left mr-3" src="images/profile.png" alt="profile-pic">
            <span class="font-weight-bolder fs-2 float-left mt-2">anze_gorsek</span><br>
            <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
        </div>
        <div>

            <h6 class="text-black-50">Suggestions For You</h6>

            <div class="mt-3 line-height">
                <img class="custom-img1 float-left mr-3" src="images/profile.png" alt="profile-pic">
                <span class="font-weight-bolder fs-2 float-left mt-1">anze_gorsek</span><br>
                <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
            </div>
            <div class="mt-3 line-height">
                <img class="custom-img1 float-left mr-3" src="images/profile.png" alt="profile-pic">
                <span class="font-weight-bolder fs-2 float-left mt-1">anze_gorsek</span><br>
                <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
            </div>
            <div class="mt-3 line-height">
                <img class="custom-img1 float-left mr-3" src="images/profile.png" alt="profile-pic">
                <span class="font-weight-bolder fs-2 float-left mt-1">anze_gorsek</span><br>
                <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
            </div>
            <div class="mt-3 line-height">
                <img class="custom-img1 float-left mr-3" src="images/profile.png" alt="profile-pic">
                <span class="font-weight-bolder fs-2 float-left mt-1">anze_gorsek</span><br>
                <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
            </div>
            <div class="mt-3 line-height">
                <img class="custom-img1 float-left mr-3" src="images/profile.png" alt="profile-pic">
                <span class="font-weight-bolder fs-2 float-left mt-1">anze_gorsek</span><br>
                <span class="text-black-50 fs-1 clearfix">Anže Goršek</span>
            </div>
        </div>
    </div>
</div>
<?php
include_once './footer.php';
?>