<?php
include_once('session.php');
include_once('database.php');

$query = "INSERT INTO followers(date, user_id, follower_id) VALUES (CURRENT_TIMESTAMP(), ?,?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['profile_id'], $_SESSION['user_id']]);
header("Location: profile_visit.php");
?>