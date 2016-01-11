<?php
require 'database.php';

header('Content-type: application/json');

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("select username from users where username = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
exit;
}
$stmt->bind_param('s', $username);

$stmt->execute(); 
$stmt->bind_result($existUser);

$stmt->fetch();
if (!is_null($existUser)) {
	echo json_encode(array(
		"success" => false,
		"message" => "username already exists"
	));
	exit;
}
$stmt->close();

$stmt2 = $mysqli->prepare("insert into users (username, password) values (?, ?)");

if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt2->bind_param('ss', $username, crypt($password));
$stmt2->execute();

if ($stmt2) {
    echo json_encode(array(
        "success"=>true,
        "token"=>substr(md5(rand()), 0, 10)
    ));
    $stmt2->close();
    exit;
}
else {
    echo json_encode(array(
        "success" => false,
        "message" => "insert did not execute properly"
    ));
}

?>