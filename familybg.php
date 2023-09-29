<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
    <style>
        
    </style>

    <script>
        $(Document).ready(function(){

          $("input#spSname").keyup(function(){
            var spName = $(this).val();
            if(spName == "N/A" || spName == "N/a"){
              $("input#spFname").val("N/A");
              $("input#spMname").val("N/A");
              $("input#spExt").val("N/A");
              $("input#spOccu").val("N/A");
              $("input#spEmpName").val("N/A");
              $("input#spBadd").val("N/A");
              $("input#spTel").val("N/A");
            }
            else{
              $("input#spFname").val("");
              $("input#spMname").val("");
              $("input#spExt").val("");
              $("input#spOccu").val("");
              $("input#spEmpName").val("");
              $("input#spBadd").val("");
              $("input#spTel").val("");
            }
          })
            $("input:text").keyup(function(){
              var val = $(this).val();
              $(this).val(val.toUpperCase());
            })

            $("#add").on("click",function(){
                    $("#body").append('<tr><td id="sad"><input type="text" class="form-control" id="chName"></td><td><input type="date" class="form-control" id="chBday"></td></tr>')
            })


            $("#prev").on("click",function(){
              window.location.href="personalInfo.php";
            })

            $("#next").on("click",function(){
                var chName = "";
                var chBday = "";
                var spSname = $("#spSname").val();
                var spFname = $("#spFname").val();
                var spMname = $("#spMname").val();
                var spExt = $("#spExt").val();
                var spOccu = $("#spOccu").val();
                var spEmpName = $("#spEmpName").val();
                var spBadd = $("#spBadd").val();
                var spTel = $("#spTel").val();
                var fSname = $("#fSname").val();
                var fFname = $("#fFname").val();
                var fMname = $("#fMname").val();
                var fExt = $("#fExt").val();
                var mSname = $("#mSname").val();
                var mMaidName = $("#mMaidName").val();
                var mFname = $("#mFname").val();
                var mMname = $("#mMname").val();
                var mExt = $("#mExt").val();

                $("td#sad").each(function(){ 
                  var searchName = $(this).find("#chName").val();
                  chName += searchName +",";
                })
                $("td#sad2").each(function(){
                  var searchBday = $(this).find("#chBday").val();
                  chBday += searchBday + ",";
                })
                var ChildNconvert = chName.substr(0,chName.length-1);
                var ChildBconvert = chBday.substr(0,chBday.length-1);
                $.ajax({
                  data: {ChildNconvert: ChildNconvert,
                        ChildBconvert:ChildBconvert,
                        spSname: spSname,
                        spFname: spFname,
                        spMname: spMname,
                        spExt: spExt,
                        spOccu: spOccu,
                        spEmpName: spEmpName,
                        spBadd: spBadd,
                        spTel: spTel,
                        fSname: fSname,
                        fFname: fFname,
                        fMname: fMname,
                        fExt: fExt,
                        mSname: mSname,
                        mMaidName: mMaidName,
                        mFname: mFname,
                        mMname: mMname,
                        mExt: mExt},
                  type: "POST",
                  url: "storeFamilyBg.php",
                  success: function(data){
                    if(data == 'nc'){
                      window.location.href="educbg.php";
                    }
                    else{
                      iziToast.warning({
                position: 'topRight',
                title: 'Failed',
                message: 'Please check your input.'
                });
                    }
                  }
                })
              //window.location.href="educbg.php";
            })
        })

   
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">II. Family Background</div>
<div class="row row-cols-2 ">

    <div class="col">
    <div class="form-floating mb-3">
    <input type="text" class="form-control" id="spSname">
    <label for="spSname">Spouse's Surname (N/A if not applicable)</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spFname" >
  <label for="spFname">First Name</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spMname">
  <label for="spMname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spExt" >
  <label for="spExt">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spOccu">
  <label for="spOccu">Occupation</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spEmpName">
  <label for="spEmpName">Employer Business Name</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spBadd">
  <label for="spBadd">Business Address</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="spTel">
  <label for="spTel">Telephone No</label>
    </div>
    </div>

</div>
        <hr>
    <div class="row row-cols-2 ">
    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="fSname">
  <label for="fSname">Father's Surname</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="fFname">
  <label for="fFname">First Name</label>
    </div>
    </div>

   
    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="fMname">
  <label for="fMname">Middle Name</label>
    </div>
    </div>

    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="fExt" >
  <label for="fExt">Name Extension (Jr. Sr.)</label>
    </div>
    </div>


</div>


<div class="row row-cols-2 ">
    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="mMaidName">
  <label for="mSname">Mother's Maiden Name</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="mSname">
  <label for="mSname">Mother's Surname</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="mFname">
  <label for="mFname">First Name</label>
    </div>
    </div>

    <div class="col">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="mMname" >
  <label for="mExt">Middle Name</label>
    </div>
    </div>
   
    <div class="col col-md-3">
    <div class="form-floating mb-3">
  <input type="text" class="form-control" id="mExt" >
  <label for="mMname">Name Extension (Jr. Sr.)</label>
    </div>
    </div>

    

</div>
<div class="container pb-1">
<table class="table table-bordered">
    <thead>
        <tr>
            <Th scope="col">Name of Childrem (Write full name and list all)</th>
            <th scope="col">DATE OF BIRTH</th>
        </tr>
    </thead>
    <tbody id="body">
      
    <tr>
      <td id="sad"><input type="text" class="form-control" id="chName"></td>
      <td id="sad2"><input type="date" class="form-control" id="chBday"></td> 
    </tr>

    <tr>
      <td id="sad"><input type="text" class="form-control" id="chName"></td>
      <td id="sad2"><input type="date" class="form-control" id="chBday"></td> 
    </tr>

    <tr>
      <td id="sad"><input type="text" class="form-control" id="chName"></td>
      <td id="sad2"><input type="date" class="form-control" id="chBday"></td> 
    </tr>
    

</tbody>
</table>

<div class="d-flex justify-content-end">
        <button class="btn btn-dark p-1 m-2" id="add"><i class="fi fi-rr-add p-1"></i>Add Row</button>
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-primary m-2 p-1" id="next">Next</button>
    </div>
</div>
        


<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>