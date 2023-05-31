<?php
include 'function.php';
require "db_con.php";


$sql = "DELETE FROM musics WHERE id='3'";


$result =mysqli_query($db_con, $sql);



if ($result) {
  
    // Convert the array to JSON format
   $response = json_encode(['status'=>'success','message'=>'scores successfully cleared.']);
    // Output the JSON data
    echo $response;
    return;
}
else{
     $response = json_encode(['status'=>'error','message'=>'unable to clear scores.']);
   
        echo $response;
            return;
}
// Close the database connection
$db_con->close();

?>