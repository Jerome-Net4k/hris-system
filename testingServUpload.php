<?php

include 'connection.php';

session_start();
$_SESSION['career'] = $_POST['convCareer'];
$_SESSION['rating'] = $_POST['convRating'];
$_SESSION['doe'] = $_POST['convDoe'];
$_SESSION['poe'] = $_POST['convPoe'];
$_SESSION['LNum'] = $_POST['convLNum'];
$_SESSION['dov'] = $_POST['convDov'];

/*$career = explode(',',$_POST['convCareer']);
$rating = explode(',', $_POST['convRating']);
$doe = explode(',',$_POST['convDoe']);
$poe = explode(',',$_POST['convPoe']);
$lNum = explode(',',$_POST['convLNum']);
$dov = explode(',',$_POST['convDov']);

for($a = 0;$a < count($career); $a++){
    $query = "INSERT INTO `testing_tbl`( `career`, `rating`, `doe`, `poe`, `number`, `dov`) 
    VALUES (?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssss',$career[$a],$rating[$a],$doe[$a],$poe[$a],$lNum[$a],$dov[$a]);
    $stmt->execute();
}*/

?>