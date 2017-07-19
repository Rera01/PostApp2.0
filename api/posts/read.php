<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//inclide database and object files
include_once '../config/database.php';
include_once '../objects/posts.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

//initialize object
$user = new Posts($db);

//query users
$stmt = $user->read();
$num = $stmt->rowCount();

//chech if more than 0 records found
if($num>0){
	//users array
	$users_arr = array();

	//retrieve our table content
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//extract row
		//this will make $row['username'] to just $username only
		extract($row);

		$user_item = array(
			"id" => (int)$id,
			"username" => $username,
			"title" => $title,
			"body" => $body,
			"picture" => $picture
		);

		array_push($users_arr, $user_item);
	}

	echo json_encode($users_arr, JSON_PRETTY_PRINT);
}
else{
	echo json_encode(
		array("message" => "No user found.")
	);
}
?>