<?php 
session_start();

if(isset($_POST['pcrSelected'])){
    uploadPcr();
}else if(isset($_POST['opcrUp'])){
    uploadOpcr();
}else if(isset($_POST['ipcrUp'])){
    uploadIpcr();
}else if(isset($_POST['dpcrUp'])){
    uploadDpcr();
}else if(isset($_POST['pmcrUp'])){
    uploadPmcr();
}else if(isset($_POST['firstEditionUpload'])){
    uploadSpmsFirst();
}else if(isset($_POST['EnhanceEditionUpload'])){
    uploadSpmsEnhanced();
}else if(isset($_POST['addYearDirectory'])){
    createYearDirectory();
} 
// my file darwin
elseif(isset($_POST['nosiUp'])){
    $month = $_POST['nosimonthselect' . $_POST['empno']];
    if ($month == "January") {$convmonth = "1";}
    else if ($month == "February") {$convmonth = "2";}
    else if ($month == "March") {$convmonth = "3";}
    else if ($month == "April") {$convmonth = "4";}
    else if ($month == "May") {$convmonth = "5";}
    else if ($month == "June") {$convmonth = "6";}
    else if ($month == "July") {$convmonth = "7";}
    else if ($month == "August") {$convmonth = "8";}
    else if ($month == "September") {$convmonth = "9";}
    else if ($month == "October") {$convmonth = "10";}
    else if ($month == "November") {$convmonth = "11";}
    else if ($month == "December") {$convmonth = "12";}
    else {
        $convmonth = ""; // Assign a default value or handle the non-January case
    }

    $datetoday = $_POST['nosimonthselect' . $_POST['empno']] . " " . $_POST['nosidayselect' . $_POST['empno']] . ", " . $_POST['yearSelected'];
    uploadNosi($datetoday,$convmonth);

}else if(isset($_POST['nosaUp'])){
    $month = $_POST['nosamonthselect' . $_POST['empno']];
    if ($month == "January") {$convmonth = "1";}
    else if ($month == "February") {$convmonth = "2";}
    else if ($month == "March") {$convmonth = "3";}
    else if ($month == "April") {$convmonth = "4";}
    else if ($month == "May") {$convmonth = "5";}
    else if ($month == "June") {$convmonth = "6";}
    else if ($month == "July") {$convmonth = "7";}
    else if ($month == "August") {$convmonth = "8";}
    else if ($month == "September") {$convmonth = "9";}
    else if ($month == "October") {$convmonth = "10";}
    else if ($month == "November") {$convmonth = "11";}
    else if ($month == "December") {$convmonth = "12";}
    else {
        $convmonth = ""; // Assign a default value or handle the non-January case
    }

    $datetoday = $_POST['nosamonthselect' . $_POST['empno']] . " " . $_POST['nosadayselect' . $_POST['empno']] . ", " . $_POST['yearSelected'];
    uploadNosa($datetoday,$convmonth);

}else if(isset($_POST['salnUp'])){
    $month = $_POST['salnmonthselect' . $_POST['empno']];
    if ($month == "January") {$convmonth = "1";}
    else if ($month == "February") {$convmonth = "2";}
    else if ($month == "March") {$convmonth = "3";}
    else if ($month == "April") {$convmonth = "4";}
    else if ($month == "May") {$convmonth = "5";}
    else if ($month == "June") {$convmonth = "6";}
    else if ($month == "July") {$convmonth = "7";}
    else if ($month == "August") {$convmonth = "8";}
    else if ($month == "September") {$convmonth = "9";}
    else if ($month == "October") {$convmonth = "10";}
    else if ($month == "November") {$convmonth = "11";}
    else if ($month == "December") {$convmonth = "12";}
    else {
        $convmonth = ""; // Assign a default value or handle the non-January case
    }

    $datetoday = $_POST['salnmonthselect' . $_POST['empno']] . " " . $_POST['salndayselect' . $_POST['empno']] . ", " . $_POST['yearSelected'];
    uploadSaln($datetoday,$convmonth);

}else if(isset($_POST['coeUp'])){
    $month = $_POST['coemonthselect' . $_POST['empno']];
    if ($month == "January") {$convmonth = "1";}
    else if ($month == "February") {$convmonth = "2";}
    else if ($month == "March") {$convmonth = "3";}
    else if ($month == "April") {$convmonth = "4";}
    else if ($month == "May") {$convmonth = "5";}
    else if ($month == "June") {$convmonth = "6";}
    else if ($month == "July") {$convmonth = "7";}
    else if ($month == "August") {$convmonth = "8";}
    else if ($month == "September") {$convmonth = "9";}
    else if ($month == "October") {$convmonth = "10";}
    else if ($month == "November") {$convmonth = "11";}
    else if ($month == "December") {$convmonth = "12";}
    else {
        $convmonth = ""; // Assign a default value or handle the non-January case
    }

    $datetoday = $_POST['coemonthselect' . $_POST['empno']] . " " . $_POST['coedayselect' . $_POST['empno']] . ", " . $_POST['yearSelected'];
    uploadCoe($datetoday,$convmonth);

}elseif(isset($_POST['pdsUp'])){
    $month = $_POST['pdsmonthselect' . $_POST['bpNo']];
    if ($month == "January") {$convmonth = "1";}
    else if ($month == "February") {$convmonth = "2";}
    else if ($month == "March") {$convmonth = "3";}
    else if ($month == "April") {$convmonth = "4";}
    else if ($month == "May") {$convmonth = "5";}
    else if ($month == "June") {$convmonth = "6";}
    else if ($month == "July") {$convmonth = "7";}
    else if ($month == "August") {$convmonth = "8";}
    else if ($month == "September") {$convmonth = "9";}
    else if ($month == "October") {$convmonth = "10";}
    else if ($month == "November") {$convmonth = "11";}
    else if ($month == "December") {$convmonth = "12";}
    else {
        $convmonth = ""; // Assign a default value or handle the non-January case
    }

    $datetoday = $_POST['pdsmonthselect' . $_POST['bpNo']] . " " . $_POST['pdsdayselect' . $_POST['bpNo']] . ", " . $_POST['yearSelected'];
    uploadPds($datetoday,$convmonth);

}
// --------------------------

