<?php
require 'partials/_db-connect.php';

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	$sn = $_SESSION['sn'];
	$sql = "SELECT * from `users` WHERE `id` = $sn";
	$result = mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$Login = true;
    header('location: index.php');

		}
		else{
  			header('location: login.php');

		}
	}
}

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    if ($cpass == $pass) {
        $sql = "SELECT `email` FROM `users` WHERE `email` = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) != 0) {
                header("location: /signup.php/?error=<strong>Email Already exist! </strong> Choose an other email...");
                die($error_msg);
            } else {
                $target_dir = "img/";
                $target_file = $target_dir . $username . $username . basename($_FILES["profile-img"]["name"]);
                str_replace(' ', '', $target_file, );

                move_uploaded_file($_FILES["profile-img"]["tmp_name"], $target_file);

                // die(var_dump($_FILES['profile-img']));
                $sql = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_img`, `dt`) VALUES (NULL, '$username', '$email', '$hash', '$target_file', current_timestamp());";
                $result = mysqli_query($conn, $sql);
                // die($sql);

                if ($result) {
                    header('location: login.php');
                } else {
                }
            }
        }
    } else {

        header("location: /signup.php/?error=Passwords does not match!! Try Again...");
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Sign Up - Create an account</title>
</head>

<body>


    <?php

    if (isset($_GET['error'])) {
        echo '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
' . $_GET['error'] . '
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Create an account</strong> PLease Enter your details and Sign Up FIrst...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }

    ?>
    <div class="container mt-4">
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">User Name</label>
                <input required name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input required type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input requiredt name="pass" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input required name="cpass" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Profile Image</label>
                <input required name="profile-img" class="form-control" type="file" id="formFileMultiple" multiple>
            </div>
            <div class="mb-3">
                If you already have an account, PLease <a href="login.php" class="link-primary">Login</a>!
            </div>

            <div class="d-grid gap-2">
                <button name="signup" class="btn btn-primary" type="submit">Sign Up</button>
            </div>
        </form>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>