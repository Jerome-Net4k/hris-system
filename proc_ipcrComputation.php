<?php
include "connection.php";

    $empId = $_POST['empId'];
    $half = $_POST['semiSelected'];
    $yearSelected = $_POST['yearSelect'];

    $ipcrQuery = $con->prepare("SELECT * FROM `ipcr_output_table` WHERE half = $half AND year = $yearSelected AND `emp_id` = $empId");
    $ipcrQuery->execute();
    $ipcrQueryResult = $ipcrQuery->get_result();


    echo '
    <form id ="computeRatingForm" enctype="multipart/form-data">

    <button type="button" id="outputAdd" class="btn btn-outline-success"><i class="fa fa-plus" aria-hidden="true" style="font-weight: 700;"></i></button>
    <button type="button" id="outputRemove" class="btn btn-outline-success" disabled><i class="fa fa-minus" aria-hidden="true" style="font-weight: 700;"></i></button>

    <table id="outputTable" class="table table-bordered mt-2">
    <caption style="text-align: right;"><button type="button" id="computeBtn" class="btn btn-outline-primary" style="font-weight: 700; margin-right: 570px;">COMPUTE</button><button type="button" id="computeSubmitBtn" class="btn btn-outline-primary" style="font-weight: 700;" disabled>SUBMIT</button></caption>
        <thead>
            <th>Output</th>
            <th>Q</th>
            <th>E</th>
            <th>T</th>
            <th>A</th>
        </thead>

            <tbody id="outputTable">';

        $outputCount = 2;
        $importCount = 0;
        $totalq = 0;
        $totale = 0;
        $totalt = 0;
        $totala = 0;
        $countq = 0;
        $counte = 0;
        $countt = 0;

    if($ipcrQueryResult->num_rows > 0){

        while($row = $ipcrQueryResult->fetch_assoc()){
        
        $importCount += 1;

        $totalq += $row['q'];
        $totale += $row['e'];
        $totalt += $row['t'];
        $totala += $row['a'];

        if($row['q']!=0){
            $countq += 1;
        }
        if($row['e']!=0){
            $counte += 1;
        }
        if($row['t']!=0){
            $countt += 1;
        }

        echo
        '<tr id="outputRow' . $row['output'] . '">
        <td><input type="text" name="" id="" value="' . $row['output'] . '" style="width: 50px; font-weight: bold;" disabled></td>
        <td><input type="number" name="outputq' . $row['output'] . '" id="outputq' . $row['output'] . '" value="' . $row['q'] . '" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outpute' . $row['output'] . '" id="outpute' . $row['output'] . '" value="' . $row['e'] . '" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outputt' . $row['output'] . '" id="outputt' . $row['output'] . '" value="' . $row['t'] . '" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="text" name="outputa' . $row['output'] . '" id="outputa' . $row['output'] . '" value="' . number_format($row['a'], 2) . '" style="width: 75px;" disabled></td>
        <input type="hidden" name="outputaVal' . $row['output'] . '" id="outputaVal' . $row['output'] . '" value="' . $row['a'] . '">
        </tr>
        ';
        
        }

        if($totalq != 0){
            $totalq = ($totalq/$countq);
        } else {
            $totalq = 0;
        }
        if($totale != 0){
            $totale = ($totale/$counte);
        } else {
            $totale = 0;
        }
        if($totalt != 0){
            $totalt = ($totalt/$countt);
        } else {
            $totalt = 0;
        }

        // $totalq = $totalq/$countq;
        // $totale = $totale/$counte;
        // $totalt = $totalt/$countt;
        $totala = $totala/$importCount;

        echo '
        
        <tr id="totalRow">
        <td style="font-weight: bold;">TOTAL <br> AVERAGE</td>
        <td><input type="text" name="" id="" value="' . number_format($totalq, 2) . '" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="0.00" disabled></td>
        <td><input type="text" name="" id="" value="' . number_format($totale, 2) . '" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="0.00" disabled></td>
        <td><input type="text" name="" id="" value="' . number_format($totalt, 2) . '" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="0.00" disabled></td>
        <td><input type="text" name="" id="" value="' . number_format($totala, 2) . '" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="0.00" disabled></td>
        </tr>
        
        ';
    } else {
        echo
        '<tr>
        <td><input type="text" name="" id="" value="1" style="width: 50px; font-weight: bold;" disabled></td>
        <td><input type="number" name="outputq1" id="outputq1" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outpute1" id="outpute1" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outputt1" id="outputt1" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="text" name="outputa1" id="outputa1" style="width: 75px;" disabled></td>
        <input type="hidden" name="outputaVal1" id="outputaVal1" value="">
        </tr>
        
        <tr>
        <td><input type="text" name="" id="" value="2" style="width: 50px; font-weight: bold;" disabled></td>
        <td><input type="number" name="outputq2" id="outputq2" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outpute2" id="outpute2" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="number" name="outputt2" id="outputt2" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td>
        <td><input type="text" name="outputa2" id="outputa2" style="width: 75px;" disabled></td>
        <input type="hidden" name="outputaVal2" id="outputaVal2" value="">
        </tr>';
    }
    



    echo '
            </tbody>

    </table>

    <input type="hidden" name="rowCount" id="rowCount" value="">
    <input type="hidden" name="empId" id="empId" value="'. $empId .'">
    <input type="hidden" name="half" id="half" value="'. $half .'">
    <input type="hidden" name="yearSelected" id="yearSelected" value="'. $yearSelected .'">
    
    </form>

    <script>
    
    var empId = '. $empId .';
    var half = '. $half .';
    var yearSelected = '. $yearSelected .';

    var importCount = '. $importCount .';
    if(importCount != 0){
        var outputCount = '. $importCount .';

    } else {
        var outputCount = '. $outputCount .';
    }

    var countQ = outputCount;
    var countE = outputCount;
    var countT = outputCount;
    
    var blankCheck = false;

        function resetSubmitBtn(){
            document.getElementById("computeSubmitBtn").disabled = true;
        }

        $("button#outputAdd").on("click",function(){
            $(\'#totalRow\').remove();
            outputCount += 1;
            countQ += 1;
            countE += 1;
            countT += 1;
                $("#outputTable").append(\'<tr id="outputRow\' + outputCount +\'"><td><input type="text" name="" id="" value="\' + outputCount +\'" style="width: 50px; font-weight: bold;" disabled></td><td><input type="number" name="outputq\'+ outputCount +\'" id="outputq\'+ outputCount +\'" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td><td><input type="number" name="outpute\'+ outputCount +\'" id="outpute\'+ outputCount +\'" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td><td><input type="number" name="outputt\'+ outputCount +\'" id="outputt\'+ outputCount +\'" style="width: 75px;" step="0.25" max="5" min="0" onchange="resetSubmitBtn();"></td><td><input type="text" name="outputa\'+ outputCount +\'" id="outputa\'+ outputCount +\'" style="width: 75px;" disabled></td><input type="hidden" name="outputaVal\'+ outputCount +\'" id="outputaVal\'+ outputCount +\'" value=""></tr>\');

            document.getElementById("outputRemove").disabled = false;
            document.getElementById("computeSubmitBtn").disabled = true;
            })
        
        $("button#outputRemove").on("click",function(){
            $(\'#totalRow\').remove();
            $(\'#outputTable tr:last\').remove();
            outputCount -= 1;
            countQ -= 1;
            countE -= 1;
            countT -= 1;
            if(outputCount == importCount || outputCount == 2){
                document.getElementById("outputRemove").disabled = true;
                document.getElementById("computeSubmitBtn").disabled = true;
            }
            
            })

        $("button#computeBtn").on("click",function(){

            countQ = outputCount;
            countE = outputCount;
            countT = outputCount;

            document.getElementById("computeSubmitBtn").disabled = false;

            var totalQ = 0;
            var totalE = 0;
            var totalT = 0;
            var totalA = 0;

        for (let i = 1; i <= outputCount; i++) {

            var outputQ = $("#outputq" + i).val();
            var outputE = $("#outpute" + i).val();
            var outputT = $("#outputt" + i).val();
            var outputA = 0;
            var averageNum = 3;
            
            if(outputQ == 0 || outputQ == ""){
                averageNum -= 1;
                countQ -= 1;
                document.getElementById(\'outputq\' + i).value = 0;                
            }
            if(outputE == 0 || outputE == ""){
                averageNum -= 1;
                countE -= 1;
                document.getElementById(\'outpute\' + i).value = 0;
            }
            if(outputT == 0 || outputT == ""){
                averageNum -= 1;
                countT -= 1;
                document.getElementById(\'outputt\' + i).value = 0;
            }

            if(averageNum > 0){
                outputA = (+outputQ + +outputE + +outputT) / +averageNum;
                blankCheck = false;
            } else {
                document.getElementById("computeSubmitBtn").disabled = true;
                blankCheck = true;
            }
    
            document.getElementById(\'outputa\' + i).value = outputA.toFixed(2);
            document.getElementById(\'outputaVal\' + i).value = outputA.toFixed(2);

            totalQ += +outputQ;
            totalE += +outputE;
            totalT += +outputT;
            totalA += +outputA.toFixed(2);


        }

        if(totalQ != 0){
            totalQ = (totalQ/countQ).toFixed(2);
        } else {
            totalQ = 0;
        }
        if(totalE != 0){
            totalE = (totalE/countE).toFixed(2);
        } else {
            totalE = 0;
        }
        if(totalT != 0){
            totalT = (totalT/countT).toFixed(2);
        } else {
            totalT = 0;
        }
        
        // totalE = (totalE/countE).toFixed(2);
        // totalT = (totalT/countT).toFixed(2);
        totalA = (totalA/outputCount).toFixed(2);

        if(blankCheck == true){
            iziToast.warning({
                timeout: 2000,
                title: \'Warning\',
                message: \'Blank output row/s.\',
                position: "center",
                messageSize: \'20\',
                titleSize: \'20\'
            });
        } else {
            $(\'#totalRow\').remove();
            $("#outputTable").append(\'<tr id="totalRow"><td style="font-weight: bold;">TOTAL <br> AVERAGE</td><td><input type="text" name="" id="" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="\'+ totalQ +\'" disabled></td><td><input type="text" name="" id="" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="\'+ totalE +\'" disabled></td><td><input type="text" name="" id="" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="\'+ totalT +\'" disabled></td><td><input type="text" name="" id="" style="border: 0px; width: 75px; font-size: 20px; font-weight: bold;" value="\'+ totalA +\'" disabled></td></tr>\');
        }


        

    })
    
        $("#computeSubmitBtn").click(function(){
            var rowCount = $(\'#outputTable >tbody >tr\').length;
            document.getElementById(\'rowCount\').value = rowCount;
            $("#computeRatingForm").submit();

        });' .

    '$("#computeRatingForm").on(\'submit\', function(e){
        e.preventDefault();

        if(confirm(\'submit?\')){

            $.ajax({
                url:"uploadComputation.php",
                data: new FormData(this),
                type: "POST",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    iziToast.success({
                        position: "center",
                        timeout: 1500,
                        title: "OK",
                        message: data,
                        messageSize: \'30\',
                        titleSize: \'25\'
                    });
                    if(half==1){
                        $( "#computeBtn1' . $empId . '" ).addClass("btn-outline-success");
                        $( "#computeBtn1' . $empId . '" ).removeClass("btn-outline-danger");
                    } else if (half==2){
                        $( "#computeBtn2' . $empId . '" ).addClass("btn-outline-success");
                        $( "#computeBtn2' . $empId . '" ).removeClass("btn-outline-danger");
                    }
                },
                error: function() {
                    iziToast.error({
                        position: "center",
                        title: "",
                        message: "Something went wrong..",
                        messageSize: \'30\',
                        titleSize: \'25\'
                    });
                }
            })
            
        }
        

    });' .


    '</script>';


?>