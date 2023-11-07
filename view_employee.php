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
    <?php include 'partials_header.php';  ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="arrow.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>
    
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
       *{
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        $(document).ready(function(){
          
        $("div#editProf").hide();
        $("div#editProf2").hide();
        
        document.getElementById("imgselect").addEventListener("click", function() {
          document.getElementById("pdsimage").click();
        });

        document.getElementById("pdsimage").addEventListener("change", function() {
          var fileInput = this; // Reference to the file input element
          var previewImage = document.getElementById("pp"); // Reference to the preview image element

          if (fileInput.files && fileInput.files[0]) {
            $("#imgpdsindicator").text("Preview...");
            // Check if files are present and the first file is selected

            var reader = new FileReader(); // Create a FileReader object

            reader.onload = function(e) {
            // Event handler for when the file is loaded

            previewImage.setAttribute("src", e.target.result); // Set the source of the preview image to the loaded file data
            };

            reader.readAsDataURL(fileInput.files[0]); // Read the selected file as a data URL
          }
        });


        $("form#uploadpdsimg").submit(function(e){
          e.preventDefault();
          $("#pp").removeAttr("src"); // Remove the existing 'src' attribute
          
          var editProf_form = new FormData(this);
          var viewgsis = $("#viewgsis").text().trim();
          var viewsname = $("#viewsname").text().trim();
          var pdsimage = $("#pdsimage").val();
          // alert(pdsimage);
          editProf_form.append('viewgsisimgupload', viewgsis);
          editProf_form.append('viewsnameimgupload', viewsname);

          $.ajax({
            data: editProf_form,
            type: "POST",
            url: "views_home_crud_ESA.php",
            processData: false,
            contentType: false,
            success: function(data) {
              // $("#exampleModal").modal('hide');
              // load();
              // Call the function with the appropriate values
              $("#pdsimage").val("");
              $("#imgpdsindicator").text("Uploaded...");
              refreshImage(viewgsis, viewsname);
              setInterval(function () {
                $("#imgpdsindicator").text("");
              }, 1000);
            }
          })
        })

        function refreshImage(viewgsis, viewsname) {
          $("#pp").attr("src", "uploads/emp_img/" + viewgsis + " " + viewsname + ".png?" + new Date().getTime());
        }

        $("#prof").on("click",function(){
          $("div#editProf").show("fast");
        });

        $("#prof2").on("click",function(){
          $("div#editProf2").show("fast");
        });

        load();  

// put this code if the user is login enabled btn
        $("#updis").prop("disabled", false);

        $("#updis").on("click",function(){
          $("#editProf2").hide();
        });
        

// additional dar. for update the pds record
        $("#updatepds").on("submit", function(event) {
          event.preventDefault();
          var formData = $(this).serialize();
          // alert(formData);
          $.ajax({
            url: "views_home_crud.php",
            method: "POST",
            data: formData,
            success: function(data) {
              if (data === "PDS update") {
                iziToast.success({
                  title: 'UPDATED',
                  message: 'THE PDS UPDATED SUCCESSFULLY!'
                });
                $("#updateinfo").modal('hide');
                $("#exampleModal").modal('hide');
                load();
              }else {
                iziToast.warning({
                  title: 'ERROR',
                  message: 'SOMETHING WRONG, PLEASE TRY AGAIN!'
                });
              }
            }
          });
        });

        $("#delpdsinfo").on("click", function() {
          var delgsis = $("#viewgsis2").val();
          // alert(delgsis);
          var confirmation = confirm("Continue deleting this record?");
          if (confirmation){
            
          $.ajax({
            url: "views_home_crud.php",
            method: "POST",
            data: {delgsis:delgsis},
            success: function(data) {
              if (data === "PDS deleted") {
                iziToast.success({
                  title: 'DELETED',
                  message: 'THE PDS RECORD DELETE SUCCESSFULLY!'
                });
                $("#updateinfo").modal('hide');
                $("#exampleModal").modal('hide');
                load();
              }else {
                iziToast.warning({
                  title: 'ERROR',
                  message: 'SOMETHING WRONG, PLEASE TRY AGAIN!'
                });
              }
            }
          });
          }
        });



        $("#newData").on("click",function(){
          window.location.href="personalInfo_ESA.php";
        })

        $("#fil").change(function(){
          fil = $("#fil").val();
          // alert(fil);
        })
          $("input#searchBar").keypress(function(){
            var searchBar = $("input#searchBar").val();
              if(searchBar.length >= 2){
                $.ajax({
                  url: "proc_personalInfo_ESA.php",
                  type: "POST",
                  data: {searchBar: searchBar,
                          fil: fil},
                  success: function(data){
                    $("#content").html(data)
                  }
                })
              }
              else{
                load();
              }
          })
        })

        var fil = 'surname';


        
        function load(){
          var sortval = "lname";
          var sortwhat = "ASC";
          // var emptype = "WHERE soa='" + btnload + "'";
          var emptype = "";
          $.ajax({
            url:"proc_personalInfo_ESA.php",
            type: "POST",
            data: {sortval:sortval, sortwhat:sortwhat,emptype:emptype},
            success: function(data){
             $("#content").html(data)
            }
          })
        }


    </script>
</head>
<body style="overflow: hidden;">
  
<div class="loader">
    <img src="images/loading2.gif" width="20%" height="40%">
</div>
        <?php include 'navbar.php'; ?>
      <div class="container-fluid">
        <div class="d-flex justify-content-start">
        <?php
include 'connection.php';

try {
    $bpNoToFetch = 'bpNo'; // Replace with the BP NO you want to fetch

    $sql = "SELECT * FROM emp_table WHERE bpNo = :bpNo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bpNo', $bpNoToFetch, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Display employee details
            echo '<h1>Employee Details</h1>';
            echo '<p><strong>BP NO:</strong> '  . $row["bpNo"] .  '</p>';
            echo '<p><strong>Last Name:</strong> '  . $row["lname"] .  '</p>';
            echo '<p><strong>First Name:</strong> '  . $row["fname"] . '</p>';
        }
    } else {
        echo 'No records found for BP NO: ' . $bpNoToFetch;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>



        </div>
          <div class="row">
            <div class="input-group rounded col-6 pt-2" style="width: 30%;">
              <!-- <select name="" class="form-control filter" id="fil">
                <option value="" hidden>Filter</option>
                <option value="lname">Surname</option>
                <option value="fname">First Name</option>
                <option value="mname">Middle Name</option>
                <option value="ext">Name Extension</option>
              </select> -->
              <div style="padding: 10px 15px; background: #dee2e6; border-radius: 5px;">
              <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
              </div>
              <input type="text" class="form-control" id="searchBar">
              <button class="btn btn-primary" id="search"><i class="fas fa-search"></i> Search</button>
            </div>


                <div class="col pt-2">
                <div class="btn-group">
                    <button type="button" class="btn silver btn-secondary dropdown-toggle" data-toggle="dropdown">
                        Select Type
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item" value="P">REGULAR</button>
                        <button class="dropdown-item" value="C">CASUAL</button>
                        <button class="dropdown-item" value="JO">JOB ORDER</button>
                        <button class="dropdown-item" value="ALL">OVERVIEW</button>
                    </div>
                </div>
            </div>
            </div>
            <div class="col pt-2 d-flex justify-content-end">
            <label class="btn btn-primary btn-cool">
                <i class="fas fa-cloud-upload-alt"></i> Upload File
                <input type="file" class="d-none" id="fileInput" name="fileInput">
            </label>
        </div>
        </div>
        </div>
      </div>
      <div class="container-fluid mt-2">
        <div class="table-responsive" style="height: 750px; overflow-x: scroll;">
            <table class="table bg-white rounded table-hover" id="mainTable">
              <thead style="top: 0; position: sticky; background: whitesmoke; height: auto;">
               <tr>
                <th>
                  <div class="d-flex justify-content-left bpsort">BPNO
                    <div class="sort" data-value="bpNo">
                      <div class="arrow arrow1 chevron1"></div>
                    </div>
                  </div>
                </th>

                <th>
                  <div class="d-flex justify-content-left bpsort">SURNAME
                    <div class="sort" data-value="lname">
                      <div class="arrow arrow1 chevron2"></div>
                    </div>
                  </div>
                </th>

                <th>
                  <div class="d-flex justify-content-left bpsort">FIRST NAME
                    <div class="sort" data-value="fname">
                      <div class="arrow arrow1 chevron3"></div>
                    </div>
                  </div></th>
              </tr>
              </thead>
              <!-- ajax request -->
              <tbody id="content">

              </tbody>  
            </table>

            
        </div>
      </div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View PDS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-borderless">
      <tbody>
            <tr>
                <th>Surname: </th>
                <td id='viewsname'></td>
                <td id="profile" rowspan="6" colspan="2" class="text-center" style="width: 200px; border: 2px solid;">
                  <form enctype="multipart/form-data" id="uploadpdsimg">
                    <div class="d-flex mb-2">
                      <p id="imgpdsindicator"></p>
                      <input type="file" class="form-control" id="pdsimage" name="pdsimage" required style="visibility: hidden;">
                      <button type="button" class="btn btn-outline-dark" id="imgselect"><i class='far fa-images' style='font-size:24px'></i></button>
                      <button class="btn btn-primary" type="submit" style="margin-left: 5px;"><i class="fa fa-upload" style='font-size:20px'></i></button>
                    </div>
                  </form>
                  <img alt="blank" id="pp" style="width: 170px; height: 250px;">
                </td>
                
            </tr>
            
            <tr>
                <th>First Name:</th>
                <td id='viewfname'></td>
            </tr>

            <tr>
                <th>Middle Name:</th>
                <td id='viewmname'></td>
            </tr>

            <tr>
                <th>Suffix:</th>
                <td id='viewsfx'> N/A</td>
            </tr>

            <tr>
                <th>Date of Birth:</th>
                <td id='viewdob'></td>
            </tr>
            
            <tr>
                <th>Place of Birth:</th>
                <td id="viewpob"></td>
            </tr>

            <tr>
                <th>Gender:</th>
                <td id="viewgender"></td>

                <th>ID NO:</th>
                <td id="viewempNo"></td>     
            </tr>

            <tr>
                <th>Civil Status:</th>
                <td id="viewcivil"></td>

                <th >Position:</th>
                <td id="pos"></td>
            </tr>

            <tr>
                <th>House/Block/Lot No.</th>
                <td id="viewresHouse"></td>

                <th>Department:</th>
                <td id="dept"></td>
            </tr>

            <tr>
                <th>Barangay:</th>
                <td id="viewresBrgy"></td>

                <th>Employment Type:</th>
                <td id="soa"></td>
            </tr>

            <tr>
                <th>City:</th>
                <td id="viewresCity"></td>

                <th>Employment Status:</th>
                <td>ACTIVE</td>
            </tr>

            <tr>
                <th>Zipcode:</th>
                <td id="viewresZip"></td>

                <th>Contact Number</th>
                <td id="viewmobile"></td>
            </tr>

            <tr>
                <th>Email:</th>
                <td id="viewemail"></td>
            </tr>

            <tr>
                <th>Citizenship:</th>
                <td id="viewciti"></td>

                
            </tr>

            <tr>
                <th>Height:</th>
                <td id="viewheight"></td>
            </tr>

            <tr>
                <th>Weight:</th>
                <td id="viewweight"></td>
            </tr>

            <tr>
                <th>Blood Type:</th>
                <td id="viewbtype"></td>
            </tr>

            <tr>
                <th>GSIS ID No.</th>
                <td id="viewgsis"></td>

            </tr>

            <tr>
                <th>Pag-Ibig ID No.:</th>
                <td id="viewpagibig"></td>
            </tr>

            <tr>
                <th>Philhealth:</th>
                <td id="viewphealth"></td>
            </tr>

            <tr>
                <th>TIN:</th>
                <td id="viewtin"></td>
            </tr>
        </tbody>
       </table>
      
       <hr>
       
       <h1>Personal Files</h1>
       <select name="uploadedshow" id="uploadedshow" class="form-select mb-2" style="width: 20%">
        <?php
        include "connection.php";
        $stmt = $con->prepare("SELECT * FROM performance_rating_year");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['year'] . '">' . $row['year'] . '</option>';
            }
        }
        ?>
    </select>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>File type</th>
              <th>File Name</th>
              <!-- <th class="text-center">Action</th> -->
            </tr>
          </thead>
          <tbody id="fileuploaded">
            
          </tbody>

          
        </table>

        <div id="editProf">
          <hr>
            <form enctype="multipart/form-data" id="uploadpdsimg">

              <label for="">Image</label>
              <div class="d-flex justify-content-center">
                <input type="file" class="form-control" id="pdsimage" name="pdsimage" required>
                <button class="btn btn-primary mt-2" type="submit"><i class="fa fa-upload" style='font-size:24px'></i></button>
              </div>

            </form>
        </div>
      </div>

      <div class="modal-footer">
        <!-- <button class="btn btn-outline-dark" id="prof"><i class='far fa-images' style='font-size:24px'></i></button> -->
        <a id="viewPds" class="btn btn-success" target="_blank"><i class="fa far fa-file" style='font-size:24px' aria-hidden="true"></i></a>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateinfo" disabled id="updis"><i class="fa far fa-edit" style='font-size:24px' aria-hidden="true"></i></button>
      </div>
    </div>
  </div>
