<?php
include 'table_serviceRecTable.php';
include 'table_personalInfoTable.php';
include 'table_rnr.php';

$personalInfo = new personalInfo();
$serviceRec = new serviceRec();
$Rnrrec = new Rnrrec();

if(isset($_GET['proc'])){
    $proc = $_GET['proc'];
    if($proc == 'load'){
        loadlistofservicerec($serviceRec);
    }else if($proc == 'upload'){
        uploadrnrrec($serviceRec,$Rnrrec);
    }
}
    function loadlistofservicerec($serviceRec){
        $result =  $serviceRec->load_allRec();
        if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo ' <tr>
            <td>'.$row['name'].'</td>
    
            <td>'.$row['designation'].'</td>
                
            <td style="text-align: center;">
                <button class="btn btn-outline-success p-1" id="view" value="'.$row['empNo'].'"><i class="far fa-eye"></i> |  Leave Balance</button>
                <button class="btn btn-outline-secondary p-1" value="'.$row['empNo'].'" id="edit"><i class="far fa-edit"></i> | Manage Leave </button>
            </td>
        </tr>';
        }
    }
    else{
        echo '<tr>
            <td colspan="7" class="text-center"><h1>No Record Found</h1></td>
        </tr>';
    }
    echo '<script>
    $("button#view").on("click",function(){
        var empNo = $(this).val();
        window.location.href="views_servRecHistory.php?id=" + empNo;
    })
    $("button#edit").on("click",function(){
        var empNo = $(this).val();
        window.location.href="leavemanage.php?id=" + empNo;
        alert(empNo);
    })
 
</script>';
}
  

function uploadrnrrec($serviceRec,$Rnrrec){
    $day = $_POST['day'];
    $hrs = $_POST['hrs'];
    $min = $_POST['min'];
    $id = $_POST['id'];
    $leavetype = $_POST['leavetype'];
    $auwp = $_POST['auwp'];
    $auwop = $_POST['auwop'];
    $leavedate = $_POST['leavedate'];
  
    $Rnrrec->upload_rnrrec($id,$day,$hrs,$min,$leavetype,$auwp,$auwop,$leavedate);
    echo 'nice';

}









?>