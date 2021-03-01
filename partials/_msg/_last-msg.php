<?php

require "../_db-connect.php";
session_start();
$sn = $_SESSION['sn'];
			
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
					<li  onclick="ref( '.$chat_room_id.'  , '.$user_id_2.' )" '; if($i == 1 && !(isset($_POST['cid'])) ){ echo 'id="act-now" '; $i = $i + 1;} elseif(isset($_POST['cid']) && $_POST['cid'] == $chat_room_id ){echo 'id="act-now" ';}
					echo ' class="contact-info">
					<div class="f-half-i">
						<img class="contact-img" src="' . $img_location . '" alt="">
					</div>
					<div class="con-name-msg">
						<h3>' . $name . '</h3>

						<p>' .  substr($last_message, 0, 25)  . '...</p>
					</div>
				</div>';
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
					<li  onclick="ref('.$chat_room_id.'  , '.$user_id_1.' )" '; if($i == 1 && !(isset($_POST['cid'])) ){ echo 'id="act-now" '; $i = $i + 1;} elseif(isset($_POST['cid']) && $_POST['cid'] == $chat_room_id ){echo 'id="act-now" ';}
					echo '                   class="contact-info">
					<div class="f-half-i">
						<img class="contact-img" src="' . $img_location . '" alt="">
					</div>
					<div class="con-name-msg">
						<h3>' . $name . '</h3>
						<p>' .  substr($last_message, 0, 25)  . '...</p>
					</div>
				</div>';
				}
		
			}
			session_abort();
			
			?>
