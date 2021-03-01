<?php

require "../_db-connect.php";

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $sn = $_SESSION['sn'];
}

else{
  header('location: login-signin.php');
}

if(isset($_POST['id']) && $_POST['id'] != ''){
    $id = $_POST['id'];
}

if($id != $sn){
  $sql = "SELECT `name`, `profile_img` FROM `users` WHERE `id` = $id";
  $result = mysqli_query($conn, $sql);
  $img_location = "img/profile.png";
  $name = 'User';
  
  if($result){
      if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);
          $name = $row['name'];
  
          if($row['profile_img'] != ""){
              $img_location = $row['profile_img'];
          }
  
      }
  }
  
  
  echo '				
  <img src="'.$img_location.'" alt="" />
  <a href="profile.php?sn='.$id.'">'.$name.'</a>
  ';
}
else{
  echo '				
  <img src="img/profile.png" alt="" />
  <a href="profile.php?sn='.$id.'">User</a>
  ';
}




?>