<?php
include "connection.php";

if (isset($_POST['viewgsis2'])) {
    updatepds();
} 

if(isset($_POST['delgsis'])){
    deletepds();
}

if(isset($_POST['viewgsisimgupload'])){
    $pdsimage = $_POST['pdsimage'];
    $viewgsisimgupload = $_POST['viewgsisimgupload'];
    $viewsnameimgupload = $_POST['viewsnameimgupload'];

    $image_tmp = $_FILES["pdsimage"]["tmp_name"];
    $image_name = $viewgsisimgupload . " " . $viewsnameimgupload . ".png";
     // Move the image to the folder with the new name and extension
    move_uploaded_file($image_tmp, "uploads/emp_img/" . $image_name);
    echo "hello";
}


function updatepds(){
    include "connection.php";
    $viewsname2 = $_POST['viewsname2'];
    $viewfname2 = $_POST['viewfname2'];
    $viewmname2 = $_POST['viewmname2'];

    $viewsfx2 = $_POST['viewsfx2'];
    $viewdob2 = $_POST['viewdob2'];
    $viewpob2 = $_POST['viewpob2'];
    $viewgender2 = $_POST['viewgender2'];
    $viewempNo2 = $_POST['viewempNo2'];

    $viewcivil2 = $_POST['viewcivil2'];
    $pos2 = $_POST['pos2'];
    $viewresHouse2 = $_POST['viewresHouse2'];
    $dept2 = $_POST['dept2'];
    $viewresBrgy2 = $_POST['viewresBrgy2'];

    $soa2val = $_POST['soa2'];
    $viewresCity2 = $_POST['viewresCity2'];
    $viewstatus2 = $_POST['viewstatus2'];
    $viewresZip2 = $_POST['viewresZip2'];

    $viewmobile2 = $_POST['viewmobile2'];
    $viewemail2 = $_POST['viewemail2'];
    $viewciti2 = $_POST['viewciti2'];
    $viewheight2 = $_POST['viewheight2'];

    $viewweight2 = $_POST['viewweight2'];
    $viewbtype2 = $_POST['viewbtype2'];
    $viewpagibig2 = $_POST['viewpagibig2'];
    $viewphealth2 = $_POST['viewphealth2'];
    $viewtin2 = $_POST['viewtin2'];
    $viewsg2 = $_POST['viewsg2'];
    if ($soa2val =="Regular" || $soa2val =="REGULAR") {
        $soa2 = "P";
    } else if ($soa2val =="Casual" || $soa2val =="CASUAL") {
        $soa2 = "C";
    } else if ($soa2val =="Presidential Appointee" || $soa2val =="PRESIDENTIAL APPOINTEE") {
        $soa2 = "PA";
    } else {
        $soa2 = "";
    }

    // Where?
    $viewgsis2 = $_POST['viewgsis2'];

    $sql = "UPDATE `emp_table` SET `empNo`=?, `pos_title`=?, `division`=?, `salary_grade`=?, `lname`=?, `fname`=?, `mname`=?, `ext`=?, `dob`=?, `pagibig`=?, `philhealth`=?, `tin`=?, `sex`=?, `soa`=?, `emp_status`=? WHERE bpNo=?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssssssss', $viewempNo2, $pos2, $dept2, $viewsg2, $viewsname2, $viewfname2, $viewmname2, $viewsfx2, $viewdob2, $viewpagibig2, $viewphealth2, $viewtin2, $viewgender2, $soa2, $viewstatus2, $viewgsis2);

    $success = mysqli_stmt_execute($stmt);
    $sql2 = "UPDATE `personalinfo_table` SET `sname`=?, `fname`=?, `mname`=?, `ext`=?, `dob`=?, `pob`=?, `sex`=?, `civilStat`=?, `height`=?, `weight`=?, `btype`=?, `pagibig`=?, `philhealth`=?, `tin`=?, `empNo`=?, `citizen`=?, `resHouse`=?, `resBrgy`=?, `resCity`=?, `resZip`=?, `permHouse`=?, `permBrgy`=?, `permCity`=?, `permZip`=?, `mobile`=?, `email`=?, `emp_status`=? WHERE gsis=?"; //

    $stmt2 = mysqli_prepare($con, $sql2); //
    mysqli_stmt_bind_param($stmt2, 'ssssssssssssssssssssssssssss', $viewsname2, $viewfname2, $viewmname2, $viewsfx2, $viewdob2, $viewpob2, $viewgender2, $viewcivil2, $viewheight2, $viewweight2, $viewbtype2, $viewpagibig2, $viewphealth2, $viewtin2, $viewempNo2, $viewciti2, $viewresHouse2, $viewresBrgy2, $viewresCity2, $viewresZip2, $viewpermHouse2, $viewpermBrgy2, $viewpermCity2, $viewpermZip2, $viewmobile2, $viewemail2, $viewstatus2, $viewgsis2); //

    $success = $success && mysqli_stmt_execute($stmt2);

    if ($success) {
        echo "PDS update";
    } else {
        echo "Error updating PDS";
    }

    mysqli_close($con);

    // if (mysqli_stmt_execute($stmt)) {
    //     echo "PDS update";
    // }
    // mysqli_close($con);

}


function deletepds(){
    $delgsis = $_POST['delgsis'];
    include "connection.php";
    
    $delsql = "DELETE FROM `emp_table` WHERE `bpNo` = ?";
    $delstmt = mysqli_prepare($con, $delsql);
    mysqli_stmt_bind_param($delstmt, 's', $delgsis);
    $success1 = mysqli_stmt_execute($delstmt);

    $delsql2 = "DELETE FROM `personalinfo_table` WHERE `gsis` = ?";
    $delstmt2 = mysqli_prepare($con, $delsql2);
    mysqli_stmt_bind_param($delstmt2, 's', $delgsis);

    $success2 = mysqli_stmt_execute($delstmt2);

    if ($success1 && $success2) {
        echo "PDS deleted";
    } else {
        echo "Error updating PDS";
    }
}

// update gsis number
if (isset($_POST['newgsisupdate'])) {
    $newgsisupdate = $_POST['newgsisupdate'];
    $currentgsis = $_POST['currentgsis'];
    // Assuming you have established the database connection as "$con"

    $stmt = $con->prepare("UPDATE emp_table SET bpNo=? WHERE bpNo=?");
    // Bind parameters
    $stmt->bind_param("ss", $newgsisupdate, $currentgsis);
    $success = $stmt->execute();
    $stmt->close();

    $stmt2 = $con->prepare("UPDATE personalinfo_table SET gsis=? WHERE gsis=?");
    // Bind parameters
    $stmt2->bind_param("ss", $newgsisupdate, $currentgsis);
    $success2 = $stmt2->execute();
    $stmt2->close();

    // Process the result
    if ($success && $success2) {
        echo 'gsis updated';
    }
}

if (isset($_POST['delidid'])) {
    $delidid = $_POST['delidid'];
    $delsql2 = "DELETE FROM `emp_table` WHERE `id` = ?";
    $delstmt2 = mysqli_prepare($con, $delsql2);
    mysqli_stmt_bind_param($delstmt2, 's', $delidid);
    
    $success2 = mysqli_stmt_execute($delstmt2);
    
    if ($success2) {
        echo 'delete duplicate';
    }
}

?>