<?php

include 'connection.php';

session_start();

$_SESSION['elemSchl'] = $_POST['elemSchl'];
$_SESSION['elecDegree'] = $_POST['elecDegree'];
$_SESSION['elemFrom'] = $_POST['elemFrom'];
$_SESSION['elemTo'] = $_POST['elemTo'];
$_SESSION['elemUnit'] = $_POST['elemUnit'];
$_SESSION['elemGrad'] = $_POST['elemGrad'];
$_SESSION['elemScho'] = $_POST['elemScho'];
$_SESSION['secSch'] = $_POST['secSch'];
$_SESSION['secDegree'] = $_POST['secDegree'];
$_SESSION['secFrom'] = $_POST['secFrom'];
$_SESSION['secTo'] = $_POST['secTo'];
$_SESSION['secUnit'] = $_POST['secUnit'];
$_SESSION['secGrad'] = $_POST['secGrad'];
$_SESSION['secScho'] = $_POST['secScho'];
$_SESSION['vocSchl'] = $_POST['vocSchl'];
$_SESSION['vocDegree'] = $_POST['vocDegree'];
$_SESSION['vocFrom'] = $_POST['vocFrom'];
$_SESSION['vocTo'] = $_POST['vocTo'];
$_SESSION['vocUnit'] = $_POST['vocUnit'];
$_SESSION['vocGrad'] = $_POST['vocGrad'];
$_SESSION['vocScho'] = $_POST['vocScho'];
$_SESSION['colSchl'] = $_POST['colSchl'];
$_SESSION['colDegree'] = $_POST['colDegree'];
$_SESSION['colFrom'] = $_POST['colFrom'];
$_SESSION['colTo'] = $_POST['colTo'];
$_SESSION['colUnit'] = $_POST['colUnit'];
$_SESSION['colGrad'] = $_POST['colGrad'];
$_SESSION['colScho'] = $_POST['colScho'];
$_SESSION['gradSchl'] = $_POST['gradSchl'];
$_SESSION['gradDegree'] = $_POST['gradDegree'];
$_SESSION['gradFrom'] = $_POST['gradFrom'];
$_SESSION['gradTo'] = $_POST['gradTo'];
$_SESSION['gradUnit'] = $_POST['gradUnit'];
$_SESSION['gradGrad'] = $_POST['gradGrad'];
$_SESSION['gradScho'] = $_POST['gradScho'];
?>