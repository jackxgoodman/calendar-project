<?php
ini_set("session.cookie_httponly", 1);
require 'database.php';

session_start();

$eventID = (int)$_POST['eventID'];
$name = $_POST['eventname'];
$category = $_POST['eventcategory'];
$date = $_POST['eventdate'];
$time = $_POST['eventtime'];

if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

$stmt = $mysqli->prepare("update events set eventName=?, date=?, time=?, category=? where eventID=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ssssi', $name, $date, $time, $category, $eventID);
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