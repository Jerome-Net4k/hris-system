<?php

if (isset($_POST['idNo'])){
  $remarks = $_POST['remarks'];
  $idNo = $_POST['idNo'];
  $oldidNo = $_POST['idNo'];
  $rowno = $_POST['rowno'];
  $sname = $_POST['sname'];
  $oldsname = $_POST['sname'];
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $ext = $_POST['ext'];
  $region = $_POST['region'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
   
    <script>
      $(document).ready(function(){

        $("button#submit").on("click",function(){
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

                var remarks = $("#remarks").val();
                var oldidNo = "<?php echo $oldidNo ?>";
                var editInactive = true;
                var rowno = <?php echo $rowno ?>;
                var idNo = $("#inactive201").val();
                var oldsname = "<?php echo $oldsname ?>";
                var sname = $("#sname").val();
                var fname = $("#fname").val();
                var mname = $("#mname").val();
                var ext = $("#ext").val();
                var region = $("#region option:selected").val();

                  iziToast.info({
                    timeout: 15000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Confirmation',
                    message: 'Are you sure you want to save this edit??',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                 
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            
                      $.ajax({
                  data: {                    
                        editInactive: editInactive,
                        remarks: '"' + remarks + '"',
                        rowno: rowno,
                        oldidNo: oldidNo,
                        idNo: idNo,
                        oldsname: oldsname,
                        sname: '"' + sname + '"',
                        fname: '"' + fname + '"',
                        mname: '"' + mname + '"',
                        region: '"' + region + '"',
                        ext: '"' + ext + '"'
                      },
                        type: "POST",
                        url: "uploadPDInactive.php",
                        success: function(data){
                          if (data == 'success'){
                            window.location.href = "views_201Files.php";
                          } else {
                            iziToast.warning({
                            title: 'Failed',
                            message: 'Possible duplicate, please check your input.'
                            });
                          }                          
                        }
                      })
                 
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                 
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                 
                        }],
                    ]
                });
                 

               


                      
                }
              
        })

        $("button#prev").on("click",function(){
                window.location.href = "views_201Files.php"
            })

        $("#clearBtn").on("click",function (e){
                $("#sname").val("");
                $("#fname").val("");
                $("#mname").val("");
                $("#ext").val("");
                $("#region").val("N/A");
            })

      })

      function checkBlank(){
                var a = document.getElementById("inactive201").value;
                if(a == "" || a == 0){
                  $("#sname").addClass("required");
                  $("#fname").addClass("required");
                } else {
                  $("#sname").removeClass("required");
                  $("#fname").removeClass("required");
                }

            }

    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <button class="btn btn-primary m-2 p-1" id="prev"><< Back</button>
    <h1 class="fw-bolder text-center mb-2 pt-2">INACTIVE 201</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">I. Personal Information</div>


    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="remarks" class="form-control" value="<?php echo $remarks ?>">
  <label for="sname">Remarks</label>
    </div>
    </div>

    <div class="col col-md-2">
    <div class="form-floating mb-3">
  <input type="text" id="inactive201" class="form-control" value="<?php echo $idNo ?>" oninput="checkBlank();">
  <label for="inactive201">201 No.*</label>
    </div>
    </div>

    <div class="col col-md-2">
    <div class="form-floating mb-3">
    <button class="btn btn-outline-danger p-1" id="clearBtn" style="font-weight: 700;">CLEAR</button>
    </div>
    </div>
    
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="sname" class="form-control" value="<?php echo $sname ?>">
  <label for="sname">Surname*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="fname" class="form-control" value="<?php echo $fname ?>">
  <label for="fname">First Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="mname" class="form-control" value="<?php echo $mname ?>">
  <label for="mname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" id="ext" class="form-control" value="<?php echo $ext ?>">
  <label for="ext">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
    <select name="" id="region" class="form-control w-50 p-1">
                        <option value="N/A" <?php echo $region == 'N/A' ? 'selected' : '' ?>>N/A</option>
                        <option value="Central Office" <?php echo $region == 'Central Office' ? 'selected' : '' ?>>Central Office</option>
                        <option value="NCR East" <?php echo $region == 'NCR East' ? 'selected' : '' ?>>NCR East</option>
                        <option value="NCR West" <?php echo $region == 'NCR West' ? 'selected' : '' ?>>NCR West</option>
                        <option value="1" <?php echo $region == '1' ? 'selected' : '' ?>>1 - San Fernando, La Union</option>
                        <option value="2" <?php echo $region == '2' ? 'selected' : '' ?>>2 - Tuguegarao, Cagayan</option>
                        <option value="3" <?php echo $region == '3' ? 'selected' : '' ?>>3 - San Fernando, Pampanga</option>
                        <option value="4A" <?php echo $region == '4A' ? 'selected' : '' ?>>4A - Lipa City, Batangas</option>
                        <option value="4B" <?php echo $region == '4B' ? 'selected' : '' ?>>4B - MIMAROPA</option>
                        <option value="5" <?php echo $region == '5' ? 'selected' : '' ?>>5 - Legazpi City, Albay</option>
                        <option value="6" <?php echo $region == '6' ? 'selected' : '' ?>>6 - Iloilo City</option>
                        <option value="7" <?php echo $region == '7' ? 'selected' : '' ?>>7 - Cebu City</option>
                        <option value="8" <?php echo $region == '8' ? 'selected' : '' ?>>8 - Tacloban City</option>
                        <option value="9" <?php echo $region == '9' ? 'selected' : '' ?>>9 - Zamboanga City</option>
                        <option value="10" <?php echo $region == '10' ? 'selected' : '' ?>>10 - Cagayan de Oro City</option>
                        <option value="11" <?php echo $region == '11' ? 'selected' : '' ?>>11 - Davao City</option>
                        <option value="12" <?php echo $region == '12' ? 'selected' : '' ?>>12 - Koronadal City</option>
                        <option value="14" <?php echo $region == '14' ? 'selected' : '' ?>>14 - Baguio City (CAR)</option>
                        <option value="15" <?php echo $region == '15' ? 'selected' : '' ?>>15 - Butuan City (CARAGA)</option>  
    </select>
    </div>
    </div>

</div>
<div class="d-flex justify-content-end">
          <button class="btn btn-primary mb-2" id="submit">Submit</button>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>