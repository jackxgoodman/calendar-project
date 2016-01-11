<?php
require 'database.php';
 
header('Content-type: application/json');

$user = $_POST['username'];
$pwd_guess = $_POST['password'];

 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), userID, password FROM users WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
 
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	ini_set("session.cookie_httponly", 1);
	session_start();
	$token = substr(md5(rand()), 0, 10);
	$_SESSION['token'] = $token;
    
    echo json_encode(array(
        "success" => true,
        "userID" => $user_id,
        "token" => $token
        ));
	
	exit;	
}
else{
	echo json_encode(array(
        "success" => false,
        "$pwd_guess" => $pwd_guess,
        "$pwd_hash" => $pwd_hash
    ));
    
	exit;	
}
?>