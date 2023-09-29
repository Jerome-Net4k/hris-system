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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="stylehome.css">

    
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
              </li> </ul>
        </div>
        </div>
        <ul class="nav justify-content-end me-5">
              <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle h5 text-white" href="#" id="acc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src ="images/account.png" class="">
                </a>
                <div class="dropdown-menu" aria-labelledby="acc">
                  <a class="dropdown-item" href="logoutProc.php">Log Out</a>                 
                 <a class="dropdown-item" href="#">View Account</a>
                </div>
            </li>
          </ul>
      </nav>
      <div class="container">
        <div class="d-flex justify-content-start">
          <h1 class="title">Personal Data Sheet</h1>
        </div>
          <div class="row">
          <div class="input-group w-50 rounded col-6 pt-2">
            <select name="" class="form-control filter" id="fil">
              <option value="" hidden>Filter</option>
              <option value="surname">Surname</option>
              <option value="fname">First Name</option>
              <option value="mname">Middle Name</option>
              <option value="ext">Name Extension</option>
              
            </select>
          <input type="text" class="form-control" id="searchBar">
            <button class="btn btn-primary" id="search"><i class="fi fi-rr-search p-1"></i>Search</button>
        </div>
        <div class="col pt-2 d-flex justify-content-end">
          <button class="btn btn-dark p-1" id="newData"><i class="fi fi-rr-layer-plus p-1"></i>New Data</button>
        </div>
        </div>
      </div>
      <div class="container">
        <div class="d-flex justify-content-center pt-1">
            <table class="table bg-white shadow-sm table-striped roundTable">
               <tr>
                <th>SURNAME</th>
                <th>FIRST NAME</th>
                <th>MIDDLE NAME</th>
                <th>NAME EXTENSION</th>
                <th class="header">Action</th>
               </tr>
               <!-- ajax request -->
               <tbody id="content">
                        <tr>
                            <td>sad</td>
                            <td>sad</td>
                            <td>sad</td>
                            <td>sad</td>
                            <td> 
                            <?php
                                include 'connection.php';
                                $id = $_SESSION['user'];
                                $query = "SELECT * FROM `user_table` WHERE `id` = ?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param('s',$id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                             if($row['view'] == 1){
                                echo '<button class="btn btn-primary">View</button>';
                             }
                             if($row['edit'] == 1){
                                echo '<button class="btn btn-dark">Edit</button>';
                             }
                            ?>
                            </td>
                        </tr>
               </tbody>      
            </table>

            
        </div>
      </div>

      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel"> View Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="container">
      <table class="table table-borderless">
        <tbody>
            <tr>
                <th>Surname: </th>
                <td id='sname'></td>
                
                <th>Suffix:</th>
                <td id='sfx'> N/A</td>
                <td rowspan="3" colspan="2"><img src="images/profile.png" alt=""></td>
            </tr>
            
            <tr>
                <th>First Name:</th>
                <td id='fname'>Test First Name</td>
            </tr>

            <tr>
                <th>Middle Name:</th>
                <td id='mname'>Test Middle Name</td>
            </tr>

            <tr>
                <th>Date of Birth:</th>
                <td id='dob'>04/22/2001</td>
            </tr>
            
            <tr>
                <th>Place of Birth:</th>
                <td id="pob"></td>
                
                

                <th>ID NO.</th>
                <td id="empNo"></td>
            </tr>

            <tr>
                <th>Gender:</th>
                <td id="gender"></td>
            </tr>

            <tr>
                <th>Civil Status:</th>
                <td id="civil"></td>
            </tr>

            <tr>
                <th>House/Block/Lot No.</th>
                <td id="resHouse"></td>
            </tr>

            <tr>
                <th>Barangay:</th>
                <td id="resBrgy"></td>
            </tr>

            <tr>
                <th>City:</th>
                <td id="resCity"></td>
            </tr>

            <tr>
                <th>Zipcode:</th>
                <td id="resZip"></td>

                <th>Position</th>
                <td>Testing Position</td>
            </tr>

            <tr>
                <th>Email:</th>
                <td id="email"></td>

                <th>Department:</th>
                <td>Testing dept</td>
            </tr>

            <tr>
                <th>Citizenship:</th>
                <td id="citi"></td>

                <th>Plantilla:</th>
                <td>Testing plantilla</td>
            </tr>

            <tr>
                <th>Height:</th>
                <td id="height"></td>

                <th>Employment Type:</th>
                <td>Regular</td>
            </tr>

            <tr>
                <th>Weight:</th>
                <td id="weight"></td>

                <th>Employment Status:</th>
                <td>ACTIVE</td>
            </tr>

            <tr>
                <th>Blood Type:</th>
                <td id="btype"><td>

            </tr>

            <tr>
                <th>GSIS ID No.</th>
                <td id="gsis"></td>

                <th>Contact Number</th>
                <td id="mobile"></td>
            </tr>

            <tr>
                <th>Pag-Ibig ID No.:</th>
                <td id="pagibig"></td>
            </tr>

            <tr>
                <th>Philhealth:</th>
                <td id="phealth"></td>
            </tr>

            <tr>
                <th>TIN:</th>
                <td id="tin"></td>
            </tr>
        </tbody>
      </table>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">PDS</button>
        <button class="btn btn-primary">Appointment</button>
      </div>
    </div>
  </div>
</div>

      
      
    
</body>
</html>