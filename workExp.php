<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="educbg.css">
    <title>New Account</title>
   
    <style>
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    </style>
    <script>
        
        $(document).ready(function(){
          $("input#workPosNum:eq(0)").keyup(function(){
            var itemNum = $(this).val();
            if(itemNum !== ''){
              $.ajax({
              type: "GET",
              url:  "getSalaryMonthly.php?id=" + itemNum,
              success: function(data){
                var conv = jQuery.parseJSON(data);
                $("input#workxpPos:eq(0)").val(conv.pos_title)
                $("select#workxpDept:eq(0)").val(conv.division)
                $("input#workxpSalary:eq(0)").val((conv.authorize / 12).toFixed(2));
                $("input#workxpSg:eq(0)").val((conv.salary_grade) + "-1");
              }
            })
            }
            else{
                $("input#workxpPos:eq(0)").val('')
                $("select#workxpDept:eq(0)").val('')
            }
          })
          
            $("#add").on("click",function(){
              $("tbody#body").append('<tr> <td id="workxpFrom"> <input type="date" class="form-control" id="workxpFrom"> </td> <td id="workxpTo"> <input type="date" class="form-control" id="workxpTo"> </td> <td id="workPosNum"> <input type="text" class="form-control" id="workPosNum"> </td> <td id="workxpPos"> <input type="text" class="form-control" id="workxpPos"> </td> <td id="workxpDept"> <div class="input-group"> <select name="" id="workxpDept" class="form-control"> <option value="" hidden>Division/Office List</option> <option value="others">OTHERS</option> <option value="OFFICE OF ASSISTANT SECRETARY">OFFICE OF ASSISTANT SECRETARY</option> <option value="LAW ENFORCEMENT SERVICE">LAW ENFORCEMENT SERVICE</option> <option value="PLATE MAKING PLANT">PLATE MAKING PLANT</option> <option value="TRAFFIC ADJUDICATION SERVICE">TRAFFIC ADJUDICATION SERVICE</option> <option value="TRAFFIC SAFETY DIVISION">TRAFFIC SAFETY DIVISION</option> <option value="FIELD ENFORCEMENT DIVISION<">FIELD ENFORCEMENT DIVISION</option> <option value="INTELLIGENCE & INVESTIGATION DIVISION">INTELLIGENCE & INVESTIGATION DIVISION</option> <option value="MANAGEMENT DIVISION">MANAGEMENT DIVISION</option> <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option> <option value="FINANCIAL DIVISION">FINANCIAL DIVISION</option> <option value="OPERATIONS DIVISION">OPERATIONS DIVISION</option> <option value="MANAGEMENT INFORMATION DIVISION">MANAGEMENT INFORMATION DIVISION</option> </select> <input type="text" class="form-control" id="divOth"> </div> </td> <td id="workxpSalary"> <input type="text" class="form-control" id="workxpSalary"> </td> <td id="workxpSg"> <input type="text" class="form-control" id="workxpSg" placeholder="00-0"> </td> <td id="workxpStats"> <select name="" id="workxpStats" class="form-control"> <option value="PA">PA</option> <option value="P">Permanent</option> <option value="Casual">Casual</option> <option value="JO">Job Order</option> <option value="COS">COS</option> <option value="ojt">OJT</option> <option value="n/a">n/a</option> </select> </td> <td id="workxpServe"> <select name="" id="workxpServe" class="form-control text-center" > <option value="Yes">Yes</option> <option value="No">No</option> </select> </td> </tr>')
              $("input#divOth:last").hide();
            })
          
            $("button#next").on("click",function(){
                var workFrom = "";
                var workTo = "";
                var workItemNum = "";
                var workPos = "";
                var custWorkPos = "";
                var workDept = "";
                var workSalary = "";
                var workSG = "";
                var workSoa = "";
                var workGovt = "";-

                $("td#workxpFrom").each(function(){
                  var findxpFrom = $(this).find("input#workxpFrom").val();
                  workFrom += findxpFrom + ",";
                })
                $("td#workxpTo:eq(0)").each(function(){
                  workTo += "present" + ",";
                })
                $("td#workxpTo:gt(0)").each(function(){
                  var findxpTo = $(this).find("input#workxpTo").val();
                  workTo += findxpTo + ",";
                })
                $("td#workPosNum").each(function(){
                  var findxpPosNum = $(this).find("input#workPosNum").val();
                  workItemNum += findxpPosNum + ",";
                })
                $("td#workxpPos").each(function(){
                  var findxpPos = $(this).find("input#workxpPos").val();
                  workPos += findxpPos + ",";
                })
                $("td#workxpDept").each(function(){
                  var row = $(this).closest('tr').index();
                  var findxpDept = $(this).find("select#workxpDept").val();

                if(findxpDept == 'others'){
                  var findxpDeptOth = $("tr:eq("+(row + 2)+")").find("input#divOth").val();
                  workDept += findxpDeptOth + ",";
                }
                else{
                  workDept += findxpDept + ",";
                }
                })
                $("td#workxpSalary").each(function(){
                  var findxpSalary = $(this).find("input#workxpSalary").val();
                  workSalary += findxpSalary + ",";
                })
                $("td#workxpSg").each(function(){
                  var findxpSg = $(this).find("input#workxpSg").val();
                  workSG += findxpSg + ",";
                })
                $("td#workxpStats").each(function(){
                  var findxpStats = $(this).find("select#workxpStats").val();
                  workSoa += findxpStats + ",";
                })
                $("td#workxpServe").each(function(){
                  var findxpServe = $(this).find("select#workxpServe").val();
                  workGovt += findxpServe + ",";
                })

                var convWorkFrom = workFrom.substr(0,workFrom.length-1);
                var convWorkTo = workTo.substr(0,workTo.length-1);
                var convWorkPos = workPos.substr(0,workPos.length-1);
                var convWorkItemNum = workItemNum.substr(0,workItemNum.length-1);
                var convWorkDept = workDept.substr(0,workDept.length-1);
                var convWorkSalary = workSalary.substr(0,workSalary.length-1);
                var convWorkSg = workSG.substr(0,workSG.length-1);
                var convWorkSoa = workSoa.substr(0,workSoa.length-1);
                var convWorkGovt = workGovt.substr(0,workGovt.length-1);      
                
                var getDOA = convWorkFrom.split(',');
                var checkStat = convWorkSoa.split(',')

                var doa = getDOA[0];
                for(var a = 0; a < getDOA.length; a++){
                  if(checkStat[a] == 'P' && getDOA[a] < doa){
                    doa = getDOA[a]
                  }
                }
                
                var promotion;
                $("tbody tr").each(function(){    
                  promotion = $("tbody tr:eq(0)").find("input#workxpFrom").val();
                  var index = $(this).closest("tbody tr").index();
                  var value = $("tbody tr:eq("+index+")").find("input#workxpPos").val();
                  var val = $("tbody tr:eq("+(index + 1)+")").find("input#workxpPos").val();

                  if(value != val){
                    promotion = $("tbody tr:eq("+index+")").find("input#workxpFrom").val();
                    return false;   
                  }   
                          
                })

                $.ajax({
                  data: {
                    promotion: promotion,
                    convWorkFrom: convWorkFrom,   
                    doa:doa,
                    convWorkTo: convWorkTo,
                    convWorkPos: convWorkPos,
                    convWorkItemNum: convWorkItemNum,
                    convWorkDept: convWorkDept,
                    convWorkSalary: convWorkSalary,
                    convWorkSg: convWorkSg,
                    convWorkSoa: convWorkSoa,
                    convWorkGovt: convWorkGovt,
                  },
                  type: "POST",
                  url: "storeWorkExp.php",
                  success: function(data){
                    //alert(data)
                    if(data == 'nice'){
                      window.location.href = "voluntarywork.php"
                    }
                    else if(data == 'occupied'){
                      iziToast.warning({
                      title: 'Occupied!',
                      position: 'topRight',
                      message: 'Position already occupied.'
                      });
                    }
                    else{
                      iziToast.error({
                      title: 'Error!',
                      position: 'topRight',
                      message: 'Position not exist.'
                      });
                    }
                  }
                })
            })           
            $("button#prev").on("click",function(){
                window.location.href="serviceeligibility.php"
            })  
            $("input#divOth").hide();

             setInterval(function(){
              $("select#workxpDept").change(function(){
              var val = $(this).val();
              var row = $(this).closest("tr").index();
              if(val == 'others'){
                $("tr:eq("+(row + 2)+")").find("input#divOth").show("slow");
              }
              else{
                
                $("tr:eq("+(row + 2)+")").find("input#divOth").hide("slow");
              }
            })
             },500)
              
          


            /*$("select#workxpPos").change(function(){
              var id = $(this).val();
              var row = $(this).closest("tr").index();
              if(id != 'other'){
              $.ajax({
                data: {id: id},
                type: "GET",
                url:  "getSalaryMonthly.php?id=" + id,
                success: function(data){
                  var conv = jQuery.parseJSON(data);
                  $("tr:eq("+(row + 2)+")").find("input#workxpSalary").val((conv.authorize / 12));
                  $("tr:eq("+(row + 2)+")").find("input#workxpSg").val((conv.salary_grade) + "-1");
                  $("tr:eq("+(row + 2)+")").find("input#workPosNum").val(conv.item_num);
                  $("tr:eq("+(row + 2)+")").find("input#otherPos").hide("slow");
                }
              })
            }
            else{
              $("tr:eq("+(row + 2)+")").find("input#otherPos").show("slow");
              $("tr:eq("+(row + 2)+")").find("input#workxpSalary").val("");
              $("tr:eq("+(row + 2)+")").find("input#workxpSg").val("");
            }
            })*/
        })

        function getPos(val){
          $.ajax({
            data: {val:val},
            type: "POST",
            url: "getPosition.php",
            success: function(data){
                $("select#workxpPos").html(data)
            }
          })
        }
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container-fluid table-responsive bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">V. WORK EXPERIENCE</div>
    <div class="fs-5 text-center fst-italic mb-2">(For regular employee please refer to plantilla to get accurate item number.)</div>
    <div class="row row-cols-2">
    <table class="table table-bordered">
        <thead>
            <tr>
            <th colspan="2" style="width:5%">INCLUSIVE DATES</th>
            <th rowspan="2" style="padding-bottom: 20px;">ITEM NUMBER(if applicable)</th>
            <th rowspan="2" style="padding-bottom: 20px;">POSITION TITLE</th>
            <th rowspan="2" style="padding-bottom: 20px; font-size: 12px; width: 15%">DEPARTMENT/AGENCY/OFFICE/COMPANY</th>
            <th rowspan="2" style="padding-bottom: 20px; width: 7%">MONTHLY SALARY</th>
            <th rowspan="2" style="font-size: 8px; width: 6%">SALARY GRADE<br>(if applicable) <br>& STEP(00-0) <br>INCREMENT</th>
            <th rowspan="2" style="padding-bottom: 20px; font-size: 10px; width: 5%">STATUS OF APPOINTMENT</th>
            <th rowspan="2" style="padding-bottom: 20px; font-size: 12px; width: 5%">GOV'T SERVICE(Y/N)</th>
            </tr>
            <tr>
            <th>FROM</th>
            <th>TO</th>
            </tr>
        </thead>
        <tbody id="body">
            <tr>
                <td id='workxpFrom' >
                    <input type="date" class="form-control" id='workxpFrom'>
                </td>
                <td id="workxpTo" style="padding-top: 15px">
                    PRESENT
                </td>
                <td id="workPosNum">
                      <input type="text" class="form-control" id="workPosNum">
                </td>
                <td id="workxpPos">
                  <input type="text" class="form-control" id="workxpPos">
                  <!--<div class="input-group">
                   <select name="" id="workxpPos" class="form-control">
                    <option value="" hidden>Please Select Department</option>

                  </select> 
                  <input type="text" class="form-control" id="otherPos">
                    </div> -->
                </td>
                <td id="workxpDept">
                  <div class="input-group">
                    <select name="" id="workxpDept" class="form-control">
                      <option value="" hidden>Division/Office List</option>
                      <option value="OASEC">OFFICE OF ASSISTANT SECRETARY</option>
                      <option value="LES">LAW ENFORCEMENT SERVICE</option>
                      <option value="PMP">PLATE MAKING PLANT</option>
                      <option value="TAS">TRAFFIC ADJUDICATION SERVICE</option>
                      <option value="TSD">TRAFFIC SAFETY DIVISION</option>
                      <option value="FED">FIELD ENFORCEMENT DIVISION</option>
                      <option value="IID">INTELLIGENCE & INVESTIGATION DIVISION</option>
                      <option value="MD">MANAGEMENT DIVISION</option>
                      <option value="ADMIN">ADMINISTRATIVE DIVISION</option>
                      <option value="FD">FINANCIAL DIVISION</option>
                      <option value="OD">OPERATIONS DIVISION</option>
                      <option value="MID">MANAGEMENT INFORMATION DIVISION</option>
                      <option value="others">OTHERS</option>
                    </select>
                    <input type="text" class="form-control" id="divOth">
                    </div>
                </td>
                <td id="workxpSalary">
                    <input type="number" class="form-control" id="workxpSalary">
                </td>

                <td id="workxpSg">
                <input type="text" class="form-control" id="workxpSg" placeholder="00-0">
                </td>

                <td id="workxpStats">
                    <select name="" id="workxpStats" class="form-control">
                      <option value="P">Permanent</option>
                      <option value="PA">PA</option>
                      <option value="Casual">Casual</option>
                      <option value="JO">Job Order</option>
                      <option value="COS">COS</option>
                      <option value="ojt">OJT</option>
                      <option value="n/a">n/a</option>
                    </select>
                </td>

                <td id="workxpServe">
                    <select name="" id="workxpServe" class="form-control text-center" >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td id='workxpFrom' >
                    <input type="date" class="form-control" id='workxpFrom'>
                </td>
                <td id="workxpTo">
                    <input type="date" class="form-control" id="workxpTo">
                </td>
                <td id="workPosNum">
                      <input type="text" class="form-control" id="workPosNum">
                </td>
                <td id="workxpPos">
                  <input type="text" class="form-control" id="workxpPos">
                </td>
                <td id="workxpDept">
                  <div class="input-group">
                    <select name="" id="workxpDept" class="form-control">
                      <option value="" hidden>Division/Office List</option>
                      <option value="others">OTHERS</option>
                      <option value="OFFICE OF ASSISTANT SECRETARY">OFFICE OF ASSISTANT SECRETARY</option>
                      <option value="LAW ENFORCEMENT SERVICE">LAW ENFORCEMENT SERVICE</option>
                      <option value="PLATE MAKING PLANT">PLATE MAKING PLANT</option>
                      <option value="TRAFFIC ADJUDICATION SERVICE">TRAFFIC ADJUDICATION SERVICE</option>
                      <option value="TRAFFIC SAFETY DIVISION">TRAFFIC SAFETY DIVISION</option>
                      <option value="FIELD ENFORCEMENT DIVISION<">FIELD ENFORCEMENT DIVISION</option>
                      <option value="INTELLIGENCE & INVESTIGATION DIVISION">INTELLIGENCE & INVESTIGATION DIVISION</option>
                      <option value="MANAGEMENT DIVISION">MANAGEMENT DIVISION</option>
                      <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option>
                      <option value="FINANCIAL DIVISION">FINANCIAL DIVISION</option>
                      <option value="OPERATIONS DIVISION">OPERATIONS DIVISION</option>
                      <option value="MANAGEMENT INFORMATION DIVISION">MANAGEMENT INFORMATION DIVISION</option>
                    </select>
                    <input type="text" class="form-control" id="divOth">
                    </div>
                </td>
                <td id="workxpSalary">
                    <input type="text" class="form-control" id="workxpSalary">
                </td>

                <td id="workxpSg">
                <input type="text" class="form-control" id="workxpSg" placeholder="00-0">
                </td>

                <td id="workxpStats">
                    <select name="" id="workxpStats" class="form-control">
                      <option value="P">Permanent</option>
                      <option value="PA">PA</option>
                      <option value="Casual">Casual</option>
                      <option value="JO">Job Order</option>
                      <option value="COS">COS</option>
                      <option value="ojt">OJT</option>
                      <option value="n/a">n/a</option>
                    </select>
                </td>

                <td id="workxpServe">
                    <select name="" id="workxpServe" class="form-control text-center" >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                </td>
            </tr>    

            <tr>
                <td id='workxpFrom' >
                    <input type="date" class="form-control" id='workxpFrom'>
                </td>
                <td id="workxpTo">
                    <input type="date" class="form-control" id="workxpTo">
                </td>
                <td id="workPosNum">
                      <input type="text" class="form-control" id="workPosNum">
                </td>
                <td id="workxpPos">
                  <input type="text" class="form-control" id="workxpPos">
                </td>
                <td id="workxpDept">
                  <div class="input-group">
                    <select name="" id="workxpDept" class="form-control">
                      <option value="" hidden>Division/Office List</option>
                      <option value="others">OTHERS</option>
                      <option value="OFFICE OF ASSISTANT SECRETARY">OFFICE OF ASSISTANT SECRETARY</option>
                      <option value="LAW ENFORCEMENT SERVICE">LAW ENFORCEMENT SERVICE</option>
                      <option value="PLATE MAKING PLANT">PLATE MAKING PLANT</option>
                      <option value="TRAFFIC ADJUDICATION SERVICE">TRAFFIC ADJUDICATION SERVICE</option>
                      <option value="TRAFFIC SAFETY DIVISION">TRAFFIC SAFETY DIVISION</option>
                      <option value="FIELD ENFORCEMENT DIVISION<">FIELD ENFORCEMENT DIVISION</option>
                      <option value="INTELLIGENCE & INVESTIGATION DIVISION">INTELLIGENCE & INVESTIGATION DIVISION</option>
                      <option value="MANAGEMENT DIVISION">MANAGEMENT DIVISION</option>
                      <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option>
                      <option value="FINANCIAL DIVISION">FINANCIAL DIVISION</option>
                      <option value="OPERATIONS DIVISION">OPERATIONS DIVISION</option>
                      <option value="MANAGEMENT INFORMATION DIVISION">MANAGEMENT INFORMATION DIVISION</option>
                    </select>
                    <input type="text" class="form-control" id="divOth">
                    </div>
                </td>
                <td id="workxpSalary">
                    <input type="text" class="form-control" id="workxpSalary">
                </td>

                <td id="workxpSg">
                <input type="text" class="form-control" id="workxpSg" placeholder="00-0">
                </td>

                <td id="workxpStats">
                    <select name="" id="workxpStats" class="form-control">
                      <option value="P">Permanent</option>
                      <option value="PA">PA</option>
                      <option value="Casual">Casual</option>
                      <option value="JO">Job Order</option>
                      <option value="COS">COS</option>
                      <option value="ojt">OJT</option>
                      <option value="n/a">n/a</option>
                    </select>
                </td>

                <td id="workxpServe">
                    <select name="" id="workxpServe" class="form-control text-center" >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td id='workxpFrom' >
                    <input type="date" class="form-control" id='workxpFrom'>
                </td>
                <td id="workxpTo">
                    <input type="date" class="form-control" id="workxpTo">
                </td>
                <td id="workPosNum">
                      <input type="text" class="form-control" id="workPosNum">
                </td>
                <td id="workxpPos">
                  <input type="text" class="form-control" id="workxpPos">
                </td>
                <td id="workxpDept">
                  <div class="input-group">
                    <select name="" id="workxpDept" class="form-control">
                      <option value="" hidden>Division/Office List</option>
                      <option value="others">OTHERS</option>
                      <option value="OFFICE OF ASSISTANT SECRETARY">OFFICE OF ASSISTANT SECRETARY</option>
                      <option value="LAW ENFORCEMENT SERVICE">LAW ENFORCEMENT SERVICE</option>
                      <option value="PLATE MAKING PLANT">PLATE MAKING PLANT</option>
                      <option value="TRAFFIC ADJUDICATION SERVICE">TRAFFIC ADJUDICATION SERVICE</option>
                      <option value="TRAFFIC SAFETY DIVISION">TRAFFIC SAFETY DIVISION</option>
                      <option value="FIELD ENFORCEMENT DIVISION<">FIELD ENFORCEMENT DIVISION</option>
                      <option value="INTELLIGENCE & INVESTIGATION DIVISION">INTELLIGENCE & INVESTIGATION DIVISION</option>
                      <option value="MANAGEMENT DIVISION">MANAGEMENT DIVISION</option>
                      <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option>
                      <option value="FINANCIAL DIVISION">FINANCIAL DIVISION</option>
                      <option value="OPERATIONS DIVISION">OPERATIONS DIVISION</option>
                      <option value="MANAGEMENT INFORMATION DIVISION">MANAGEMENT INFORMATION DIVISION</option>
                    </select>
                    <input type="text" class="form-control" id="divOth">
                    </div>
                </td>
                <td id="workxpSalary">
                    <input type="text" class="form-control" id="workxpSalary">
                </td>

                <td id="workxpSg">
                <input type="text" class="form-control" id="workxpSg" placeholder="00-0">
                </td>

                <td id="workxpStats">
                    <select name="" id="workxpStats" class="form-control">
                    <option value="P">Permanent</option>
                      <option value="PA">PA</option>
                      <option value="Casual">Casual</option>
                      <option value="JO">Job Order</option>
                      <option value="COS">COS</option>
                      <option value="ojt">OJT</option>
                      <option value="n/a">n/a</option>
                    </select>
                </td>

                <td id="workxpServe">
                    <select name="" id="workxpServe" class="form-control text-center" >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                </td>
            </tr>  

            <tr>
                <td id='workxpFrom' >
                    <input type="date" class="form-control" id='workxpFrom'>
                </td>
                <td id="workxpTo">
                    <input type="date" class="form-control" id="workxpTo">
                </td>
                <td id="workPosNum">
                      <input type="text" class="form-control" id="workPosNum">
                </td>
                <td id="workxpPos">
                  <input type="text" class="form-control" id="workxpPos">
                </td>
                <td id="workxpDept">
                  <div class="input-group">
                    <select name="" id="workxpDept" class="form-control">
                      <option value="" hidden>Division/Office List</option>
                      <option value="others">OTHERS</option>
                      <option value="OFFICE OF ASSISTANT SECRETARY">OFFICE OF ASSISTANT SECRETARY</option>
                      <option value="LAW ENFORCEMENT SERVICE">LAW ENFORCEMENT SERVICE</option>
                      <option value="PLATE MAKING PLANT">PLATE MAKING PLANT</option>
                      <option value="TRAFFIC ADJUDICATION SERVICE">TRAFFIC ADJUDICATION SERVICE</option>
                      <option value="TRAFFIC SAFETY DIVISION">TRAFFIC SAFETY DIVISION</option>
                      <option value="FIELD ENFORCEMENT DIVISION<">FIELD ENFORCEMENT DIVISION</option>
                      <option value="INTELLIGENCE & INVESTIGATION DIVISION">INTELLIGENCE & INVESTIGATION DIVISION</option>
                      <option value="MANAGEMENT DIVISION">MANAGEMENT DIVISION</option>
                      <option value="ADMINISTRATIVE DIVISION">ADMINISTRATIVE DIVISION</option>
                      <option value="FINANCIAL DIVISION">FINANCIAL DIVISION</option>
                      <option value="OPERATIONS DIVISION">OPERATIONS DIVISION</option>
                      <option value="MANAGEMENT INFORMATION DIVISION">MANAGEMENT INFORMATION DIVISION</option>
                    </select>
                    <input type="text" class="form-control" id="divOth">
                    </div>
                </td>
                <td id="workxpSalary">
                    <input type="text" class="form-control" id="workxpSalary">
                </td>

                <td id="workxpSg">
                <input type="text" class="form-control" id="workxpSg" placeholder="00-0">
                </td>

                <td id="workxpStats">
                    <select name="" id="workxpStats" class="form-control">
                    <option value="P">Permanent</option>
                      <option value="PA">PA</option>
                      <option value="Casual">Casual</option>
                      <option value="JO">Job Order</option>
                      <option value="COS">COS</option>
                      <option value="ojt">OJT</option>
                      <option value="n/a">n/a</option>
                    </select>
                </td>

                <td id="workxpServe">
                    <select name="" id="workxpServe" class="form-control text-center" >
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                </td>
            </tr>  
            

               
                    
            </tbody>
    </table>
    
</div>
<div class="d-flex justify-content-end">
        <button class="btn btn-dark p-1 m-2" id="add"><i class="fi fi-rr-add p-1"></i>Add Row</button>
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-primary m-2 p-1" id="next">Next</button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>