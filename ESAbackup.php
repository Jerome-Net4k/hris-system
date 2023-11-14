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
$(document).ready(function() {
 $("#searchBar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    var filter = $("#fil").val();
    var rows = $("#mainTable2 tbody tr");

    if (filter === "") {
      rows.show();
    } else {
      rows.each(function() {
        var self = $(this);
        var td = self.find("td:eq(0)");
        var searchColumn = td.text().toLowerCase();

        if (searchColumn.indexOf(value) !== -1) {
          self.show();
        } else {
          self.hide();
        }
      });
    }
 });
});
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

    <!-- Modal -->

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.exampleModal2').on('click', function() {
                var row = $(this).closest('tr');
                var id = row.find('td:eq(0)').text();
                var type = row.find('td:eq(1)').text();
                var from = row.find('td:eq(2)').text();
                var to = row.find('td:eq(3)').text();

                $('#exampleModal').modal('show');
                $('.modal-title').text($(this).data('title'));
                $('.modal-text').html('<table class="table table-striped table-bordered"><tbody><tr><th>ID</th><td>' + id + '</td></tr><tr><th>Type</th><td>' + type + '</td></tr><tr><th>From</th><td>' + from + '</td></tr><tr><th>To</th><td>' + to + '</td></tr></tbody></table>');
            });
        });
    </script>
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
      <input type="text" class="form-control" id="searchBar2">
              <button class="btn btn-primary" id="search2"><i class="fas fa-search"></i> Search</button>
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
          echo '<tr class="exampleModal2" data-title="' . $row["title"] . '" data-type="' . $row["type"] . '" data-from="' . $row["lndFrom"] . '" data-to="' . $row["lndTo"] . '">';
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td id="employeeId"></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td id="employeeLastName"></td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td id="employeeFirstName"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'connection.php';

        try {
            $sql = "SELECT * FROM emp_table";
            $result = $conn->query($sql);

            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr class="clickable-row" data-toggle="modal" data-target="#exampleModal" data-id="' . $row["bpNo"] . '" data-lname="' . $row["lname"] . '" data-fname="' . $row["fname"] . '">';
                    echo '<td>' . $row["bpNo"] . '</td>';
                    echo '<td>' . $row["lname"] . '</td>';
                    echo '<td>' . $row["fname"] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No records found.</td></tr>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
        ?>
    </tbody>
</table>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        $('.clickable-row').on('click', function () {
            var id = $(this).data('id');
            var lname = $(this).data('lname');
            var fname = $(this).data('fname');

            $('#employeeId').text(id);
            $('#employeeLastName').text(lname);
            $('#employeeFirstName').text(fname);
        });
    });
</script>


<script>
      // Attach an event listener to the search button
document.getElementById('search').addEventListener('click', function() {
    var filter = document.getElementById('fil').value;
    var searchBar = document.getElementById('searchBar').value;

    // If filter or searchBar are empty, return without performing any action
    if (filter === '' || searchBar === '') {
        return;
    }

    // Prepare AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Handle response
    xhr.onload = function() {
        if (this.status === 200) {
            var data = JSON.parse(this.responseText);
            populateTable(data);
        }
    };

    // Send AJAX request
    xhr.send('filter=' + filter + '&searchBar=' + searchBar);
});

function populateTable(data) {
    var table = document.getElementById('mainTable');
    var tbody = table.getElementsByTagName('tbody')[0];
    var html = '';

    for (var i = 0; i < data.length; i++) {
        html += '<tr class="exampleModal" data-fname="' + data[i].fname + '" data-lname="' + data[i].lname + '" data-bpNo="' + data[i].bpNo + '">';
        html += '<td>' + data[i].fname + '</td>';
        html += '<td>' + data[i].lname + '</td>';
        html += '<td>' + data[i].bpNo + '</td>';
        html += '</tr>';
    }

    tbody.innerHTML = html;
}
    </script>

    
<script>
// Attach an event listener to the search button
document.getElementById('search2').addEventListener('click', function() {
    var filter = document.getElementById('fil').value;
    var searchBar2 = document.getElementById('searchBar2').value;

    // If filter or searchBar are empty, return without performing any action
    if (filter === '' || searchBar2 === '') {
        return;
    }

    // Prepare AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Handle response
    xhr.onload = function() {
        if (this.status === 200) {
            var data = JSON.parse(this.responseText);
            populateTable(data);
        }
    };

    // Send AJAX request
    xhr.send('filter=' + filter + '&searchBar2=' + searchBar2);
});

function populateTable(data) {
    var table = document.getElementById('mainTable2');
    var tbody = table.getElementsByTagName('tbody')[0];
    var html = '';

    for (var i = 0; i < data.length; i++) {
        html += '<tr class="exampleModal2" data-title="' + data[i].title + '" data-type="' + data[i].type + '" data-from="' + data[i].lndFrom + '" data-to="' + data[i].lndTo + '">';
        html += '<td>' + data[i].title + '</td>';
        html += '<td>' + data[i].type + '</td>';
        html += '<td>' + data[i].lndFrom + '</td>';
        html += '<td>' + data[i].lndTo + '</td>';
        html += '</tr>';
    }

    tbody.innerHTML = html;
}
</script>
<!-- Employee Details Modal -->

<!-- List of Seminars Modal -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
