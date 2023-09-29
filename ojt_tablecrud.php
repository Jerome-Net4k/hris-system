<?php
  include "connection.php";

// this code use to select record from the database information of the ojt VIEW ojt_tablelist.php
  if(isset($_GET['id'])){
    $myidd = $_GET['id'];
    selectojtinfo($myidd);
  }

  function selectojtinfo($myidd){
    // Get the id from the GET parameter
    // $myidd = $_GET['id'];
    include "connection.php";
  
    // Prepare the SQL statement with a placeholder for the id
    $sql = "SELECT * FROM ojt_tbl WHERE idnum = ?";
  
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

  if (isset($_POST['headerid'])) {
    $headid = $_POST['headerid'];
    selectojthour($headid);
  }


// this code used select time
function selectojthour($headid) {
  include "connection.php";
  $dayselect = $_POST['dayselect'];
  $dtrmonth = $_POST['dtrmonth'];
  $dtryear = $_POST['dtryear'];

  // Prepare the SQL statement with placeholders for the parameters
  $sql = "SELECT * FROM tbl_logs WHERE idnum = ? AND month = ? AND day = ? AND year = ?";

  // Prepare the statement
  $stmt = mysqli_prepare($con, $sql);

  // Bind the parameters to the prepared statement
  mysqli_stmt_bind_param($stmt, "ssss", $headid, $dtrmonth, $dayselect, $dtryear);

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
  
  if (count($data) > 0) {
    // Return data as JSON object
    echo json_encode($data);
  } else {
    // No results found
    echo json_encode("No data found");
  }
}



// insert new dtr record
  if(isset($_POST['dtrtimein'])){
    include "connection.php";
    $headeriddtr = $_POST['headeriddtr'];
    $dtrmonth = $_POST['dtrmonth'];
    $dayselectdtr = $_POST['dayselectdtr'];
    $dtryear = $_POST['dtryear'];
    $dtrtimein = $_POST['dtrtimein'];
    $dtrtimeout = $_POST['dtrtimeout'];
    $dtrtimerender = $_POST['dtrtimerender'];
    $datein = $dtrmonth . " " . $dayselectdtr . ", " . $dtryear;
    $headernamedtr = $_POST['headernamedtr'];

    $sql = "SELECT * FROM tbl_logs WHERE idnum = ? AND month = ? AND day = ? AND year = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ssss', $headeriddtr, $dtrmonth, $dayselectdtr, $dtryear);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $update_stmt = mysqli_prepare($con, "UPDATE tbl_logs SET Timein=?, timeout=?, timerender=? WHERE idnum=? AND month=? AND day=? AND year=?");

      // Bind the parameters to the prepared statement
      mysqli_stmt_bind_param($update_stmt, "sssssss", $dtrtimein, $dtrtimeout, $dtrtimerender, $headeriddtr, $dtrmonth, $dayselectdtr, $dtryear);
      // Execute the UPDATE statement
      if (mysqli_stmt_execute($update_stmt)) {
        echo "DTR record updated";
      }
    }else{
      $insert_stmt = mysqli_prepare($con, "INSERT INTO tbl_logs (idnum, month, day, year, Timein, timeout, timerender, lastdate_in, nameintern) VALUES (?,?,?,?,?,?,?,?,?)");
  
      // Bind the parameters to the prepared statement
      mysqli_stmt_bind_param($insert_stmt, "sssssssss", $headeriddtr, $dtrmonth, $dayselectdtr, $dtryear, $dtrtimein, $dtrtimeout, $dtrtimerender, $datein, $headernamedtr);
      // Execute the INSERT statement
      if (mysqli_stmt_execute($insert_stmt)) {
        echo "DTR record inserted";
      }
    }


  }

// update ojt dtr record
  if (isset($_POST['ojtottimein'])) {
    // echo "DTR record updated";
    $headeriddtr = $_POST['headeridot'];
    $dtrmonth = $_POST['dtrmonth'];
    $dayselectdtr = $_POST['dayselectot'];
    $dtryear = $_POST['dtryear'];
    $dtrtimein = $_POST['ojtottimein'];
    $dtrtimeout = $_POST['ojtottimeout'];
    $dtrtimerender = $_POST['ojtottimerender'];

    // Validate and sanitize input values if necessary
    $update_stmt = mysqli_prepare($con, "UPDATE tbl_logs SET Timein=?, timeout=?, timerender=? WHERE idnum=? AND month=? AND day=? AND year=?");

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($update_stmt, "sssssss", $dtrtimein, $dtrtimeout, $dtrtimerender, $headeriddtr, $dtrmonth, $dayselectdtr, $dtryear);

    // Execute the UPDATE statement
    if (mysqli_stmt_execute($update_stmt)) {
      echo "DTR record updated";
    }
    mysqli_close($con);
  }



// Code for the "update" button in ojt_tablelist.php
// Update button functionality
if (isset($_POST['ojtid'])) {
  $ojtid = $_POST['ojtid'];
  $ojtname = $_POST['ojtname'];
  $latestin = $_POST['latestin'];
  $dutyhours = $_POST['dutyhours'];
  $ojtstatus = $_POST['ojtstatus'];
  $remarks = $_POST['remarks'];

  // Validate and sanitize input values if necessary

  $update_stmt = mysqli_prepare($con, "INSERT INTO tbl_biostatus (idnum, full_name, lastdate_in, status, duty_hour, remarks) VALUES (?, ?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE lastdate_in=VALUES(lastdate_in), status=VALUES(status), duty_hour=VALUES(duty_hour), remarks=VALUES(remarks)");

  // Bind the parameters to the prepared statement
  mysqli_stmt_bind_param($update_stmt, "ssssss", $ojtid, $ojtname, $latestin, $ojtstatus, $dutyhours, $remarks);

  // Execute the UPDATE statement
  if (mysqli_stmt_execute($update_stmt)) {
      echo "DTR info updated";
  } else {
      echo "Failed to update DTR info";
  }

  // Close the statement
  mysqli_stmt_close($update_stmt);
  mysqli_close($con);
}


// Code for the "readbtn" button in ojt_tablelist.php
// Update button functionality
  if (isset($_POST['pendingid'])) {
    include "connection.php";
    $statusconcern = 'DONE';
    $idnum = $_POST['pendingid'];
    $stmt = $con->prepare("UPDATE ojt_concern SET status=? WHERE idnum=?");
    // Bind the parameters to the prepared statement
    $stmt->bind_param("ss", $statusconcern, $idnum);

    // Execute the UPDATE statement
    if ($stmt->execute()) {
        echo "Pending update";
    }
  }

  if (isset($_POST['delheaderidot'])) {
    $delheaderidot = $_POST['delheaderidot'];
    $delday = $_POST['delday'];
    $delmonth = $_POST['delmonth'];
    $delyear = $_POST['delyear'];

    $update_stmt = mysqli_prepare($con, "DELETE FROM tbl_logs WHERE idnum=? AND day=? AND month=? AND year=?");

    // Check if the prepare statement was successful
    if ($update_stmt) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($update_stmt, "ssss", $delheaderidot, $delday, $delmonth, $delyear);

        // Execute the DELETE statement
        if (mysqli_stmt_execute($update_stmt)) {
            echo "DTR record deleted";
        } else {
            echo "Failed to delete DTR record";
        }

        // Close the statement
        mysqli_stmt_close($update_stmt);
    } else {
        echo "Error in prepared statement: " . mysqli_error($con);
    }

    // Close the connection
    mysqli_close($con);
}


?>
