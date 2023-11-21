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
    width: 50%;
    padding: 5px;
    text-align: left;
    overflow-x: hidden;
    flex: 1;
    margin: 0 10px;
}

.flex-row {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}


.scrollable-table {
  width: 100%;
}

.scrollable-tbody {
  overflow-y: auto;
  max-height: 610px; /* Adjust this value to fit your needs */
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

.table-container {
  display: flex;
  justify-content: space-between;
}

.table-wrapper {
  width: 49%; /* Adjust this value as needed */
}

{.box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
background-color: #fff;
font-size: 12px;  
}

.custom-table {
    width: 100%;
    table-layout: fixed;
}

th {
    color: white; /* Header text color */
    text-align: left;  
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
    height: 700px;
}

.sticky-header th {
  position: sticky;
  top: 0;
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

.padded-header, .padded-data {
  padding-left: 200px; /* Adjust this value as needed */
}

.from-to-header, .from-to-data {
  padding-left: 150px; /* Adjust this value as needed */
}

#searchEmployee, #searchSeminar {
  width: 100%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  padding: 12px 20px 12px 50px; /* Increased left padding */
}

#searchEmployee::placeholder, #searchSeminar::placeholder {
  font-size: 16px;
  padding-left: 30px; /* Increased left padding */
  background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>') no-repeat;
  background-size: 20px 20px;
  background-position: 10px center; /* Adjusted position */
}

</style>
</head>

<body>
<?php include 'navbar.php'; ?>

<script>
  // Employee modal
$(document).ready(function(){
  $("#employeeTable tr").click(function() {
    var bpNo = $(this).find("td:first").text(); // Assuming the bpNo is in the first cell of the row

    $.ajax({
      url: 'fetch_seminars.php',
      type: 'post',
      data: {bpNo: bpNo},
      success: function(response) {
        $("#seminarTableBodyModal").html(response);
      }
    });
  });

  $('#employeeTable tbody tr').click(function(){
    var id = $(this).children('td').eq(0).text();
    var fname = $(this).children('td').eq(1).text();
    var lname = $(this).children('td').eq(2).text();

    $('#employeeBpno').text('BP NO: ' + id);
    $('#employeeName').text('Name: ' + fname + ' ' + lname); // Concatenate the first name and last name
    $('#employeeModal').modal('show');
  });
});

// Seminar modal
$(document).ready(function(){
  $("#seminarTable tr").click(function() {
    var empNo = $(this).find("td:first").text(); // Assuming the title is in the first cell of the row

    $.ajax({
      url: 'fetch_seminar_attendees.php',
      type: 'post',
      data: {empNo: empNo},
      success: function(response) {
        $("#employeeTableBodyModal").html(response);
      }
    });
  });

  $('#seminarTable tbody tr').click(function(){
    var title = $(this).children('td').eq(0).text();
    var type = $(this).children('td').eq(1).text();
    var from = $(this).children('td').eq(2).text();
    var to = $(this).children('td').eq(3).text();

    $('#seminarType').text('Type: ' + type);
    $('#seminarName').text('Title: ' + title);
    $('#seminarFrom').text('From: ' + from);
    $('#seminarTo').text('To: ' + to);
    $('#seminarModal').modal('show');
  });
});


$(document).ready(function(){
  // When the close button or the close icon is clicked...
  $('.modal .close, .modal .btn-secondary').click(function(){
    // Hide the modal
    $('.modal').modal('hide');
    // Manually remove the modal backdrop
    $('.modal-backdrop').remove();
    // Manually remove the 'modal-open' class from the body
    $('body').removeClass('modal-open');
  });
});

