<?php
require 'partials/_db-connect.php';

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $sn = $_SESSION['sn'];
    $sql = "SELECT * from `users` WHERE `id` = $sn";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $Login = true;
        } else {
            header('location: login.php');
        }
    }
} else {
    header('location: login.php');
}


$user_id_1 = '';
$user_id_2 = '';

if (isset($_GET['myid']) && $_GET['myid'] != '' && isset($_GET['id']) && $_GET['id'] != '' && $_GET['myid'] != $_GET['id']) {
    if ($_GET['myid'] != $sn) {
        // header('location: messages.php');
        exit();
    }
    $user_id_1 = $_GET['myid'];
    $user_id_2 = $_GET['id'];
    $sql = "SELECT * FROM `chat_rooms` WHERE `user_id_1` = $user_id_1 AND `user_id_2` = $user_id_2";
    $result = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM `chat_rooms` WHERE `user_id_2` = $user_id_1 AND `user_id_1` = $user_id_2";
    $result2 = mysqli_query($conn, $sql2);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $chat_room_id = $row['id'];
        header('location: messages.php?cid=' . $chat_room_id . '');
        exit();
    } elseif ($result2 && mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        $chat_room_id = $row['id'];
        header('location: messages.php?cid=' . $chat_room_id . '');
        exit();
    } else {
        $sql = "SELECT * FROM `users` WHERE `id` = $user_id_1";
        $sql2 = "SELECT * FROM `users` WHERE `id` = $user_id_2";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        if ($result && $result2  && mysqli_num_rows($result) > 0 && mysqli_num_rows($result2) > 0) {
            $sql = "INSERT INTO `chat_rooms` (`id`, `user_id_1`, `user_id_2`, `dt`) VALUES (NULL, '$user_id_1', '$user_id_2', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $sql = "SELECT `id` FROM `chat_rooms` WHERE `user_id_1` = $user_id_1 AND `user_id_2` = $user_id_2";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $chat_room_id = $row['id'];
                    header('location: messages.php?cid=' . $chat_room_id . '');
                }
            }
        } else {
            die('Invalid User!!!');
        }
    }
} elseif (isset($_GET['cid']) && $_GET['cid'] != '') {
    $chat_room_id = $_GET['cid'];
    $sql = "SELECT * FROM `chat_rooms` WHERE `id` = $chat_room_id";
    $result = mysqli_query($conn, $sql);
    $user_id_1 = '';
    $user_id_2 = '';
    if ($result && mysqli_num_rows($result) > 0) {
    } else {
        header('location: index.php');
    }
} else {
}



session_abort();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/messages.css">
    <script src="https://kit.fontawesome.com/b5e36b87ea.js" crossorigin="anonymous"></script>
    <script src="js/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>All Messages</title>
</head>

