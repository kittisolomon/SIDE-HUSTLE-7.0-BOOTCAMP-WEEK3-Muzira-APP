<?php
include 'function.php';
require 'db_con.php';

$data = json_decode(file_get_contents('php://input'));

// $user_id = "1";
// $song_id = "6";
$user_id = filter_var($data->user_id, FILTER_SANITIZE_EMAIL);
$song_id = filter_var($data->song_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(!empty($user_id) && !empty($song_id)){
    
    $ch_id = mysqli_query($db_con, "SELECT * FROM users WHERE id = '$user_id'");
    
    if(!$ch_id ->num_rows>0 ){
        $response = json_encode(['status'=>'error','message'=> 'please login']);
        echo $response;
    }else {
        $ch_sg = mysqli_query($db_con, "SELECT * FROM favorite_songs WHERE user_id ='$user_id' AND song_id = '$song_id'");
    
        if(!$ch_sg ->num_rows<1){
            $response = json_encode(['status'=>'error','message'=> 'music already in your favorites']);
            echo $response;
        }else{
            $sql = 'INSERT INTO favorite_songs (user_id, song_id) VALUES("'.$user_id.'","'.$song_id.'")';
            $result = mysqli_query($db_con, $sql);
           if($result){
        
            $response = json_encode(['status'=>'success','message'=> 'Favorite music added']);
            echo $response;
    
           }else{
        
            $response = json_encode(['status'=>'error','message'=> 'Could not add to favorites']);
            echo $response;
        
           }
      }
    }
}else{
      $response = json_encode(['status'=>'error','message'=>'Please Complete All Fields.']);
        echo $response;
        return;
}

?>