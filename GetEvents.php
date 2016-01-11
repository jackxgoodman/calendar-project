<?php

require 'database.php';

$month = $_POST['current_month'];
$year = $_POST['current_year'];
$userID = (int)$_POST['userID'];

header('Content-type: application/json');
$output = array();

$updatedMonth = ($month < 9) ? "0".($month+1) : "".($month+1);

$regexQuery = $year."-".$updatedMonth."-[0-9][0-9]";

$stmt = $mysqli->prepare("SELECT eventID, eventName, date, time, category FROM events WHERE userID = ? AND date REGEXP ? ORDER by time");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->bind_param('is', $userID, $regexQuery);
$stmt->execute(); 
$stmt->bind_result($eventID, $eventName, $eventDate, $eventTime, $eventCategory);

while ($stmt->fetch()) {
    $output[] = array("id"=>$eventID, "name"=>$eventName, "date"=>$eventDate, "time"=>$eventTime, "category"=>$eventCategory);
}
$stmt->close();

echo json_encode($output);

?>