<body>



    <script>

    </script>
    <?php
    $sql = "SELECT `name`, `profile_img` FROM `users` WHERE `id` = $sn";
    $result = mysqli_query($conn, $sql);
    $img_location = "img/profile.png";
    $name = 'User';

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];

            if ($row['profile_img'] != "") {
                $img_location = $row['profile_img'];
            }
        }
    }


    ?>

    <div class="all-wrap">
        <div class="contacts">
            <div class="settings">
                <div class="settings-wrapper">
                    <!-- <input class="search" type="text" name="search" id="search-contacts" placeholder="Search Contacts"> -->
                </div>
            </div>
            <div class="all-contacts">
                <div id="cons" class="contacts-wrapper">
                    <?php

                    $mysql = "SELECT * FROM `chat_rooms` WHERE `user_id_1` = $sn";
                    $my_result = mysqli_query($conn, $mysql);
                    if ($my_result && mysqli_num_rows($my_result) > 0) {
                        $i = 1;
                        while ($my_row = mysqli_fetch_assoc($my_result)) {
                            $user_id_1 = $my_row['user_id_1'];
                            $user_id_2 = $my_row['user_id_2'];
                            $chat_room_id = $my_row['id'];
                            $sql = "SELECT * FROM `users` WHERE `id` = $user_id_2";
                            $result = mysqli_query($conn, $sql);
                            $last_message = '';

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $img_location = "img/profile.png";

                                if ($row['profile_img'] != "") {
                                    $img_location = $row['profile_img'];
                                }
                                $name = $row['name'];
                                $sql = "SELECT * FROM `messages` WHERE `chat_room_id` = $chat_room_id ORDER BY `id` DESC LIMIT 1";
                                $result = mysqli_query($conn, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $last_message = $row['message'];
                                }
                            }
                            echo '
                            <div  onclick="ref(' . $chat_room_id . '  , ' . $user_id_2 . ' )" ';
                            if ($i == 1 && !(isset($_GET['cid']))) {
                                echo 'id="act-now" ';
                                $i = $i + 1;
                            } elseif (isset($_GET['cid']) && $_GET['cid'] == $chat_room_id) {
                                echo 'id="act-now" ';
                            }
                            echo '                   class="contact-info">
                            <div class="f-half-i">
                                <img class="contact-img" src="' . $img_location . '" alt="">
                            </div>
                            <div class="con-name-msg">
                                <h3>' . $name . '</h3>
                                <p>' . substr($last_message, 0, 20)  . '...</p>
                            </div>
                        </div>';
                        }
                    }

                    $mysql = "SELECT * FROM `chat_rooms` WHERE `user_id_2` = $sn";
                    $my_result = mysqli_query($conn, $mysql);
                    if ($my_result && mysqli_num_rows($my_result) > 0) {
                        $i = 1;

                        while ($my_row = mysqli_fetch_assoc($my_result)) {
                            $user_id_1 = $my_row['user_id_1'];
                            $user_id_2 = $my_row['user_id_2'];
                            $chat_room_id = $my_row['id'];
                            $sql = "SELECT * FROM `users` WHERE `id` = $user_id_1";
                            $result = mysqli_query($conn, $sql);
                            $last_message = '';

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $img_location = "img/profile.png";

                                if ($row['profile_img'] != "") {
                                    $img_location = $row['profile_img'];
                                }
                                $name = $row['name'];
                                $sql = "SELECT * FROM `messages` WHERE `chat_room_id` = $chat_room_id ORDER BY `id` DESC LIMIT 1";
                                $result = mysqli_query($conn, $sql);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $last_message = $row['message'];
                                }
                            }
                            echo '
					<div  onclick="ref(' . $chat_room_id . '  , ' . $user_id_1 . ' )" ';
                            if ($i == 1 && !(isset($_GET['cid']))) {
                                echo 'id="act-now" ';
                                $i = $i + 1;
                            } elseif (isset($_GET['cid']) && $_GET['cid'] == $chat_room_id) {
                                echo 'id="act-now" ';
                            }
                            echo '                   class="contact-info">
                            <div class="f-half-i">
                                <img class="contact-img" src="' . $img_location . '" alt="">
                            </div>
                            <div class="con-name-msg">
                                <h3>' . $name . '</h3>
                                <p>' .  substr($last_message, 0, 25) . '...</p>
                            </div>
                        </div>';
                        }
                    }




                    ?>


                </div>
            </div>
        </div>
        <div class="messages">
            <div class="menu">
                <nav style="width: 100%;" class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php"><b>Message List</b></a>
                                </li>


                            </ul>
                            <a class="btn btn-outline-success" href="logout.php" role="submit">Log Out</a>


                        </div>
                    </div>
                </nav>
            </div>
            <div class="message-section">
                <div class="message-header-section">
                    <div id="con-header" class="contacter-info">
                        <div class="f-half-i">
                            <img class="contact-img-msg" src="img.jpg" alt="">
                        </div>
                        <div class="con-name-msg-section">
                            <h4>Dr. Jakir Naik</h4>
                        </div>
                    </div>
                </div>
                <div id="all-messages" class="all-chats-section">
                    
                </div>
                <div class="send-message-section">
                    <input id="message" class="the-message" type="text" placeholder="Your Message...">
                    <div onclick="send()" id="send-message" class="send-button">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script src="js/message.js"></script>

<script src="js/messages.js"></script>

</html>