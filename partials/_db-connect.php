<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'messages';

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Could not connect to the database because of this error --> ". mysqli_connect_error($conn) ." \n \n Sorry for this trouble. Please contact with the support.");
    
}

?>