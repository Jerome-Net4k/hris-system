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


    
    <script>
        $(document).ready(function(){
                setInterval(function(){
                    load()
                },500)

                $("button#save").on("click",function(){
                    var role = "";
                    $("input#role").each(function(){
                        if($(this).prop("checked") == true){
                            role += $(this).val() + ",";
                        }
                    })
                    var convRole = role.substring(0,role.length-1);
                    var username = $("#username").val();
                    var fname = $("#fname").val();
                    var mname = $("#mname").val();
                    var lname = $("#lname").val();
                    $.ajax({
                        data: {username:username,convRole: convRole,fname:fname,mname:mname,lname:lname},
                        type: "POST",
                        url: 'proc_user.php?action=save',
                        success: function(data){
                            if(data == 'duplicate'){
                                iziToast.error({
                                position: "topRight",
                                title: 'Failed',
                                message: 'Username already exist!'
                                });
                            }
                            else if(data == 'check'){
                                iziToast.error({
                                position: "topRight",
                                title: 'Failed',
                                message: 'Please check your input!'
                                });
                            }
                            else{
                                $("#exampleModal").modal('toggle')
                            }
                        }
                    })
                })

            function load(){
                $.ajax({
                    type: "GET",
                    url: "proc_user.php?action=load",
                    success: function(data){
                       $("#content").html(data)
                       
                    }
                })
            }
        })
    </script>
</head>
<body>
        <?php include 'navbar.php'; ?>
      <div class="container-fluid">
      <div class="row">
        <div class="col">
        <div class="d-flex justify-content-start">
          <h1 class="title fs-2 fw-bold p-2">Personal Data Sheet</h1>
        </div>
        </div>
        <div class="col">
        <div class="col p-2 d-flex justify-content-end">
          <button class="btn btn-outline-dark p-1" id="newUser" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="far fa-user p-1"></i> | New User</button>
        </div>
        </div>
       </div>
       <div class="container-fluid bg-white rounded">
        <div class="d-flex justify-content-center pt-1 table-responsive">
            <table class="table bg-white rounded table-bordered" id="mainTable">
               <tr>
               <th>ID</th>
               <th>USERNAME</th>
               <th>FIRST NAME</th>
               <th>MIDDLE NAME</th>
               <th>LAST NAME</th>
               <th>ROLE</th>
               <th>STATUS</th>
               <th>ONLINE STATUS</th>
               </tr>
               <!-- ajax request -->
               <tbody id="content">

              </tbody>  
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="">Username</label>
        <input type="text" class="form-control mb-2" id="username">
        <label for="">First Name</label>
        <input type="text" class="form-control" id="fname">
        <label for="">Middle Name</label>
        <input type="text" class="form-control" id="mname">
        <label for="">Last Name</label>
        <input type="text" class="form-control mb-2" id="lname">
        <h4>Role</h4>
        <div class="row">
            <div class="col-sm">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="RSP" id="role">
                <label class="form-check-label" for="flexCheckDefault">
                RSP
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="PM" id="role">
                <label class="form-check-label" for="flexCheckChecked">
                PM
                </label>
                </div>

                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="OJT" id="role">
                <label class="form-check-label" for="flexCheckChecked">
                OJT
                </label>
                </div>
            </div>

            <div class="col-sm">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="RNR" id="role">
                <label class="form-check-label" for="flexCheckDefault">
                RNR
                </label>
                </div>                
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="L&D" id="role">
                <label class="form-check-label" for="flexCheckChecked">
                L&D
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value="OTHERS" id="role">
                <label class="form-check-label" for="flexCheckDefault">
                OTHERS
                </label>
                </div>
                
            </div>

            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
      </div>
    </div>
  </div>
</div>
    
      </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>