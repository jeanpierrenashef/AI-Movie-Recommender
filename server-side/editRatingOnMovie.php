<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include "connection.php";


$user_id = $_POST["user_id"];
$movie_id = $_POST["movie_id"];
$rating_scale = $_POST["rating_scale"];;


$query = $connection->prepare("UPDATE ratings SET rating_scale = ? WHERE user_id = ? AND movie_id = ?");
$query->bind_param("iii", $rating_scale, $user_id, $movie_id);

$query->execute();

$result = $query->affected_rows;

if($result != 0){
    $query1 = $connection->prepare("UPDATE movies SET avg_rating = (SELECT AVG(rating_scale) FROM ratings WHERE movie_id=$movie_id) WHERE movie_id=$movie_id");
    $query1->execute();

    $result1 = $query1->affected_rows;
    if($result1 != 0){
        echo json_encode([
            "status" => "Average rating of $movie_id updated"
        ]);
    }else{
        echo json_encode([
            "status" => "Failure to updated average rating"
        ]);
    } 

    echo json_encode([
        "status" => "Rating edited",
    ]);
}else{
    echo json_encode([
        "status" => "Failed to edit rating"
    ]);
}
