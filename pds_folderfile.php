<?php 
if(isset($_POST['pdsView'])){
  $empId = $_POST['empId'];
  $lname = $_POST['lname'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  // $pdsempNo = '53';
  // $lname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $empId . ' ' . $lname; 
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";
} 


  echo '<iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';


?>