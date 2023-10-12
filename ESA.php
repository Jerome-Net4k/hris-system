<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'partials_header.php';?>
    <?php include 'connection.php';?>
    <?php include 'fetch_employee_data.php';?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>

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

        <script>

$(document).ready(function () {
  // Function for fetching data for modal in List of Employees table
  function fetchDataForEmployeesModal(bpNo, lname, fname) {
    // Update the modal content with the received data
    $("#exampleModal .modal-body .bpNo").text(bpNo);
    $("#exampleModal .modal-body .lname").text(lname);
    $("#exampleModal .modal-body .fname").text(fname);
  }

  // Attach event listener to trigger the modal and fetch data for List of Employees table
  $('#emp_table').on('click', 'tr', function () {
    var bpNo = $(this).data('bpno');
    var lname = $(this).data('lname');
    var fname = $(this).data('fname');

    fetchDataForEmployeesModal(bpNo, lname, fname);

    // Open the modal for List of Employees table
    $("#exampleModal").modal("show");
  });

  // Function for fetching data for modal in List of Seminars table
  function fetchDataForSeminarsModal(title, type, lndFrom, lndTo) {
    // Update the modal content with the received data
    $("#exampleModal2 .modal-body .title").text(title);
    $("#exampleModal2 .modal-body .type").text(type);
    $("#exampleModal2 .modal-body .lndFrom").text(lndFrom);
    $("#exampleModal2 .modal-body .lndTo").text(lndTo);
  }

  // Attach event listener to trigger the modal and fetch data for List of Seminars table
  $('#lnd_table').on('click', 'tr', function () {
    var title = $(this).data('title');
    var type = $(this).data('type');
    var lndFrom = $(this).data('lndFrom');
    var lndTo = $(this).data('lndTo');

    fetchDataForSeminarsModal(title, type, lndFrom, lndTo);

    // Open the modal for List of Seminars table
    $("#exampleModal2").modal("show");
  });

  // Sorting functionality for List of Employees table
  $("th[data-sort-column]").on("click", function () {
    var column = $(this).data("sort-column");
    var arrow = $(this).find(".sort-arrow");

    // Remove sorting classes from all columns
    $("th[data-sort-column]").not(this).removeClass("asc desc");
    $(".sort-arrow").html("");

    if (arrow.hasClass("asc")) {
      arrow.html("&#9650;"); // Up arrow
      arrow.removeClass("asc").addClass("desc");
      // Perform sorting in descending order for the selected column in List of Employees table
      // Implement your sorting logic here
    } else {
      arrow.html("&#9660;"); // Down arrow
      arrow.removeClass("desc").addClass("asc");
      // Perform sorting in ascending order for the selected column in List of Employees table
      // Implement your sorting logic here
    }
  });
});

// Get a reference to the close button element
var closeButton = document.getElementById('closeButton');

// Add a click event listener to the close button
closeButton.addEventListener('click', function() {
  // Get a reference to the modal element
  var modal = document.getElementById('exampleModal');

  // Hide the modal by removing the "show" class
  modal.classList.remove('');
});

// Get a reference to the close button element
var closeButton = document.getElementById('closeButton');

// Add a click event listener to the close button
closeButton.addEventListener('click', function() {
  // Get a reference to the modal element
  var modal = document.getElementById('exampleModal2');

  // Hide the modal by removing the "show" class
  modal.classList.remove('');
});

 
 
</script>

<div class="loader">
  
        <img src="images/loading2.gif" width="20%" height="40%">
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seminar/Training Information</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

        </div>
            <table class="table rounded table-hover" id="mainTable">
            <thead style="top: 0; position: sticky;  height: auto;">
            <tr>
              <th data-sort-employees="title">Title <span class="sort-arrow"></span></th>
              <th data-sort-employees="type">Type <span class="sort-arrow"></span></th>
              <th data-sort-employees="lndFrom">From <span class="sort-arrow"></span></th>
              <th data-sort-employees="lndTo">To <span class="sort-arrow"></span></th>
            </tr>
              </thead>
               <!-- ajax request -->
               <tbody class="left-align-table">
               <h5 class="modal-title" id="exampleModal">
                 <?php
                 // Include the database connection file
                 include 'connection.php';
               
                 try {
                   // SQL statement to fetch the fname and lname data
                   $sql = "SELECT fname, lname FROM emp_table";
                   $result = $conn->query($sql);
               
                   if ($result->rowCount() > 0) {
                     // Fetch the fname and lname from the first row
                     $row = $result->fetch(PDO::FETCH_ASSOC);
                     $fname = $row["fname"];
                     $lname = $row["lname"];
               
                     // Output the dynamic data in the <h5> tag
                     echo $fname . " " . $lname;
                   } else {
                     echo "No data found";
                   }
                 } catch (PDOException $e) {
                   echo "Error: " . $e->getMessage();
                 }
               
                 // Close the database connection
                 $conn = null;
                 ?>
               </h5>      


               <?php
        include 'connection.php';
        try {
          $sql = "SELECT * FROM lnd_table";
          $result = $conn->query($sql);

          if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr data-toggle=\"modal\" data-target=\"#exampleModal2\" " . $row["title"] . "\" data-type=\"" . $row["type"] . "\" data-lndFrom=\"" . $row["lndFrom"] . "\"data-lndTo=\"" . $row["lndTo"] . "\">";
              echo "<td>" . $row["title"] . "</td>";
              echo "<td>" . $row["type"] . "</td>";
              echo "<td>" . $row["lndFrom"] . "</td>";
              echo "<td>" . $row["lndTo"] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan=\"4\">No records found.</td></tr>";
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }

        // Close the database connection
        $conn = null;
      ?>

              </tbody>  
        </table>
        </div>

