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

require 'partials/_db-connect.php';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    // die($email . $pass);
    $sql = "SELECT `id`, `email`, `password` FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) != 0) {
            $row = mysqli_fetch_assoc($result);
            $hash = $row['password'];
            $id = $row['id'];
            $name = $row['name'];
            password_verify($pass, $hash);
            if (password_verify($pass, $hash)) {
                session_start();
                $_SESSION['sn'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['loggedin'] = true;
                header('location: index.php');
            } else {
                header('location: /login.php/?error=Wrong Password. Please try again...&e=true');
            }
        } else {
            header('location: /login.php/?error=Email does not exist!!&e=true');
        }
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

    <title>Login</title>
</head>

<body>
    <?php

    if (isset($_GET['e'])) {
        echo '  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  ' . $_GET['error'] . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
        echo '  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Login</strong> PLease Enter your Email and password to login...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
    }

    ?>

    <div class="container mt-4">
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input  required name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input required  name="pass" type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <div class="mb-3">
                If you don't have an account, PLease <a href="signup.php" class="link-primary">Signup</a> First!
            </div>

            <div class="d-grid gap-2">
                <button name="login" class="btn btn-primary" type="submit">Login</button>
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