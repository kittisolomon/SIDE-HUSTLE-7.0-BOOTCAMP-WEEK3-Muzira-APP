<?php
include "function.php";
require "db_con.php";

// Retrieve the latest released songs from the database


// $user_id="1";
// $user_id = $data->user_id;
//  $user_id= $_GET['sessionId'];
// if(!empty($user_id)){
    $sql = "SELECT * FROM musics ORDER BY release_date DESC LIMIT 10";
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
            $all_song["new_release"][] = $song;
        }
        $songs = $all_song;
         $response = json_encode(['status'=>'success','message'=>$songs]);
                    echo $response;
                    return;
        // $response = json_encode($songs);
        // echo $response;
        //         return;
    } else {
        $response = json_encode(['status'=>'error','message'=>'no songs available']);
       
            echo $response;
                return;
    }
// }else{
//      $response = ["message"=>"please login"];
//           echo json_encode($response);
// }

// Close the database connection
// $db_con->close();



?>