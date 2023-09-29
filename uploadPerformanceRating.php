<?php

session_start();
include 'connection.php';

if(isset($_POST['addYearDirectory'])){
    createYearDirectory();
}else {

}

function createYearDirectory(){
    include 'connection.php';

    $yearFolder = $_POST['yearInput'];
    $folderPath = "pmupload/" . $yearFolder;
    $opcrPath = $folderPath . "/OPCR";
    $dpcrPath = $folderPath . "/DPCR";
    $ipcrPath = $folderPath . "/IPCR";
    $pmcrPath = $folderPath . "/PMCR";
    $nosiPath = $folderPath . "/NOSI";
    $nosaPath = $folderPath . "/NOSA";
    $salnPath = $folderPath . "/SALN";
    $coePath = $folderPath . "/COE";

    $query = "INSERT INTO `performance_rating_year`(`year`) VALUES ($yearFolder)";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        mkdir($folderPath);
        mkdir($opcrPath);
        mkdir($dpcrPath);
        mkdir($ipcrPath);
        mkdir($pmcrPath);
        mkdir($nosiPath);
        mkdir($nosaPath);
        mkdir($salnPath);
        mkdir($coePath);
    }
}

?>