<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>PLANTILA</title>
    <STYLE>
        .text{
            font-size: 0.7rem;
        }
        .textdata{
            font-size: 0.8rem;
        }
        
        .data{
            border: none;
            border-left: none;
            border-right: none;
        }
        .header{
          font-size: 0.8rem;
        }

    </STYLE>
    
    <script>
      $(document).ready(function(){
        var year = new Date().getFullYear();
        var division = 'OASEC';

        load(year,division);
        getGrandTotal(year,division);
        getFilledTotal(year,division);
        getUnFilledTotal(year,division)
       
        $("button#search").on("click",function(){
            load(year,division);
            getGrandTotal(year,division);
            getFilledTotal(year,division);
            getUnFilledTotal(year,division)
            $("#office").text(div(division));
            
        })

        $("select#year").change(function(){
            year = $(this).val();
        })

        $("select#div").change(function(){
            division = $(this).val();
        })

      })

      function getUnFilledTotal(year,div){
        var proc = 'unfilledTotal';
        $.ajax({
          type: "POST",
          data: {proc:proc,div:div,year:year},
          url: "proc_psipop.php",
          success: function(data){
            var conv = jQuery.parseJSON(data);
            $("td#unfilPos").text(conv.position); 
            $("td#unfilAuth").text(conv.auth);
            $("td#unfilAct").text(conv.act);
          }
        })
      }

      function getFilledTotal(year,div){
        var proc = 'filledTotal';
        $.ajax({
            type: "POST",
            data: {proc:proc,div:div,year:year},
            url: "proc_psipop.php",
            success: function(data){
            var conv = jQuery.parseJSON(data);
            $("td#filledPos").text(conv.position); 
            $("td#filledAuth").text(conv.auth);
            $("td#filledAct").text(conv.act);
          }
        })
      }

      function load(year,div){
        var proc = "load"
        $.ajax({
            type: "POST",
            data: {proc:proc,div:div,year:year},
            url: "proc_psipop.php",
            success: function(data){
                $("#content").html(data);
            }
        })
      }

      function getGrandTotal(year,div){
        var proc = "grandTotal";
        $.ajax({
            type: "POST",
            data: {proc:proc,div:div,year:year},
            url: "proc_psipop.php",
          success: function(data){
            var conv = jQuery.parseJSON(data);
            $("span#totPos").text(conv.position); 
            $("span#totAuth").text(conv.auth);
            $("span#totAct").text(conv.act);

            $("td#totPos").text(conv.position);
            $("td#totAuth").text(conv.auth);
            $("td#totAct").text(conv.act);
          }
        }) 
      }

      function div(div){
             let division;
        switch(div){
            case 'OASEC': division = "OFFICE OF THE SECRETARY ASSISTANT";
            break;
            case 'PMP': division = "PLATE MAKING PLANT";
            break;
            case 'ADMIN': division = "ADMINISTRATIVE DIVISION";
            break;
            case 'FD': division = "FINANCIAL DIVISION";
            break;
            case 'LES': division = "LAW ENFORCEMENT SERVICE";
            break;
            case 'MD': division = "MANAGEMENT   DIVISION";
            break;
            case 'TAS': division = "TRAFFIC ADJUCATION SERVICE";
            break;
            case 'OD': division = "OPERATIONS DIVISION";
            break;
            case 'MID': division = "MANAGEMENT INFORMATION DIVISION";
            break;
            default: division = "UNKNOWN";
        }
        return division;
      }
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
        <div class="container-fluid bg-white pb-2">
        <div class="d-flex justify-content-center pt-3">
            <div class="input-group w-25">
              <select name="" id="year" class="form-control">
              <option value="" hidden>Fiscal Year</option>
              <?php
                include 'connection.php';
                $query = "SELECT * FROM `psipop_table` GROUP BY `year`";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    echo '<option value="'.$row['year'].'">'.$row['year'].' </option>';
                }
              ?>
              </select>
              <select name="" id="div" class="form-control">
              <option value="" hidden>Office/Division</option>
              <?php
                include 'connection.php';
                $query = "SELECT * FROM `psipop_table` GROUP BY `division`";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    echo '<option value="'.$row['division'].'">'.$row['division'].' </option>';
                }
              ?>
              </select>
              <button class="btn btn-primary" id="search"><i class="fi fi-rr-search pe-1"></i>Search</button>
            </div>
            </div>
            <p class="text-center fs-5 pt-2">PERSONEL SERVICES ITEMIZATION AND PLANTILA OF PERSONNEL (PSIPOP) <br><span class="text-center fs-5 pt-2" id="fiscalYearDisp">for the Fiscal Year : 2023</span> </p>
          
            

        <table class="table table-bordered" style="border: 1px;">
            <tr>
                <td class="text-start" colspan="9">Department: Department of Transportation</td>
                <td class="text-start" colspan="9">Bureau/Agency: Office of the Secretary</td>
            </tr>
            <tr>
                <td rowspan="2" class="header" style="width:400px; padding-top: 40px;">ITEM NUMBER <br><span style="margin-top: 40px;">(1)</span></td>
                <td rowspan="2" class="header"  style="width:300px; padding-top: 40px;">POSITION TITLE and <br>SALARY GRADE <br>(2)</td>
                <td colspan="2" class="header"  style="width: 10%">ANNUAL SALARY</td>
                <td class="text header" rowspan="2"style="width:15px; padding-top: 20px;">S<br>T<br>E<br>P<br>(5)</td>
                <td colspan="2" style="line-spacing: 1px">Area</td>
                <td class="text" rowspan="2"style="width:15px; padding-top: 20px;">L<br>E<br>V<br>E<br>L<br>(8)</td>
                <td rowspan="2" class="header" style="width: 100px; padding-top: 40px;">P/P/A ATTRIBUTION<br>(9)</td>
                <td rowspan="2" class="header" style="width: 150px; padding-top: 40px;">NAME OF INCUMBENT<br>(10)</td>
                <td rowspan="2"  class="header"style="width: 10px; padding-top: 30px;">S<BR>E<BR>X<br>(11)</td>
                <td rowspan="2" class="header" style="width: 70px; padding-top: 40px;">DATE OF BIRTH<br>(12)</td>
                <td rowspan="2" class="header" style="width: 1px; padding-top: 40px;">TIN<br>(13)</td>
                <td rowspan="2" class="header" style="width: 100px; padding-top: 40px;">DATE OF ORIGINAL APPOINTMENT<br>(14)</td>
                <td rowspan="2" class="header" style="width: 10px; padding-top: 40px;">DATE OF LAST PROMOTION<br>(15)</td>
                <td rowspan="2" class="text" style="width: 10px">S<BR>T<BR>A<BR>T<BR>U<BR>S<br>(16)</td>
                <td rowspan="2" class="header" style="width: 10px; padding-top: 40px;">CIVIL SERVICE ELIGIBILITY<br>(17)</td>
            </tr>
            <tr>
                <td style="padding-top: 20px; font-size: .8rem">AUTHORIZED <br>(3)</td>
                <td style=" padding-top: 20px; font-size: .8rem">ACTUAL<br>(4)</td>
                <td class="text" style="width:15px;">C<br>O<br>D<br>E<br>(6)</td>
                <td class="text" style="width:15px">T<br>Y<br>P<br>E<br>(7)</td>
            </tr>
            <tr class="data">
                <td class="text-start textdata data" colspan="5">84.000 <span style="padding-left:80px;"  id="office">OFFICE OF THE SECRETARY ASSISTANT </span>
                </td>
            </tr>
            <tr class="data"><td class="data text-start" colspan="12">
                <span class="usog textdata" style="padding-left:200px">Total Positions: </span>
                <span class="usog textdata" style="padding-left:70px" id="totPos"></span>
                <span class="usog textdata" style="padding-left:30px" id="totAuth"> </span>
                <span class="usog textdata" style="padding-left:30px" id="totAct"></span>
            </td>
            </tr>

            <tbody id="content">
            
    
      </tbody>  

    </table>

        <table style="border: 1px solid black; border-collapse: collapse; border-bottom:0; border-left:0px; border-right:0;">
        <tr>
            <td rowspan="3" class="text-start textdata" style="padding-bottom:30px">
                Grandtotal
            </td>
            <td style="padding-left: 40px" class="text-start textdata">
                No. of Filled Positions: 
            </td>
            <td class="textdata"style="padding-left: 40px" id="filledPos">
                8 
            </td>
            <td class="textdata" style="padding-left: 60px" id="filledAuth">
                6,805,200
            </td>
            <td class="textdata" style="padding-left: 60px" id="filledAct">
                6,805,200
            </td>
        </tr>    
            <tr>
                <td class="textdata" style="padding-left: 40px">
                    No. of Unfilled Positions:
                </td>
                <td class="textdata" style="padding-left: 40px" id="unfilPos">
                    3
                </td>
                <td class="textdata" style="padding-left: 60px" id="unfilAuth">
                    1,179,996
                </td>
                <td class="textdata" class="text-end"style="padding-left: 60px" id="unfilAct">
                    0
                </td>
            </tr>     

            <tr>
                <td class="textdata" style="padding-left: 40px">
                    No. of Itemized Positions:
                </td>
                <td class="textdata" style="padding-left: 40px" id="totPos">
                    3
                </td>
                <td class="textdata" style="padding-left: 60px" id="totAuth">
                    1,179,996
                </td>
                <td class="textdata" class="text-end"style="padding-left: 60px" id="totAct">
                    0
                </td>
            </tr> 
            
            
    </table>
       <div class="container-fluid mt-2">
                <div class="d-flex justify-content-center">
                <table style="border: 1px solid black">
          <tr class="textdata">
            <td  class="text-start"  style="width:500px; padding-bottom: 50px;">Department of Budget and Management</td>
            <td  class="text-start data" style="width:500px; padding-bottom: 30px">I certify to the correctness of the entries from columns 4 to 17 and that employees 
          whose name appear on the above PSIPOP are the incumbents of the position.</td>
          <td  class="text-center" style="width:500px; padding-bottom: 50px; ">APPROVED BY:</td>

          </tr>
          <tr style="border-left: 1px;">
            <td  style="width:350px; font-size: .9rem"><u>WENDEL E. AVISADO</u><br><p style="line-height: 7px; font-size: .8rem">ACTING SECRETARY</p></td>
            <td class="data" style="width:100px; font-size: .9rem"><u>ALFREDO LIM</u><br><p style="line-height: 7px; font-size: .8rem">Human Resource Management</p></td>
            <td  style="width:100px; font-size: .9rem"><u>EDGAR C. GALVANTE</u><br><p style="line-height: 7px; font-size: .8rem">Head of Agency</p></td>


          </tr>


          
          
          
      </table>
                </div>
       </div>
</div>


</body>
</html>