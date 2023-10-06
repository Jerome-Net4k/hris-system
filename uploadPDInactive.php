<?php

session_start();
include 'connection.php';

if(isset($_POST['editInactive'])){
    updatePersonalInfo();
} else if(isset($_POST['checkCount'])){
    getPendingCount();
} else if(isset($_POST['newInactive'])){
    uploadPersonalInfo();
} else if(isset($_POST['pendingTransfer'])){
    pendingStatus();
} else if(isset($_POST['delRow'])){
    deletePersonalInfo();
}else if(isset($_POST['addYearDirectory'])){
    createYearDirectory();
}else {
}

function createYearDirectory(){
    include 'connection.php';

    $yearFolder = $_POST['yearInput'];
    $folderPath = "pmupload/" . $yearFolder;
    $opcrPath = $folderPath . "/OPCR";
    $dpcrPath = $folderPath . "/DPCR";
    $ipcrPath = $folderPath . "/IPCR";

    $query = "INSERT INTO `performance_rating_year`(`year`) VALUES ($yearFolder)";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        mkdir($folderPath);
        mkdir($opcrPath);
        mkdir($dpcrPath);
        mkdir($ipcrPath);
    }
}

function deletePersonalInfo(){
    include 'connection.php';

    $rowno = $_POST['rowno'];
    $sname = $_POST['sname'];

    $fileName = $rowno . ' ' . trim($sname,'"')  . ".pdf";

    $delFilePath = "docs/Inactive/" . $fileName;

    $query = "DELETE FROM personalinfo_inactive_table WHERE rowno = $rowno";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        if(file_exists($delFilePath)){
            unlink($delFilePath);
        }
        echo 'success';
    }
}

function getPendingCount(){
    include 'connection.php';

    $query = "SELECT COUNT(idno) AS pendingcount FROM `pending_inactive_table` WHERE status = 'pending'";
    $stmt = $conn->prepare($query);

    if($stmt->execute()){
        $stmtPendingResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($stmtPendingResult as $pending){
            $pendingCount = $pending['pendingcount'];
            echo $pendingCount;
        }
    }
}

function pendingStatus(){
    include 'connection.php';

    $assignNoInput = $_POST['assignNoInput'];
    $idno = $_POST['idno'];


    $query = "UPDATE `pending_inactive_table` SET status = 'inactive' WHERE idno = $idno";
    $stmt = $con->prepare($query);

    $query2 = "INSERT INTO personalinfo_inactive_table (idno,surname, firstname, middlename, ext, region, modeofinput) SELECT $assignNoInput,surname,firstname,middlename,ext,region,'transfer' FROM pending_inactive_table WHERE idno = $idno";
    $stmt2 = $con->prepare($query2);

    if($stmt2->execute()){
        if($stmt->execute()){
            echo 'success';
        }
    }
}

function testPending(){
    include 'connection.php';

    $sname = '"Dela Cruz"';
    $fname = '"Juan"';
    $mname = '"Reyes"';
    $ext = '"Sr."';
    $region = '"NCR"';

    $query = "INSERT INTO `pending_inactive_table`(`surname`, `firstname`, `middlename`, `ext`, `region`) VALUES ($sname, $fname, $mname, $ext, $region)";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        echo 'success';
    }
}


function uploadPersonalInfo(){
    include 'connection.php';

    $remarks = $_POST['remarks'];
    $idNo = $_POST['idNo'];
    $sname = $_POST['sname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $ext = $_POST['ext'];
    $region = $_POST['region'];

    $fileName = $idNo . ' ' . trim($sname,'"');

    $filePath = "docs/" . $fileName;

    // $idNo = "8";
    // $sname = '"wew"';
    // $fname = '"wew"';
    // $mname = '"wew"';
    // $ext = '"wew"';
    // $region = '"wew"';

    $query = "INSERT INTO `personalinfo_inactive_table`(`idNo`, `surname`, `firstname`, `middlename`, `ext`, `region`, `modeofinput`,`remarks`) VALUES ($idNo, UPPER($sname), UPPER($fname), UPPER($mname), UPPER($ext), $region, 'manual', $remarks)";
    $stmt = $con->prepare($query);
    // $stmt->execute();

    // if($stmt->affected_rows > 0) {
    //     echo 'success';
    //     $stmt->execute();
    // }

    if($stmt->execute()){
    //     // $stmt->execute();
        // mkdir($filePath);
        echo 'success';
        $_SESSION['insertSuccess'] = true;
    }
}

function updatePersonalInfo(){
    include 'connection.php';
    $oldidNo = $_POST['oldidNo'];
    $rowno = $_POST['rowno'];
    if($_POST['idNo']==""){
    $idNo = "NULL";
    } else {
    $idNo = $_POST['idNo'];
    }
    $remarks = $_POST['remarks'];
    $oldsname = $_POST['oldsname'];
    $sname = $_POST['sname'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $ext = $_POST['ext'];
    $region = $_POST['region'];

    $oldfileName = $rowno . ' ' . trim($oldsname,'"')  . ".pdf";
    $newfileName = $rowno . ' ' . trim($sname,'"')  . ".pdf";

    $oldfilePath = "docs/Inactive/" . $oldfileName;
    $newfilePath = "docs/Inactive/" . $newfileName;

    // $oldidNo = '1111';
    // $idNo = '39';
    // $sname = '"wew"';
    // $fname = 'wew';
    // $mname = 'wew';
    // $ext = 'wew';
    // $region = 'wew';


    // $query = "INSERT INTO `personalinfo_inactive_table`(`idNo`,`surname`, `firstname`, `middlename`, `ext`, `region`) VALUES ($idNo, $sname, $fname, $mname, $ext, $region)";
    $query = "UPDATE `personalinfo_inactive_table` SET `idNo` = $idNo, `surname` = $sname, `firstname` = $fname, `middlename` = $mname, `ext` = $ext, `region` = $region, `remarks` = $remarks WHERE `rowno` = $rowno";
    // $query = "UPDATE `personalinfo_inactive_table` SET `idNo` = $idNo, `surname` = $sname, `firstname` = $fname WHERE `idNo` = $oldidNo";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        if(file_exists($oldfilePath)){
            rename($oldfilePath, $newfilePath);
        }
        echo 'success';
        $_SESSION['editSuccess'] = true;
    }
}


// INSERT INTO personalinfo_inactive_table (surname, firstname, middlename, ext, region) SELECT surname,firstname,middlename,ext,region FROM pending_inactive_table WHERE idno = 1

?>