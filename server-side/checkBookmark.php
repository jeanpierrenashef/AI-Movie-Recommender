<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "connection.php";

$user_id = $_POST["user_id"];
$movie_id = $_POST["movie_id"];

$query = $connection->prepare("SELECT * FROM BOOKMARKS WHERE user_id=? AND movie_id=?");
$query->bind_param("ii", $user_id,$movie_id);
$query->execute();

$result = $query->get_result();

if($result->num_rows > 0){
    echo json_encode([
        "status" => true,
        "message" => "exists/already bookmarked"
    ]);
}else{
    echo json_encode([
        "status" => false
    ]);
}
