<?php

session_start();
require 'db_con.php';
include 'displayuserprofile';

$data = json_decode(file_get_contents('php://input'));

      include 'connection.php';


      if(isset($_POST['submit'])){

    $view_user["email"] = $row["email"];
    $view_user["profilename"] = $row["profilename"];
    $view_user["day"] = $row["day"];
    $view_user["month"] = $row["month"];
    $view_user["year"] = $row["year"];
    $view_user["gender"] = $row["gender"];
    $user["all_details"][] = $view_user;
        }
        
    $query = "UPDATE users SET email = '$view_user',
    profilename = '$view_user', day = $view_user, month = '$view_user', year = '$view_user', gender = '$view_user',
    WHERE user_id =  '$user'";

    $result = mysqli_query($db_con, $query) 
    or die(mysqli_error($db_con));


?>