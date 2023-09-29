<?php 
if(isset($_POST['salnView'])){
  $empId = $_POST['empId'];
  $sname = $_POST['sname'];
  $yearSelect = $_POST['yearSelect'];
  $folderSelect = $_POST['folderSelect'];
  // $empNo = '53';
  // $sname = 'Adduru';
  // $yearSelect = '2023';
  // $folderSelect = 'OPCR';
  $fileName = $empId . ' ' . $sname; 
  $filePath = "pmupload/" . $yearSelect . "/" . $folderSelect . '/' . $fileName .".pdf";
  // $filePath = "pmupload/2023/OPCR/Central Office - 1st.pdf";
} 


  echo '<iframe src="' . $filePath . '" width="100%" style="height:75vh"></iframe>';


?>