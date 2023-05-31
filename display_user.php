<?php
include "function.php";
require "db_con.php";

// $data = json_decode(file_get_contents('php://input'));


// $user_id= "2";
// $user_id= $data->user_id;
 $user_id= $_GET['sessionId'];
$follower="1";
$following="1";

if(!empty($user_id)){
    
   $sql= "SELECT * FROM users WHERE id='$user_id'";
   $result = mysqli_query($db_con, $sql);
   
   if($result->num_rows >0){
        while($row = $result->fetch_assoc()){
            $view_user["email"] = $row["email"];
            $view_user["profilename"] = $row["profilename"];
            $view_user["day"] = $row["day"];
            $view_user["month"] = $row["month"];
            $view_user["year"] = $row["year"];
            $view_user["gender"] = $row["gender"];
            $count_playlist = mysqli_query($db_con, "SELECT COUNT(*) as total_playlist FROM playlist WHERE user_id = $user_id");
            $aa1 = mysqli_fetch_array($count_playlist);
            $view_user["total_playlist"] = $aa1["total_playlist"];  
            $view_user["follower"] = $follower;  
            $view_user["following"] = $following;  
            $user["all_details"][] = $view_user;
    
            $response = json_encode(["status"=>"success","message"=>$user]);
            echo $response;
            return;
        }
    } else {
        $response = ['status'=>'error', 'message'=>'unable to retrieve user'];
        echo json_encode($response);
    }
}else{
    $response = ['status'=>'error', 'message'=>'Please  login'];
        echo json_encode($response);
        return;
}

?>