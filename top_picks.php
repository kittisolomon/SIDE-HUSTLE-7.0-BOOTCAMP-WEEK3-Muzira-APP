<?php
include 'function.php';
require 'db_con.php';

  
    $sql = "SELECT * FROM musics ORDER BY cart DESC ";
    $result = $db_con->query($sql);
    if( $result->num_rows > 0){
         while($row =  $result->fetch_assoc()) {
            $song["artist_name"] = $row["artist_name"];
            $song["music"] = $row["music"];
            $song["music_title"] = $row["music_title"];
            $song["artist_label"] = $row["artist_label"];
            $song["genre"] = $row["genre"];
            $song["cover_picture"] = $row["cover_picture"];
            $song["release_date"] = $row["release_date"];
            $all_song["top_picks"][] = $song;
           
         } 
         $top_picks =  $all_song;
          $response = json_encode(['status'=>'success','message'=>$top_picks]);
                    echo $response;
                    return;
            // // Convert the array to JSON format
            // $response = json_encode($top_picks);
            // // Output the JSON data
            // echo $response;
            // return;
    }else{
          $response = ["message"=>"No song available yet"];
          echo json_encode($response);
    }   

    
?>