else {
    uploadFiles();
}

function createYearDirectory(){
    include 'connection.php';

    $yearFolder = $_POST['yearInput'];
    $folderPath = "pmupload/" . $yearFolder;
    $opcrPath = $folderPath . "/OPCR";
    $dpcrPath = $folderPath . "/DPCR";
    $ipcrPath = $folderPath . "/IPCR";
    $pmcrPath = $folderPath . "/PMCR";
    $nosaPath = $folderPath . "/NOSA";
    $nosiPath = $folderPath . "/NOSI";
    $salnPath = $folderPath . "/SALN";
    $coePath = $folderPath . "/COE";
    $pdsPath = $folderPath . "/PDS";

    $query = "INSERT INTO `performance_rating_year`(`year`) VALUES ($yearFolder)";
    $stmt = $con->prepare($query);

    if($stmt->execute()){
        mkdir($folderPath);
        mkdir($opcrPath);
        mkdir($dpcrPath);
        mkdir($ipcrPath);
        mkdir($pmcrPath);
        mkdir($nosaPath);
        mkdir($nosiPath);
        mkdir($salnPath);
        mkdir($coePath);
        mkdir($pdsPath);
    }
}

function uploadSpmsFirst(){
    include 'connection.php';

        $file_tmp = $_FILES['spmsDocs']['tmp_name'];
        $to = "spms/firstEdition.pdf";        

        if(move_uploaded_file($file_tmp, $to)){
            if($stmtPending->execute()){
            } else {
                $_SESSION['uploadSuccess'] = false;            
            }
        } else {
            $_SESSION['uploadSuccess'] = false;
        }
    
    }

    function uploadSpmsEnhanced(){
        include 'connection.php';
    
            $file_tmp = $_FILES['spmsDocs']['tmp_name'];
            $to = "spms/enhancedEdition.pdf";        
    
            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                    $_SESSION['uploadSuccess'] = false;            
                }
            } else {
                $_SESSION['uploadSuccess'] = false;
            }
        
        }

