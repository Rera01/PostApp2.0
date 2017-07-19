<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Receive POST values and start session
if(!isset($_POST)) die();

session_start();

if((isset($_POST['username'])) && (isset($_POST['password']))) {
	$login_user = $_POST['username'];
	$login_pass = $_POST['password'];
};

//inclide database and object files
include_once '../config/database.php';
include_once '../objects/users.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

//initialize object
$user = new Users($db);

//query users
$stmt = $user->read();
$num = $stmt->rowCount();

//chech if more than 0 records found
if($num>0){
	//users array
	$users_arr = array();
	$users_arr["records"] = array();

	//retrieve our table content
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row
		//this will make $row['username'] to just $username only
		extract($row);

		$user_item = array(
			"userid" => (int)$userid,
			"username" => $username,
			"password" => $password,
			"picture" => $picture
		);

		if(($login_user == $username) && ($login_pass == $password)){
			$_SESSION['id'] = $userid;
			$_SESSION['user'] = $username;
		}

		array_push($users_arr["records"], $user_item);
	}

	echo json_encode($users_arr);
}
else{
	echo json_encode(
		array("message" => "No user found.")
	);
}
?>