<?php

session_start();
include 'connection.php';

uploadPersonalInfo();
uploadFamilyBg();
uploadChild();
uploadEducBg();
uploadServeEligilibity();
uploadWorkExp();
uploadVoluntaryWork();
uploadLnd();
uploadServeRec();
uploadEmpInfo();
uploadPlantilla();





function uploadPersonalInfo(){
    include 'connection.php';
    $query = "INSERT INTO `personalInfo_table`(`sname`, `fname`, `mname`, `ext`, `dob`, `pob`, `sex`, `civilStat`, `height`, `weight`, `btype`, `gsis`, `pagibig`, `philhealth`, `sss`, `tin`, `empNo`, `citizen`, `resHouse`, `resStreet`, `resSub`, `resBrgy`, `resCity`, `resProv`, `resZip`, `permHouse`, `permStreet`, `permSub`, `permBrgy`, `permCity`, `permProv`, `permZip`, `tel`, 
    `mobile`, `email`) VALUES 
    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssssssssssssssssssssssssssssssss", $_SESSION['sname'],$_SESSION['fname'],$_SESSION['mname'],$_SESSION['ext'],
    $_SESSION['dob'],$_SESSION['pob'],$_SESSION['sex'],$_SESSION['civ'],$_SESSION['height'],$_SESSION['weight'],$_SESSION['btype'],$_SESSION['gsis'],
    $_SESSION['pagibig'],$_SESSION['phealth'],$_SESSION['sss'],$_SESSION['tin'],$_SESSION['empno'],$_SESSION['citi'],$_SESSION['resHouse'],$_SESSION['resStreet'],
    $_SESSION['resSub'],$_SESSION['resCity'],$_SESSION['resBrgy'],$_SESSION['resProv'],$_SESSION['resZip'],$_SESSION['permHouse'],$_SESSION['permStreet'],
    $_SESSION['permSub'],$_SESSION['permCity'],$_SESSION['permBrgy'],$_SESSION['permProv'],$_SESSION['permZip'],$_SESSION['tel'],$_SESSION['mobile'],$_SESSION['email']);
    $stmt->execute();
}

function uploadFamilyBg(){
    include 'connection.php';
    $query = "INSERT INTO `familybg_table`(`empNo`, `spSname`, `spFname`, `spMname`, `spExt`, `spOccu`, `spEmpName`, `spBadd`, `spTel`, `fSname`, `fFname`, `fMname`, `fExt`, `mSname`, `mFname`, `mMname`, `mExt`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssssssssssssssss',$_SESSION['gsis'],$_SESSION['spSname'],$_SESSION['spFname'],$_SESSION['spMname'],$_SESSION['spExt'],
    $_SESSION['spOccu'],$_SESSION['spEmpName'],$_SESSION['spBadd'],$_SESSION['spTel'],$_SESSION['fSname'],
    $_SESSION['fFname'],$_SESSION['fMname'],$_SESSION['fExt'],$_SESSION['mSname'],$_SESSION['mFname'],$_SESSION['mMname'],$_SESSION['mExt']);
    $stmt->execute();
}

