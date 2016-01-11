<?php

ini_set("session.cookie_httponly", 1);

session_start();
require 'database.php';

$name = $_POST['eventname'];
$category = $_POST['eventcategory'];
$date = $_POST['eventdate'];
$time = $_POST['eventtime'];
$user_id = $_POST['user_id'];

$stmt = $mysqli->prepare("insert into events (eventName, date, time, userID, category) values (?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sssis', $name, $date, $time, $user_id, $category);
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