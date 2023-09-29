<?php
$connect = mysqli_connect("localhost", "root", "", "hr_management");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$idnum = mysqli_real_escape_string($connect, $_POST['idnum']); // ID of the record to update

$nameintern = mysqli_real_escape_string($connect, $_POST['nameintern']);
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
$file = $_FILES['file']['name'];

if (!empty($internpic)) {
    $temp = $_FILES['internpic']['tmp_name'];
    $target = "internpic/" . basename($internpic);
    if (!move_uploaded_file($temp, $target)) {
        die("Failed to upload internpic.");
    }
}

if (!empty($file)) {
    $temps = $_FILES['file']['tmp_name'];
    $targets = "ojtfiles/" . basename($file);
    if (!move_uploaded_file($temps, $targets)) {
        die("Failed to upload file.");
    }
}

// Update the record
if (!empty($internpic) && !empty($file)) {
    $query = "UPDATE ojt_tbl SET internpic='$internpic', nameintern='$nameintern', ext='$ext', dob='$dob', school='$school', dept='$dept', btype='$btype', nameguard='$nameguard', rel='$rel', address='$address', contactnum='$contactnum', remarks='$remarks', file='$file' WHERE idnum=$idnum";
} elseif (!empty($internpic)) {
    $query = "UPDATE ojt_tbl SET internpic='$internpic', nameintern='$nameintern', ext='$ext', dob='$dob', school='$school', dept='$dept', btype='$btype', nameguard='$nameguard', rel='$rel', address='$address', contactnum='$contactnum', remarks='$remarks' WHERE idnum=$idnum";
} elseif (!empty($file)) {
    $query = "UPDATE ojt_tbl SET nameintern='$nameintern', ext='$ext', dob='$dob', school='$school', dept='$dept', btype='$btype', nameguard='$nameguard', rel='$rel', address='$address', contactnum='$contactnum', remarks='$remarks', file='$file' WHERE idnum=$idnum";
} else {
    $query = "UPDATE ojt_tbl SET nameintern='$nameintern', ext='$ext', dob='$dob', school='$school', dept='$dept', btype='$btype', nameguard='$nameguard', rel='$rel', address='$address', contactnum='$contactnum', remarks='$remarks' WHERE idnum=$idnum";
}

if (mysqli_query($connect, $query)) {
    echo "success";
} else {
    echo "Failed: " . mysqli_error($connect);
}

mysqli_close($connect);

?>
