<?php
//header requests
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if(!isset($_POST) || !isset($_POST['userid'])) die();

session_start();

if($_SESSION['id'] != $_POST['userid']) die(); //CSRF attack

//inclide database and object files
include_once '../config/database.php';
include_once '../objects/users.php';

$response = array();

// get database connection
$database = new Database();
$db = $database->getConnection();

//prepare user object
$user = new Users($db);

// get id of user to be edited
$userid = $_POST['userid'];
$newPass = $_POST['password'];

//set id property of user to be edited
$user->userid = $userid;

//set user property value
$user->password = $newPass;

//update the user
if($user->update_pass()){
	$response['status'] = 'done';
}

// if unable to update user
else{
	echo '{';
		echo '"message": "Unable to update user."';
	echo '}';
}

echo json_encode($response);