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
    width: 100%;
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
  height: auto;
  overflow: hidden;
}
.scrollable-tbody {
  overflow: scroll;
  height: 610px; /* Adjust this value to fit your needs */     /*you cant adjust the height if you only using zoom */
  overflow-x:hidden;
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


</style>
</head>

<body>
<?php include 'navbar.php'; ?>

<?php 
include 'connection.php';

// Fetch data for emp_table
$emp_query = "SELECT * FROM emp_table";
$emp_result = $conn->query("SELECT * FROM emp_table");

// Fetch data for lnd_table
$lnd_query = "SELECT * FROM lnd_table";
$lnd_result = $conn->query("SELECT * FROM lnd_table");
?>

<div class="loader">
  
        <img src="images/loading2.gif" width="20%" height="40%">
    </div>
        
   <div class="container-fluid pt-2">
        <h1 class="mt-2">Learning and Development In</h1>
        <h2 class="mt-2">List of Seminars and Employees</h2>
    <div class="row">
    </div> 
</div>



  
  



      <label><h3>Search</h3></label><input type="text" name="search" id="search" placeholder="Search By Name" class="formcontrol">







    <script src="jquery/jquery.min.js"></script>
    <script src="jquery/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Function to filter the table based on the selected value or search input
              $('#search').keyup(function(){
                search_table($(this).val());
              });
              function search_table(value){
                  $('#myTable tr').each(function(){
                    var found ="false";
                    $(this).each(function(){
                        if($(this).text().toLowerCase().indexOf(value.toLowerCase())>=0)
                        {
                          found='true';
                        }
                    });
                    if(found=='true'){
                        $(this).show()
                    }
                    else{
                      $(this).hide();
                    }
                  })
              }
          });
      </script>

<div class="table-container">
    <!-- Employee Table -->
    <div class="table-wrapper">
        <div class="
        able-table">
          <table>
            <thead>
              <tr class="sticky-header">
                <th colspan="3" class="table-header" style="font-size: 20px">List Of Employees</th>
              </tr>
              <tr class="sticky-header">
                <th>BPNO</th>
                <th>Employee Name</th>
                <th>Department</th>
              </tr>
            </thead>
          </table>
          <div class="scrollable-tbody">
            <table>
              <tbody>
                <?php while($row = $emp_result->fetch(PDO::FETCH_ASSOC)) { ?>                
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    <div class="table-wrapper">
        <div class="scrollable-table">
        <table>
          <thead>
            <tr class="sticky-header">
              <th colspan="3" class="table-header" style="font-size: 20px">List Of Seminar</th>
            </tr>
            <tr class="sticky-header">
              <th>Learning ID</th>
              <th>Learning Name</th>
              <th>Category</th>
            </tr>
          </thead>
        </table>
        <div class="scrollable-tbody">
          <table>
            <tbody>
              <?php while($row = $lnd_result->fetch(PDO::FETCH_ASSOC)) { ?>                
                <tr>
                  <td><?php echo $row['title']; ?></td>
                  <td><?php echo $row['type']; ?></td>
                  <td><?php echo $row['lndFrom']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

</body>
</html>
