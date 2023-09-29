<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php' ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
  
<script>
        $(Document).ready(function(){
            $("#add").on("click",function(){
                    $("#body").append('<tr><td id="skill"><input type="text" class="form-control" id="skill"></td><td id="acad"><input type="text" class="form-control" id="acad"></td><td id="member"><input type="text" class="form-control" id="member"></td></tr>')
            })
            
            $("#prev").on("click",function(){
              window.location.href="lnd.php";
            })

            $("#submit").on("click",function(){
              var skill = "";
              var acad = "";
              var member = "";

              $("td#skill").each(function(){
                var findSkill = $(this).find("input#skill").val();
                skill += findSkill + ",";
              })

              $("td#acad").each(function(){
                var findAcad = $(this).find("input#acad").val();
                acad += findAcad + ",";
              })

              $("td#member").each(function(){
                var findMember = $(this).find("input#member").val();
                member += findMember + ",";
              })

              var convSkill = skill.substr(0,skill.length-1);
              var convAcad = acad.substr(0,acad.length-1);
              var convMember = member.substr(0,member.length-1);

              $.ajax({
                data: {convSkill:convSkill,convAcad:convAcad,convMember:convMember},
                type: "POST",
                url: "uploadPDS.php",
                processData: false,
                contentType: false,
                success: function(data){
                  window.location.href="views_home.php";
                }
              })
            })
        })
    </script>
</head>
<body>
  <?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container rounded bg-white mt-3">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">VIII. OTHER INFORMATION</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <Th scope="col" class="text-center">SPECIAL SKILLS AND HOBBIES</th>
            <th scope="col" class="text-center">NON-ACADEMIC DISTINCTIONS / RECOGNITION <BR> (Write in full)</th>
            <th scope="col" style="width: 400px" class="text-center">MEMBERSHIP IN ASSOCIATION / ORGANIZATION (Write in full)</th>
        </tr>
    </thead>
    <tbody id="body">
    <tr>
      <td id="skill"><input type="text" class="form-control" id="skill"></td>
      <td id="acad"><input type="text" class="form-control" id="acad"></td>
      <td id="member"><input type="text" class="form-control" id="member"></td>
    </tr>

    <tr>
      <td id="skill"><input type="text" class="form-control" id="skill"></td>
      <td id="acad"><input type="text" class="form-control" id="acad"></td>
      <td id="member"><input type="text" class="form-control" id="member"></td>
    </tr>

    <tr>
      <td id="skill"><input type="text" class="form-control" id="skill"></td>
      <td id="acad"><input type="text" class="form-control" id="acad"></td>
      <td id="member"><input type="text" class="form-control" id="member"></td>
    </tr>

    <tr>
      <td id="skill"><input type="text" class="form-control" id="skill"></td>
      <td id="acad"><input type="text" class="form-control" id="acad"></td>
      <td id="member"><input type="text" class="form-control" id="member"></td>
    </tr>

    <tr>
      <td id="skill"><input type="text" class="form-control" id="skill"></td>
      <td id="acad"><input type="text" class="form-control" id="acad"></td>
      <td id="member"><input type="text" class="form-control" id="member"></td>
    </tr>
</tbody>
<table>

  <div class="d-flex justify-content-end pb-1 me-2 pt-1">
    <button class="btn btn-dark p-1 m-2" id="add"><i class="fi fi-rr-add p-1"></i>Add Row</button>
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-success m-2 p-1" id="submit">Submit</button>
    </div>

        

</div>
</div>

</body>
</html>