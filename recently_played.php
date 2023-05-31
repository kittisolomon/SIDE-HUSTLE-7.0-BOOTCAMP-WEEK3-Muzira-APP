<?php
include 'function.php';
require 'db_con.php';


// $data = json_decode(file_get_contents('php://input'));

//  $user_id = "1";
$user_id= $_GET['sessionId'];

// $recently_played=array();
if(!empty($user_id)){
// if(!empty($data->user_id)){
    $sql = "SELECT * FROM recently_played WHERE user_id = '$user_id' ORDER BY play_date DESC LIMIT 10";
    $result =mysqli_query($db_con, $sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
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
            $all_song["recently_played"][] = $song;
            }
        }
            
        }
        $recently_played =  $all_song;
            
            $response = json_encode(['status'=>'success','message'=>$recently_played]);
                    echo $response;
                    return;
            // // Convert the array to JSON format
            // $response = json_encode($recently_played);
            // // Output the JSON data
            // echo $response;
            // return;
           
        
    }else{
        $response = json_encode(['status'=>'error','message'=>'no song streamed yet']);
        echo $response;
            return;
    }
}else{
    $response = json_encode(['status'=>'error','message'=>'please login']);
        echo $response;
            return;
}
?>