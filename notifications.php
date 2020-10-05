<?php 
include_once 'database.php';
$query = "SELECT id FROM followers WHERE user_id = ? ORDER BY date DESC LIMIT 5";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
for($i = 0;$user = $stmt->fetch(); $i++){
    $query1 = "SELECT u.id AS id, u.profile_pic AS profile_pic, u.username AS username FROM users u INNER JOIN followers f ON u.id=f.follower_id WHERE f.id = ?";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->execute([$user['id']]);
    $user1 = $stmt1->fetch();
    if (empty($user1['profile_pic'])) {
        $user1['profile_pic'] = 'images/profile.png';
    }
    if ($i != 0) {
        echo '<div class="dropdown-divider my-0"></div>';
    }
    //echo '<a class="dropdown-item" href="edit_profile.php">'.$user1['username'].'</a></div>';
    echo '<form action="profile_session.php" method="POST">';
    echo '<div role="button" onclick="this.parentNode.submit();" class="d-flex justify-content-start px-1 py-1 max-content"><div>';
    echo '<img class="custom-img1 mr-3" src="'.$user1['profile_pic'].'" alt="profile-pic">';
    echo '</div><div class="my-auto pb-1"><span><span class="px-0 font-weight-bold py-0" href="">' . $user1['username'] . '</span> started following you.</span></div></div>';
    echo '<input type="number" name="id" value="' . $user1['id'] . '" hidden>';
    echo '</form>';
}

?>