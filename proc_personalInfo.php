<?php
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
// if(!isset($_POST['searchBar']) && !isset($_GET['id'])){
//     $sortval = $_POST['sortval'];
//     $sortwhat = $_POST['sortwhat'];
//     loadPersonalInfo($personalInfo,$sortval,$sortwhat);
// }

if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}

if(isset($_GET['id'])){ 
    echo getPdsInfo($personalInfo);
}

if(isset($_POST['sortval'])){
    $sortval = $_POST['sortval'];
    $sortwhat = $_POST['sortwhat'];
    $emptype = $_POST['emptype'];
    loadPersonalInfo($personalInfo, $sortval,$sortwhat,$emptype);
}

// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['bpNo'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['lname'].'</td> 
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['fname'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['mname'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['ext'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pos_title'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['division'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['tin'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pagibig'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['philhealth'].'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$soa.'</td>
// <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['emp_status'].'</td>
// <td>delete</td>

// <td>'.$row['bpNo'].'</td>
//                 <td>'.$row['lname'].'</td> 
//                 <td>'.$row['fname'].'</td>
//                 <td>'.$row['mname'].'</td>
//                 <td>'.$row['ext'].'</td>
//                 <td>'.$row['pos_title'].'</td>
//                 <td>'.$row['division'].'</td>
//                 <td>'.$row['tin'].'</td>
//                 <td>'.$row['pagibig'].'</td>
//                 <td>'.$row['philhealth'].'</td>
//                 <td>'.$soa.'</td>
//                 <td>'.$row['emp_status'].'</td>

function loadPersonalInfo($personalInfo,$sortval,$sortwhat,$emptype){
    include 'connection.php';
    $query = "SELECT * FROM `emp_table` $emptype ORDER BY $sortval $sortwhat ";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $soa = "";
            switch($row['soa']){
                case 'PA': $soa = "PRESIDENTIAL APPOINTEE";
                break;
                case 'P': $soa = "REGULAR";
                break;
                case 'C': $soa = "CASUAL";
                break;
                case 'JO': $soa = "JOB ORDER";
                break;
                case 'COS': $soa = "CONTRACT OF SERVICE";
                break;
            }
            // data-bs-toggle="modal" data-bs-target="#exampleModal"
                echo '<tr style="height: auto;" id="idshow" data-value="' . $row['id'] . '">
                
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['bpNo'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['lname'].'</td> 
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['fname'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['mname'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['ext'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pos_title'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['division'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['tin'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pagibig'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['philhealth'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$soa.'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['emp_status'].'</td>
                <td id="dupdelete_'. $row['id'] .'"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                </tr>';
                
                echo '<script>
                $("#dupdelete_'. $row['id'] .'").on("click", function(){
                    var delidid = "'. $row['id'] .'";
                    var confirmation = confirm("Are you sure do you want to DELETE this record?");
                    // alert(delidid);
                    if (confirmation){
                    $.ajax({
                        type: "POST",
                        url: "views_home_crud.php",
                        data: { delidid: delidid },
                        success: function(data) {
                            if (data == "delete duplicate") {
                                iziToast.error({
                                    title: "DELETED",
                                    message: "SELECTED RECORD DELETED SUCCESSFULLY!"
                                });
                                
                                var sortval = "lname";
                                var sortwhat = "ASC";
                                var emptype = "";
                                
                                $.ajax({
                                    url: "proc_personalInfo.php",
                                    type: "POST",
                                    data: { sortval: sortval, sortwhat: sortwhat, emptype: emptype },
                                    success: function(data) {
                                        $("#content").html(data);
                                    }
                                });
                            }
                        }
                    });
                    }                 
                });
                </script>';
        }   
        //<td class="header"><button class="btn btn-outline-success p-1 m-1" id="view" value="'.$row['empNo'].'" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-eye" aria-hidden="true"></i> | View</button>
        //<button class="btn btn-outline-primary p-1" id="update" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> | Update</button></td>
    }
    else{
        echo '<tr><td colspan="12" class="text-center"><h1>No Data Found</h1></td></tr>';
    }

    echo '<script>
    
    $("table#mainTable tbody tr").on("click",function(){
        var id = $(this).find("td:eq(0)").text();
        var idd = $(this).data("value");
        // alert(idd);
        $.ajax({
            type: "GET",
            url: "proc_personalInfo.php?id=" + id,
            success: function(data){
                var conv = jQuery.parseJSON(data);
                $("#viewsname").text(conv.sname);
                $("#viewfname").text(conv.fname);
                $("#viewmname").text(conv.mname);
                $("#viewsfx").text(conv.ext);
                $("#viewdob").text(conv.dob);
                $("#viewpob").text(conv.pob);
                $("#viewgender").text(conv.sex);
                $("#viewcivil").text(conv.civilStat);
                $("#viewresHouse").text(conv.resHouse);
                $("#viewresBrgy").text(conv.resCity);
                $("#viewresCity").text(conv.resBrgy);
                $("#viewresZip").text(conv.resZip);
                $("#viewemail").text(conv.email);
                $("#viewciti").text(conv.citizen);
                $("#viewheight").text(conv.height);
                $("#viewweight").text(conv.weight);
                $("#viewbtype").text(conv.btype);
                $("#viewgsis").text(conv.gsis);
                $("#viewmobile").text(conv.mobile);
                $("#viewpagibig").text(conv.pagibig);
                $("#viewphealth").text(conv.philhealth);
                $("#viewtin").text(conv.tin);
                $("#viewempNo").text(conv.empNo);

                $("#imgpdsindicator").text("");
                var gsis = conv.gsis; // Assuming conv.gsis contains the GSIS value
                var sname = conv.sname; // Assuming conv.sname contains the employees name
                var imageName = gsis + " " + sname + ".png"; // Construct the image name

                var imagePath = "uploads/emp_img/" + imageName; // Construct the image path
                var timestamp = new Date().getTime(); // Get current timestamp

                // Append the timestamp as a query parameter to the image URL
                var imageUrl = imagePath + "?timestamp=" + timestamp;

                $("#pp").attr("src", imageUrl); // Set the src attribute of the

                $("#pos").text(conv.pos_title)
                $("#dept").text(conv.division)
                if(conv.soa == "P"){
                    $("#soa").text("Regular");
                }
                else if(conv.soa == "C"){
                    $("#soa").text("Casual");
                }
                else if(conv.soa == "PA"){
                    $("#soa").text("Presidential Appointee");
                }
                else{
                    $("#soa").text("Job Order");
                }
                $("#viewPds").attr("href", "uploads/emp_pds/" + conv.pds_file);

// for update button
                $("#idselect").val(idd);
                $("#viewsname2").val(conv.empno);
                $("#viewsname2").val(conv.sname);
                $("#viewfname2").val(conv.fname);
                $("#viewmname2").val(conv.mname);
                $("#viewsfx2").val(conv.ext);
                $("#viewdob2").val(conv.dob);
                $("#viewpob2").val(conv.pob);
                $("#viewgender2").val(conv.sex);
                $("#viewcivil2").val(conv.civilStat);
                $("#viewresHouse2").val(conv.resHouse);
                $("#viewresBrgy2").val(conv.resCity);
                $("#viewresCity2").val(conv.resBrgy);
                $("#viewresZip2").val(conv.resZip);
                $("#viewemail2").val(conv.email);
                $("#viewciti2").val(conv.citizen);
                $("#viewheight2").val(conv.height);
                $("#viewweight2").val(conv.weight);
                $("#viewbtype2").val(conv.btype);
                $("#viewgsis2").val(conv.gsis);
                $("#viewgsis2t").text(conv.gsis);
                $("#viewmobile2").val(conv.mobile);
                $("#viewpagibig2").val(conv.pagibig);
                $("#viewphealth2").val(conv.philhealth);
                $("#viewtin2").val(conv.tin);
                $("#viewempNo2").val(conv.empNo);
                $("#viewsg2").val(conv.salary_grade);
                $("#viewstatus2").val(conv.emp_status);
                $("#pp2").attr("src","uploads/emp_img/" + conv.gsis + " " + conv.sname + ".png")
                $("#pos2").val(conv.pos_title)
                $("#dept2").val(conv.division)
                if(conv.soa == "P"){
                    $("#soa2").val("Regular");
                }
                else if(conv.soa == "C"){
                    $("#soa2").val("Casual");
                }
                else if(conv.soa == "PA"){
                    $("#soa2").val("Presidential Appointee");
                }
                else{
                    $("#soa2").val("Job Order");
                }
                
                var uploadedgsis = conv.gsis; 
                var uploadesurname = conv.sname;
                var uploadeyear = $("#uploadedshow").val();
                $.ajax({
                    url:"views_display_uploaded.php",
                    type: "POST",
                    data: {uploadeyear:uploadeyear, uploadedgsis:uploadedgsis,uploadesurname:uploadesurname},
                    success: function(data){
                        $("#fileuploaded").html(data)
                    }
                })
            }
        })

      })

    $("button#view").on("click",function(){
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "proc_personalInfo.php?id=" + id,
            success: function(data){
                var conv = jQuery.parseJSON(data);
                $("#viewsname").text(conv.sname);
                $("#viewfname").text(conv.fname);
                $("#viewmname").text(conv.mname);
                $("#viewsfx").text(conv.ext);
                $("#viewdob").text(conv.dob);
                $("#viewpob").text(conv.pob);
                $("#viewgender").text(conv.sex);
                $("#viewcivil").text(conv.civilStat);
                $("#viewresHouse").text(conv.resHouse);
                $("#viewresBrgy").text(conv.resBrgy);
                $("#viewresCity").text(conv.resCity);
                $("#viewresZip").text(conv.resZip);
                $("#viewemail").text(conv.email);
                $("#viewciti").text(conv.citizen);
                $("#viewheight").text(conv.height);
                $("#viewweight").text(conv.weight);
                $("#viewbtype").text(conv.btype);
                $("#viewgsis").text(conv.gsis);
                $("#viewmobile").text(conv.mobile);
                $("#viewpagibig").text(conv.pagibig);
                $("#viewphealth").text(conv.philhealth);
                $("#viewtin").text(conv.tin);
                $("#viewempNo").text(conv.empNo);

            }
        })
    })
</script>';
}

function getPdsInfo($personalInfo){
    $id = $_GET['id'];
    $result = $personalInfo->get_sglTbl('gsis',$id);
    $row = $result->fetch_assoc();
    return json_encode($row);
}

function searchPersonalInfo($personalInfo){
    $name = $_POST['searchBar']."%";
    $fil = $_POST['fil'];
    $result = $personalInfo->get_wldcrdTbl2($fil,$name);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $soa = "";
            switch($row['soa']){
                case 'PA': $soa = "PRESIDENTIAL APPOINTEE";
                break;
                case 'P': $soa = "REGULAR";
                break;
                case 'C': $soa = "CASUAL";
                break;
                case 'JO': $soa = "JOB ORDER";
                break;
                case 'COS': $soa = "CONTRACT OF SERVICE";
                break;
            }
                echo '<tr style="height: auto;" id="idshow" data-value="' . $row['id'] . '">
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['bpNo'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['lname'].'</td> 
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['fname'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['mname'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['ext'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pos_title'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['division'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['tin'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['pagibig'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['philhealth'].'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$soa.'</td>
                <td data-bs-toggle="modal" data-bs-target="#exampleModal">'.$row['emp_status'].'</td>
                <td id="dupdelete_'. $row['id'] .'"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                </tr>';
                echo '<script>
                $("#dupdelete_'. $row['id'] .'").on("click", function(){
                    var delidid = "'. $row['id'] .'";
                    var confirmation = confirm("Are you sure do you want to DELETE this record?");
                    alert(delidid);
                    if (confirmation){
                    $.ajax({
                        type: "POST",
                        url: "views_home_crud.php",
                        data: { delidid: delidid },
                        success: function(data) {
                            if (data == "delete duplicate") {
                                iziToast.error({
                                    title: "DELETED",
                                    message: "SELECTED RECORD DELETED SUCCESSFULLY!"
                                });
                                
                                var sortval = "lname";
                                var sortwhat = "ASC";
                                var emptype = "";
                                
                                $.ajax({
                                    url: "proc_personalInfo.php",
                                    type: "POST",
                                    data: { sortval: sortval, sortwhat: sortwhat, emptype: emptype },
                                    success: function(data) {
                                        $("#content").html(data);
                                    }
                                });
                            }
                        }
                    });
                    }                 
                });
                </script>';
        }
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }

    echo '<script>

    $("table#mainTable tbody tr").on("click",function(){
        var id = $(this).find("td:eq(0)").text();
        // alert(id);
        $.ajax({
            type: "GET",
            url: "proc_personalInfo.php?id=" + id,
            success: function(data){
                var conv = jQuery.parseJSON(data);
                $("#viewsname").text(conv.sname);
                $("#viewfname").text(conv.fname);
                $("#viewmname").text(conv.mname);
                $("#viewsfx").text(conv.ext);
                $("#viewdob").text(conv.dob);
                $("#viewpob").text(conv.pob);
                $("#viewgender").text(conv.sex);
                $("#viewcivil").text(conv.civilStat);
                $("#viewresHouse").text(conv.resHouse);
                $("#viewresBrgy").text(conv.resCity);
                $("#viewresCity").text(conv.resBrgy);
                $("#viewresZip").text(conv.resZip);
                $("#viewemail").text(conv.email);
                $("#viewciti").text(conv.citizen);
                $("#viewheight").text(conv.height);
                $("#viewweight").text(conv.weight);
                $("#viewbtype").text(conv.btype);
                $("#viewgsis").text(conv.gsis);
                $("#viewmobile").text(conv.mobile);
                $("#viewpagibig").text(conv.pagibig);
                $("#viewphealth").text(conv.philhealth);
                $("#viewtin").text(conv.tin);
                $("#viewempNo").text(conv.empNo);
                $("#pp").attr("src","uploads/emp_img/" + conv.gsis + " " + conv.sname + ".png")
                $("#pos").text(conv.pos_title)
                $("#dept").text(conv.division)
                if(conv.soa == "P"){
                    $("#soa").text("Regular");
                }
                else if(conv.soa == "C"){
                    $("#soa").text("Casual");
                }
                else if(conv.soa == "PA"){
                    $("#soa").text("Presidential Appointee");
                }
                else{
                    $("#soa").text("Job Order");
                }
                $("#viewPds").attr("href", "uploads/emp_pds/" + conv.pds_file);

// for update button
                $("#viewsname2").val(conv.empno);
                $("#viewsname2").val(conv.sname);
                $("#viewfname2").val(conv.fname);
                $("#viewmname2").val(conv.mname);
                $("#viewsfx2").val(conv.ext);
                $("#viewdob2").val(conv.dob);
                $("#viewpob2").val(conv.pob);
                $("#viewgender2").val(conv.sex);
                $("#viewcivil2").val(conv.civilStat);
                $("#viewresHouse2").val(conv.resHouse);
                $("#viewresBrgy2").val(conv.resCity);
                $("#viewresCity2").val(conv.resBrgy);
                $("#viewresZip2").val(conv.resZip);
                $("#viewemail2").val(conv.email);
                $("#viewciti2").val(conv.citizen);
                $("#viewheight2").val(conv.height);
                $("#viewweight2").val(conv.weight);
                $("#viewbtype2").val(conv.btype);
                $("#viewgsis2").val(conv.gsis);
                $("#viewmobile2").val(conv.mobile);
                $("#viewpagibig2").val(conv.pagibig);
                $("#viewphealth2").val(conv.philhealth);
                $("#viewtin2").val(conv.tin);
                $("#viewempNo2").val(conv.empNo);
                $("#viewsg2").val(conv.salary_grade);
                $("#viewstatus2").val(conv.emp_status);
                $("#pp2").attr("src","uploads/emp_img/" + conv.gsis + " " + conv.sname + ".png")
                $("#pos2").val(conv.pos_title)
                $("#dept2").val(conv.division)
                if(conv.soa == "P"){
                    $("#soa2").val("Regular");
                }
                else if(conv.soa == "C"){
                    $("#soa2").val("Casual");
                }
                else if(conv.soa == "PA"){
                    $("#soa2").val("Presidential Appointee");
                }
                else{
                    $("#soa2").val("Job Order");
                }
                
                var uploadedgsis = conv.gsis; 
                var uploadesurname = conv.sname;
                var uploadeyear = $("#uploadedshow").val();
                $.ajax({
                    url:"views_display_uploaded.php",
                    type: "POST",
                    data: {uploadeyear:uploadeyear, uploadedgsis:uploadedgsis,uploadesurname:uploadesurname},
                    success: function(data){
                        $("#fileuploaded").html(data)
                    }
                });

            }
        })
      })

    $("button#view").on("click",function(){
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "proc_personalInfo.php?id=" + id,
            success: function(data){
                var conv = jQuery.parseJSON(data);
                $("#viewsname").text(conv.sname);
                $("#viewfname").text(conv.fname);
                $("#viewmname").text(conv.mname);
                $("#viewsfx").text(conv.ext);
                $("#viewdob").text(conv.dob);
                $("#viewpob").text(conv.pob);
                $("#viewgender").text(conv.sex);
                $("#viewcivil").text(conv.civilStat);
                $("#viewresHouse").text(conv.resHouse);
                $("#viewresBrgy").text(conv.resBrgy);
                $("#viewresCity").text(conv.resCity);
                $("#viewresZip").text(conv.resZip);
                $("#viewemail").text(conv.email);
                $("#viewciti").text(conv.citizen);
                $("#viewheight").text(conv.height);
                $("#viewweight").text(conv.weight);
                $("#viewbtype").text(conv.btype);
                $("#viewgsis").text(conv.gsis);
                $("#viewmobile").text(conv.mobile);
                $("#viewpagibig").text(conv.pagibig);
                $("#viewphealth").text(conv.philhealth);
                $("#viewtin").text(conv.tin);
                $("#viewempNo").text(conv.empNo);

            }
        })
    })
</script>';
}

?>
