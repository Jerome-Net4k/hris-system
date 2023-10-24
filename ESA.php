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
          <th colspan="4" class="table-header" style="font-size: 14px">List Of Employees</th>
        </tr>
        <tr>
          <th class= "sticky-header">BPNO</th>
          <th class= "sticky-header">Last Name</th>
          <th class= "sticky-header">First Name</th>
          <th class= "sticky-header">Action</th>
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
                          echo '<tr>';
                          echo '<td>' . $row["bpNo"] . '</td>';
                          echo '<td>' . $row["lname"] . '</td>';
                          echo '<td>' . $row["fname"] . '</td>';
                          echo '<td><a href="view_employee.php?bpNo=' . $row["bpNo"] . '" class="btn btn-info">View</a></td>';
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
          <th colspan="5" class="table-header" style="font-size: 14px">List Of Seminars</th>
        </tr>
          <th class= "sticky-header">Title</th>
          <th class= "sticky-header">Type</th>
          <th class= "sticky-header">From</th>
          <th class= "sticky-header">To</th>
          <th class= "sticky-header">Action</th>
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
                          echo '<tr>';
                          echo '<td>' . $row["title"] . '</td>';
                          echo '<td>' . $row["type"] . '</td>';
                          echo '<td>' . $row["lndFrom"] . '</td>';
                          echo '<td>' . $row["lndTo"] . '</td>';
                          echo '<td><a href="view_seminar.php?id=' . $row["id"] . '" class="btn btn-info">View</a></td>';
                          echo '</tr>';
                      }
                  } else {
                      echo '<tr><td colspan="5">No records found.</td></tr>';
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
