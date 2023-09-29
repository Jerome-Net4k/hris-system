<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New OJT</title>
   
    <script>
      $(document).ready(function(){
        $("#otherBtype").hide();
        $("#otherLabel").hide();
        var btype = "A";
        $("select#btype").change(function(){
          btype = $("select#btype").val();
          if(btype == "others"){
            $("#otherBtype").show("slow");
            $("#otherLabel").show("slow");
            btype = $("#otherBtype").val();
          }
          else{
            $("#otherBtype").hide("slow");
            $("#otherLabel").hide("slow");
            $("#otherBtype").val("");
            btype = $("select#btype").val();
          }
        })
        $("#mobile").keyup(function(){
          var mob = $(this).val();
          if(mob.length >= 11){
            $("#mobile").val(mob.substr(0,11));
          }
        })

        $("button#next").on("click",function(){
          var valid = true;
          $(".required").each(function(){
              var val = $(this).val();
              if(val == ''){
                valid = false;
                $(this).css("border-color","#DF2E38")
                iziToast.warning({
                          displayMode: 1, 
                          position: 'topRight',
                          title: 'Failed',
                          message: 'Please check your input.'
                          });
              }
              else{
                $(this).css("border-color","#cfcfcf")
              }      
                })
              
                if(valid == true){
                  
                var Name = $("#Name").val();
                var Address = $("#Address").val();
                var emailAddress = $("#emailAddress").val();
                var Mobileno = $("#Mobileno").val();
                var School = $("#School").val();
                var Gname = $("#Gname").val();
                var Gmobileno = $("#Gmobileno").val();
                
                
                $.ajax({
                  data: {
                    Name: Name,
                    Address: Address,
                    emailAddress: emailAddress,
                    Mobileno: Mobileno,
                    School: School,
                    Gname: Gname,
                    Gmobileno: Gmobileno,
                        
                      },
                        type: "POST",
                        url: "storeOJTinfo.php",
                        success: function(data){
                          if(data == 'nc'){
                            window.location.href="OJTfamilybg.php";
                          }
                          else if(data == 'duplicate'){
                            iziToast.warning({
                            position: 'topRight',
                            title: 'Failed',
                            message: 'Duplicate data please check your input.'
                            });
                          }
                          else{
                            iziToast.warning({
                            position: 'topRight',
                            title: 'Failed',
                            message: 'Please input valid email.'
                            });
                          }
                        }
                      })
                }
              
        })

        
      })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2 pt-2">OJT DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">PERSONAL INFORMATION</div>
<div class="row row-cols-2 ">

  <div class="col">
      <div class="form-floating mb-3">
      <input type="text" id="id" class="form-control required" required>
      <label for="sname">ID Number*</label>
      </div>
      </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="Name" class="form-control required" required>
  <label for="sname">Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
    <input type="date" id="bday" class="form-control required" required>
    <label for="sname">Birthdate*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
      <input type="text" class="form-control required" id="Address" required>
      <label for="floatingInput">Complete Address</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="Mobileno" required>
  <label for="mobile">Mobile No*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="email" class="form-control required" id="eAddress" required>
  <label for="email">Email Address*</label>
    </div>
    </div>


</div>
<hr>
<div class="row">
<div class="fs-4 text-center fst-italic mb-2"> GUARDIAN</div>
<div class="col">
    <div class="form-floating">
  <input type="text" class="form-control required mb-4" id="NoS" required>
  <label for="floatingInput">Name of School</label>
    </div>
    <hr>
    </div>
</div>
<div class="row ">
<div class="fs-4 text-center fst-italic mb-2"> SCHOOL</div>
<div class="col">
    <div class="form-floating">
  <input type="text" class="form-control required mb-4" id="NoS" required>
  <label for="floatingInput">Name of School</label>
    </div>
    <hr>
    </div>

<div class="d-flex justify-content-end">
<button class="btn btn-success m-2 p-1" id="submit">Submit</button>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>