<!-- ... Other content ... -->



                <!-- Add any buttons or actions you need here -->

      <div class="modal-footer">
        <button id="closeButton" class="close-button">Close</button>
      </div>
    </div>
  </div>
</div>
        </div>
    </div>


    <!-- Seminar Details Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModal2Label">Seminar/Training Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          

        </div>
            <table class="table rounded table-hover" id="mainTable2">
              <thead style="top: 0; position: sticky;  height: auto;">
              <tr>
              <th data-sort-employees="bpNo">BP NO <span class="sort-arrow"></span></th>
              <th data-sort-employees="lname">Surname <span class="sort-arrow"></span></th>
              <th data-sort-employees="fname">First Name <span class="sort-arrow"></span></th>
            
            </tr>
              </thead>

               <?php
            // Include the database connection file
            include 'connection.php';

            try {
                // SQL statement to fetch data from the emp_table tables
                $sql = "SELECT * FROM emp_table";
                $result = $conn->query($sql);

                if ($result->rowCount() > 0) {
                  
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr data-toggle=\"modal\" data-target=\"#exampleModal\" data-BPNO=\"" . $row["bpNo"] . ", " . $row["lname"] . "\" data-lname=\"" . $row["lname"] . "\" data-fname=\"" . $row["fname"] . "\">";
                        echo "<td>" . $row["bpNo"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=\"3\">No records found.</td></tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            // Close the database connection
            $conn = null;
          ?>

              </tbody>  

            
        </table>
    </div>
      <div class="modal-footer">
      <button id="closeButton" class="close-button">Close</button>
      </div>
    </div>
  </div>
</div>
        </div>
    </div>

    <div class="container-fluid pt-2">
        <div class="row pt-2 rounded bg-white">
            <h1 class="mt-2">Learning and Development In</h1>
            <h2 class="mt-2">List of Seminars and Employees</h2>

            <!-- ... existing code ... -->

<!-- Add the container for the button -->
<div class="button-container">
  <a href="AdminDashboard.php" class="btn btn-primary">View Pie Chart</a>
</div>

<!-- ... existing code ... -->


                <div class="row">
  <!-- List of Employees -->
  <div class="column" style="height: 750px; width: 50%; overflow-x: hidden;">
    <div class="input-group w-50 rounded col-6 pt-2">
      <select name="" class="form-control filter" id="fil">
        <option value="" hidden>Filter</option>
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
          <th colspan="3" class="table-header" style="font-size: 14px">List Of Employees</th>
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
                echo "<tr data-toggle=\"modal\" data-target=\"#exampleModal\" data-BPNO=\"" . $row["bpNo"] . "\" data-lname=\"" . $row["lname"] . "\" data-fname=\"" . $row["fname"] . "\">";
                echo "<td>" . $row["bpNo"] . "</td>";
                echo "<td>" . $row["lname"] . "</td>";
                echo "<td>" . $row["fname"] . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan=\"4\">No records found.</td></tr>";
            }
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }

          $conn = null;
        ?>
      </tbody>
    </table>
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
    <table class="left-align-table custom-table" id="mainTable2" >
      <thead>
        <tr>
          <th colspan="4" class="table-header" style="font-size: 14px">List Of Seminars</th>
        </tr>
        
          <th class= "sticky-header">Title</th>
          <th class= "sticky-header">Type</th>
          <th class= "sticky-header">From</th>
          <th class= "sticky-header">To</th>
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
                echo "<tr data-toggle=\"modal\" data-target=\"#exampleModal2\" data-title=\"" . $row["title"] . "\" data-type=\"" . $row["type"] . "\" data-lndFrom=\"" . $row["lndFrom"] . "\" data-lndTo=\"" . $row["lndTo"] . "\">";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["lndFrom"] . "</td>";
                echo "<td>" . $row["lndTo"] . "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan=\"4\">No records found.</td></tr>";
            }
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }

          $conn = null;
        ?>
      </tbody>
    </table>
  </div>
</div>


<script>
$(document).ready(function () {
    // Function to filter the table based on the selected value or search input
    function filterTable(tableId, filterValue) {
      $(`#${tableId} tbody tr`).each(function () {
        var rowText = $(this).text().toLowerCase();
        if (rowText.indexOf(filterValue) !== -1) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    }

    // Filter the employee table
    $('#EmployeeSearchBar').on('keyup', function () {
      var searchValue = $(this).val().toLowerCase();
      filterTable('mainTable', searchValue);
    });

    // Filter the seminar table
    $('#seminarSearchBar').on('keyup', function () {
      var searchValue = $(this).val().toLowerCase();
      filterTable('mainTable2', searchValue);
    });

    // Filter the table when the select input changes
    $('.filter').on('change', function () {
      var filterValue = $(this).val().toLowerCase();
      var tableId = $(this).closest('.column').find('table').attr('id');
      filterTable(tableId, filterValue);
    });
  });
</script>



            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
