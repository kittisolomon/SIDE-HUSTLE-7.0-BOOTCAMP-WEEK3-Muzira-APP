<?php
include 'function.php';
require 'db_con.php';


$data = json_decode(file_get_contents('php://input'));

//  $user_id = "1";
 $user_id = $data->user_id;


$favorite=array();
if(!empty($user_id)){
// if(!empty($data->user_id)){
    $sql = "SELECT * FROM favorite_songs WHERE user_id = '$user_id' ORDER BY song_id DESC LIMIT 10";
    $result =mysqli_query($db_con, $sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            $song_id= $row["song_id"];
        
        $sql2="SELECT * FROM musics WHERE id ='$song_id'";
        $result2=mysqli_query($db_con, $sql2);
        if ($result2->num_rows > 0) {
            while($row =  $result2->fetch_assoc()) {
            $song["artist_name"] = $row["artist_name"];
            $song["music"] = $row["music"];
            $song["music_title"] = $row["music_title"];
            $song["artist_label"] = $row["artist_label"];
            $song["genre"] = $row["genre"];
            $song["cover_picture"] = $row["cover_picture"];
            $song["release_date"] = $row["release_date"];
            $all_song["favorite_songs"][] = $song;
            }
        }
           
    
        }
         $favorite =  $all_song;
            // Convert the array to JSON format
            $response = json_encode($favorite);
            // Output the JSON data
            echo $response;
            return;
           
    } else {
        $response = json_encode(['status'=>'error','message'=>'no favorite songs available']);
   
        echo $response;
            return;
    }
}
else{
    $response = json_encode(['status'=>'error','message'=>'please login']);
   
        echo $response;
            return;
}
?>