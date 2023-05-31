<?php
include 'function.php';
    require 'db_con.php';

$data = json_decode(file_get_contents('php://input'));

// $user_id = "2";
// $password = "123456";
// $profilename = "mike";
// $day = "12";
// $month = "june";
// $year = "1990";
// $gender = "female";
$user_id = filter_var($data->user_id, FILTER_SANITIZE_NUMBER_INT);
$password = filter_var($data->password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$profilename = filter_var($data->profilename, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$day = filter_var($data->day, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$month = filter_var($data->month, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$year = filter_var($data->year, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$gender =filter_var($data->gender, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$md5pass = md5("$password");

$sql = "UPDATE users  SET password = '$md5pass',  profilename = '$profilename', day = '$day', 
        month= '$month', year = '$year', gender = '$gender'  WHERE id = '$user_id' ";

$result = $db_con->query($sql);

if($result){

    $response = ["status"=>"success","message"=>"Update Sucessful"];

    echo json_encode($response);

    return;
}else{
    $response = ["status"=>"error","message"=>"Update Failed"];

    echo json_encode($response);
}


// Close the database connection
$db_con->close();


?>