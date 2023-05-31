<?php   

require "db_con.php";

$data = json_decode(file_get_contents('php://input'));



if(!empty($data->playlist_name)){

    $playlist_name = filter_var($data->playlist_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $user_id = $data->user_id;

    $sql = 'INSERT INTO playlist (user_id,playlist_name) VALUES("'.$user_id.'","'.$playlist_name.'")';
    $result = mysqli_query($db_con, $sql);
   if($result){

    $response = json_encode(['status'=>'success','message'=> 'Playlist Created']);
    echo $response;

   }else{

    $response = json_encode(['status'=>'error','message'=> 'Could not create Playlist']);
    echo $response;

   }

}else{
     $response = json_encode(['status'=>'error','message'=> 'No Playlist Created']);
    echo $response;
}

// Close the database connection
$db_con->close();

?>