function uploadEducBg(){
    include 'connection.php';
    $query = "INSERT INTO `educbg_table`(`empNo`, `elemSchl`, `elecDegree`, `elemFrom`, `elemTo`, `elemUnit`, `elemGrad`, `elemScho`, `secSchl`, `secDegree`, `secFrom`, `secTo`, `secUnit`, `secGrad`, `secScho`, `vocSchl`, `vocDegree`, `vocFrom`, `vocTo`, `vocUnit`, `vocGrad`, `vocScho`, `colSchl`, `colDegree`, `colFrom`, `colTo`, `colUnit`, `colGrad`, `colScho`, `gradSchl`, `gradDegree`, `gradFrom`, `gradTo`, `gradUnit`, `gradGrad`, `gradScho`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssssssssssssssssssssssssssssssssss', $_SESSION['gsis'],$_SESSION['elemSchl'],$_SESSION['elecDegree'],
    $_SESSION['elemFrom'],$_SESSION['elemTo'],$_SESSION['elemUnit'],$_SESSION['elemGrad'],$_SESSION['elemScho'],
    $_SESSION['secSch'],$_SESSION['secDegree'],$_SESSION['secFrom'],$_SESSION['secTo'],$_SESSION['secUnit'],
    $_SESSION['secGrad'],$_SESSION['secScho'],$_SESSION['vocSchl'],$_SESSION['vocDegree'],$_SESSION['vocFrom'],
    $_SESSION['vocTo'],$_SESSION['vocUnit'],$_SESSION['vocGrad'],$_SESSION['vocScho'],$_SESSION['colSchl'],$_SESSION['colDegree'],
    $_SESSION['colFrom'],$_SESSION['colTo'],$_SESSION['colUnit'],$_SESSION['colGrad'],$_SESSION['colScho'],
    $_SESSION['gradSchl'],$_SESSION['gradDegree'],$_SESSION['gradFrom'],$_SESSION['gradTo'],$_SESSION['gradUnit'],
    $_SESSION['gradGrad'],$_SESSION['gradScho']);
    $stmt->execute();
}

