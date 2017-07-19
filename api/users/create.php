 <?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(!isset($_POST) || !isset($_POST['username'])) die();

session_start();

//database connection and users
include_once "../config/database.php";
include_once "../objects/users.php";

$response = array();

// get database connection
$database = new Database();
$db = $database->getConnection();

//prepare user object
$user = new Users($db);

// get id of user to be edited
$newUserid = $_POST['username'];
$newPass = $_POST['password'];

//set id property of user to be edited
$user->username = $newUserid;

//set user property value
$user->password = $newPass;

//update the user
if($user->create()){
	$response['status'] = 'created';
}

// if unable to update user
else{
	echo '{';
		echo '"message": "Unable to update user."';
	echo '}';
}

echo json_encode($response);