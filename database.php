<?php
// Content of database.php
 
$mysqli = new mysqli('localhost', 'caluser', 'calpass', 'calendar');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
