 <?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//database connection and users
include_once "../config/database.php";
include_once "../objects/users.php";

$database = new Database();
$db = $database->getConnection();

$user = new Users($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));
//set user property values
$user->username = $data->username;
$user->password = $data->password;
$user->picture = $data->picture;

//create user
if($user->create()){
	echo '{';
		echo '"message": "User was created."';
	echo '}';
}
else{
	echo '{';
		echo '"message": "Inable to create user."';
	echo '}';
}

?>