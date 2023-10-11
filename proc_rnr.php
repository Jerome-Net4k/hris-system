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
            loadServiceRecord($serviceRec);
        } 
        else if($proc == 'getrec'){
            servrec($Rnrrec); 
        }
        else if($proc == 'getrecorddata'){
            rnrrecord($Rnrrec);
        }
        else if($proc == 'getleaverecdata'){
            rnrleaverec($Rnrrec);
        }
        else if($proc == 'updaterecorddata'){
            updaternrrecord($Rnrrec);
        }
        else if($proc == 'viewrecorddata'){
            viewrnrrecord($Rnrrec);
        }
        else if($proc == 'getLeaveData'){
            $id = $_GET['id'];
            echo getLeaveData($id,$Rnrrec);
        }
        else if($proc == 'upload'){
            uploadrnrrec($serviceRec,$Rnrrec);
        }
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
                                                $vl_bal = $_POST['vl_bal'];
                                                $sl_bal = $_POST['sl_bal'];
                                                $fl_bal = $_POST['fl_bal'];
                                                $pl_bal = $_POST['pl_bal'];
                                                $ml_bal = $_POST['ml_bal'];
                                                $pt_bal = $_POST['pt_bal'];
                                                $mc_bal = $_POST['mc_bal'];
                                                $sp_bal = $_POST['sp_bal'];
                                                $rb_bal = $_POST['rb_bal'];
                                                $Rnrrec->upload_rnrrec($id,$day,$hrs,$min,$leavetype,$auwp,$auwop,$leavedate,$vl_bal,$sl_bal,$fl_bal,$pl_bal,$ml_bal,$pt_bal,$mc_bal,$sp_bal,$rb_bal);
                                                }

    function getLeaveData($id,$Rnrrec){
        $result = $Rnrrec->get_rnrleaveTbl($id);
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
            <td style="text-align: center;">
                <button class="btn btn-success p-1" id="view" value="'.$row['empNo'].'"><i class="fi fi-rr-eye p-1"></i>View</button>
            </td>
        </tr>';
        }}
    
    else{
        echo '<tr>
            <td colspan="7" class="text-center"><h1>No Record Found</h1></td>
        </tr>';
    }
        echo '<script>
        $("button#view").on("click",function(){
        var empNo = $(this).val();
        window.location.href="rnrdash.php?id=" + empNo;
        })
        
        </script>';
    }       
        
        function servrec($Rnrrec){
            $id = $_GET['id'];  
            $result =  $Rnrrec->get_servicerec($id);
            if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo ' <tr>
                <td class="fw-bold fs-5 text-center " style="padding:1px;">Name:</td>
                <td class="fs-5" style="padding:1px;">'.$row['name'].'</td>
                </tr>
                <tr><td class="fw-bold fs-5 text-center" style="padding:1px;">Division Office:</td>
                <td class="fs-5" style="padding:1px;">'.$row['designation'].'</td>
                </tr>
                <tr> <td class="fw-bold fs-5 text-center" style="padding:1px;">1st Day of service: </td>
                <td class="fs-5" style="padding:1px;">'.$row['serveRecFrom'].'</td>
                </tr>';
            }}
        }    
        function rnrleaverec($Rnrrec){
        echo'<tr><td>asdadsasdsas</td></tr>';             
            }

        function rnrrecord($Rnrrec){
            $id = $_GET['id'];  
            $result =  $Rnrrec->get_rnrrecordTbl($id);
            if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo'<tr>
                <td class="text-center">'.$row['day'].'-'.$row['hrs'].'-'.$row['min'].'</td>
                <td class="text-center">'.$row['auwp'].'</td>
                <td class="text-center">'.$row['leavetype'].'</td>
                <td class="text-center">'.$row['leavedate'].'</td>
                <td class="text-center">'.$row['auwop'].'</td>
                </tr>';                
            }}
            else{
                echo'<tr><td>none</td></tr>';
            }
        }
        function updaternrrecord($Rnrrec){
            $id = $_GET['id'];  
            $result =  $Rnrrec->get_rnrrecordTbl($id);
            if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo'<tr>
                <td class="text-center" style="padding:4px">'.$row['day'].'-'.$row['hrs'].'-'.$row['min'].'</td>
                <td class="text-center" style="padding:4px">'.$row['auwp'].'</td>
                <td style="padding:4px">'.$row['leavetype'].'</td>
                <td style="padding:4px">'.$row['leavedate'].'</td>
                <td class="text-center" style="padding:4px">'.$row['auwop'].'</td>
                <td class="text-center" style="padding:4px"><button type="submit" class="btn btn-success " id="rec"><i class="fi fi-rr-edit"> Update</i></button>
                </tr>';                
            }}
            echo'<script> 
            $("button#btndel").on("click",function(){
                var empNo = $(this).val();
                window.location.href="rnrdash.php?id=" + empNo;
                })
            </script>';
        }
        /**
         * Function to view the rnr record.
         *
         * @param object $Rnrrec The Rnrrec object.
         * @throws Some_Exception_Class description of exception
         * @return void
         */
        function viewrnrrecord($Rnrrec){
            $id = $_GET['id'];  
            $result =  $Rnrrec->get_rnrrecordTbl($id);
            if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo'<tr>
                <td class="text-center" style="padding:4px">'.$row['day'].'-'.$row['hrs'].'-'.$row['min'].'</td>
                <td class="text-center" style="padding:4px">'.$row['auwp'].'</td>
                <td style="padding:4px">'.$row['leavetype'].'</td>
                <td style="padding:4px">'.$row['leavedate'].'</td>
                <td class="text-center" style="padding:4px">'.$row['auwop'].'</td>
                </tr>';                
            }}
            else{
                echo'<script> 
                $("button#btndel").on("click",function(){
                    var empNo = $(this).val();
                    window.location.href="rnrdash.php?id=" + empNo;
                    })
                </script>';
            }

        }

?>
