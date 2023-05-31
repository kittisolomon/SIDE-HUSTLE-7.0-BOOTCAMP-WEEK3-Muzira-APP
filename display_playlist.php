<?php   
    include 'function.php';
    require 'db_con.php';



// $data = json_decode(file_get_contents('php://input'));
// $user_id="1";
// $user_id = $data->user_id;
$user_id= $_GET['sessionId'];

$sql = "SELECT * FROM playlist WHERE user_id = '$user_id'";

$result = $db_con->query($sql);


if( $result->num_rows > 0){

 while($row = $result->fetch_assoc()){
      $playlist_id= $row["id"];
      
    // $view_json["playlist_id"] = $row["id"];
    // $view_json["user_id"] = $row["user_id"];
    $view_json["playlist_name"] = $row["playlist_name"];
    $count_songs = mysqli_query($db_con, "SELECT COUNT(*) as total_songs FROM playlist_songs WHERE playlist_id = $playlist_id");
    $aa1 = mysqli_fetch_array($count_songs);
    $view_json["total_songs"] = $aa1["total_songs"];  
    $get_user = mysqli_query($db_con, "SELECT profilename FROM users WHERE id = $user_id");
    $aa3 = mysqli_fetch_array($get_user);
    $view_json["by"] = $aa3[0];  
    $playlist["all_playlist"][] = $view_json;
 }

    // $response = ["status"=>"success","retrieved"=>$playlist];
  
    $response = json_encode(['status'=>'success','playlist'=>$playlist]);
    
                    echo $response;
                    echo  $count_songs;
                    return;
  }else{
  
      $response = ["message"=>"Could not retrieved Playlist"];
      echo json_encode($response);
  }  


// Close the database connection
$db_con->close();


  ?>