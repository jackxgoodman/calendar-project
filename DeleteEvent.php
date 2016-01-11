<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database.php';

$eventID = (int)$_POST['eventID'];

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("delete from events where eventID=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('i', $eventID);
$stmt->execute();

if ($stmt) {
	echo json_encode(array(
		"success" => true
	));
}
else {
	echo json_encode(array(
		"success" => false,
		"message" => "query failed"
	));
}
$stmt->close();

exit;

?>