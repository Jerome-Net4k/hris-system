<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>Service Record</title>
    <style>
        .tr{
        border-bottom:2px solid #005000
        }
        
        .name{
        text-align: left;
        font-size: .9rem;
        }
        .subtag{
          line-height: 9px;
          font-size: .7rem;
        }
        .Birthplace{
          font-size: .5rem;
        }
        .text-size{
          font-size: .8rem;
          font-weight:bold;
        }
        .text-caption{
          font-size: .8rem;

        }
        .nobord{
          border-bottom: 0px;
          border-top: 0px;
          line-height:10px
        }
       
    </style>

<script>
        $(Document).ready(function(){
          var id = <?php echo $_GET['id'] ?>;
          
          $.ajax({
            type: "GET",
            url: "proc_personalInfo.php?id=" + <?php echo $_GET['id'] ?>,
            success: function(data){
              var conv = jQuery.parseJSON(data)
              var sex = conv.sex
              var dob = conv.dob;
              var month =  dob.substr(dob.length-5,2)
              var day = dob.substr(dob.length-2,2)
              var year = dob.substr(0,4)
              if(month == 01 || month == 1){
                var cMonth = "January";
              }
              else if(month == 02 || month == 2){
                cMonth = "February";
              }
              else if(month == 03 || month == 3){
                cMonth = "March";
              }
              else if(month == 04 || month == 4){
                cMonth = "April";
              }
              else if(month == 05 || month == 5){
                cMonth = "May";
              }
              else if(month == 06 || month == 6){
                cMonth = "June";
              }
              else if(month == 07 || month == 7){
                cMonth = "July";
              }
              else if(month == 08 || month == 8){
                cMonth = "August";
              }
              else if(month == 09 || month == 9){
                cMonth = "September";
              }
              else if(month == 10){
                cMonth= "October";
              }
              else if(month == 11){
                cMonth = "November";
              }
              else if(month == 12){
                cMonth = "December";
              }
              $("#sname").text(conv.sname)
              $("#fname").text(conv.fname)
              $("#mname").text(conv.mname)
              $("#bp").text(conv.gsis)
              $("#dob").text(cMonth + " " + day + "," + year)
              $("#pob").text(conv.pob)
              $("#sex").text(sex.charAt(0))
            }
          })

           $.ajax({
            data: {id: id},
            type: "POST",
            url: "proc_serviceRecord.php?id=" + <?php echo $_GET['id']?> + "&proc=edit",
            success: function(data){
              $("#body").html(data);
            }
           })
            
            $("#add").on("click",function(){
                    $("#body").append('<tr class="nobord"><td class="text-size" id="servFrom"><input class="form-control" type="date" style="width: 135px" id="servFrom"></td><td class="text-size" id="servTo"><input class="form-control" type="date" style="width: 135px" id="servTo"></td><td class="text-size" id="servDesig"><input class="form-control" type="text" id="servDesig"></td><td class="text-size" id="servStatus"><input class="form-control" type="text" id="servStatus"></td><td class="text-size" id="servSalary"><input class="form-control" type="text" id="servSalary"></td><td class="text-size" id="servStation"><input class="form-control" type="text" id="servStation"></td><td class="text-size" id="servBranch"><input class="form-control" type="text" id="servBranch"></td><td class="text-size" id="servLv"><input class="form-control" type="text" id="servLv"></td><td class="text-size text-start" id="servCause"><input class="form-control" type="text" id="servCause"></td></tr>')
            })

            $("#from").on("click",function(){
                $(this).attr("type","date");
            })

            $("#save").on("click",function(){
              var servFrom = "";
              var servTo = "";
              var servDesig = "";
              var servStatus = "";
              var servSalary = "";
              var servStation = "";
              var servBranch = "";
              var servLv = "";
              var servCause = "";
              $("td#servFrom").each(function(){
                  var findFrom = $(this).find("input#servFrom").val();
                  servFrom += findFrom + ",";
              })
              $("td#servTo").each(function(){
                var findTo = $(this).find("input#servTo").val();
                servTo += findTo + ","
              })
              $("td#servDesig").each(function(){
                var findDesig = $(this).find("input#servDesig").val();
                servDesig += findDesig + ",";
              })
              $("td#servStatus").each(function(){
                var findStatus = $(this).find("input#servStatus").val();
                servStatus += findStatus + ",";
              })
              $("td#servSalary").each(function(){
                var findSalary = $(this).find("input#servSalary").val();
                servSalary += findSalary + ",";
              })
              $("td#servStation").each(function(){
                var findStation = $(this).find("input#servStation").val();
                servStation += findStation + ",";
              })
              $("td#servBranch").each(function(){
                var findBranch = $(this).find("input#servBranch").val();
                servBranch += findBranch + ",";
              })
              $("td#servLv").each(function(){
                var findLv = $(this).find("input#servLv").val();
                servLv += findLv + ",";
              })
              $("td#servCause").each(function(){
                var findCause = $(this).find("input#servCause").val();
                servCause += findCause + ",";
              })

              var convServFrom = servFrom.substr(0,servFrom.length-1);
              var convServTo = servTo.substr(0,servTo.length-1);
              var convServDesig = servDesig.substr(0,servDesig.length-1);
              var convServStatus = servStatus.substr(0,servStatus.length-1);
              var convServSalary = servSalary.substr(0,servSalary.length-1);
              var convServStation = servStation.substr(0,servStation.length-1);
              var convServBranch = servBranch.substr(0,servBranch.length-1);
              var convServLv = servLv.substr(0,servLv.length-1);
              var convServCause = servCause.substr(0,servCause.length-1);
             
             
              $.ajax({
                data: {
                  id: id,
                  convServFrom: convServFrom,
                  convServTo: convServTo,
                  convServDesig: convServDesig,
                  convServStatus: convServStatus,
                  convServSalary: convServSalary,
                  convServStation: convServStation,
                  convServBranch: convServBranch,
                  convServLv: convServLv,
                  convServCause: convServCause
                },
                type: "POST",
                url: "proc_serviceRecord.php?proc=upload",
                success: function(data){
                  alert(data);
                }
              })
             
            })
        })
    </script>
