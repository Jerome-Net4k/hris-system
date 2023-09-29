<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="educbg.css">
    <title>New Account</title>
   
    <script>
        $(Document).ready(function(){
            //loadSeminars();

                /*setInterval(function(){
                  $("select#tos").change(function(){
                  var id = $(this).val();
                  var action = "getDOS";
                  var index = $(this).closest('tbody tr').index();
                  $.ajax({
                    data: {id:id,action:action},
                    type: "POST",
                    url: "proc_lnd.php",
                    success: function(data){
                      var conv = jQuery.parseJSON(data);
                      var dateFrom = conv.dateFrom;
                      var dateTo = conv.dateTo;
                      var dfd = dateFrom.substr(-2);
                      var dfm = dateFrom.substr(5,2);
                      var dfy = dateFrom.substr(0,4);

                      var dtd = dateTo.substr(-2);
                      var dtm = dateTo.substr(5,2);
                      var dty = dateTo.substr(0,4);
                      $("tbody tr:eq("+index+")").find("input#type").val(conv.typeLnd)
                      $("tbody tr:eq("+index+")").find("input#noh").val(conv.noHours)
                      $("tbody tr:eq("+index+")").find("input#from").val(dfy + "-" + dfm + "-" + dfd)
                      $("tbody tr:eq("+index+")").find("input#to").val(dty + "-" + dtm + "-" + dtd)
                      $("tbody tr:eq("+index+")").find("input#sponsor").val(conv.smt)
                      
                    }
                  })
              })
                },500)*/

                $("input:text").keyup(function(){
                  var val = $(this).val();
                  var conver = val.toUpperCase();
                  $(this).val(conver);
                })

              $("#add").on('click',function(){
                var options = $("select#tos").html()
                $("#body").append('<tr> <td id="title"> <input type="text" class="form-control" id="title"> </td> <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td> <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td> <td id="noh"><input type="text" class="form-control" id="noh"></td> <td id="type"><select name="" id="type" class="form-control"> <option value="Managerial">Managerial</option> <option value="Supervisory">Supervisory</option> <option value="Technical">Technical</option> <option value="Foundation">Foundation</option> </select></td> <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td> </tr>')
                //$("#body").append('<tr> <td id="title"> <select name="" id="tos" class="form-control"> </select> </td> <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td> <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td> <td id="noh"><input type="text" class="form-control" id="noh"></td> <td id="type"><input type="text" class="form-control" id="type"></td> <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td> </tr>')    
              })

            $("button#next").on("click",function(){
                var title = "";
                var from = "";
                var to = "";
                var noh = "";
                var type = "";
                var sponsor = "";

                $("td#title").each(function(){
                  var findTitle = $(this).find("input#title").val();
                  title += findTitle + ",";
                })
                $("td#from").each(function(){
                  var findFrom = $(this).find("input#from").val();
                  from += findFrom + ",";
                })
                $("td#to").each(function(){
                  var findTo = $(this).find("input#to").val();
                  to += findTo + ",";
                })
                $("td#noh").each(function(){
                  var findNoh = $(this).find("input#noh").val();
                  noh += findNoh + ",";
                })
                $("td#type").each(function(){
                  var findType = $(this).find("input#type").val();
                  type += findType + ",";
                })
                $("td#sponsor").each(function(){
                  var findSponsor = $(this).find("input#sponsor").val();
                  sponsor += findSponsor + ',';
                })

                var convTitle = title.substr(0,title.length-1);
                var convFrom = from.substr(0,from.length-1);
                var convTo = to.substr(0,to.length-1);
                var convNoh = noh.substr(0,noh.length-1);
                var convType = type.substr(0,type.length-1);
                var convSponsor = sponsor.substr(0,sponsor.length-1);

                $.ajax({
                  data: {
                    convTitle: convTitle,
                    convFrom: convFrom,
                    convTo: convTo,
                    convNoh: convNoh,
                    convType: convType,
                    convSponsor: convSponsor
                  },
                  type: "POST",
                  url: "storeLnd.php",
                  success: function(data){
                    window.location.href="otherinfo.php";
                  }
                })
                //
            })

            $("button#prev").on("click",function(){
                window.location.href="voluntarywork.php"
            })

            function loadSeminars(){
              var action = "loadSeminar";
              $.ajax({
                url: "proc_lnd.php",
                data: {action:action},
                type: "POST",
                success: function(data){
                  $("select#tos").html(data)
                  /*var conv = data.substr(0,-1);
                  var splitConv = data.split(',');
                  for(var a = 0; a < splitConv.length; a++){
                    $("select#tos").append('<option val='+splitConv[a]+'>'+splitConv[a]+'</option>')
                  }*/
                }
              })
            }
        })


    </script>
    
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container bg-white rounded mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTION/TRAINING PROGRAMS ATTENDED</div>
    <div class="fs-6 text-center fst-italic mb-2">(include only non LTO related seminars/trainings)</div>
    <div class="row row-cols-2 ">

    <table class="table table-bordered ">
        <thead>
        <tr>
            <th scope="col" class="text-center" rowspan="2" style="font-size: 13px">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS <BR> (Write in full)</th>
            <th scope="col" class="text-center" colspan="2">INCLUSIVE DATES</th>
            <th scope="col" style="width: 100px" class="text-center" rowspan="2">NUMBER OF HOURS</th>
            <th scope="col" style="width: 125px; font-size: 10px" class="text-center" rowspan="2">TYPE OF LD<br>(Managerial/<br>Supervisory/<br>Technical/Etc)</th>
            <th scope="col" style="width: 320px" class="text-center" rowspan="2">CONDUCTED/SPONSORED BY<br>(Write in full)</th>
        </tr>

        <tr>
          <th class="text-center">FROM</th>
          <th class="text-center">TO</th>
        </tr>
        </thead>
        <tbody id='body'>
            <tr>
                <td id="title">
                  <input type="text" class="form-control" id="title">
                </td>

                <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td>
                <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td>
                
                <td id="noh"><input type="text" class="form-control" id="noh"></td>
                <td id="type"><select name="" id="type" class="form-control">
                  <option value="Managerial">Managerial</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Technical">Technical</option>
                  <option value="Foundation">Foundation</option>
                </select></td>
                <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td>
            </tr>

            <tr>
                <td id="title">
                  <input type="text" class="form-control" id="title">
                </td>

                <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td>
                <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td>
                
                <td id="noh"><input type="text" class="form-control" id="noh"></td>
                <td id="type"><select name="" id="type" class="form-control">
                  <option value="Managerial">Managerial</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Technical">Technical</option>
                  <option value="Foundation">Foundation</option>
                </select></td>
                <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td>
            </tr>

            <tr>
                <td id="title">
                  <input type="text" class="form-control" id="title">
                </td>

                <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td>
                <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td>
                
                <td id="noh"><input type="text" class="form-control" id="noh"></td>
                <td id="type"><select name="" id="type" class="form-control">
                  <option value="Managerial">Managerial</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Technical">Technical</option>
                  <option value="Foundation">Foundation</option>
                </select></td>
                <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td>
            </tr>


            <tr>
                <td id="title">
                  <input type="text" class="form-control" id="title">
                </td>

                <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td>
                <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td>
                
                <td id="noh"><input type="text" class="form-control" id="noh"></td>
                <td id="type"><select name="" id="type" class="form-control">
                  <option value="Managerial">Managerial</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Technical">Technical</option>
                  <option value="Foundation">Foundation</option>
                </select></td>
                <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td>
            </tr>

            <tr>
                <td id="title">
                  <input type="text" class="form-control" id="title">
                </td>

                <td id="from"><input type="date" class="form-control" style="width: 130px" id="from"></td>
                <td id="to"><input type="date" class="form-control" style="width: 130px" id="to"></td>
                
                <td id="noh"><input type="text" class="form-control" id="noh"></td>
                <td id="type"><select name="" id="type" class="form-control">
                  <option value="Managerial">Managerial</option>
                  <option value="Supervisory">Supervisory</option>
                  <option value="Technical">Technical</option>
                  <option value="Foundation">Foundation</option>
                </select></td>
                <td id="sponsor"><input type="text" class="form-control" id="sponsor"></td>
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
</body>
</html>
