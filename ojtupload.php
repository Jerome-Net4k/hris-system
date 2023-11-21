<?php

$connect = mysqli_connect("localhost", "root", "", "hr_management");

function checkDuplicateIdnum($idnum) {
    global $connect;
    $query = "SELECT * FROM ojt_tbl WHERE idnum='$idnum'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
$query = "INSERT INTO ojt_tbl (idnum, internpic, nameintern, fname, mname, lname, ext, dob, school, dept, btype, nameguard, rel, address, contactnum, remarks, file) 
VALUES ('$idnum', '$internpic', '$nameintern', '$fname', '$mname', '$lname' '$ext', '$dob', '$school', '$dept', '$btype', '$nameguard', '$rel', '$address', '$contactnum', '$remarks', '$file')";

if (mysqli_query($connect, $query)) {
    echo "success";
} else {
    echo "Error: " . mysqli_error($connect);
}
$idnum = mysqli_real_escape_string($connect, $_POST['idnum']);

// Continue with inserting the new record if the idnum is not a duplicate
if (!checkDuplicateIdnum($idnum)) {
    $nameintern = mysqli_real_escape_string($connect, $_POST['nameintern']);
    $fname = mysqli_real_escape_string($connect, $_POST['fname']);
    $mname = mysqli_real_escape_string($connect, $_POST['mname']);
    $lname = mysqli_real_escape_string($connect, $_POST['lname']);
    $ext = mysqli_real_escape_string($connect, $_POST['ext']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $school = mysqli_real_escape_string($connect, $_POST['school']);
    $dept = mysqli_real_escape_string($connect, $_POST['dept']);
    $btype = mysqli_real_escape_string($connect, $_POST['btype']);
    $nameguard = mysqli_real_escape_string($connect, $_POST['nameguard']);
    $rel = mysqli_real_escape_string($connect, $_POST['rel']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $contactnum = mysqli_real_escape_string($connect, $_POST['contactnum']);
    $remarks = mysqli_real_escape_string($connect, $_POST['remarks']);


    $internpic = $_FILES['internpic']['name'];
    $temp = $_FILES['internpic']['tmp_name'];

    $file = $_FILES['file']['name'];
    $temps = $_FILES['file']['tmp_name'];

    $target = "internpic/" . basename($internpic);
    move_uploaded_file($temp, $target);

    $targets = "ojtfiles/" . basename($file);
    move_uploaded_file($temps, $targets);

    $query = "INSERT INTO ojt_tbl (idnum, internpic, nameintern, fname, mname, lname, ext, dob, school, dept, btype, nameguard, rel, address, contactnum, remarks, file) 
    VALUES ('$idnum', '$internpic', '$nameintern', '$fname', '$mname', '$lname', '$ext', '$dob', '$school', '$dept', '$btype', '$nameguard', '$rel', '$address', '$contactnum', '$remarks', '$file')";
    
    if (mysqli_query($connect, $query)) {
        echo "success";
    } else {
        echo "failed";
    }
} else {
    echo "duplicate";
}

?>
