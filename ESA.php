<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'partials_header.php';?>
    <?php include 'connection.php';?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script>
    $(document).ready(function(){
        load();
        $("select#add").change(function(){
            var type = $(this).val();
            if(type == 'new'){
            window.location.href="views_addNewSeminar.php"
            }
            else{
                window.location.href="views_addExistingSeminar.php"
            }
        })

        function load(){
            var action = "load";
            $.ajax({
                type: "POST",
                data: {action:action},
                url: "proc_lnd.php",
                success: function(data){
                    $("table#mainTable tbody").html(data);
                }
            })
        }
    })
</script>


<style>
* {
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

.row {
  margin-left: 0px;
  margin-right: 0px;
  text-align: left;
  display: flex;
}

.column {
  width: 30%;
  padding: 5px;
  text-align: left;
  overflow-x: hidden;
}



table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  table-layout: fixed;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  background-color: #fff;
  font-size: 12px;  
}


th {
  color: white; /* Header text color */
  text-align: left , 100%;  
  padding: 16px;
  background-color: #0d6efd; 
  top: 0;    
  position: sticky;
}

td {
padding: 16px;
white-space: pre-wrap;
text-align: left;
}

tbody {
  height: 680px;
  overflow-y: auto;
}

.sticky-header {
  position: sticky;
  top: 0;
  background-color: #0d6efd;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}


tr:hover {
  background-color: #cce6ff;   
}


caption {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 10px;
  caption-side: Center;
}
h3 {
text-align: center;
}
/* Add this CSS to your existing styles */
.table-header {
background-color: #666; /* Header background color */
color: white; /* Header text color */
text-align: center; /* Center align text within the header cell */
padding: 16px;
}


</style>

  
</head>
<body style="overflow: hidden;">
    <?php include 'navbar.php'; ?>



<div class="loader">
  
        <img src="images/loading2.gif" width="20%" height="40%">
    </div>
        
   <div class="container-fluid pt-2">
        <div class="row pt-2 rounded bg-white">
            <h1 class="mt-2">Learning and Development In</h1>
            <h2 class="mt-2">List of Seminars and Employees</h2>

            <!-- ... existing code ... -->



<!-- Add the container for the button -->
<div class="button-container">
  <a href="Admin/AdminDashboard.php" class="btn btn-primary">View Pie Chart</a>
</div>

<!-- ... existing code ... -->


  <div class="row">
  <!-- List of Employees -->
  <div class="column" style="height: 750px; width: 50%; overflow-x: hidden;">
    <div class="input-group w-50 rounded col-6 pt-2">
      <select name="" class="form-control filter" id="fil">
        <option value="hidden" >Filter</option>
        <option value="bpNo">BP NO</option>
        <option value="fname">First Name</option>
        <option value="lname">Last Name</option>
      </select>
      <div style="padding: 10px 15px; background: #dee2e6; border-radius: 5px;">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
      </div>
      <input type="text" class="form-control" id="searchBar">
              <button class="btn btn-primary" id="search"><i class="fas fa-search"></i> Search</button>
    </div>
    <table class="left-align-table custom-table" id="mainTable">
      <thead>
        <tr>
          <th colspan="3" class="table-header" style="font-size: 20px">List Of Employees</th>
        </tr>
        <tr>
          <th class= "sticky-header">BPNO</th>
          <th class= "sticky-header">Last Name</th>
          <th class= "sticky-header">First Name</th>
        </tr>
      </thead>
      <tbody style="overflow-y: auto;">
            <?php
              include 'connection.php';

              try {
                  $sql = "SELECT * FROM emp_table";
                  $result = $conn->query($sql);

                  if ($result->rowCount() > 0) {
                      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr class="clickable-row" data-title="exampleModal' . $row["bpNo"] . '" data-type="' . $row["lname"] . '" data-from="' . $row["fname"] . '">';
                        echo '<td>' . $row["bpNo"] . '</td>';
                          echo '<td>' . $row["lname"] . '</td>';
                          echo '<td>' . $row["fname"] . '</td>';
                          echo '</tr>';
                      }
                  } else {
                      echo '<tr><td colspan="4">No records found.</td></tr>';
                  }
              } catch (PDOException $e) {
                  echo "Error: " . $e->getMessage();
              }

              $conn = null;
            ?>

      </tbody>
    </table>
  </div>

  <!-- List of Seminars Modal -->