function uploadOpcr(){
    include 'connection.php';
            
        $region = $_POST['region'];
        $yearSelected = $_POST['yearSelected'];

        if(isset($_POST['opcr1'])){
            $newfileName = trim($region,'"') . ' - 1st' . ".pdf";
            $stmtPending = $con->prepare("INSERT INTO `opcr_monitoring_table`(`region`, `year`, `firsthalf`) VALUES ('$region', $yearSelected, '1') ON DUPLICATE KEY UPDATE `firsthalf` = '1'");
        }else if(isset($_POST['opcr2'])){
            $newfileName = trim($region,'"') . ' - 2nd' . ".pdf"; 
            $stmtPending = $con->prepare("INSERT INTO `opcr_monitoring_table`(`region`, `year`, `secondhalf`) VALUES ('$region', $yearSelected, '1') ON DUPLICATE KEY UPDATE `secondhalf` = '1'");
        }else if(isset($_POST['opcrTarget'])){
            $newfileName = trim($region,'"') . ' - Target' . ".pdf"; 
            $stmtPending = $con->prepare("INSERT INTO `opcr_monitoring_table`(`region`, `year`, `target`) VALUES ('$region', $yearSelected, '1') ON DUPLICATE KEY UPDATE `target` = '1'");
        }

     
        $file_tmp = $_FILES['pcrDocs']['tmp_name'];
        $to = "pmupload/" . $yearSelected  . '/OPCR/' . $newfileName;

        if(move_uploaded_file($file_tmp, $to)){
            if($stmtPending->execute()){
            } else {
                $_SESSION['uploadSuccess'] = false;            
            }
        } else {
            $_SESSION['uploadSuccess'] = false;
        }
    
    }

    function uploadIpcr(){
        include 'connection.php';
                
            $empId = $_POST['empNo'];
            $sname = $_POST['sname'];
            $yearSelected = $_POST['yearSelected'];
    
            if(isset($_POST['ipcr1'])){
                $newfileName = trim($empId,'"') . ' ' . trim($sname,'"') . ' - 1st' . ".pdf";
                $stmtPending = $con->prepare("INSERT INTO `ipcr_monitoring_table`(`empno`, `year`, `firsthalf`) VALUES ('$empId', '$yearSelected', '1') ON DUPLICATE KEY UPDATE `firsthalf` = '1'");
            }else if(isset($_POST['ipcr2'])){
                $newfileName = trim($empId,'"') . ' ' . trim($sname,'"')  . ' - 2nd' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `ipcr_monitoring_table`(`empno`, `year`, `secondhalf`) VALUES ('$empId', '$yearSelected', '1') ON DUPLICATE KEY UPDATE `secondhalf` = '1'");
            }else if(isset($_POST['ipcrTarget'])){
                $newfileName = trim($empId,'"') . ' ' . trim($sname,'"')  . ' - Target' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `ipcr_monitoring_table`(`empno`, `year`, `target`) VALUES ('$empId', '$yearSelected', '1') ON DUPLICATE KEY UPDATE `target` = '1'");
            }
         
            $file_tmp = $_FILES['pcrDocs']['tmp_name'];
            $to = "pmupload/" . $yearSelected  . '/IPCR/' . $newfileName;

            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                }
            } else {
            }        
    
        }

    function uploadPmcr(){
        include 'connection.php';
                
            $empId = $_POST['empNo'];
            $sname = $_POST['sname'];
            $yearSelected = $_POST['yearSelected'];
    
            if(isset($_POST['pmcr1'])){
                $newfileName = $empId . ' ' . trim($sname,'"') . ' - 1st' . ".pdf";
                $stmtPending = $con->prepare("INSERT INTO `pmcr_monitoring_table`(`emp_id`, `year`, `firsthalf`) VALUES ('$empId', $yearSelected, '1') ON DUPLICATE KEY UPDATE `firsthalf` = '1'");
            }else if(isset($_POST['pmcr2'])){
                $newfileName = $empId . ' ' . trim($sname,'"')  . ' - 2nd' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `pmcr_monitoring_table`(`emp_id`, `year`, `secondhalf`) VALUES ('$empId', $yearSelected, '1') ON DUPLICATE KEY UPDATE `secondhalf` = '1'");
            }else if(isset($_POST['pmcrTarget'])){
                $newfileName = $empId . ' ' . trim($sname,'"')  . ' - Target' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `pmcr_monitoring_table`(`emp_id`, `year`, `target`) VALUES ('$empId', $yearSelected, '1') ON DUPLICATE KEY UPDATE `target` = '1'");
            }
         
            $file_tmp = $_FILES['pcrDocs']['tmp_name'];
            $to = "pmupload/" . $yearSelected  . '/PMCR/' . $newfileName;

            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                    $_SESSION['uploadSuccess'] = false;            
                }
            } else {
                $_SESSION['uploadSuccess'] = false;
            }        
    
        }

    
    function uploadDpcr(){
        include 'connection.php';
                
            $division = $_POST['division'];
            $yearSelected = $_POST['yearSelected'];
    
            if(isset($_POST['dpcr1'])){
                $newfileName = trim($division,'"') . ' - 1st' . ".pdf";
                $stmtPending = $con->prepare("INSERT INTO `dpcr_monitoring_table`(`division`, `year`, `firsthalf`) VALUES ('$division', $yearSelected, '1') ON DUPLICATE KEY UPDATE `firsthalf` = '1'");
            }else if(isset($_POST['dpcr2'])){
                $newfileName = trim($division,'"')  . ' - 2nd' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `dpcr_monitoring_table`(`division`, `year`, `secondhalf`) VALUES ('$division', $yearSelected, '1') ON DUPLICATE KEY UPDATE `secondhalf` = '1'");
            }else if(isset($_POST['dpcrTarget'])){
                $newfileName = trim($division,'"')  . ' - Target' . ".pdf"; 
                $stmtPending = $con->prepare("INSERT INTO `dpcr_monitoring_table`(`division`, `year`, `target`) VALUES ('$division', $yearSelected, '1') ON DUPLICATE KEY UPDATE `target` = '1'");
            }
         
            $file_tmp = $_FILES['pcrDocs']['tmp_name'];
            $to = "pmupload/" . $yearSelected  . '/DPCR/' . $newfileName;

            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                    $_SESSION['uploadSuccess'] = false;            
                }
            } else {
                $_SESSION['uploadSuccess'] = false;
            }        
    
        }


