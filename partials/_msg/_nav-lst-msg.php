<?php
require "../_db-connect.php";

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$sn = $_SESSION['sn'];
	$sql = "SELECT * from `users` WHERE `id` = $sn";
	$result = mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$Login = true;
		}
		else{
  			header('location: login.php');

		}
	}
}

else{
  header('location: login.php');
}
session_abort();


        
          $mysql = "SELECT * FROM `chat_rooms` WHERE `user_id_1` = $sn";
			$my_result = mysqli_query($conn, $mysql);
  			if($my_result && mysqli_num_rows($my_result) > 0){
				$i = 1;
				while($my_row = mysqli_fetch_assoc($my_result)){
					$user_id_1 = $my_row['user_id_1'];
					$user_id_2 = $my_row['user_id_2'];
					$chat_room_id = $my_row['id'];
					$sql = "SELECT * FROM `users` WHERE `id` = $user_id_2";
					$result = mysqli_query($conn, $sql);
					$last_message = '';

					if($result && mysqli_num_rows($result) > 0){
						$row = mysqli_fetch_assoc($result);
						$img_location = "img/profile.png";

						if($row['profile_img'] != ""){
							$img_location = $row['profile_img'];
						}
						
						$name = $row['name'];
						$sql = "SELECT * FROM `messages` WHERE `chat_room_id` = $chat_room_id ORDER BY `id` DESC LIMIT 1";
						$result = mysqli_query($conn, $sql);
						if($result && mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							$last_message = $row['message'];
						}
						
					}
          echo '        
          <a target="_blank" href="message.php?myid='. $sn .'&id='.$user_id_2.'" class="dropdown-item">
            <div class="media">
              <img src="'.$img_location.'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  '. $name .'
                  <!--  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> -->
                </h3>
                <p class="text-sm">'.$last_message.'</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>';
				}
		
			}
			$mysql = "SELECT * FROM `chat_rooms` WHERE `user_id_2` = $sn";
			$my_result = mysqli_query($conn, $mysql);
  			if($my_result && mysqli_num_rows($my_result) > 0){
				$i = 1;

				while($my_row = mysqli_fetch_assoc($my_result)){
					$user_id_1 = $my_row['user_id_1'];
					$user_id_2 = $my_row['user_id_2'];
					$chat_room_id = $my_row['id'];
					$sql = "SELECT * FROM `users` WHERE `id` = $user_id_1";
					$result = mysqli_query($conn, $sql);
					$last_message = '';

					if($result && mysqli_num_rows($result) > 0){
						$row = mysqli_fetch_assoc($result);
						$img_location = "img/profile.png";

						if($row['profile_img'] != ""){
							$img_location = $row['profile_img'];
						}
						$name = $row['name'];
						$sql = "SELECT * FROM `messages` WHERE `chat_room_id` = $chat_room_id ORDER BY `id` DESC LIMIT 1";
						$result = mysqli_query($conn, $sql);
						if($result && mysqli_num_rows($result) > 0){
							$row = mysqli_fetch_assoc($result);
							$last_message = $row['message'];
						}
						
          }

          
          echo '        
          <a target="_blank" href="message.php?myid='. $sn .'&id='.$user_id_2.'" class="dropdown-item">
            <div class="media">
              <img src="'.$img_location.'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  '. $name .'
                  <!--  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> -->
                </h3>
                <p class="text-sm">'.$last_message.'</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>';

          
        }
        
		
			}
			
          
          ?>