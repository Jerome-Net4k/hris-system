<?php
  include "connection.php";

  if(isset($_GET['id'])){
    $myidd = $_GET['id'];
    selectojtinfo($myidd);
  }

// this code use to select
  function selectojtinfo($myidd){
    // Get the id from the GET parameter
    // $myidd = $_GET['id'];
    include "connection.php";
  
    // Prepare the SQL statement with a placeholder for the id
    $sql = "SELECT * FROM attendance_table_person WHERE empNo = ?";
  
    // Prepare the statement
    $stmt = mysqli_prepare($con, $sql);
  
    // Bind the id parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $myidd);
  
    // Execute the statement
    mysqli_stmt_execute($stmt);
  
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
  
    // Create array to store data
    $data = array();
  
    // Loop through the result set and add each row to the data array
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    // Return data as JSON object
    echo json_encode($data);
  }


  if (isset($_POST['daycreate'])) {
    $attmonth = $_POST['attmonth'];
    $daycreate = $_POST['daycreate'];
    $attyear = $_POST['attyear'];
  
    // Check if the record already exists
    $check_stmt = mysqli_prepare($con, "SELECT * FROM attendance_date WHERE dmonth = ? AND dday = ? AND dyear = ?");
    mysqli_stmt_bind_param($check_stmt, "sss", $attmonth, $daycreate, $attyear);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
  
    if (mysqli_stmt_num_rows($check_stmt) > 0) {
      echo 'Record already exists';
    } else {
      $insert_stmt = mysqli_prepare($con, "INSERT INTO attendance_date (dmonth, dday, dyear) VALUES (?, ?, ?)");
  
      // Bind the parameters to the prepared statement
      mysqli_stmt_bind_param($insert_stmt, "sss", $attmonth, $daycreate, $attyear);
  
      // Execute the INSERT statement
      if (mysqli_stmt_execute($insert_stmt)) {
        echo 'Create date directory';
      }
    }
  }

  if (isset($_POST['yearload'])) {
    $yearload = $_POST['yearload'];
    $month = $_POST['month'];
    $sql = "SELECT * FROM attendance_date WHERE dmonth = '$month' AND dyear = '$yearload' GROUP BY dday";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      echo '<option></option>';
      while ($row = $result->fetch_assoc()) {
        echo '<option>' . $row['dday'] . '</option>';
                                          // Your code logic here
      }
    }
  }

  if (isset($_POST['deltypeyes'])) {
    $editdateinfomonth = $_POST['editdateinfomonth'];
    $editdateinfoday = $_POST['editdateinfoday'];
    $editdateinfoyear = $_POST['editdateinfoyear'];

    // Delete from attendance_date table
    $delete_stmt = mysqli_prepare($con, "DELETE FROM attendance_date WHERE dmonth=? AND dday=? AND dyear=?");
    mysqli_stmt_bind_param($delete_stmt, "sss", $editdateinfomonth, $editdateinfoday, $editdateinfoyear);
    if (mysqli_stmt_execute($delete_stmt)) {
        echo 'Date deleted';
    }

    // Delete from attendance_monitoring table
    $delete2_stmt = mysqli_prepare($con, "DELETE FROM attendance_monitoring WHERE month=? AND day=? AND year=?");
    mysqli_stmt_bind_param($delete2_stmt, "sss", $editdateinfomonth, $editdateinfoday, $editdateinfoyear);
    mysqli_stmt_execute($delete2_stmt);
  }

  if (isset($_POST['dayupdate'])) {
    $dayupdate = $_POST['dayupdate'];
    $editdateinfomonth = $_POST['editdateinfomonth'];
    $editdateinfoday = $_POST['editdateinfoday'];
    $editdateinfoyear = $_POST['editdateinfoyear'];

    // Update attendance_date table
    $update_stmt = mysqli_prepare($con, "UPDATE attendance_date SET dday=? WHERE dmonth=? AND dday=? AND dyear=?");
    mysqli_stmt_bind_param($update_stmt, "ssss", $dayupdate, $editdateinfomonth, $editdateinfoday, $editdateinfoyear);
    if (mysqli_stmt_execute($update_stmt)) {
        echo 'Date updated';
    }

    // Update attendance_monitoring table
    $update2_stmt = mysqli_prepare($con, "UPDATE attendance_monitoring SET day=? WHERE month=? AND day=? AND year=?");
    mysqli_stmt_bind_param($update2_stmt, "ssss", $dayupdate, $editdateinfomonth, $editdateinfoday, $editdateinfoyear);
    mysqli_stmt_execute($update2_stmt);
  }

  if (isset($_POST['deptname'])) {
    $attfileupload = $_FILES["pdfFile"]["name"];
    $deptnameupload = $_POST['deptname'];
    $dayattendance = $_POST['dayattendance'];
    $attmonth = $_POST['attmonth'];
    $attyear = $_POST['attyear'];

    $filename = $deptnameupload . " " . $attmonth ." ". $dayattendance .", " . $attyear . '.pdf'; // Keep the original filename
    $upimage_tmp = $_FILES["pdfFile"]["tmp_name"];
    move_uploaded_file($upimage_tmp, "attfile/" . $filename);
    echo 'Uploaded file';
  }

// attendance pdf file load
  if (isset($_POST['viewattdayupload'])) {
    $month = $_POST['viewattmonthupload'];
    $day = $_POST['viewattdayupload'];
    $year = $_POST['viewattyearupload'];
    $dept = $_POST['viewdeptnameupload'];
  
    $filename = $dept . " " . $month . " " . $day . ", " . $year . '.pdf';
    
    $filepath = "attfile/$filename";
    
    if (file_exists($filepath)) {
      echo "<iframe src='$filepath' frameborder='0' width='100%' height='90%'></iframe>";
    } else {
      echo "<div class='d-flex justify-content-center' style='font-size: 30px; color: red;'><strong>NO PDF FILE UPLOAD YET</strong></div>";
    }
  }
// attendance pdf file delete
  if (isset($_POST['delattdayupload'])) {
    $month = $_POST['delattmonthupload'];
    $day = $_POST['delattdayupload'];
    $year = $_POST['delattyearupload'];
    $dept = $_POST['deldeptnameupload'];

    $filename = $dept . " " . $month . " " . $day . ", " . $year . '.pdf';
    
    $filepath = "attfile/$filename";
    if (file_exists($filepath)) {
        if (unlink($filepath)) {
          echo "File deleted successfully";
        }
    }
  }
  
  if (isset($_POST['newdepartment'])) {
    $newdepartment = $_POST['newdepartment'];

    $insert_stmt = mysqli_prepare($con, "INSERT INTO attendance_department (department) VALUES (?)");
  
      // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($insert_stmt, "s", $newdepartment);
  
      // Execute the INSERT statement
    if (mysqli_stmt_execute($insert_stmt)) {
      echo 'Add department';
    }
  }

if (isset($_POST['attendfile'])) {
  echo '<iframe src="flagcere_attendance_file.php" frameborder="0" width="100%" height="100%">

  </iframe>';
}
?>
