<?php


session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $sn = $_SESSION['sn'];
}

else{
  exit();
}

require "../_db-connect.php";

if(isset($_POST['id']) && $_POST != ''){
    $chat_room_id = $_POST['id'];
    $sql = "SELECT * FROM `messages` WHERE `chat_room_id` = $chat_room_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        if(mysqli_num_rows($result) != 0){
            $sql3 = "UPDATE `messages` SET `seen` = 1 WHERE `messages`.`chat_room_id` = $chat_room_id AND `receiver_id` = $sn;";
            $result4 = mysqli_query($conn, $sql3);
            $num = mysqli_num_rows($result);

        }
    }
    $sql2 = "SELECT `seen` FROM `messages` WHERE `chat_room_id` = $chat_room_id AND `seen` = 1 AND `sender_id` = $sn";
    $result2 = mysqli_query($conn, $sql2);
    $seen_num = -1;
    if($result2){
        $seen_num = mysqli_num_rows($result2);
    }


    $loop_counter = 0;
    $loop_counter_seen = 0;
    if($result && mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $loop_counter += 1;
        //     <div class="got my-4">

        //     <div class="msg-text">
        //         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit</p>
        //     </div>

        // </div>
            echo '
                
            <div class="  my-4 ';
                if($row['sender_id'] == $sn){
                    $sent = true;
                    echo 'sent';
                    $sql = "SELECT `name`, `profile_img` FROM `users` WHERE `id` = $sn";
                    $result2 = mysqli_query($conn, $sql);
                    $img_location = "img/profile.png";
                    
                    if($result2){
                        if(mysqli_num_rows($result2) > 0){
                            $row2 = mysqli_fetch_assoc($result2);
                    
                            if($row2['profile_img'] != ""){
                                $img_location = $row2['profile_img'];
                            }
                    
                        }
                    }
                }
                else{
                    $sent = false;

                    echo 'got';
                    $sql = "SELECT `name`, `profile_img` FROM `users` WHERE `id` = ".$row['sender_id']."";
                    $result2 = mysqli_query($conn, $sql);
                    $img_location = "img/profile.png";
                    
                    if($result2){
                        if(mysqli_num_rows($result2) > 0){
                            $row2 = mysqli_fetch_assoc($result2);
                    
                            if($row2['profile_img'] != ""){
                                $img_location = $row2['profile_img'];
                            }
                    
                        }
                    }
                }
                
                echo '">
                <div class="msg-text">
                <p>'.$row['message'].'</p>
                
                
                
                
            </div>';
            if($sent){

                $loop_counter_seen += 1;
                if($seen_num == $loop_counter_seen && $seen_num != 0){

                    echo '
                    <img class=" condition msg-seen " src="'.$img_location.'" alt=""></i>
                    ';

                }
                if($loop_counter == $num && $seen_num != $loop_counter_seen ){
                    echo '<div class="condition "><i class="fas fa-check msg-sent"></i></div>';
                }
            }

            echo'

        </div>

                    


            ';
        }
    }
}



if(isset($_POST['user_id']) && $_POST['user_id'] != ''){
    $user_id = $_POST['user_id'];
    $sql = "SELECT `name`, `profile_img` FROM `users` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo '<div class="f-half-i">
                <img class="contact-img-msg" src="'.$row['profile_img'].'" alt="">
                </div>
                <div class="con-name-msg-section">
                <h4>'.$row['name'].'</h4>
                </div>';
            }
        }
    }

}
