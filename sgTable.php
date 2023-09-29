<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:login.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <?php include 'partials_header.php';  ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    <script>
        $(document).ready(function(){

            $("#sg").load("getSalaryGrade.php");
        })
        
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #1548C3;">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="images/logo.png" alt="" width="80" height="80" class="d-inline-block align-text-top">
    </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link h5 text-white" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle h5 text-white" href="#" id="RSP" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                RSP
              </a>
              <div class="dropdown-menu " aria-labelledby="RSP">
                <a class="dropdown-item" href="home.php">PDS</a>
                <a class="dropdown-item" href="serviceRec.php">Service Record</a>
                <a class="dropdown-item" href="#">Plantila</a>
                <a class="dropdown-item" href="#">201 Files</a>
                <a class="dropdown-item" href="#">NOSA</a>
                <a class="dropdown-item" href="#">NOSI</a>
                <a class="dropdown-item" href="#">COE</a>
                <a class="dropdown-item" href="#">SALN</a>
                <a class="dropdown-item" href="#">PDF</a>
              </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h5 text-white" href="#" id="PM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  PM
                </a>
                <div class="dropdown-menu" aria-labelledby="PM">
                  <a class="dropdown-item" href="#">SPMS</a>
                  <a class="dropdown-item" href="#">OPCR</a>
                  <a class="dropdown-item" href="#">IPCR</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link h5 text-white" href="#">RNR</a>
              </li>
              <li class="nav-item">
                <a class="nav-link h5 text-white" href="#">LND</a>
              </li>
              <li class="nav-item">
                <a class="nav-link h5 text-white" href="#">OJT</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h5 text-white" href="#" id="Others" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Others
                </a>
                <div class="dropdown-menu" aria-labelledby="Others">
                  <a class="dropdown-item" href="#">ARTA</a>
                  <a class="dropdown-item" href="#">GAD</a>
                  <a class="dropdown-item" href="#">EA</a>
                  <a class="dropdown-item" href="#">PRIME</a>
                  <a class="dropdown-item" href="#">DIRECTORY</a>
                  <a class="dropdown-item" href="#">ORG CHART</a>

                </div>
              </li> 
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle h5 text-white" href="#" id="Others" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account
                </a>
                <div class="dropdown-menu" aria-labelledby="Others">
                  <a class="dropdown-item" href="#">View Account</a>
                  <a class="dropdown-item" href="logoutProc.php">Logout</a>
                </div>
              </li> 
            </ul>
        </div>
        </div>
      </nav>
      <div class="container">
        <table class="table bg-white rounded mt-2 bt-2">
        <thead>
                <th class="text-center">Salary Grade</th>
                <th>Step 1</th>
                <th>Step 2</th>
                <th>Step 3</th>
                <th>Step 4</th>
                <th>Step 5</th>
                <th>Step 6</th>
                <th>Step 7</th>
                <th>Step 8</th>
            </thead>
            <tbody id="sg">
                <td></td>
            </tbody>

            
          </table>
      </div>
    

      
      
    
</body>
</html>