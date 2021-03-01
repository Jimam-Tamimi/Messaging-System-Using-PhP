<?php

echo 'Login out... Please Wait..';
session_start();
session_reset();
session_unset();
session_destroy();
header('location: login.php');
?>