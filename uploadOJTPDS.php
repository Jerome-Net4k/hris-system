<?php

session_start();
include 'connection.php';

uploadOJTinfo();
header("Location: home.php");




function uploadOJTinfo(){
    include 'connection.php';
    $query = "INSERT INTO `ojtinfo_table`(`Name`, `Address`, `Mobileno`, `eAddress`, `NoS`, `Gname`, `Gmobileno`) VALUES ('','','','','','','')";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssssssssssssssssssssssssssssssss", $_SESSION['Name'],$_SESSION['Address'],$_SESSION['Mobileno'],$_SESSION['eAddress'],$_SESSION['NoS'],$_SESSION['Gname'],$_SESSION['Gmobileno']);
    $stmt->execute();
}
