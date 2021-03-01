<?php

require "../_db-connect.php";

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $sn = $_SESSION['sn'];
}

else{
  header('location: login-signin.php');
  exit();
}


if(isset($_POST['msg']) && isset($_POST['chatId']) && isset($_POST['id']) && $_POST['msg'] != ''  && $_POST['chatId'] != '' && $_POST['id'] != ''){
    $chat_room_id = $_POST['chatId'];
    $sender_id = $sn;
    $receiver_id = $_POST['id'];
    $message = $_POST['msg']; 

    str_replace("'", "\'", $message);
    str_replace("\\", "\\\\", $message);
    str_replace("<?", "", $message);
    str_replace("<?php", "", $message);

    $sql = "INSERT INTO `messages` (`id`, `chat_room_id`, `sender_id`, `receiver_id`, `message`, `dt`) VALUES (NULL, '$chat_room_id', '$sender_id', '$receiver_id' , \"$message\" , current_timestamp())";
    $result = mysqli_query($conn, $sql);
    
}




?>