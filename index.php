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



?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <script src="js/jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <style>
        .profile-img {
            max-width: 55px;
            max-height: 55px;
            border-radius: 100px;
            margin-right: 20px;
        }
    </style>
    <title>Message List</title>
</head>

<body>

<nav style="width: 100%;" class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="messages.php"><b>Messages</b></a>
                                </li>
                                

                            </ul>
                            <a class="btn btn-outline-success" href="logout.php" role="submit">Log Out</a>


                        </div>
                    </div>
                </nav>
    <div class="container mt-4">
        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT * FROM `users`";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['id'] != $sn) {

                            echo '
                    <tr>
                    <th scope="row">' . $i . '</th>
                    <td> <img class="profile-img" src="' . $row['profile_img'] . '"> ' . $row['name'] . '</td>
                    <td><a href="messages.php?myid=' . $sn . '&id=' . $row['id'] . '" role="button" class="btn btn-primary">Messages</a>
                    </td>
                </tr>
                    ';
                            $i += 1;
                        }
                    }
                }

                ?>

            </tbody>
        </table>
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