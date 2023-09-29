<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
   <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }
   </style>
    <script>
      $(document).ready(function(){
        
        $("input:text").keyup(function(){
          var val = $(this).val();
          $(this).val(val.toUpperCase());
        })

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
                  
                var sname = $("#sname").val();
                var fname = $("#fname").val();
                var mname = $("#mname").val();
                var ext = $("#ext").val();
                var dob = $("#dob").val();
                var pob = $("#pob").val();
                var sex = $("#sex:checked").val();
                var civ = $("#civil:checked").val();
                var height = $("#height").val();
                var weight = $("#weight").val();
                var gsis = $("#gsis").val();
                var pagibig = $("#pagibig").val();
                var phealth = $("#phealth").val();
                var sss = $("#sss").val();
                var tin = $("#tin").val();
                var empno = $("#empno").val();
                var citi = $("#citizenship:checked").val() + "-" + $("#dualCit:checked").val();

                var resHouse = $("#resHouse").val();
                var resStreet = $("#resStreet").val();
                var resSub = $("#resSub").val();
                var resCity = $("#resCity").val();
                var resBrgy = $("#resBrgy").val();
                var resProv = $("#resProv").val();
                var resZip = $("#resZip").val();

                var permHouse = $("#permHouse").val();
                var permStreet = $("#permStrt").val();
                var permSub = $("#permSub").val();
                var permCity = $("#permCity").val();
                var permBrgy = $("#permBrgy").val();
                var permProv = $("#permProv").val();
                var permZip = $("#permZip").val();

                var tel = $("#telephone").val();
                var mobile = $("#mobile").val();
                var email = $("#email").val();


                $.ajax({
                  data: {
                        sname: sname,
                        fname: fname,
                        mname: mname,
                        ext: ext,
                        dob: dob,
                        pob: pob,
                        sex: sex,
                        civ: civ,
                        height: height,
                        weight: weight,
                        btype: btype,
                        gsis: gsis,
                        pagibig: pagibig,
                        phealth: phealth,
                        sss: sss,
                        tin: tin,
                        empno: empno,
                        citi: citi,
                        resHouse: resHouse,
                        resStreet: resStreet,
                        resSub: resSub,
                        resCity: resCity,
                        resBrgy: resBrgy,
                        resProv: resProv,
                        resZip: resZip,
                        permHouse: permHouse,
                        permStreet: permStreet,
                        permSub: permSub,
                        permCity: permCity,
                        permBrgy: permBrgy,
                        permProv: permProv,
                        permZip: permZip,
                        tel: tel,
                        mobile:mobile,
                        email: email
                      },
                        type: "POST",
                        url: "storePersonalInfo.php",
                        success: function(data){
                          if(data == 'nc'){
                            window.location.href="familybg.php";
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

        $("#same").on("click",function(){
          
          if($("#same").is(":checked")){
            var house = $("#resHouse").val();
            var street = $("#resStreet").val();
            var sub = $("#resSub").val();
            var city = $("#resCity").val();
            var brgy = $("#resBrgy").val();
            var prov = $("#resProv").val();
            var zip = $("#resZip").val();

            $("#permHouse").val(house);
            $("#permStrt").val(street);
            $("#permSub").val(sub);
            $("#permCity").val(city);
            $("#permBrgy").val(brgy);
            $("#permProv").val(prov);
            $("#permZip").val(zip);
          }
          else{
            $("#permHouse").val("");
            $("#permStrt").val("");
            $("#permSub").val("");
            $("#permCity").val("");
            $("#permBrgy").val("");
            $("#permProv").val("");
            $("#permZip").val("");
          }
          
        })
      })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2 pt-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">I. Personal Information</div>
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="sname" class="form-control required" required>
  <label for="sname">Surname*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="fname" class="form-control required" required>
  <label for="fname">First Name*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" id="mname" class="form-control required">
  <label for="mname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" id="ext" class="form-control" >
  <label for="ext">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    <div class="col ">
    <div class="form-floating mb-3">
  <input type="date" class="form-control required" id="dob" >
  <label for="dob">Date of Birth*</label>
    </div>
    </div>

    <div class="col ">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="pob" >
  <label for="pob">Place of Birth*</label>
    </div>
    </div>

    
<div class="col col-lg-8">
    <span class="fs-3 me-3">Sex* </span>
    <div class="form-check form-check-inline">
  <input class="form-check-input required" type="radio" value="Male" id="sex" name="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault1">
    Male
  </label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input required" type="radio" value="Female" id="sex" name="flexRadioDefault1">
  <label class="form-check-label" for="flexRadioDefault2">
    Female
  </label>
</div>
</div>

<div class="col-lg-8">
    <span class="fs-3">Civil Status* </span>
    <div class="form-check form-check-inline">
    <input class="form-check-input required" type="radio" value="Single" id="civil" name="flexRadioDefault2">
  <label class="form-check-label" for="flexRadioDefault2">
    Single
  </label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input required" type="radio" value="Married" id="civil" name="flexRadioDefault2">
  <label class="form-check-label" for="flexRadioDefault2">
    Married
  </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input required" type="radio" value="Widowed" id="civil" name="flexRadioDefault2">
  <label class="form-check-label" for="flexRadioDefault2">
    Widowed
  </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input required" type="radio" value="Separated" id="civil" name="flexRadioDefault2">
  <label class="form-check-label" for="flexRadioDefault2">
    Separated
  </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input required" type="radio" value="Others" id="civil" name="flexRadioDefault2">
  <label class="form-check-label" for="flexRadioDefault2">
    Others
  </label>
</div>
</div>
</div>


<div class="row">
<div class="col-md-4 pt-2">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="height" >
  <label for="height">Height (m)*</label>
    </div>
    </div>

    <div class="col-md-4 pt-2">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="weight" >
  <label for="weight">Weight (kg)*</label>
    </div>
    </div>

    <div class="col col-sm-2 pt-2">
    <div class="form-floating mb-3">
    <select name="" id="btype" class="form-control required">
      <option value="A">A</option>
      <option value="A+">A+</option>
      <option value="A-">A-</option>
      <option value="B">B</option>
      <option value="B+">B+</option>
      <option value="B-">B-</option>
      <option value="AB">AB</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
      <option value="O">O</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
      <option value="others">OTHERS</option>
    </select>
    <label for="btype">Bloodtype</label>
    </div>
    </div>

    <div class="col col-sm-2 pt-2">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="otherBtype">
      <label for="otherBtype" id="otherLabel">Other Bloodtype</label>
    </div>
    </div>
</div>

<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="gsis">
  <label for="gsis">GSIS ID NO.*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="pagibig">
  <label for="pagibig">PAG IBIG NO.*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="phealth">
  <label for="phealth">PHILHEALTH NO.*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="sss">
  <label for="sss">SSS NO.*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="tin">
  <label for="tin">TIN NO*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="empno">
  <label for="empno">AGENCY EMPLOYEE NO*</label>
    </div>
    </div>

    <div class="col-lg">
    <span class="fs-3">Citizenship*</span>
    <div class="form-check form-check-inline">
    <input class="form-check-input required" type="radio" value="Filipino" id="citizenship" name="citizenship" checked>
  <label class="form-check-label" for="flexCheckDefault">
    Filipino
  </label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input required" type="radio" value="dual" id="citizenship" name="citizenship">
  <label class="form-check-label" for="flexCheckDefault">
    Dual Citizenship
  </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" value="By Birth" id="dualCit" name="citizenBy" checked>
  <label class="form-check-label" for="flexCheckDefault">
    By Birth
  </label>
</div>

<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" value="By Naturalization" id="dualCit" name="citizenBy">
  <label class="form-check-label" for="flexCheckDefault">
    By Naturalization
  </label>
</div>
</div>
</div>


<hr>
<div class="row">
<div class="fs-4"> Residential Address*</div>


<div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resHouse" required>
  <label for="floatingInput">House/Block/Lot No</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resStreet" required>
  <label for="floatingInput">Street</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resSub" required>
  <label for="floatingInput">Subdivision/Village</label>
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resBrgy" required>
  <label for="floatingInput">Barangay</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resCity" required>
  <label for="floatingInput">City/Municipality</label>
    </div>
    </div>
   

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resProv" required>
  <label for="floatingInput">Province</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="resZip" required>
  <label for="floatingInput">ZipCode</label>
    </div>
    </div>
</div>
 
<hr>
<div class="row">
<div class="fs-4"> Permanent Address*</div>

<div class="pt-2 pb-2"><input class="form-check-input" type="checkbox" value="" id="same">
  <label class="form-check-label" for="flexCheckDefault">
    Same as Residential Address
  </label></div>

<div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permHouse" required>
  <label for="floatingInput">House/Block/Lot No</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permStrt" required>
  <label for="floatingInput">Street</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permSub" required>
  <label for="floatingInput">Subdivision/Village</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permBrgy" required>
  <label for="floatingInput">Barangay</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permCity" required>
  <label for="floatingInput">City/Municipality</label>
    </div>
    </div>
   

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permProv" required>
  <label for="floatingInput">Province</label>
    </div>
    </div>

    <div class="col-md-4">
    <div class="form-floating mb-3">
  <input type="text" class="form-control required" id="permZip" required>
  <label for="floatingInput">ZipCode</label>
    </div>
    </div>
</div>

<hr>
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
  <input type="tel" class="form-control" id="telephone">
  <label for="telephone">Telephone</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="number" class="form-control required" id="mobile" required>
  <label for="mobile">Mobile No*</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="email" class="form-control required" id="email" required>
  <label for="email">Email Address*</label>
    </div>
    </div>



</div>
<div class="d-flex justify-content-end">
          <button class="btn btn-primary mb-2" id="next">Next</button>
        </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>