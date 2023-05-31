<?php
include "function.php";
require "db_con.php";

  // Check if required fields are set
  if (!isset($_POST['artist_name'], $_POST['music_title'], $_POST['genre'], $_POST['artist_label'], $_POST['release_date'])) {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Missing required fields'));
    exit;
  }

  // Process form data
  $artist_name = $_POST['artist_name'];
  $music_title = $_POST['music_title'];
  $genre = $_POST['genre'];
  $artist_label = $_POST['artist_label'];
  $release_date = $_POST['release_date'];

  // Handle file uploads
  $music_file = $_FILES['music'];
  $cover_picture_file = $_FILES['cover_picture'];

  // Validate file types and sizes, and move uploaded files to a permanent location
  $allowed_music_types = array('audio/mpeg', 'audio/wav', 'audio/mp3');
  $allowed_cover_types = array('image/jpeg', 'image/png');
  $max_file_size = 8000000; // 8 MB
 //  uniqid() . '_' . 
  if ( in_array($music_file['type'], $allowed_music_types) && $music_file['size'] <= $max_file_size) {
    $music_file_name =  $music_file['name'];
    $music_file_path = 'musics/' . $music_file_name;
    move_uploaded_file($music_file['tmp_name'], $music_file_path);
  }else {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Invalid Music type, size > 8MB '));
    exit;
  } 

  if (in_array($cover_picture_file['type'], $allowed_cover_types) && $cover_picture_file['size'] <= $max_file_size) {
    $cover_picture_file_name = $cover_picture_file['name'];
    $cover_picture_file_path = 'cover/' . $cover_picture_file_name;
    move_uploaded_file($cover_picture_file['tmp_name'], $cover_picture_file_path);
  } else {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Invalid cover picture file'));
    exit;
  }

  // Save song and cover picture into the database
  $sql = "INSERT INTO musics (artist_name, music, music_title, genre, artist_label, release_date, cover_picture) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $db_con->prepare($sql);
  $stmt->bind_param("sssssss", $artist_name, $music_file_name, $music_title, $genre, $artist_label, $release_date,  $cover_picture_file_name);

  if ($stmt->execute()) {
    // If everything is successful, send a response
    http_response_code(200);
    echo json_encode(array('status' => 'success', 'message' => 'Song uploaded successfully'));


  }else{
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Song uploaded not successful'));
    exit;
  }
    ?>