$(document).ready(function(){
  $("#searchEmployee").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#employeeTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#searchSeminar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#seminarTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


</script>

<?php 
include 'connection.php';

// Fetch data for emp_table
$emp_query = "SELECT * FROM emp_table";
$emp_result = $conn->query("SELECT * FROM emp_table");

// Fetch data for lnd_table
$seminars_query = "SELECT * FROM seminars_table";
$seminars_result = $conn->query($seminars_query);
?>

<div class="container-fluid" style="background-color: #f8f9fa;"> <!-- Add your desired background color here -->
    <div class="loader">
        <img src="images/loading2.gif" width="20%" height="40%">
    </div>
        
    <div class="container-fluid pt-2">
        <h1 class="mt-2">Learning and Development In</h1>
        <h2 class="mt-2">List of Seminars and Employees</h2>
        <div class="row">
        </div> 
    </div>


    <!-- Employee Table -->
    
    <div class="table-container" style="justify-content: center;"> <!-- Adjust the space between tables -->
        <div class="table-wrapper" style="margin-right: 10px;"> <!-- Added margin-right -->
            <div class="scrollable-table">
            <input type="text" id="searchEmployee" placeholder="Search Employee">

            <table id="employeeTable"> <!-- Added ID here -->
                <thead>
                  <tr class="sticky-header">
                    <th colspan="3" class="table-header" style="font-size: 20px">List Of Employee</th>
                  </tr>
                  <tr class="sticky-header">
                    <th>Employee BP NO</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                  </tr>
                </thead>
              </table>
              <div class="scrollable-tbody">
              <table id="employeeTable"> <!-- Added ID here -->
                  <tbody>
                    <?php while($row = $emp_result->fetch(PDO::FETCH_ASSOC)) { ?>                
                      <tr data-toggle="modal" data-target="#employeeModal">
                        <td><?php echo $row['bpNo']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
              <!-- Employee Modal -->
          <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                </div>
                <div class="modal-body">
                <p id="employeeBpno"></p> <!-- Placeholder for employee ID -->
                <p id="employeeName"></p> <!-- Placeholder for employee last name -->               
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <table id="seminarTableModal">
                  <thead>
                    <tr>
                      <th>Seminar Type</th>
                      <th>Seminar Name</th>
                      <th>Date From</th>
                      <th>Date To</th>
                      <!-- Other headers -->
                    </tr>
                  </thead>
                  <tbody id="seminarTableBodyModal">
                    <!-- Seminar data will be inserted here -->
                  </tbody>
                </table>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>

           <!-- Seminar Table -->
          <div class="table-wrapper" style="margin-right: 10px;"> <!-- Added margin-right -->
          <input type="text" id="searchSeminar" placeholder="Search Seminar">
            <div class="scrollable-table">
            <table id="seminarTable"> <!-- Added ID here -->
              <thead>
                <tr class="sticky-header">
                  <th colspan="4" class="table-header" style="font-size: 20px">List Of Seminar</th>
                </tr>
                <tr class="sticky-header">
                  <th>Title</th>
                  <th class="padded-header">Type</th>
                  <th class="padded-header from-to-header">To</th>
                  <th class="padded-header from-to-header">From</th>
                </tr>
              </thead>
            </table>
            <div class="scrollable-tbody">
            <table id="seminarTable"> <!-- Added ID here -->
                <tbody>
                  <?php while($row = $seminars_result->fetch(PDO::FETCH_ASSOC)) { ?>                
                    <tr data-toggle="modal" data-target="#seminarModal">
                      <td><?php echo $row['title']; ?></td>
                      <td class="padded-data"><?php echo $row['typeLnd']; ?></td>
                      <td class="padded-data from-to-data"><?php echo $row['dateFrom']; ?></td>
                      <td class="padded-data from-to-data"><?php echo $row['dateTo']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
  <!-- Seminar Modal -->
          <div class="modal fade" id="seminarModal" tabindex="-1" role="dialog" aria-labelledby="seminarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="seminarModalLabel">Seminar Details</h5>
                </div>
                <div class="modal-body">
                  <p id="seminarType"></p> <!-- Placeholder for seminar type -->
                  <p id="seminarName"></p> <!-- Placeholder for seminar name -->
                  <p id="seminarFrom"></p> <!-- Placeholder for seminar start date -->
                  <p id="seminarTo"></p> <!-- Placeholder for seminar end date -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <table id="employeeTableModal">
                      <thead>
                        <tr>
                          <th>Employee ID</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <!-- Other headers -->
                        </tr>
                      </thead>
                      <tbody id="employeeTableBodyModal">
                        <!-- Employee data will be inserted here -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
</body>
</html>