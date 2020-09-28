<?php
include_once('session.php');
include_once('database.php');

$query = "DELETE FROM followers WHERE user_id = ? AND follower_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['profile_id'], $_SESSION['user_id']]);
header("Location: profile_visit.php");
?>
