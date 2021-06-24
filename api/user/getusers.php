<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: user/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new user($db);
$stmt = $user->read();
$num = $stmt->rowCount();

// check if more than 0 record found
    if($num>0){
        $users_arr=array();
        $users_arr["users"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $user_item=array(
                "id" => $id,
                "firstname" => $firstname, 
                "lastname" => $lastname, 
                "email" => $email,
                "type" => $type
            );
            array_push($users_arr["users"], $user_item);
        }

        http_response_code(200);
        echo json_encode($users_arr);
    }
  
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No users found.")
        );
    }
?>