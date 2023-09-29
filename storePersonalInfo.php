<?php
session_start();

if(!empty($_POST['sname']) && !empty($_POST['fname']) && !empty($_POST['dob']) && !empty($_POST['pob'])
&& !empty($_POST['sex']) && !empty($_POST['civ']) && !empty($_POST['height']) && !empty($_POST['weight']) && !empty($_POST['btype'])
&& !empty($_POST['gsis']) && !empty($_POST['pagibig']) && !empty($_POST['phealth']) && !empty($_POST['sss']) && !empty($_POST['tin'])
&& !empty($_POST['empno']) && !empty($_POST['citi']) && !empty($_POST['resHouse']) && !empty($_POST['resStreet']) && !empty($_POST['resSub'])
&& !empty($_POST['resCity']) && !empty($_POST['resBrgy']) && !empty($_POST['resProv']) && !empty($_POST['resZip']) 
&& !empty($_POST['permHouse']) && !empty($_POST['permStreet']) && !empty($_POST['permSub']) && !empty($_POST['permCity'])
&& !empty($_POST['permBrgy']) && !empty($_POST['permProv']) && !empty($_POST['permZip']) && 
!empty($_POST['mobile']) && !empty($_POST['email'])){

    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
    {
        include 'connection.php';
        $query = "SELECT * FROM `personalInfo_table` WHERE `sname` = ? AND `fname` = ? AND `mname` = ? AND `ext` = ? OR `empNo` = ? OR `gsis` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssssss',$_POST['sname'],$_POST['fname'],$_POST['mname'],$_POST['ext'],$_POST['empno'],$_POST['gsis']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows < 1){
        $_SESSION['sname'] = $_POST['sname'];
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['mname'] = $_POST['mname'];
        $_SESSION['ext'] = $_POST['ext'];
        $_SESSION['dob'] = $_POST['dob'];
        $_SESSION['pob'] = $_POST['pob'];
        $_SESSION['sex'] = $_POST['sex'];
        $_SESSION['civ'] = $_POST['civ'];
        $_SESSION['height'] = $_POST['height'];
        $_SESSION['weight'] = $_POST['weight'];
        $_SESSION['btype'] = $_POST['btype'];
        $_SESSION['gsis'] = $_POST['gsis'];
        $_SESSION['pagibig'] = $_POST['pagibig'];
        $_SESSION['phealth'] = $_POST['phealth'];
        $_SESSION['sss'] = $_POST['sss'];
        $_SESSION['tin'] = $_POST['tin'];
        $_SESSION['empno'] = $_POST['empno'];
        $_SESSION['citi'] = $_POST['citi'];
        $_SESSION['resHouse'] = $_POST['resHouse'];
        $_SESSION['resStreet'] = $_POST['resStreet'];
        $_SESSION['resSub'] = $_POST['resSub'];
        $_SESSION['resCity'] = $_POST['resCity'];
        $_SESSION['resBrgy'] = $_POST['resBrgy'];
        $_SESSION['resProv'] = $_POST['resProv'];
        $_SESSION['resZip'] = $_POST['resZip'];
        
        $_SESSION['permHouse'] = $_POST['permHouse'];
        $_SESSION['permStreet'] = $_POST['permStreet'];
        $_SESSION['permSub'] = $_POST['permSub'];
        $_SESSION['permCity'] = $_POST['permCity'];
        $_SESSION['permBrgy'] = $_POST['permBrgy'];
        $_SESSION['permProv'] = $_POST['permProv'];
        $_SESSION['permZip'] = $_POST['permZip'];
        
        $_SESSION['tel'] = $_POST['tel'];
        $_SESSION['mobile'] = $_POST['mobile'];
        $_SESSION['email'] = $_POST['email'];
        
        
        echo 'nc';
        }
        else{
            echo 'duplicate';
        }  
    }
    else{
        echo 'email';
}
}
else{
    echo 'sad';
}


?>
