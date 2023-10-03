<?php

include 'table_serviceRecTable.php';
include 'table_personalInfoTable.php';

$personalInfo = new personalInfo();
$serviceRec = new serviceRec();

if(isset($_GET['proc'])){
    $proc = $_GET['proc'];
    if($proc == 'load'){
        loadServiceRecord($serviceRec);
    }
    else if($proc == 'getHistory'){
        getserveHistory($serviceRec);
    }
    else if($proc == 'edit'){
        editServeRecord($serviceRec);
    }
    else if($proc == 'upload'){
        uploadServiceRecord($personalInfo,$serviceRec);
    }
    else if($proc == 'editServe'){
        $id = $_GET['id'];
        echo loadServeRecordData($id);
    }
  
}

function loadServeRecordData($id){
    include 'connection.php';
    $query = "SELECT * FROM `servicerecord_table` WHERE `id` = ? ";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return json_encode($row);
}


function loadServiceRecord($serviceRec){
    $result =  $serviceRec->load_allRec();
    if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo ' <tr>
        <td>'.$row['name'].'</td>

        <td>'.$row['designation'].'</td>

        <td>'.$row['status'].'</td>

        <td>'.number_format($row['salary']).'/a</td>

        <td>'.$row['station'].'</td>

        <td>'.$row['branch'].'</td>

        <td style="text-align: center;">
            <button class="btn btn-outline-success p-1" id="view" value="'.$row['empNo'].'"><i class="far fa-eye"></i> | View</button>
            <button class="btn btn-outline-secondary p-1" value="'.$row['empNo'].'" id="edit"><i class="far fa-edit"></i> | Edit</button>
            <button class="btn btn-outline-primary p-1" value="'.$row['empNo'].'" id="update"><i class="fas fa-user-edit"></i> | Update</button>
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
        window.location.href="views_editservicerecord.php?id=" + empNo;
    })
    $("button#update").on("click",function(){
        var empNo = $(this).val();
        window.location.href="views_updateservicerecord.php?id=" + empNo;
    })
</script>';
}

function getserveHistory($serviceRec){
    $id = $_GET['id'];  
    $result =  $serviceRec->get_history($id);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['serveRecFrom'] != "0000-00-00" && $row['serveRecTo'] != "0000-00-00"){
                $getRecFrom = $row['serveRecFrom'];
                $getRecTo = $row['serveRecTo'];
                if($row['serveRecTo'] != 'present'){
                    $getDayTo = substr($getRecTo,strlen($getRecTo)-2);
                    $getMonthTo = substr($getRecTo,5,2);
                    $getYearTo = substr($getRecTo,0,4);
    
                    $toDate = $getMonthTo."/".$getDayTo."/".$getYearTo;
                }
                else{
                    $toDate = 'present';
                }
                $getDay = substr($getRecFrom,strlen($getRecFrom)-2);
                $getMonth = substr($getRecFrom,5,2);
                $getYear = substr($getRecFrom,0,4);
    
                
            echo '<tr class="nobord">
            <td class="text-size">'.$getMonth."/".$getDay."/".$getYear.'</td>
            <td class="text-size">'.$toDate.'</td>
            <td class="text-size">'.$row['designation'].'</td>
            <td class="text-size">'.$row['status'].'</td>
            <td class="text-size">'.number_format($row['salary'],2).'/a</td>
            <td class="text-size">'.$row['station'].'</td>
            <td class="text-size">'.$row['branch'].'</td>
            <td class="text-size">'.$row['abs'].'</td>
            <td class="text-size text-start">'.$row['cause'].'</td>
          </tr>';
        }
        }
    }
    else{
        echo '<td colspan="9" class="text-center"><h1>No Data Found</h1></td>';
    }
}

