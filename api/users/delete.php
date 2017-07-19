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

//set id property of user to be deleted
$user->userid = $userid;

//delete the user
if($_SESSION['id'] == "1"){
	$response['status'] = 'noThisOne';
}
elseif($user->delete()){
	$response['status'] = 'deleted';
}


// if unable to update user
else{
	echo '{';
		echo '"message": "Unable to delete user."';
	echo '}';
}

echo json_encode($response);

session_destroy();