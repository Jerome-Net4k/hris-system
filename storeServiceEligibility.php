<?php

include 'connection.php';

session_start();
$_SESSION['civilCareer'] = $_POST['convCareer'];
$_SESSION['civilRating'] = $_POST['convRating'];
$_SESSION['civilDoe'] = $_POST['convDoe'];
$_SESSION['civilPoe'] = $_POST['convPoe'];
$_SESSION['civilLNum'] = $_POST['convLNum'];
$_SESSION['civilDov'] = $_POST['convDov'];
?>