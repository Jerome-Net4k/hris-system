<?php

echo '<script>
  $(document).ready(function(){
    $("#hideLocal").hide()
    $("#hideInt").hide()
    $("#spmsHide").hide();
    $("#prHide").hide();
    $("#joHide").hide();
//PR autohide
    $("#pr").hover(function(){
      $("#spmsHide").hide("fast");
      $("#prHide").show("fast");
      $("#joHide").show("fast");
    })
//spms autohide
    $("#spms").hover(function(){
      $("#spmsHide").show("fast");
      $("#prHide").hide("fast");
      $("#joHide").show("fast");
    })
//jo autohide
    $("#jo").hover(function(){
      $("#spmsHide").show("fast");
      $("#prHide").hide("fast");
      $("#joHide").show("fast");
    })
    $("#local").hover(function(){
      $("#hideLocal").show("fast")
      $("#hideInt").hide("fast")
    })
    $("#int").hover(function(){
      $("#hideLocal").hide("fast")
      $("#hideInt").show("fast")
    })
  })
  </script>
';
  echo '<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #1548C3;">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">
    <img src="images/logo.png" alt="" width="80" height="80" class="d-inline-block align-text-top">
  </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h3 class="text-white fs-3 mt-3">Human Resource Development Section<br><span><h4 class="fs-4">Information System</h4></span></h3>
      <div class="collapse navbar-collapse d-flex justify-content-end me-2" id="navbarNavDropdown">

        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link h5 text-white" href="views_index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle h5 text-white" href="#" id="RSP" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              RSP
            </a>
            <div class="dropdown-menu " aria-labelledby="RSP">
              <a class="dropdown-item" href="views_home.php">EMR</a>
              <a class="dropdown-item" href="views_serviceRec.php">Service Record</a>
              <a class="dropdown-item" href="views_plantila.php">Plantila</a>
              <a class="dropdown-item" href="views_201Files.php">201 Files</a>
              <a class="dropdown-item" href="nosa_view_uploadfile.php">NOSA</a>
              <a class="dropdown-item" href="nosi_view_uploadfile.php">NOSI</a>
              <a class="dropdown-item" href="coe_view_uploadfile.php">COE</a>
              <a class="dropdown-item" href="saln_view_uploadfile.php">SALN</a>
              <a class="dropdown-item" href="#">PDF</a>
            </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle h5 text-white" href="#" id="PM" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                PM
              </a>
              <div class="dropdown-menu" aria-labelledby="PM">
              <a class="dropdown-item fw-bold" href="" id="spms">SPMS</a>
              <div id="spmsHide">
              </div>
              <a class="dropdown-item fw-bold" href="" id="pr">Performance Rating</a>
              <div id="prHide">
                <a class="dropdown-item" href="" id="">OPCR</a>
                <a class="dropdown-item" href="" id="">DPCR</a>
                <a class="dropdown-item" href="views_ipcrUpload.php" id="">IPCR</a>
                <a class="dropdown-item" href="views_ipcrEncoding.php" id="">IPCR Encoding</a>
                <a class="dropdown-item" href="views_ipcrRatingSummary.php" id="">Summary of Ratings</a>
                <a class="dropdown-item" href="" id="">JO Evaluation Report</a>
              </div>
              <a class="dropdown-item fw-bold" href="" id="pr">Monitoring of Submission</a>
              <a class="dropdown-item fw-bold" href="" id="pr">Success Indicator</a>
              <a class="dropdown-item fw-bold" href="pds_view_uploadfile.php">PDS FORM</a>
              <a class="dropdown-item fw-bold" href="" id="">JO | Contract Of Service</a>
              <div id="joHide">
                <a class="dropdown-item" href="views_joContractUpload.php" id="">Contract</a>
                <a class="dropdown-item" href="views_joMonitoring.php" id="">Monitoring</a>
              </div>
            </div>
            


            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle h5 text-white" href="#" id="Others" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              R&R
            </a>
            <div class="dropdown-menu" aria-labelledby="R&R">
              <a class="dropdown-item" href="view_leavecredits.php">LEAVE CREDITS</a>
              <a class="dropdown-item" href="view_loyalty.php">LOYALTY AWARDS</a>
            </div>
          </li> 
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle h5 text-white" href="#" id="L&D" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                L&D 
              </a>
              <div class="dropdown-menu" aria-labelledby="L&D">
              <a class="dropdown-item fw-bold" href="#" id="local">LOCAL</a>
                <div id="hideLocal">
                <a class="dropdown-item" href="ESA.php">Employee Seminar Attended</a>
                <a class="dropdown-item" href="views_lnd.php">In-House Training</a>
                <a class="dropdown-item" href="#">Out-House Training</a>
                <a class="dropdown-item" href="#">Coaching</a>
                <a class="dropdown-item" href="#">Mentoring</a>
                <a class="dropdown-item" href="#">On-Boarding</a>
                <a class="dropdown-item" href="#">Job Rotation</a></div>
  
                <a class="dropdown-item fw-bold" href="#" id="int">INTERNATIONAL</a>
                <div id="hideInt">
                <a class="dropdown-item" href="#">In-House Training</a>
                <a class="dropdown-item" href="#">Out-House Training</a>
                <a class="dropdown-item" href="#">Coaching</a>
                <a class="dropdown-item" href="#">Mentoring</a>
                <a class="dropdown-item" href="#">On-Boarding</a>
                <a class="dropdown-item" href="#">Job Rotation</a></div>
  
                
              </div>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle h5 text-white" href="#" id="Others" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              OJT
            </a>
            <div class="dropdown-menu" aria-labelledby="ojt">
              <a class="dropdown-item" href="view_intern.php">LIST OF INTERN</a>
              <a class="dropdown-item" href="view_moa.php">LIST OF MOA</a>
              <a class="dropdown-item" href="ojt_tablelist.php">OJT TABLE</a>
              <a class="dropdown-item" href="ojt_tablemonthly.php">OJT DTR</a>
            </div>
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
                <a class="dropdown-item" href="orgchart_main.php" target="_blank">ORG CHART</a>
                <a class="dropdown-item" href="flagcere_attendance_view.php">FLAG CEREMONY</a>
                <a class="dropdown-item" href="views_archive.php">ARCHIVE</a>
                <a class="dropdown-item" href="views_user.php">USER MANAGEMENT</a>
                <a class="dropdown-item" href="dashboard_user_table.php">EMPLOYEE MANAGEMENT</a>
              </div>
            </li> 
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle h5 text-white" href="#" id="Others" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              </a>
              <div class="dropdown-menu" aria-labelledby="Others">
                <a class="dropdown-item" href="#">View Account</a>
                <a class="dropdown-item" href="logoutProc.php">Logout</a>
              </div>
            </li> 
          </ul>
      </div>
      </div>
      
    </nav>';
?>