function uploadPcr(){
include 'connection.php';

    $pcr = $_POST['pcrSelected'];
    $empNo = $_POST['empNo'];
    $sname = $_POST['sname'];
    $yearSelected = $_POST['yearSelected'];
    $newfileName = strtoupper($pcr) . ' ' . $empNo . ' ' . trim($sname,'"')  . ".pdf"; 
 
    $file_tmp = $_FILES['pcrDocs']['tmp_name'];
    $to = "pmupload/" . $yearSelected  . '/' . $pcr . '/' . $newfileName;
    

    $stmtPending = $con->prepare("INSERT INTO `monitoring_submission_table`(`emp_id`, `year`, `$pcr`) VALUES ($empNo, $yearSelected, '1') ON DUPLICATE KEY UPDATE $pcr = '1'"); 

    if(move_uploaded_file($file_tmp, $to)){
        if($stmtPending->execute()){
            $_SESSION['uploadSuccess'] = true;
        } else {
            $_SESSION['uploadSuccess'] = false;            
        }
    } else {
        $_SESSION['uploadSuccess'] = false;
    }

    if($pcr == 'opcr'){
        header("Location:views_opcrUpload.php");
    }else if($pcr == 'dpcr'){
        header("Location:views_dpcrUpload.php");
    }else if($pcr == 'ipcr'){
        header("Location:views_ipcrUpload.php");
    }else if($pcr == 'pmcr'){
        header("Location:views_pmcrUpload.php");
    } else {
        
    }
}

