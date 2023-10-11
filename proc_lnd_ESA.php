<?php
include 'table_lnd.php';
include 'table_lnd_expenses.php';
$semExp = new expenses();
$lnd = new lnd();

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action == 'upload'){
        $title = $_POST['title'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $smt = $_POST['smt'];
        $nh = $_POST['nh'];
        $type = $_POST['type'];
        $venue = $_POST['venue'];
        $total = $_POST['total'];
        $expenses = $_POST['exp'];
        $amount = $_POST['am'];
        $explodeExpenses = explode(',',$expenses);
        $explodeAmount = explode(',',$amount);
        $newExp = "";
        $newAmount = "";
        for($a = 0; $a < count($explodeAmount);$a++){
            if($explodeExpenses[$a] != "" && $explodeAmount[$a] != ""){
                $newExp .= $explodeExpenses[$a].",";
                $newAmount .= $explodeAmount[$a].",";
            }
        }
        $obj = $_POST['obj'];
        $rem = $_POST['rem'];
        $am = $_POST['am'];
        $exp = $_POST['exp'];
        $ref_file = $_FILES['file'];
        $ref_file_name = "";
        for($a = 0;$a < count($ref_file['name']);$a++){
            $file_name = $ref_file['name'][$a];
            $ref_tmp = $ref_file['tmp_name'][$a];
            $ref_error = $ref_file['error'][$a];
            if($ref_error === 0){
                $ref_file_dest = 'uploads/reference_files/'.$file_name;
                move_uploaded_file($ref_tmp,$ref_file_dest);
                $ref_file_name .= $file_name . ',';
            }
        }
        $conv_ref_file_name = substr($ref_file_name,0,-1);
        $oo_to = $_FILES['oo'];
        $oo_file_name = $oo_to['name'];
        $oo_file_tmp = $oo_to['tmp_name'];
        $oo_error = $oo_to['error'];
        if($oo_error === 0){
            $file_dest = "uploads/officeOrder_TravelOrder/". $oo_file_name;
            move_uploaded_file($oo_file_tmp,$file_dest);
            insert($lnd,$title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$newExp,$newAmount,$total,$oo_file_name,$obj,$conv_ref_file_name,$rem);
        }
    }

    if($action == "loadSeminar"){
        $result = $lnd->getAll();
            echo '<option hidden>Select Title of Seminar</hidden>';
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                //echo $row['title'].",";
                echo '<option value="'.$row['title'].'">'.$row['title'].'</option>';
            }
        }
        else{
            echo '<option disabled>No Data Found</option>';
        }
    }

    if($action == 'getDOS'){
        $id = $_POST['id'];
        $result = $lnd->getSpecificData($id);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }

    if($action == 'uploadNew'){
        $title = $_POST['title'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $smt = $_POST['smt'];
        $nh = $_POST['nh'];
        $type = $_POST['type'];
        $venue = $_POST['venue'];
        $total = $_POST['total'];
        $expenses = $_POST['exp'];
        $amount = $_POST['am'];

        $id = $_POST['id'];
        $name = $_POST['name'];
        $sg = $_POST['sg'];
        $pos = $_POST['pos'];
        $off = $_POST['off'];

        $explodeId = explode(',',$id);
        $explodeName = explode(',',$name);
        $explodeSg = explode(',',$sg);
        $explodePos = explode(',',$pos);
        $explodeOff = explode(',',$off);

        for($c = 0; $c < count($explodeId); $c++){  
            if(!empty($explodeId[$c]) || !empty($explodeName[$c]) || !empty($explodeSg[$c]) || !empty($explodePos[$c]) || !empty($explodeOff[$c])){
                include 'connection.php';
                $query = "INSERT INTO `lnd_table`(`empNo`, `title`, `lndFrom`, `lndTo`, `noh`, `type`, `sponsor`) 
                VALUES (?,?,?,?,?,?,?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssssss',$explodeId[$c],$title,$dateFrom,$dateTo,$nh,$type,$smt);
                $stmt->execute();
            }
        }

        $explodeExpenses = explode(',',$expenses);
        $explodeAmount = explode(',',$amount);
        $newExp = "";
        $newAmount = "";
        for($a = 0; $a < count($explodeAmount);$a++){
            if($explodeExpenses[$a] != "" && $explodeAmount[$a] != ""){
                $newExp .= $explodeExpenses[$a].",";
                $newAmount .= $explodeAmount[$a].",";
            }
        }
        $obj = $_POST['obj'];
        $rem = $_POST['rem'];
        $am = $_POST['am'];
        $exp = $_POST['exp'];
        $ref_file = $_FILES['file'];
        $ref_file_name = "";
        for($a = 0;$a < count($ref_file['name']);$a++){
            $file_name = $ref_file['name'][$a];
            $ref_tmp = $ref_file['tmp_name'][$a];
            $ref_error = $ref_file['error'][$a];
            if($ref_error === 0){
                $ref_file_dest = 'uploads/reference_files/'.$file_name;
                move_uploaded_file($ref_tmp,$ref_file_dest);
                $ref_file_name .= $file_name . ',';
            }
        }
        $conv_ref_file_name = substr($ref_file_name,0,-1);
        $oo_to = $_FILES['oo'];
        $oo_file_name = $oo_to['name'];
        $oo_file_tmp = $oo_to['tmp_name'];
        $oo_error = $oo_to['error'];
        if($oo_error === 0){
            $file_dest = "uploads/officeOrder_TravelOrder/". $oo_file_name;
            move_uploaded_file($oo_file_tmp,$file_dest);
            insert($lnd,$title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$newExp,$newAmount,$total,$oo_file_name,$obj,$conv_ref_file_name,$rem);

        }
    }

    if($action == 'load'){
        $result = $lnd->getAll();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo ' <tr data-bs-toggle="modal" data-bs-target="#exampleModal2">
                <td id="title">'.$row['title'].'</td>
                <td id="dateFrom">'.$row['dateFrom'].'</td>
                <td id="dateTo">'.$row['dateTo'].'</td>
                <td id="nh">'.$row['noHours'].'</td>
                <td id="type">'.$row['typeLnd'].'</td>
                </tr>';
            }
        }
        else{
            echo "<tr><td colspan='8' class='text-center'><h1>No Data Found</h1></td></tr>";
        }
        echo '<script>
        var title,dateFrom,dateTo;
        $("table#mainTable2 tbody tr").on("click",function(){
            var row = $(this).closest("tr").index();
            var action = "getData";
            $("li#refList").remove();
            $("tr#exp").remove();
            $("table#mainTable2 tbody tr:eq("+row+")").each(function(){
                title = $(this).find("td#title").text();
                dateFrom = $(this).find("td#dateFrom").text();
                dateTo = $(this).find("td#dateTo").text();
            })
            $.ajax({
                data: {action:action, title:title,dateFrom:dateFrom,dateTo:dateTo},
                type: "POST",
                url: "proc_lnd.php",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    var dateFrom = conv.dateFrom;
                    var dateTo = conv.dateTo;
                    var exp = conv.expenses;
                    var am = conv.amount;
                    var convAm = am.split(",")
                    var convExp = exp.split(",")
                    var ref = conv.ref;
                    var convRef = ref.split(",")
                    var total = conv.total;
                    for(var b = 0; b < convRef.length; b++){
                        $("ul#reference").append("<li id='."'".'refList'."'".'><a href='."'".'uploads/reference_files/"+convRef[b]+"'."'".'>"+convRef[b]+"</a></li>")
                    }
                    for(var a = 0; a < convExp.length; a++){
                        var convAmount = Number(convAm[a])
                        $("table#table_expenses tbody").append("<tr id='."'".'exp'."'".'><td>"+convExp[a]+"</td><td>Php "+convAmount.toLocaleString()+"</td></tr>")
                    }
                    var dateFromConv = dateFrom.substr(5,2) + "/" + dateFrom.substr(-2) + "/" + dateFrom.substr(0,4)
                    var dateToConv = dateTo.substr(5,2) + "/" + dateTo.substr(-2) + "/" + dateTo.substr(0,4)
                    $("span#modalTitle").text(conv.title);
                    $("#modalType").text(conv.typeLnd);
                    $("#modalCond").text(conv.smt);
                    $("#date").text(dateFromConv + " - " + dateToConv);
                    $("#modalVenue").text(conv.venue);
                    $("#modaRemarks").text(conv.rem);
                    $("#modalOfficeOrder").attr("href","uploads/officeOrder_TravelOrder/" + conv.officeOrder);
                    $("#modalOfficeOrder").text(conv.officeOrder);
                    $("#modalObj").text(conv.obj)
                    $("#modalTotal").text("Php " + total.toLocaleString("en-US"))
                }
            })
           
        })</script>';
    }

    if($action == "getData"){
        $title = $_POST['title'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $result = $lnd->getData($title,$dateFrom,$dateTo);
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
}

function insert($lnd,$title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$exp,$am,$total,$oo_file_name,$obj,$ref_name,$rem){
    $lnd->insert($title,$dateFrom,$dateTo,$smt,$nh,$type,$venue,$exp,$am,$total,$oo_file_name,$obj,$ref_name,$rem);
}

/*function insertExpenses($semExp,$am,$exp,$title,$dateFrom,$dateTo){

    $convAm = explode(",",$am);
    $convExp = explode(",",$exp);
    
    for($a = 0; $a < count($convAm); $a++){
        if(!empty($convAm[$a]) || !empty($convExp[$a])){
            $newAm = $convAm[$a];
            $newExp = $convExp[$a];
            $semExp->insert($title,$dateFrom,$dateTo,$newExp,$newAm);
        }
    }
    
}*/

?>