</div>

<!-- update information -->
<div class="modal fade" id="updateinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update the Personal Data Sheet (PDS).</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
      <form id="updatepds" method="POST" enctype="multipart/form-data">
       <table class="table table-borderless">
       <tbody>
        <!-- <input type="text" class="form-control" id='idselect'> -->
            <tr>
                <th>Surname: </th>
                <td><input type="text" class="form-control" id='viewsname2' name='viewsname2'></td>
                <th>First Name:</th>
                <td><input type="text" class="form-control" id='viewfname2' name='viewfname2'></td>
            </tr>

            <tr>
                <th>Middle Name:</th>
                <td><input type="text" class="form-control" id='viewmname2' name='viewmname2'></td>
                <th>Suffix:</th>
                <td><input type="text" class="form-control" id='viewsfx2' name='viewsfx2'></td>
            </tr>

            <tr>
                <th>Date of Birth:</th>
                <td><input type="text" class="form-control" id='viewdob2' name='viewdob2'></td>
                <th>Place of Birth:</th>
                <td><input type="text" class="form-control" id="viewpob2" name="viewpob2"></td>
            </tr>

            <tr>
                <th>Gender:</th>
                <td><input type="text" class="form-control" id="viewgender2" name="viewgender2"></td>

                <th>ID NO:</th>
                <td><input type="text" class="form-control" id="viewempNo2" name="viewempNo2"></td>     
            </tr>

            <tr>
                <th>Civil Status:</th>
                <td><input type="text" class="form-control" id="viewcivil2" name="viewcivil2"></td>

                <th>Position:</th>
                <td><input type="text" class="form-control" id="pos2" name="pos2"></td>
            </tr>

            <tr>
                <th>House/Block/Lot No.</th>
                <td><input type="text" class="form-control" id="viewresHouse2" name="viewresHouse2"></td>

                <th>Department:</th>
                <td><input type="text" class="form-control" id="dept2" name="dept2"></td>
            </tr>

            <tr>
                <th>Barangay:</th>
                <td><input type="text" class="form-control" id="viewresBrgy2" name="viewresBrgy2"></td>

                <th>Employment Type:</th>
                <td><input type="text" class="form-control" id="soa2" name="soa2"></td>
            </tr>

            <tr>
                <th>City:</th>
                <td><input type="text" class="form-control" id="viewresCity2" name="viewresCity2"></td>

                <th>Employment Status:</th>
                <td><input type="text" class="form-control" id="viewstatus2" name="viewstatus2"></td>

                  <!-- <select name="viewstatus2" id="viewstatus2" class="form-select">
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                  </select> -->
                </td>
            </tr>

            <tr>
                <th>Zipcode:</th>
                <td><input type="text" class="form-control" id="viewresZip2" name="viewresZip2"></td>

                <th>Contact Number</th>
                <td><input type="text" class="form-control" id="viewmobile2" name="viewmobile2"></td>
            </tr>

            <tr>
                <th>Email:</th>
                <td><input type="text" class="form-control" id="viewemail2" name="viewemail2"></td>
                <th>Citizenship:</th>
                <td><input type="text" class="form-control" id="viewciti2" name="viewciti2"></td>
            </tr>

            <tr>
                <th>Height:</th>
                <td><input type="text" class="form-control" id="viewheight2" name="viewheight2"></td>
                <th>Weight:</th>
                <td><input type="text" class="form-control" id="viewweight2" name="viewweight2"></td>
            </tr>

            <tr>
                <th>Blood Type:</th>
                <td><input type="text" class="form-control" id="viewbtype2" name="viewbtype2"></td>
                <th>Pag-Ibig ID No.:</th>
                <td><input type="text" class="form-control" id="viewpagibig2" name="viewpagibig2"></td>
            </tr>

            <tr>
                <th>Philhealth:</th>
                <td><input type="text" class="form-control" id="viewphealth2" name="viewphealth2"></td>

                <th>TIN:</th>
                <td><input type="text" class="form-control" id="viewtin2" name="viewtin2"></td>
            </tr>

            <tr>
                <th>Salary Grade:</th>
                <td><input type="text" class="form-control" id="viewsg2" name="viewsg2"></td>
            </tr>
            
            <tr>
              <th>GSIS ID No.:</th>
                <td>
                <input type="hidden" class="form-control" id="viewgsis2" name="viewgsis2">
                <b id="viewgsis2t" name="viewgsis2t"></b>
                </td>
              </th>
            </tr>
        </tbody>
       </table>
       
        <div>
          <div class="mt-2 mb-2">
            <div id="editProf2" style="display: flex;">
              <input type="text" class="form-control w-50" id="newgsis" name="newgsis" placeholder="Please provide your updated GSIS number.">
              <button type="button" class="btn btn-primary" style="margin-left: 3px;" id="updategsis"><i class="fa-solid fa-user-pen"></i></button>
            </div>
          </div>

          <b style="color: #0d6efd;">* Please refrain from modifying the GSIS ID. <i style="color: red; cursor: pointer; margin: 0; padding: 0;" id="prof2">Click here to update</i></b>
        </div>
      </div>
      
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-danger" id="delpdsinfo"><i class="fa fa-trash-o" style='font-size:24px' aria-hidden="true"></i></button> -->
        <button type="submit" class="btn btn-outline-success" id="aa"><i class="fa fa-floppy-o" style='font-size:24px'></i></button>
      </div>
    </form>
    </div>
  </div>
