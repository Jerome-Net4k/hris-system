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
    <link rel="stylesheet" type="text/css" href="educbg.css">
    <title>New Account</title>
   
    <script>
        $(document).ready(function(){
            $("input#inElemGrad").hide();
            $("input#inSecGrad").hide();
            $("input#inVocGrad").hide();
            $("input#inColGrad").hide();
            $("input#inGradGrad").hide();

            $("tbody tr:gt(0)").find("input").attr('disabled',true)
            $("tbody tr:gt(0)").find("input").val("N/A");
            $("tbody tr:gt(0)").find("select").attr('disabled',true)

            $("#vocSchl").keyup(function(){
                var val = $(this).val();
                if(val === 'N/a'){
                    $("input#inVocGrad").show("fast");
                    $("tbody tr:eq(3)").find("input").attr('disabled',false)
                    $("tbody tr:eq(3)").find("input").val('')
                    $("tbody tr:eq(3)").find("select").attr('disabled',false)
                    $("tbody tr:eq(2)").find("input").val('N/A')
                }
                else{
                    $("tbody tr:eq(3)").find("input").attr('disabled',true)
                    $("tbody tr:eq(3)").find("input").val('')
                    $("tbody tr:eq(3)").find("select").attr('disabled',true)
                }
            })
            $("select#elemTo").change(function(){
                var value = $(this).val();
                if(value == 'elemDGrad'){
                    $("input#inElemGrad").show("fast");
                    $("tbody tr:eq(1)").find("input").attr('disabled',false)
                    $("tbody tr:eq(1)").find("input").val('')
                    $("tbody tr:eq(1)").find("select").attr('disabled',false)
                }
                else{
                    $("input#inElemGrad").hide("fast");
                    $("input#inElemGrad").val('')
                    $("tbody tr:gt(0)").find("input").attr('disabled',true)
                    $("tbody tr:gt(0)").find("input").val("N/A");
                    $("tbody tr:gt(0)").find("select").attr('disabled',true)
                }
            })

            $("select#secTo").change(function(){
                var value = $(this).val();
                if(value == 'secDGrad'){
                    $("input#inSecGrad").show("fast");
                    $("tbody tr:eq(2)").find("input").attr('disabled',false)
                    $("tbody tr:eq(2)").find("input").val('')
                    $("tbody tr:eq(2)").find("select").attr('disabled',false)
                }
                else{
                    $("input#inSecGrad").hide("fast");
                    $("input#inSecGrad").val('')
                    $("tbody tr:gt(1)").find("input").attr('disabled',true)
                    $("tbody tr:gt(1)").find("input").val("N/A");
                    $("tbody tr:gt(1)").find("select").attr('disabled',true)
                }
            })

            $("select#vocTo").change(function(){
                var value = $(this).val();
                if(value == 'vocDGrad'){
                    $("input#inVocGrad").show("fast");
                    $("tbody tr:eq(3)").find("input").attr('disabled',false)
                    $("tbody tr:eq(3)").find("input").val('')
                    $("tbody tr:eq(3)").find("select").attr('disabled',false)
                }
                else{
                    $("input#inVocGrad").hide("fast");
                    $("input#inVocGrad").val('');
                    $("tbody tr:gt(2)").find("input").attr('disabled',true)
                    $("tbody tr:gt(2)").find("input").val("N/A");
                    $("tbody tr:gt(2)").find("select").attr('disabled',true)
                }
            })

            $("select#colTo").change(function(){
                var value = $(this).val();
                if(value == 'colDGrad'){
                    $("input#inColGrad").show("fast");
                    $("tbody tr:eq(4)").find("input").attr('disabled',false)
                    $("tbody tr:eq(4)").find("input").val('')
                    $("tbody tr:eq(4)").find("select").attr('disabled',false)
                }
                else{
                    $("input#inColGrad").hide("fast");
                    $("input#inColGrad").val('');
                    $("tbody tr:gt(3)").find("input").attr('disabled',true)
                    $("tbody tr:gt(3)").find("input").val("N/A");
                    $("tbody tr:gt(3)").find("select").attr('disabled',true)
                }
            })

            $("select#gradTo").change(function(){
                var value = $(this).val();
                if(value == 'gradDGrad'){
                    $("input#inGradGrad").show("fast");
                    $("tbody tr:eq(5)").find("input").attr('disabled',false)
                    $("tbody tr:eq(5)").find("input").val('')
                    $("tbody tr:eq(5)").find("select").attr('disabled',false)
                }
                else{
                    $("input#inGradGrad").hide("fast");
                    $("input#inGradGrad").val('')
                    $("tbody tr:gt(4)").find("input").attr('disabled',true)
                    $("tbody tr:gt(4)").find("input").val("N/A");
                    $("tbody tr:gt(4)").find("select").attr('disabled',true)
                }
            })
            $("input:text").keyup(function(){
            var val = $(this).val();
            $(this).val(val.toUpperCase());
            })
            $("button#next").on("click",function(){

                var elemSchl = $("#elemSchl").val();
                var elecDegree = $("#elecDegree").val();
                var elemFrom = $("#elemFrom").val();
                var elemTo = "";
                if($("select#elemTo").val() === 'elemDGrad'){
                    elemTo = $("input#inElemGrad").val()
                }
                else{
                    elemTo = $("select#elemTo").val();
                }
                var elemUnit = $("#elemUnit").val();
                var elemGrad = $("#elemGrad").val();
                var elemScho = $("#elemScho").val();
                var secSch = $("#secSchl").val();
                var secDegree = $("#secDegree").val();
                var secFrom = $("#secFrom").val();
                var secTo = '';
                if($("select#secTo").val() === 'secDGrad'){
                    secTo = $("input#inSecGrad").val()
                }
                else{
                    secTo = $("select#secTo").val();
                }
                var secUnit = $("#secUnit").val();
                var secGrad = $("#secGrad").val();
                var secScho = $("#secScho").val();
                var vocSchl = $("#vocSchl").val();
                var vocDegree = $("#vocDegree").val();
                var vocFrom = $("#vocFrom").val();
                var vocTo = "";
                if($("select#vocTo").val() === 'vocDGrad'){
                    vocTo =  $("input#inVocGrad").val();
                }
                else{
                    vocTo = $("select#vocTo").val();
                }
                var vocUnit = $("#vocUnit").val();
                var vocGrad = $("#vocGrad").val();
                var vocScho = $("#vocScho").val();
                var colSchl = $("#colSchl").val();
                var colDegree = $("#colDegree").val();
                var colFrom = $("#colFrom").val();
                var colTo = "";
                if($("select#colTo").val() === 'colDGrad'){
                    colTo = $("input#inColGrad").val();
                }
                else{
                    colTo = $("select#colTo").val();
                }
                var colUnit = $("#colUnit").val();
                var colGrad = $("#colGrad").val();
                var colScho = $("#colScho").val();
                var gradSchl = $("#gradSchl").val();
                var gradDegree = $("#gradDegree").val();
                var gradFrom = $("#gradFrom").val();
                var gradTo = "";
                if($("select#gradTo").val() === 'gradDGrad'){
                    gradTo = $("input#inGradGrad").val();
                }
                else{
                    gradTo = $("select#gradTo").val();
                }
                var gradUnit = $("#gradUnit").val();
                var gradGrad = $("#gradGrad").val();
                var gradScho = $("#gradScho").val();

                $.ajax({
                    data: {
                        elemSchl:elemSchl,
                        elecDegree:elecDegree,
                        elemFrom:elemFrom,
                        elemTo:elemTo,
                        elemUnit:elemUnit,
                        elemGrad: elemGrad,
                        elemScho: elemScho,
                        secSch: secSch,
                        secDegree: secDegree,
                        secFrom: secFrom,
                        secTo: secTo,
                        secUnit: secUnit,
                        secGrad: secGrad,
                        secScho: secScho,
                        vocSchl: vocSchl,
                        vocDegree: vocDegree,
                        vocFrom: vocFrom,
                        vocTo: vocTo,
                        vocUnit: vocUnit,
                        vocGrad: vocGrad,
                        vocScho: vocScho,
                        colSchl: colSchl,
                        colDegree: colDegree,
                        colFrom: colFrom,
                        colTo: colTo,
                        colUnit: colUnit,
                        colGrad: colGrad,
                        colScho: colScho,
                        gradSchl: gradSchl,
                        gradDegree: gradDegree,
                        gradFrom: gradFrom,
                        gradTo: gradTo,
                        gradUnit: gradUnit,
                        gradGrad: gradGrad,
                        gradScho: gradScho
                    },
                    type: "POST",
                    url: "storeEducBg.php",
                    success: function(data){
                        window.location.href="serviceeligibility.php";
                    }
                })

                //window.location.href="serviceeligibility.php";
            })

            $("button#prev").on("click",function(){
                window.location.href="familybg.php"
            })
        })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container-fluid rounded bg-white mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">III. EDUCATIONAL BACKGROUND</div>
    <div class="fs-6 text-center fst-italic mb-2">(separate by comma if multiple schools attended.)</div>
    <div class="row row-cols-2 ">

    <table class="table table-bordered">
        <thead>
            <tr>
            <th rowspan="2" style="width: 150px">LEVEL</th>
            <th style="width: 300px" rowspan="2">NAME OF SCHOOL</th>
            <th style="width: 200px" rowspan="2">BASIC EDUCATION/DEGREE/<br>COURSE<br>(write in full)</th>
            <th colspan="2" >PERIOD OF ATTENDANCE</th>
            <th rowspan="2" style="width: 150px">HIGHEST LEVEL EARNED</th>
            <th rowspan="2" style="width: 150px">YEAR GRADUATED</th>
            <th style="width: 100px" rowspan="2">SCHOLARSHIP/<br>HONORS RECEIVED</th>
            </tr>

            <tr>
                <th style="width: 150px">FROM</th>
                <th style="width: 200px">TO</th>
            </tr>
        </thead>
            
        <tbody>
        <tr>
                <td class="level">ELEMENTARY</td>
                <td><input type="text" class="form-control" id="elemSchl"></td>
                <td><input type="text" class="form-control" id="elecDegree"></td>
                <td>
                    <input type="text" class="form-control" id="elemFrom">
                </td>
                <td>
                   <div class="input-group">
                   <select name="" id="elemTo" class="form-control">
                        <option value="present">Present</option>
                        <option value="elemDGrad">Date of Graduation</option>
                    </select> 
                    <input type="text" class="form-control" id="inElemGrad">
                   </div>
                </td>
                <td>
                    <input type="text" class="form-control" id="elemUnit">
                </td>
                <td>
                    <input type="text" class="form-control" id="elemGrad" >
                </td>
                
                <td><input type="text" class="form-control" id="elemScho"></td>
            </tr>   

            <tr>
                <td class="level">SECONDARY</td>
                <td><input type="text" class="form-control" id="secSchl"></td>
                <td><input type="text" class="form-control" id="secDegree"></td>
                <td>
                    <input type="text" class="form-control" id="secFrom">
                </td>
                <td>
                <div class="input-group">
                   <select name="" id="secTo" class="form-control">
                        <option value="present">Present</option>
                        <option value="secDGrad">Date of Graduation</option>
                    </select> 
                    <input type="text" class="form-control" id="inSecGrad">
                   </div> 
                </td>
                <td>
                    <input type="text" class="form-control" id="secUnit">
                </td>
                <td>
                    <input type="text" class="form-control" id="secGrad">
                </td>
                
                <td><input type="text" class="form-control" id="secScho"></td>
            </tr>   

            <tr>
                <td class="level">VOCATIONAL/TRADE COURSE</td>
                <td><input type="text" class="form-control" id="vocSchl"></td>
                <td><input type="text" class="form-control" id="vocDegree"></td>
                <td>
                    <input type="text" class="form-control" id="vocFrom">
                </td>
                <td>
                    <!-- <input type="date" class="form-control" id="vocTo"> -->
                    <div class="input-group">
                   <select name="" id="vocTo" class="form-control">
                        <option value="present">Present</option>
                        <option value="vocDGrad">Date of Graduation</option>
                    </select> 
                    <input type="text" class="form-control" id="inVocGrad">
                   </div> 
                </td>
                <td>
                    <input type="text" class="form-control" id="vocUnit">
                </td>
                <td>
                    <input type="text" class="form-control" id="vocGrad">
                </td>
                
                <td><input type="text" class="form-control" id="vocScho"></td>
            </tr>   

            <tr>
                <td class="level">COLLEGE</td>
                <td><input type="text" class="form-control" id="colSchl"></td>
                <td><input type="text" class="form-control" id="colDegree"></td>
                <td>
                    <input type="text" class="form-control" id="colFrom">
                </td>
                <td>
                    <!--<input type="date" class="form-control" id="colTo">-->
                    <div class="input-group">
                    <select name="" id="colTo" class="form-control">
                        <option value="present">Present</option>
                        <option value="colDGrad">Date of Graduation</option>
                    </select> 
                    <input type="text" class="form-control" id="inColGrad">
                   </div> 
                </td>
                <td>
                    <input type="text" class="form-control" id="colUnit">
                </td>
                <td>
                    <input type="text" class="form-control" id="colGrad">
                </td>
                
                <td><input type="text" class="form-control" id="colScho"></td>
            </tr>   

            <tr>
                <td class="level">GRADUATE STUDIES</td>
                <td><input type="text" class="form-control" id="gradSchl"></td>
                <td><input type="text" class="form-control" id="gradDegree"></td>
                <td>
                    <input type="text" class="form-control" id="gradFrom">
                </td>
                <td>
                    <!--<input type="date" class="form-control" id="gradTo"> -->
                    <div class="input-group">
                    <select name="" id="gradTo" class="form-control">
                        <option value="present">Present</option>
                        <option value="gradDGrad">Date of Graduation</option>
                    </select> 
                    <input type="text" class="form-control" id="inGradGrad">
                   </div> 
                </td>
                <td>
                    <input type="text" class="form-control" id="gradUnit">
                </td>
                <td>
                    <input type="text" class="form-control" id="gradGrad">
                </td>
                
                <td><input type="text" class="form-control" id="gradScho"></td>
            </tr>   

        </tbody>
            
            
    </table>



</div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-primary m-2 p-1" id="next">Next</button>
    </div>
</div>
</body>
</html>