function uploadFiles(){

    include 'connection.php';

    $idNo = $_POST['idNo'];
    $rowno = $_POST['rowno'];
    $empName = $_POST['empName'];
    $sname = $_POST['sname'];
    $newfileName = $rowno . ' ' . trim($sname,'"')  . ".pdf";


    $_SESSION['empNo'] = $idNo;
    $_SESSION['empName'] = $empName;
    $_SESSION['rowno'] = $rowno;
    $_SESSION['sname'] = $sname;
    
 
    if(isset($_FILES['activeDocs'])){
        $file_tmp = $_FILES['activeDocs']['tmp_name'];
        $to = "docs/Active/" . $newfileName;
        $_SESSION['filePath'] = $to;
        $_SESSION['folderSelect'] = 'activeDocs';
        move_uploaded_file($file_tmp, $to);
        
    } else if(isset($_FILES['inactiveDocs'])){
        $file_tmp = $_FILES['inactiveDocs']['tmp_name'];
        $to = "docs/Inactive/" . $newfileName;
        $_SESSION['filePath'] = $to;
        $_SESSION['folderSelect'] = 'inactiveDocs';
        if(move_uploaded_file($file_tmp, $to)){
            $query = "UPDATE `personalinfo_inactive_table` SET filecheck = '1' WHERE idno = $idNo";
            $stmt = $con->prepare($query);
            $stmt->execute();
        } 

    }

    header("Location:views_201FilesActive.php");
}




// my file darwin 

