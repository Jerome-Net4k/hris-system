<?php session_start(); ?>
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
          line-height:15px
        }
       
    </style>

    <script>
      $(document).ready(function(){
        
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
            type: "GET",
            url: "proc_serviceRecord.php?id=" + <?php echo $_GET['id']?> + "&proc=getHistory",
            success: function(data){
                $("#content").html(data);
            }
          })
          
      })
    </script>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container bg-white pt-2 pb-1 mt-4 mb-2 rounded">
        <p class="fs-3 fw-bold text-center">Service Record</p>  
        
        <table style="border-collapse: collapse;">
        <tr>
            <td rowspan="2" style="width:80px; font-size: .7rem;">Name:</td>
        <td  class="tr name" style="width 80px;" ><strong id="sname"></strong></td>
        <td class="tr name"  style="width:20px" ><strong id="fname"></strong></td>
                <td class="tr name" style="width:80px" ><strong id="mname"></strong></td>
                <td class="tr name" style="width:80px" ><strong id="mmname"></strong></td>

        </tr>
        <tr>
        <td style="width:70px;" class="subtag">(Surname)</td>
        <td style="width:80px" class="subtag">(Given Name)</td>
                <td style="width:100px" class="subtag">(Middle Name)</td>
                <td style="width:120px" class="subtag">(Maiden Name)</td>

        </tr>

        <tr>
            <td rowspan="2" class="name" style="width:80px; "></td>
        <td  class="tr Birthplace" style="width 100px;"><strong id="bp"></strong></td>
        <td class="tr name"  style="width:120px"><strong id="dob"></strong></td>
                <td class="tr Birthplace" style="width:80px" id="pob"><strong></strong></td>
                <td class="tr name" style="width:80px"><strong id="sex"></strong></td>

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
    <table class="table table-bordered border-dark">

        <tr>
            <th class="text-size text-center " scope="col" colspan="2" >SERVICE <br> Inclusive Date</th>
            <th class="text-size text-center" scope="col" colspan="3" style="padding-top: 20px">RECORD OF APPOINTMENT</th>
            <th  class="text-size"scope="col" colspan="3" style="padding-top: 20px">OFFICE/ENTITY/DIVISION</th>
             <th class="text-size" scope="col" colspan="1" style="padding-top: 20px">SEPARATION</th>
      </tr>

      <tr>
        
        <td class="text-size fw-bold" style="width: 20px; padding-top: 10px">FROM</td>
        <td class="text-size fw-bold" style="width: 50px; padding-top: 10px">TO</td>
        <td class="text-size fw-bold" style="width: 100px; padding-top: 10px">DESIGNATION</td>
        <td class="text-size fw-bold" style="width: 70px; padding-top: 10px">STATUS</td>
        <td class="text-size fw-bold" style="width: 55px; padding-top: 10px">SALARY</td>
        <td class="text-size fw-bold " style="width: 20px; font-size: .7rem; line-height:11px">STATION/<br>PLACE</td>
        <td class="text-size fw-bold" style="width: 50px; padding-top: 10px">BRANCH</td>
        <td class="text-size fw-bold" style="width: 50px; font-size: .7rem; line-height:13px">L/V ABS W/O PAY</td>
        <td class="text-size fw-bold" style="width: 200px; padding-top: 10px">CAUSE</TD>
      </tr>

           
         <tbody id="content">
           
         </tbody>
 
      <tr style=" border-bottom: 0px;">
      </tr>
      </table>

 
        
      
  </table>   
</div> 

</body>
</html>