</head>
<body>
 <?php include 'navbar.php'; ?>

    <div class="container-fluid rounded bg-white pt-2 mt-2">
        <p class="fs-3 fw-bold text-center">Service Record</p>
       
        <table style="border-collapse: collapse;">
        <tr>
            <td rowspan="2" style="width:80px; font-size: .7rem;">Name:</td>
        <td  class="tr name" style="width 80px;"><strong id="sname"></strong></td>
        <td class="tr name"  style="width:20px"><strong id="fname">John Dexter</strong></td>
                <td class="tr name" style="width:80px"><strong id="mname">Alvarez</strong></td>
                <td class="tr name" style="width:80px">&nbsp;</t>

        </tr>
        <tr>
        <td style="width:70px;" class="subtag">(Surname)</td>
        <td style="width:80px" class="subtag">(Given Name)</td>
                <td style="width:100px" class="subtag">(Middle Name)</td>
                <td style="width:120px" class="subtag">(Maiden Name)</td>

        </tr>

        <tr>
            <td rowspan="2" class="name" style="width:80px; "></td>
        <td  class="tr Birthplace" style="width 100px;"><strong id="bp">200166724</strong></td>
        <td class="tr name"  style="width:120px"><strong id="dob">January 7, 1979</strong></td>
                <td class="tr Birthplace" style="width:80px"><strong id="pob">San Jose Camarines Sur</strong></td>
                <td class="tr name" style="width:80px"><strong id="sex">M</strong></td>

        </tr>
        <tr>
        <td style="width:70px;" class="subtag">(BP Number)</td>
        <td style="width:50px" class="subtag">(Birth Date)</td>
                <td style="width:40px" class="subtag">(Birth Place)</td>
                <td style="width:10px" class="subtag">(Sex)</td>
        </tr>
    </table>

                            <!--SERVICE RECORD TABLE -->
      <div class="pt-2 text-caption">
     <caption>This is to certify that the employee named herein above actually rendered services in this office as shown by the service record below. 
      Each line of which is supported by appointment and other papers actually issued by this Office and approved by the authorities concerned.
     </caption>
      </div>
      
    <table class="table table-bordered table-hover border-dark">
    <div class="d-flex justify-content-start pb-2 pt-2">
        <button class="btn btn-dark" id="add">
        <i class="fi fi-br-layer-plus pe-1"></i>Add Row
        </button>
        <tr>
            <th class="text-size text-center " scope="col" colspan="2">SERVICE <br> Inclusive Date</th>
            <th class="text-size text-center" scope="col" colspan="3" style="padding-top: 20px">RECORD OF APPOINTMENT</th>
            <th  class="text-size"scope="col" colspan="3" style="padding-top: 20px">OFFICE/ENTITY/DIVISION</th>
             <th class="text-size" scope="col" colspan="1" style="padding-top: 20px">SEPARATION</th>
      </tr>

      <tr>
        
        <td class="text-size fw-bold text-center">FROM</td>
        <td class="text-size fw-bold text-center">TO</td>
        <td class="text-size fw-bold" >DESIGNATION</td>
        <td class="text-size fw-bold" >STATUS</td>
        <td class="text-size fw-bold">SALARY</td>
        <td class="text-size fw-bold" style="font-size: 10px">STATION PLACE</td>
        <td class="text-size fw-bold" >BRANCH</td>
        <td class="text-size fw-bold" style="font-size: 10px">L/V ABS<br>W/O PAY</td>
        <td class="text-size fw-bold" >CAUSE</TD>

        
      </tr>
        <tbody id="body">
      
        </tbody>
      <tr style=" border-bottom: 0px;">
      </tr>
      </table>

      <div class="d-flex justify-content-center pb-2">
        <button class="btn btn-success" id="save">
        <i class="fi fi-rr-checkbox pe-1"></i>SAVE
        </button>
    </div>  
  </table>   

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Work Experience</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
          <div class="col">
          <label for="">From</label>
          <input type="date" class="form-control" id="from">
          </div>

          <div class="col">
          <label for="">To</label>
          <input type="date" class="form-control" id="to">
          </div>       
       </div>

       <div class="row pt-2">
        <div class="col col-9">
            <label for="">Designation</label>
            <input type="text" class="form-control" id="des">
          </div>

          <div class="col col-3">
            <label for="">Status</label>
            <input type="text" class="form-control" id="stats">
          </div>
       </div>

       <div class="row">
        <div class="col">
          <label for="">Salary</label>
          <input type="text" class="form-control" id="salar">
        </div>

        <div class="col">
          <label for="">Station Place</label>
          <input type="text" class="form-control" id="place">
        </div>
       </div>

       <div class="row">
          <div class="col">
            <label for="">Branch</label>
            <input type="text" class="form-control" id="brans">
          </div>

          <div class="col">
            <label for="">L/V ABS W/O PAY</label>
            <input type="text" class="form-control" id="leaves">
          </div>
       </div>

       <div class="row">
          <label for="">Cause</label>
          <textarea class="form-control" id="cause"></textarea>
       </div>
      </div>
      <div class="modal-footer">
          <button class="btn btn-danger me-3"><i class="fa-solid fa-trash pe-1"></i>Delete</button>
        <button type="button" class="btn btn-primary"><i class="fa-solid fa-floppy-disk pe-1"></i>Save</button>
      </div>
    </div>
  </div>
</div>
  
</div> 




</body>
</html>