function uploadNosi($datetoday, $convmonth){
    include 'connection.php';
        $dateupload = date("F j, Y"); 
        $empId = $_POST['empno'];
        $sname = $_POST['sname'];
        $yearSelected = $_POST['yearSelected'];

        $newfileName = $empId . ' ' . trim($sname,'"') . ".pdf";
        $stmtPending = $con->prepare("INSERT INTO `nosi_monitoring_table`(`empNo`, `year`, `nosi`, `month`, `datetoday`, `dateupload`) VALUES ('$empId', $yearSelected, '1', '$convmonth', '$datetoday', '$dateupload') ON DUPLICATE KEY UPDATE `month`='$convmonth', `datetoday`='$datetoday', `dateupload`='$dateupload'");
 
     
        $file_tmp = $_FILES['pcrDocs']['tmp_name'];
        $to = "pmupload/" . $yearSelected  . '/NOSI/' . $newfileName;

        if(move_uploaded_file($file_tmp, $to)){
            if($stmtPending->execute()){
            } else {
                $_SESSION['uploadSuccess'] = false;            
            }
        } else {
            $_SESSION['uploadSuccess'] = false;
        }       
    }

    function uploadNosa($datetoday, $convmonth){
        include 'connection.php';
            $dateupload = date("F j, Y"); 
            $empId = $_POST['empno'];
            $sname = $_POST['sname'];
            $yearSelected = $_POST['yearSelected'];

            $newfileName = $empId . ' ' . trim($sname,'"') . ".pdf";
            $stmtPending = $con->prepare("INSERT INTO `nosa_monitoring_table`(`empNo`, `year`, `nosa`, `month`, `datetoday`, `dateupload`) VALUES ('$empId', $yearSelected, '1', '$convmonth', '$datetoday', '$dateupload') ON DUPLICATE KEY UPDATE `month`='$convmonth', `datetoday`='$datetoday', `dateupload`='$dateupload'");
    
        
            $file_tmp = $_FILES['pcrDocs']['tmp_name'];
            $to = "pmupload/" . $yearSelected  . '/NOSA/' . $newfileName;

            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                    $_SESSION['uploadSuccess'] = false;            
                }
            } else {
                $_SESSION['uploadSuccess'] = false;
            }        

    }
    function uploadSaln($datetoday, $convmonth){
        include 'connection.php';
            $dateupload = date("F j, Y"); 
            $empId = $_POST['empno'];
            $sname = $_POST['sname'];
            $yearSelected = $_POST['yearSelected'];
    
            $newfileName = $empId . ' ' . trim($sname,'"') . ".pdf";
            $stmtPending = $con->prepare("INSERT INTO `saln_monitoring_table`(`empNo`, `year`, `saln`, `month`, `datetoday`, `dateupload`) VALUES ('$empId', $yearSelected, '1', '$convmonth', '$datetoday', '$dateupload') ON DUPLICATE KEY UPDATE `month`='$convmonth', `datetoday`='$datetoday', `dateupload`='$dateupload'");
     
         
            $file_tmp = $_FILES['pcrDocs']['tmp_name'];
            $to = "pmupload/" . $yearSelected  . '/SALN/' . $newfileName;
    
            if(move_uploaded_file($file_tmp, $to)){
                if($stmtPending->execute()){
                } else {
                    $_SESSION['uploadSuccess'] = false;            
                }
            } else {
                $_SESSION['uploadSuccess'] = false;
            }       
        }
        function uploadCoe($datetoday, $convmonth){
            include 'connection.php';
                $dateupload = date("F j, Y"); 
                $empId = $_POST['empno'];
                $sname = $_POST['sname'];
                $yearSelected = $_POST['yearSelected'];
        
                $newfileName = $empId . ' ' . trim($sname,'"') . ".pdf";
                $stmtPending = $con->prepare("INSERT INTO `coe_monitoring_table`(`empNo`, `year`, `coe`, `month`, `datetoday`, `dateupload`) VALUES ('$empId', $yearSelected, '1', '$convmonth', '$datetoday', '$dateupload') ON DUPLICATE KEY UPDATE `month`='$convmonth', `datetoday`='$datetoday', `dateupload`='$dateupload'");
         
             
                $file_tmp = $_FILES['pcrDocs']['tmp_name'];
                $to = "pmupload/" . $yearSelected  . '/COE/' . $newfileName;
        
                if(move_uploaded_file($file_tmp, $to)){
                    if($stmtPending->execute()){
                    } else {
                        $_SESSION['uploadSuccess'] = false;            
                    }
                } else {
                    $_SESSION['uploadSuccess'] = false;
                }       
            }
        
            function uploadPds($datetoday, $convmonth){
                include 'connection.php';
                    $dateupload = date("F j, Y"); 
                    $empId = $_POST['bpNo'];
                    $lname = $_POST['lname'];
                    $yearSelected = $_POST['yearSelected'];
            
                    $newfileName = $empId . ' ' . trim($lname,'"') . ".pdf";
                    $stmtPending = $con->prepare("INSERT INTO `pds_monitoring_table`(`pdsempNo`, `year`, `pds`, `month`, `datetoday`, `dateupload`) VALUES ('$empId', $yearSelected, '1', '$convmonth', '$datetoday', '$dateupload') ON DUPLICATE KEY UPDATE `month`='$convmonth', `datetoday`='$datetoday', `dateupload`='$dateupload'");
             
                 
                    $file_tmp = $_FILES['pcrDocs']['tmp_name'];
                    $to = "pmupload/" . $yearSelected  . '/PDS/' . $newfileName;
            
                    if(move_uploaded_file($file_tmp, $to)){
                        if($stmtPending->execute()){
                        } else {
                            $_SESSION['uploadSuccess'] = false;            
                        }
                    } else {
                        $_SESSION['uploadSuccess'] = false;
                    }       
                }
        // --------------------

        //for contract uploads
            function uploadJocontract(){
                include 'connection.php';
                $empId = $_POST['empNo'];
                $sname = $_POST['sname'];
                $yearSelected = $_POST['yearSelected'];
        
                $newfileName = $empId . ' ' . trim($sname,'"') . ".pdf";
                $stmtPending = $con->prepare("INSERT INTO `jo_contract_table`(`empNo`, `year`, `first_quarter`) VALUES ('$empId', $yearSelected, '1') ON DUPLICATE KEY UPDATE `first_quarter` = '1'");
        
                
                $file_tmp = $_FILES['pcrDocs']['tmp_name'];
                $to = "pmupload/" . $yearSelected  . '/JOCONTRACT/' . $newfileName;
        
                if(move_uploaded_file($file_tmp, $to)){
                    if($stmtPending->execute()){
                    } else {
                        $_SESSION['uploadSuccess'] = false;            
                    }
                } else {
                    $_SESSION['uploadSuccess'] = false;
                }       
            }

?>