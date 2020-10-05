<?php
// create a new function

function search($text){
    
    include_once('database.php');
    $text = htmlspecialchars($text);
    $text = '%' . $text . '%';
    $query = "SELECT id, name, username, profile_pic FROM users WHERE name LIKE ? OR username LIKE ? LIMIT 5";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$text, $text]);

    
	for($i = 0; $user = $stmt->fetch(); $i++){
        echo '<form action="profile_session.php" method="POST">';
        // show each usid, er as a link
        if($i != 0){
            echo '<div class="dropdown-divider my-0"></div>';
        }
        echo '<div role="button" onclick="this.parentNode.submit();" class="bg-fafafa d-flex justify-content-start px-1 py-1"><div>';
        if (!empty($user['profile_pic'])) {
            echo '<img class="custom-img1 mr-3" src="'.$user['profile_pic'].'" alt="profile-pic">';
        } 
        else {              
           echo '<img class="custom-img1 mr-3" src="images/profile.png" alt="profile-pic">';      
        }
                            
        echo '</div><div class="my-auto pb-1"><span class="px-0 py-0" href="">'.$user['username']. '</span></div></div>';
		echo '<input type="number" name="id" value="'.$user['id'].'" hidden>';
        echo '</form>';
    }
}
// call the search function with the data sent from Ajax
if (!empty($_GET['txt'])) {
    search($_GET['txt']);
}

?>