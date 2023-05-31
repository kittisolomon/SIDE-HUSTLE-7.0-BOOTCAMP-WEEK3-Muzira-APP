<?php
include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));
$user_id = "1";
$song_id = "2";
$music_title="slow downd";

$dateTime = new DateTime('now', new DateTimeZone('Africa/Lagos')); 
$time=$dateTime->format("d-M-y  h:i A");

// $user_id = $data->user_id;
// $song_id = $data->song_id;
// $music_title = $data->music_title;

// Retrieve the latest released songs from the database


$sql = "SELECT * FROM musics WHERE id= '$song_id' AND music_title = '$music_title'";
$result =mysqli_query($db_con, $sql);


$songs = array();
if ($result->num_rows > 0) {
    while($row =  $result->fetch_assoc()) {
        $song["artist_name"] = $row["artist_name"];
        $song["music"] = $row["music"];
        $song["music_title"] = $row["music_title"];
        $song["artist_label"] = $row["artist_label"];
        $song["genre"] = $row["genre"];
        $song["cover_picture"] = $row["cover_picture"];
        $song["release_date"] = $row["release_date"];
        $all_song["all"][] = $song;
        $cart=$row["cart"];
        $cart += 1;
        mysqli_query($db_con,"UPDATE musics  SET cart = '$cart' WHERE id= '$song_id' AND music_title = '$music_title'");
        
    }
    $songs = $all_song;
     mysqli_query($db_con,'INSERT INTO recently_played (user_id,song_id,playdate) VALUES("'.$user_id.'","'.$song_id.'","'.$time.'")');
    $response = json_encode($songs);
    echo $response;
            return;
} else {
    $response = json_encode(['status'=>'error','message'=>'no songs available']);
   
        echo $response;
            return;
}

// Close the database connection
$db_con->close();



?>