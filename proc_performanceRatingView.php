<?php

if(isset($_POST['opcrView'])){
  $region = $_POST['region'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  $semiSelected = $_POST['semiSelected'];
  // $empNo = '53';
  // $sname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $region . ' - ' . $semiSelected;
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";

  echo '<iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';

}else if(isset($_POST['ipcrView'])){
  $empId = $_POST['empId'];
  $sname = $_POST['sname'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  $semiSelected = $_POST['semiSelected'];
  // $empNo = '53';
  // $sname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $empId . ' ' . $sname . ' - ' . $semiSelected; 
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";

  echo '<a href="'. $filePath .'" target="_blank">Open in new tab</a><iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';

}else if(isset($_POST['dpcrView'])){
  $division = $_POST['division'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  $semiSelected = $_POST['semiSelected'];
  // $empNo = '53';
  // $sname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $division . ' - ' . $semiSelected;
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";

  echo '<iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';

}else if(isset($_POST['pmcrView'])){
  $empId = $_POST['empId'];
  $sname = $_POST['sname'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  $semiSelected = $_POST['semiSelected'];
  // $empNo = '53';
  // $sname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $empId . ' ' . $sname . ' - ' . $semiSelected; 
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";

  echo '<iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';

} else {

  echo '<center><h1>File not available.</h1></center>';

}

?>