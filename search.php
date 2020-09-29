<?php
// create a new function

function search($text){
    include_once('database.php');
    $text = htmlspecialchars($text);
    $text = '%' . $text . '%';
    $query = "SELECT name, username FROM users WHERE name LIKE ? OR username LIKE ? LIMIT 5";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$text, $text]);

	while($user = $stmt->fetch()){
        // show each user as a link
        echo $user['name'];
		
    }
}
// call the search function with the data sent from Ajax
search($_GET['txt']);

?>