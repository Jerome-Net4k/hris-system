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
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.0/bootstrap-icons.min.js"
        integrity="sha512-yqTKH8fGt64Ag0BRovGFp9mUoD2Gt+x2vJ3ZiXfI8lX2LkjKd20H2H/tZOpwRbClfYq7u5RSo4pE8r0KFZlviQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            $("button#newUser").on("click", function () {
                $("#gsis").val('');
                $("#np").val('');
                $("#ccp").val('');
            });

            $("#save").on("click", function () {
                var gsis = $("#gsis").val();
                var newPassword = $("#np").val();
                var confirmPassword = $("#ccp").val();

                // Validate the input fields
                if (gsis === "" || newPassword === "" || confirmPassword === "") {
                    iziToast.error({
                        position: "topRight",
                        title: "Failed",
                        message: "Please fill in all the fields!",
                    });
                    return;
                }

                // Perform password validation
                if (newPassword !== confirmPassword) {
                    iziToast.error({
                        position: "topRight",
                        title: "Failed",
                        message: "Passwords do not match!",
                    });
                    return;
                }

                $.ajax({
                    data: {
                        gsis: gsis,
                        newPassword: newPassword,
                    },
                    type: "POST",
                    url: "dashboard_user.php?action=insertPassword",
                    success: function (data) {
    if (data === "success") {
        iziToast.success({
            position: "topRight",
            title: "Success",
            message: "Password inserted successfully!",
        });
        $("#insertmodal").modal("close"); // Close the modal
        load(); // Refresh the table
    } else if (data === "check") {
        iziToast.error({
            position: "topRight",
            title: "Failed",
            message: "Please fill in all the fields!",
        });
    } else {
        iziToast.success({
            position: "topRight",
            title: "Success",
            message: "Password inserted successfully!",
        });
    }
},

                    complete: function () {
                        // Clear the input fields
                        $("#gsis").val("");
                        $("#np").val("");
                        $("#ccp").val("");
                        $("#pass").val("");
                    }
                });

                // Clear the input fields
                $("#gsis").val("");
                $("#np").val("");
                $("#ccp").val("");
            });

            function load() {
                var searchTerm = $("#searchBar").val(); // Get the value from the search bar

                // Send an AJAX GET request to "db_user.php?action=load"
                $.ajax({
                    type: "GET",
                    url: "dashboard_user.php?action=load",
                    data: { searchTerm: searchTerm }, // Pass the search term as a parameter
                    success: function (data) {
                        $("#content").html(data); // Update the content with the response data

                        // Attach event listener to dynamic buttons
                        $(".insert-password-btn").on("click", function () {
    var gsis = $(this).data("gsis"); // Get the GSIS value from the button data attribute
    var pass = $(this).data("pass"); // Get the password value from the button data attribute

    $("#gsis").val(gsis); // Fill the GSIS input field
    $("#pass").val(pass); // Fill the current password input field

    $("#insertmodal").modal("show"); // Show the modal
});


                        // Attach event listener to login buttons
                        $(".login-btn").on("click", function () {
                            var gsis = $(this).data("gsis"); // Get the GSIS value from the button data attribute
                            // Perform the login action using the GSIS value
                            login(gsis);
                        });
                    },
                });
            }

            // Trigger the search whenever the search bar value changes
            $("#searchBar").on("input", function () {
                load();
            });

            // Load the table on page load
            load();

            // Refresh the table every second
            setInterval(function () {
                load();
            }, 1000);

            function lockPasswordForm() {
                $("#np").prop("disabled", true);
                $("#ccp").prop("disabled", true);
                $("#save").prop("disabled", true);
            }

            function unlockPasswordForm() {
                $("#np").prop("disabled", false);
                $("#ccp").prop("disabled", false);
                $("#save").prop("disabled", false);
            }

            function login(gsis) {
                // Perform the login action
                // Replace the code below with your desired login logic
                // Here, we'll display a success message with the GSIS value
                iziToast.success({
                    position: "topRight",
                    title: "Success",
                    message: "Logged in as GSIS: " + gsis,
                });
            }
        });
    </script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-start">
                    <h1 class="title fs-2 fw-bold p-2">Dashboard Password Setup</h1>
                </div>
            </div>
            <div class="flex-row justify-content-center mt-3">
                <input type="text" class="form-control" id="searchBar" placeholder="Search...">
            </div>
            <div class="col">
                <div class="col p-2 d-flex justify-content-end">

                </div>
            </div>
        </div>
        <div class="container-fluid bg-white rounded position-sticky">
            <div class="d-flex justify-content-center pt-1 table-responsive">
                <table class="table bg-white rounded table-bordered" id="mainTable">
                    <tr style="background-color:#4f84ff;">
                        <th>GSIS</th>
                        <th>SURNAME</th>
                        <th>FIRST NAME</th>
                        <th>MIDDLE NAME</th>
                        <th>CURRENT DASHBOARD PASSWORD</th>
                        <th>Actions</th>
                    </tr>


                    <!-- ajax request -->
                    <tbody id="content"></tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="insertmodal" tabindex="-1" aria-labelledby="insertmodalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertmodalLabel">Insert/Update Password</h5>

                    </div>
                    <div class="modal-body">
                        <label for="gsis">GSIS</label>
                        <input type="text" class="form-control mb-2" id="gsis" readonly>
                        <label for="currentPassword">Current Password</label>
                        <input type="text" class="form-control mb-2" id="pass" readonly>
                        <div class="input-group mb-2">

                        </div>
                        <label for="np">New Password</label>
                        <input type="text" class="form-control mb-2" id="np">
                        <label for="ccp">Confirm Password</label>
                        <input type="text" class="form-control mb-2" id="ccp">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save">Save</button>
                    </div>

                </div>
            </div>

            <!-- Login Modal -->
            <!-- <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="user">User</label>
                        <input type="text" class="form-control" id="userpass">
                        <label for="pass">Password</label>
                        <input type="text" class="form-control" id="hrpass">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
                    </div>
                </div>
            </div>
        </div> -->
        </div>
</body>

</html>