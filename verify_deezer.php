<?php
// Set your app ID and secret
$app_id = '599704';
$app_secret = '831a730c8b405c638838c44dab0703ab';

// Get the access token from Deezer
$code = $_GET['code'];
$url = 'https://connect.deezer.com/oauth/access_token.php?app_id='.$app_id.'&secret='.$app_secret.'&code='.$code;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Parse the response and get the access token
parse_str($response, $data);
$access_token = $data['access_token'];

// Use the access token to make API calls
// For example, get the user's info
$url = 'https://api.deezer.com/user/me?access_token='.$access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Parse the response and do something with the user's info
$user_info = json_decode($response);
echo 'Welcome, '.$user_info->name.'!';
?>