//comment2
//comment
function editServeRecord($serviceRec){
    $id = $_GET['id'];  
    $result =  $serviceRec->get_history($id);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['serveRecFrom'] != "0000-00-00" && $row['serveRecTo'] != "0000-00-00"){
                $getRecFrom = $row['serveRecFrom'];
                $getRecTo = $row['serveRecTo'];
                if($row['serveRecTo'] != 'present'){
                    $getDayTo = substr($getRecTo,strlen($getRecTo)-2);
                    $getMonthTo = substr($getRecTo,5,2);
                    $getYearTo = substr($getRecTo,0,4);
    
                    $toDate = $getMonthTo."/".$getDayTo."/".$getYearTo;
                }
                else{
                    $toDate = 'present';
                }
                $getDay = substr($getRecFrom,strlen($getRecFrom)-2);
                $getMonth = substr($getRecFrom,5,2);
                $getYear = substr($getRecFrom,0,4);
    
                
            echo '<tr class="nobord" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <td id="id">'.$row['id'].'</td>
            <td class="text-size">'.$getMonth."/".$getDay."/".$getYear.'</td>
            <td class="text-size">'.$toDate.'</td>
            <td class="text-size">'.$row['designation'].'</td>
            <td class="text-size">'.$row['status'].'</td>
            <td class="text-size">'.number_format($row['salary'],2).'/a</td>
            <td class="text-size">'.$row['station'].'</td>
            <td class="text-size">'.$row['branch'].'</td>
            <td class="text-size">'.$row['abs'].'</td>
            <td class="text-size text-start">'.$row['cause'].'</td>
          </tr>';
        }
        }
    }
    echo '<tr class="nobord">
    <td class="text-size" id="servFrom"><input class="form-control" type="date" style="width: 135px" id="servFrom"></td>
    <td class="text-size" id="servTo"><input class="form-control" type="date" style="width: 135px" id="servTo"></td>
    <td class="text-size" id="servDesig"><input class="form-control" type="text" id="servDesig"></td>
    <td class="text-size" id="servStatus"><input class="form-control" type="text" id="servStatus"></td>
    <td class="text-size" id="servSalary"><input class="form-control" type="text" id="servSalary"></td>
    <td class="text-size" id="servStation"><input class="form-control" type="text" id="servStation"></td>
    <td class="text-size" id="servBranch"><input class="form-control" type="text" id="servBranch"></td>
    <td class="text-size" id="servLv"><input class="form-control" type="text" id="servLv"></td>
    <td class="text-size text-start" id="servCause"><input class="form-control" type="text" id="servCause"></td>
    </tr>';

    echo '<script>
        $("td#id").hide();
        $("tbody#body tr").on("click",function(){
            var index = $(this).closest("tr").index();
            var id = $("tbody#body tr:eq("+index+")").find("td:eq(0)").text();
            var proc = "editServe";
            $.ajax({
                url: "proc_serviceRecord.php?proc=" + proc + "&id=" + id,
                type: "GET",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    $("input#from").val(conv.serveRecFrom);
                    $("input#des").val(conv.designation);
                    $("input#stats").val(conv.status);
                    $("input#salar").val(conv.salary);
                    $("input#place").val(conv.station);
                    $("input#brans").val(conv.branch);
                    $("input#leaves").val(conv.abs);
                    $("textarea#cause").val(conv.cause);
                }
            })

        })
    </script>';
}

function uploadServiceRecord($personalInfo,$serviceRec){
    $ServFrom = $_POST['convServFrom'];
    $ServTo = $_POST['convServTo'];
    $ServDesig = $_POST['convServDesig'];
    $ServStatus = $_POST['convServStatus'];
    $ServSalary = $_POST['convServSalary'];
    $ServStation = $_POST['convServStation'];
    $ServBranch = $_POST['convServBranch'];
    $ServLv = $_POST['convServLv'];
    $ServCause = $_POST['convServCause'];
    $id = $_POST['id'];
    $name = getName($id,$personalInfo);

    $convServFrom = explode(',',$ServFrom);
    $convServTo = explode(',',$ServTo);
    $convServDesig = explode(',',$ServDesig);
    $convServStatus = explode(',',$ServStatus);
    $convServSalary = explode(',',$ServSalary);
    $convServStation = explode(',',$ServStation);
    $convServBranch = explode(',',$ServBranch);
    $convServLv = explode(',',$ServLv);
    $convServCause = explode(',',$ServCause);

    $serviceRec->upload_serveRec($id,$name,$convServFrom,$convServTo,$convServDesig,$convServStatus,$convServSalary,$convServStation,$convServBranch,$convServLv,$convServCause);


}

function getName($id,$personalInfo){
    $result = $personalInfo->get_sglTbl('empNo',$id);
    $row = $result->fetch_assoc();
    $name = "";
    if(!empty($row['mname'])){
        $name = $row['sname'].", ".$row['fname']." ".$row['mname'].".";
    }
    else{
        $name = $row['sname'].", ".$row['fname'];
    }
    return $name;
}
?>