function uploadServeEligilibity(){
    include 'connection.php';
    $civilCareer = $_SESSION['civilCareer'];
    $civilRating = $_SESSION['civilRating'];
    $civilDoe = $_SESSION['civilDoe'];  
    $civilPoe = $_SESSION['civilPoe'];
    $civilLNum = $_SESSION['civilLNum'];
    $civilDov = $_SESSION['civilDov'];

    $convCCareer = explode(',',$civilCareer);
    $convCRating = explode(',',$civilRating);
    $convCDoe = explode(',',$civilDoe);
    $convCPoe = explode(',',$civilPoe);
    $convCLNum = explode(',',$civilLNum);
    $convCDov = explode(',',$civilDov);

    for($a = 0; $a < count($convCCareer); $a++){
        if(!empty($convCRating[$a]) && $convCDoe[$a] && $convCPoe[$a]){ 
            $query = "INSERT INTO `serveeligibility_table`(`empNo`, `title`, `rating`, `doe`, `poe`, `noh`, `dov`) 
            VALUES (?,?,?,?,?,?,?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('sssssss',$_SESSION['gsis'],$convCCareer[$a],$convCRating[$a],$convCDoe[$a],$convCPoe[$a],
            $convCLNum[$a],$convCDov[$a]);
            $stmt->execute();
        }
    }
}

function uploadWorkExp(){
    include 'connection.php';
    $convWorkFrom = $_SESSION['convWorkFrom'];
    $convWorkTo = $_SESSION['convWorkTo'];
    $convWorkPos = $_SESSION['convWorkPos'];
    $convWorkDept = $_SESSION['convWorkDept'];
    $convWorkSalary = $_SESSION['convWorkSalary'];
    $convWorkSg = $_SESSION['convWorkSg'];
    $convWorkSoa = $_SESSION['convWorkSoa'];
    $convWorkGovt = $_SESSION['convWorkGovt'];

    $workFrom = explode(",",$convWorkFrom);
    $workTo = explode(",",$convWorkTo);
    $workPos = explode(",",$convWorkPos);
    $workDept = explode(",",$convWorkDept);
    $workSalary = explode(",",$convWorkSalary);
    $workSg = explode(",",$convWorkSg);
    $workSoa = explode(",",$convWorkSoa);
    $workGovt = explode(",",$convWorkGovt);

    $query = "INSERT INTO `workexp_table`(`empNo`, `expFrom`, `expTo`, `position`, `dept`, `salary`, `sg`, `soa`, `govt`) 
    VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    for($a = 0; $a < count($workFrom); $a++){
        if($workSoa[$a] == 'PA' || $workSoa[$a] == 'P' || $workSoa[$a] == 'C'){
            $stmt->bind_param('sssssssss',$_SESSION['gsis'],$workFrom[$a],$workTo[$a],$workPos[$a],$workDept[$a],
            $workSalary[$a],$workSg[$a],$workSoa[$a],$workGovt[$a]);
            $stmt->execute();
        }
    }
        
    
}

function uploadVoluntaryWork(){

    include 'connection.php';

    $convNameOrg = $_SESSION['convNameOrg'];
    $convFindFrom = $_SESSION['convFindFrom'];
    $convTo = $_SESSION['convTo'];
    $convNoh = $_SESSION['convNoh'];
    $convPos = $_SESSION['convPos'];

    $convNameOrg = explode(',', $_SESSION['convNameOrg']);
    $convFindFrom = explode(',', $_SESSION['convFindFrom']);
    $convTo = explode(',', $_SESSION['convTo']);
    $convNoh = explode(',', $_SESSION['convNoh']);
    $convPos = explode(',', $_SESSION['convPos']);

    
    for($a = 0; $a < count($convNameOrg); $a++){
        if(!empty($convNameOrg[$a])){
            $query = "INSERT INTO `voluntarywork_table`(`empNo`, `orgName`, `volFrom`, `volTo`, `noh`, `pos`) 
            VALUES (?,?,?,?,?,?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssssss',$_SESSION['gsis'],$convNameOrg[$a],$convFindFrom[$a],$convTo[$a],$convNoh[$a],$convPos[$a]);
            $stmt->execute();
        }   
    }
}

function uploadLnd(){
    include 'connection.php';

    $convTitle = explode(',', $_SESSION['convTitle']);
    $convFrom = explode(',',$_SESSION['convFrom']);
    $convTo = explode(',',$_SESSION['convLndTo']);
    $convNoh = explode(',',$_SESSION['convNoh']);
    $convType = explode(',',$_SESSION['convType']);
    $convSponsor = explode(',',$_SESSION['convSponsor']);

    for($a = 0; $a < count($convTitle); $a++){
        if(!empty($convTitle[$a])){
            $query = "INSERT INTO `lnd_table`(`empNo`, `title`, `lndFrom`, `lndTo`, `noh`, `type`, `sponsor`) 
            VALUES (?,?,?,?,?,?,?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('sssssss',$_SESSION['gsis'], $convTitle[$a],$convFrom[$a],$convTo[$a],$convNoh[$a],
            $convType[$a],$convSponsor[$a]);
            $stmt->execute();
        }
    }
    echo 'nice';
}

function uploadChild(){
    include 'connection.php';

    $ChildNconvert = explode(",",$_SESSION['ChildNconvert']);
    $ChildBconvert = explode(",",$_SESSION['ChildBconvert']);

    for($a = 0; $a < count($ChildNconvert); $a++){
        if(!empty($ChildNconvert[$a])){
            $query = "INSERT INTO `empchild_table`(`empNo`, `childName`, `dob`) 
            VALUES (?,?,?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('sss',$_SESSION['gsis'],$ChildNconvert[$a],$ChildBconvert[$a]);
            $stmt->execute();
        }
        
    }
    
}

function uploadServeRec(){
    include 'connection.php';
    $convWorkFrom = $_SESSION['convWorkFrom'];
    $convWorkTo = $_SESSION['convWorkTo'];
    $convWorkPos = $_SESSION['convWorkPos'];
    $convWorkDept = $_SESSION['convWorkDept'];
    $convWorkSalary = $_SESSION['convWorkSalary'];
    $convWorkSoa = $_SESSION['convWorkSoa'];
    $convWorkGovt = $_SESSION['convWorkGovt'];

    $workFrom = explode(",",$convWorkFrom);
    $workTo = explode(",",$convWorkTo);
    $workPos = explode(",",$convWorkPos);
    $workDept = explode(",",$convWorkDept);
    $workSalary = explode(",",$convWorkSalary);
    $workSoa = explode(",",$convWorkSoa);
    $workGovt = explode(",",$convWorkGovt);
    $mname = $_SESSION['mname'];
    if(!empty($_SESSION['mname'])){
        $fname = $_SESSION['sname'].", ".$_SESSION['fname']." ".$mname[0].".";
    }
    else{
        $fname = $_SESSION['sname'].", ".$_SESSION['fname'];
    }
    for($a = 0; $a < count($workPos); $a++){
        if(!empty($workFrom[$a]) && $workSoa[$a] == "Casual" || $workSoa[$a] == "P"){
                $pos = $workPos[$a];
                $salary = intval($workSalary[$a]) * 12;
                $na = "N/A";
                $query = "INSERT INTO `servicerecord_table`(`empNo`, `name`, `serveRecFrom`, `serveRecTo`, `designation`, `status`, `salary`) 
                VALUES (?,?,?,?,?,?,?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssssss',$_SESSION['gsis'],$fname,$workFrom[$a],$workTo[$a],$pos,$workSoa[$a],$salary);
                $stmt->execute();
            /*else{
                $salary = intval($workSalary[$a]) * 12;
                $na = "N/A";
                $query = "INSERT INTO `servicerecord_table`(`empNo`, `name`, `serveRecFrom`, `serveRecTo`, `designation`, `status`, `salary`, `station`, `branch`, `abs/lv`, `cause`) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssssssssss',$_SESSION['gsis'],$fname,$workFrom[$a],$workTo[$a],$workPos[$a],$workSoa[$a],$salary,$na,$na,$na,$na);
                $stmt->execute();
            }*/
        }
    }
}

function uploadEmpInfo(){

    $itemNum = explode(',',$_SESSION['convWorkItemNum']);
    $posTitle = explode(',', $_SESSION['convWorkPos']);
    $sgConv = explode(',',$_SESSION['convWorkSg']);
    $soaConv = explode(',',$_SESSION['convWorkSoa']);
    $convDept = explode(',',$_SESSION['convWorkDept']);
    $sg = $sgConv[0];
    if(strlen($sg) > 3){
        $sg = substr($sg,0,2);
    }
    else{
        $sg = substr($sg,0,1);
    }
    include 'connection.php';
    $query = "INSERT INTO `emp_table`(`bpNo`, `empNo`, `item_num`, `pos_title`, `division`, `salary_grade`, `lname`, `fname`, `mname`, `ext`, `dob`, `dooa`, `dolp`, `pagibig`, `philhealth`, `sss`, `tin`, `sex`, `soa`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('sssssssssssssssssss', $_SESSION['gsis'],$_SESSION['empno'],$itemNum[0],$posTitle[0],$convDept[0],$sgConv[0],$_SESSION['sname'],$_SESSION['fname'],$_SESSION['mname'],$_SESSION['ext'],$_SESSION['dob'],
    $_SESSION['workDOA'],$_SESSION['promotion'],$_SESSION['pagibig'],$_SESSION['phealth'],$_SESSION['sss'],$_SESSION['tin'],$_SESSION['sex'],$soaConv[0]);
    $stmt->execute();
}

function uploadPlantilla(){
 
    include 'connection.php';
    
    $convWorkTo = $_SESSION['convWorkTo'];
    $convWorkPos = $_SESSION['convWorkPos'];
    $convWorkSoa = $_SESSION['convWorkSoa'];
    $civilCareer = $_SESSION['civilCareer'];
    $convWorkSg = $_SESSION['convWorkSg'];
    $convWorkItemNum = $_SESSION['convWorkItemNum'];
    
    $workSg = explode(",",$convWorkSg);
    $workSoa = explode(",",$convWorkSoa);
    $convCCareer = explode(',',$civilCareer);
    $workTo = explode(",",$convWorkTo);
    $workPos = explode(",",$convWorkPos);
    $workItemNum = explode(",",$convWorkItemNum);
    
    if($workSoa[0] == 'PA' || $workSoa[0] == "P"){
        switch($convCCareer[0]){
            case 'CIVIL SERVICE ELIGIBLE - PROFESSIONAL': $civilEligible = "CSP";
            break;
            case 'CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL': $civilEligible = "CSSP";
            break;
            case 'BAR/BOARD ELIGIBILITY': $civilEligible = "RA1080";
            break;
            case 'BARANGAY HEALTH WORKER ELIGIBLITY': $civilEligible = "BWHE";
            break;
            case 'BARANGAY NUTRITION SCHOLAR ELIGIBILITY': $civilEligible = "BNSE";
            break;
            case 'Barangay Official Eligibility': $civilEligible = "BOE";
            break;
            case 'Electronic Data Processing Specialist Eligibility': $civilEligible = "EDPSE";
            break;
            case 'Foreign School Honor Graduate Eligibility': $civilEligible = "FSHGE";
            break;
            case 'Honor Graduate Eligibility': $civilEligible = "PD907";
            break;
            case 'Sanggunian Member Eligibility': $civilEligible = "SME";
            break;
            case 'Scientific and Technological Specialists Eligibility': $civilEligible = "STSE";
            break;
            case 'Skills Eligibility - Category II': $civilEligible = 'CATII';
            break;
            case 'Veteran Preference Rating Eligibility': $civilEligible = 'VPRE';
            break;
            case 'Licensure Examination for Teachers': $civilEligible = 'LET';
            break;
            case 'Professional Drivers License': $civilEligible = 'CATIII';
            break;
        }
        $actual = intval(getActualSalary() * 12);
        $step = substr($workSg[0],strlen($workSg[0])-1,1);
        
        if(!empty($_SESSION['mname'])){
            $fname = $_SESSION['sname'].", ".$_SESSION['fname']." ".substr($_SESSION['mname'],0,1).".";
        }
        else{
            $fname = $_SESSION['sname'].", ".$_SESSION['fname'];
        }
        $sex = strtoupper(substr($_SESSION['sex'],0));
        $convTin = str_replace('-','',$_SESSION['tin']);
    
            if(checkIfPosExist($workItemNum[0])){
                $query = "UPDATE `psipop_table` SET `actual` = ?, `step` = ?, `empNo` = ?, `name`= ?,`sex`= ?,`dob`= ?,`tin`= ?,`dooa` = ?,`dolp` = ?, `status`= ?, `cse` = ? WHERE `item_num` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ssssssssssss',$actual,$step ,$_SESSION['gsis'], $fname,$sex ,$_SESSION['dob'] ,$convTin, $_SESSION['workDOA'],$_SESSION['promotion'], $workSoa[0],$civilEligible, $workItemNum[0]);
                $stmt->execute();
            }
    }
    }

    function checkIfPosExist($itemNum){
        include 'connection.php';
        $check = "SELECT * FROM `psipop_table` WHERE `item_num` = ?";
        $stmt = $con->prepare($check);
        $stmt->bind_param('s',$itemNum);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function getSalaryGrade(){
        include 'connection.php';
        $convWorkPos = $_SESSION['convWorkItemNum'];
        $workPos = explode(",",$convWorkPos);
        $query = "SELECT * FROM `psipop_table` WHERE `item_num` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$workPos[0]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['salary_grade'];
        
    }
    function getActualSalary(){
        include 'connection.php';
        $convWorkSg = $_SESSION['convWorkSg'];
        $date = date("Y");
        $workSg = explode(",",$convWorkSg);
    
        $step = substr($workSg[0],strlen($workSg[0])-1,1);
        $sg = getSalaryGrade();
        switch($step){
            case '1': $query = "SELECT `sgstep1` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep1'];
            break;
            case '2': $query = "SELECT `sgstep2` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep2'];
            break;
               
            case '3': $query = "SELECT `sgstep3` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
            return $row['sgstep3'];
            break;
               
            case '4': $query = "SELECT `sgstep4` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep4'];
            break;
                
            case '5': $query = "SELECT `sgstep5` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep5'];
            break;
               
            case '6': $query = "SELECT `sgstep6` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
            $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep6'];
            break;
                
            case '7': $query = "SELECT `sgstep7` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
            $stmt = $con->prepare($query);
                $stmt->bind_param('ss',$sg,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['sgstep7'];
            break;
            
            case '8': $query = "SELECT `sgstep8` FROM `salarygrade` WHERE `level` = ? AND `yearOfValidity` = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ss',$sg,$date);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['sgstep8'];
            break;
        }
    }

function getPos($id){
    include 'connection.php';
    $query = "SELECT * FROM `psipop_table` WHERE `id` = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['pos_title'];
}




?>