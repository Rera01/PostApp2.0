<?php
//header requests
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if(!isset($_POST) || !isset($_POST['userid']) || empty($_FILES)) die();

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

//Set the path where the files are going to be stored
$path = '../../imgs/' . $_FILES['file']['name'];

// get id of user to be edited
$userid = $_POST['userid'];

if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
	$newPic = $_FILES['file']['name'];
}

//set id property of user to be edited
$user->userid = $userid;

//set user property value
$user->picture = $newPic;

//update the user
if($user->update_pic()){
	$response['status'] = 'done';
	$response['newPic'] = $newPic;
}

// if unable to update user
else{
	echo '{';
		echo '"message": "Unable to update user."';
	echo '}';
}

echo json_encode($response);