</div>

	<!-- notification -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

<script>
  $(document).ready(function() {
    

    $("#uploadedshow").on("change", function(){
      uploadeddisplay();
    });

    function uploadeddisplay(){
      var uploadeyear = $("#uploadedshow").val();
      var uploadedgsis = $("#viewgsis").text();
      var uploadesurname = $("#viewsname").text();
      // alert(uploadeyear+uploadesurname + uploadedgsis);
      $.ajax({
        url:"views_display_uploaded.php",
        type: "POST",
        data: {uploadeyear:uploadeyear, uploadedgsis:uploadedgsis,uploadesurname:uploadesurname},
        success: function(data){
          $("#fileuploaded").html(data)
        }
      })
    }

      // loading of the table depends on regular/casual and etc
    $(".btnload").on("click", function() {

      var btnload = $(this).val();
      if (btnload == "ALL"){
        var emptype = "";
      }else{
        var emptype = "WHERE soa='" + btnload + "'";
      }
      var sortval = "lname";
      var sortwhat = "ASC";
      // alert(emptype);
      $.ajax({
        url:"proc_personalInfo.php",
        type: "POST",
        data: {sortval:sortval, sortwhat:sortwhat,emptype:emptype},
        success: function(data){
          $("#content").html(data)
        }
      })
    });
    
    $("#updategsis").on("click", function() {
      var currentgsis = $("#viewgsis2").val();
      var newgsisupdate = $("#newgsis").val();

      alert(currentgsis + " " + newgsisupdate);

      if (newgsisupdate.length >= 8) {
          $.ajax({
              url: "views_home_crud_ESA.php",
              type: "POST",
              data: { currentgsis: currentgsis, newgsisupdate: newgsisupdate },

              success: function(data) {
                  if (data === "gsis updated") {
                      iziToast.success({
                          title: 'UPDATE',
                          message: 'GSIS UPDATED SUCCESSFULLY!'
                      });
                      $("#viewgsis2").val(newgsisupdate);
                      $("#viewgsis2t").text(newgsisupdate);
                      $("#newgsis").val("");
                      $("div#editProf2").hide();
                      var sortval = "lname";
                      var sortwhat = "ASC";
                      load2(sortval, sortwhat);
                  } else {
                      iziToast.error({
                          title: 'ERROR',
                          message: 'SOMETHING WENT WRONG, PLEASE TRY AGAIN!'
                      });
                  }
              }
          });
      } else {
          iziToast.error({
              title: 'ERROR',
              message: 'GSIS must be at least 8 characters long!'
          });
      }
    });


    const buttons = $('.sort');
    const arrows = $('.arrow');

    let arr = ['active', 'active1', 'active2', 'active3'];

    buttons.on('click', function() {
      var sortval = $(this).data('value');
      const buttonIndex = buttons.index(this);
      arrows.each(function(arrowIndex) {
        const arrow = $(this);
        if (arrowIndex === buttonIndex) {
          if (!arrow.hasClass(arr[buttonIndex])) {
            arrow.addClass(arr[buttonIndex]);
            var sortwhat = "DESC";
            load2(sortval, sortwhat);
          } else {
            arrow.removeClass(arr[buttonIndex]);
            var sortwhat = "ASC";
            load2(sortval, sortwhat);
            // DECREMENT VALUE
            // alert("down");
          }
        } else {
          arrow.removeClass(arr[arrowIndex]);
        }
      });
      
    });

    function load2(sortval, sortwhat) {
      // alert(sortval + sortwhat);
      
      var emptype = "";
      $.ajax({
          url: "proc_personalInfo_ESA.php",
          type: "POST",
          data: {
              sortval: sortval,
              sortwhat:sortwhat,
              emptype:emptype
          },
          success: function(data) {
              $("#content").html(data);
          }
      });
    }




  });

</script>

</body>
</html>