<div class="modal fade" id="seminarsModal" tabindex="-1" aria-labelledby="seminarsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal content for seminars -->
      <!-- ... (Your HTML structure for the list of seminars) ... -->
    </div>
  </div>
</div>

  
  <!-- List of Seminars -->
  <div class="column" style="height: 750px; width: 50%; overflow-x: hidden;">
    <div class="input-group w-50 rounded col-6 pt-2">
      <select name="" class="form-control filter" id="fil">
        
        <option value="" hidden>Filter</option>
        <option value="title">Title</option>
        <option value="type">Type</option>

      </select>
      <div style="padding: 10px 15px; background: #dee2e6; border-radius: 5px;">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
      </div>
      <input type="text" class="form-control" id="searchBar">
              <button class="btn btn-primary" id="search"><i class="fas fa-search"></i> Search</button>
    </div>
    <table class="left-align-table custom-table" id="mainTable2">
  <thead>
    <tr>
      <th colspan="4" class="table-header" style="font-size: 20px">List Of Seminars</th>
    </tr>
    <tr>
      <th class="sticky-header">Title</th>
      <th class="sticky-header">Type</th>
      <th class="sticky-header">From</th>
      <th class="sticky-header">To</th>
    </tr>
  </thead>
  <tbody style="overflow-y: auto;">
    <?php
    include 'connection.php';

    try {
      $sql = "SELECT * FROM lnd_table";
      $result = $conn->query($sql);

      if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr class="exampleModal" data-title="' . $row["title"] . '" data-type="' . $row["type"] . '" data-from="' . $row["lndFrom"] . '" data-to="' . $row["lndTo"] . '">';
          echo '<td>' . $row["title"] . '</td>';
          echo '<td>' . $row["type"] . '</td>';
          echo '<td>' . $row["lndFrom"] . '</td>';
          echo '<td>' . $row["lndTo"] . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr><td colspan="4">No records found.</td></tr>';
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    $conn = null;
    ?>
  </tbody>
</table>

<!-- Employee Details Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seminar/Training Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-8">
            <p><strong>Title:</strong> <span id="modalTitle"></span></p>
            <p><strong>Type of l&d intervention:</strong> <span id="modalType"></span></p>
            <p><strong>smt(s)/rs(s)/conducted by: </strong><span id="modalCond"></span></p>
            </div>
            <div class="col">
            <p><strong>Date:</strong> <span id="date"></span></p>
            <p><strong>Venue:</strong> <span id="modalVenue"></span></p>
            </div>
        </div>
        <p><strong>Remarks:</strong> <span id="modaRemarks"></span></p>
        <hr>
        <h4>Expenses</h4>
        <table class="table table-bordered" id="table_expenses">
                
        </table>
        <h4>Total: <span id="modalTotal"></span></h4>
        <hr>
        <h4>Office Order/Travel Oder </h4>
        <a id="modalOfficeOrder"></a>
        <hr>
        <h4>Objective/s</h4>
            <p id="modalObj"></p>
        <hr>
        <h4>Reference Files</h4>
        <ul id="reference">
            
        </ul>
        <hr>
        <h4>Participants</h4>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Salary Grade</th>
                <th>Position</th>
                <th>Type Of Certificate</th>
                <th>Remarks</th>
            </tr>
            
            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td>Adduru, Ronald Karl C.</td>
                <td>Male</td>
                <td>21</td>
                <td>18</td>
                <td>Computer Programmer II</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        </div>
    </div>
      



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
