<?php

include "function.php";
require "db_con.php";

$data = json_decode(file_get_contents('php://input'));

// $email= "asd@sda.com";
// $password ="12345";
// $cpassword ="12345";

// $profilename= "sady";
// $day ="25";
// $month="may";
// $year="2022";
// $gender="female";

// if(!empty($email) && !empty($password) && !empty($profilename)
//  && !empty($day) && !empty($month)&& !empty($year) && !empty($gender)){

    
// if(!empty($data->email) && !empty($data->password) && !empty($data->confirmPassword) && !empty($data->profileName)
//  && !empty($data->day) && !empty($data->month)&& !empty($data->year)){
if(!empty($data->email) && !empty($data->password) && !empty($data->profileName)
 && !empty($data->day) && !empty($data->month)&& !empty($data->year) && !empty($data->gender)){


        $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        
        $password = filter_var($data->password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpassword = filter_var($data->confirmPassword, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $profilename = filter_var($data->profileName, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $day = filter_var($data->day, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $month = filter_var($data->month, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $year = filter_var($data->year, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        $gender = filter_var($data->gender, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $ck_email= "SELECT email FROM users WHERE email = '$email'";
        $chk= $db_con->query($ck_email);
        if (!$chk->num_rows>0){
            if ($password === $cpassword){
                $md5pass = md5($password);
            
                $sql = 'INSERT INTO users (email,password,profilename, day, month, year, gender)
                 VALUES("'.$email.'","'.$md5pass.'","'.$profilename.'","'.$day.'","'.$month.'","'.$year.'","'.$gender.'")';
            
               $result = mysqli_query($db_con, $sql);
        
                if($result){
                
                    $response = json_encode(['status'=>'success','message'=>'Registration Succesful.']);
                    echo $response;
                    return;
                
                }else{
                   
                    $response = json_encode(['status'=>'error','message'=>'Error Occured, Try Again!.']);
                    echo $response;
                    return;
                }
            }else{
                $response = json_encode(['status'=>'error','message'=>'Password not matched, Try Again!.']);
                    echo $response;
                    return;
            }
        }else{
            $response = json_encode(['status'=>'error','message'=>'email already exist, Try Again!.']);
                    echo $response;
                    return;
        }


}else{

 $response = json_encode(['status'=>'error','message'=>'Please Complete All Fields.']);

 echo $response;


}


?>