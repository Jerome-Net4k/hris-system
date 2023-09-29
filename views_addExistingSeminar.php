<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php' ?>
    <title>Seminars</title>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
</head>
<body>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<script>
    $(document).ready(function(){
        setInterval(function(){
            $("input#amount").keyup(function(){
            $("#total").text(getTotal());
        })
        },500)

        $("#addExp").on("click",function(e){
            e.preventDefault();
            $("div#expenses").append('<div class="row mt-2 mb-2"> <div class="col exp"> <input type="text" class="form-control" id="expenses" name="expenses"> </div> <div class="col am"> <input type="number" class="form-control w-50" id="amount" name="amount"> </div> </div>');
        })

        $("form#form").submit(function(e){
            var seminar_form = new FormData(this);
            var exp = "",am = "";
            $(".exp").each(function(){
                    var findExp = $(this).find("#expenses").val();
                    exp += findExp + ",";
            })
            $(".am").each(function(){
                    var findAm = $(this).find("#amount").val();
                    am += findAm + ",";  
            })
            var total = getTotal();
            var convExp = exp.substr(0,exp.length-1);
            var convAm = am.substr(0,am.length-1);
            seminar_form.append('am',convAm);
            seminar_form.append('exp',convExp);
            seminar_form.append('total',total);
            seminar_form.append('action','upload'); 
            e.preventDefault();
            $.ajax({
                url: "proc_lnd.php",
                data: seminar_form,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data){
                    alert(data)
                }
            })
        })


        
        /*$("button#save").on("submit",function(e){
           var title = $("input#title").val();
           var dateFrom = $("input#dateFrom").val();
           var dateTo = $("input#dateTo").val();
           var smt = $("input#smt").val();
           var nh = $("input#noHours").val();
           var type = $("select#type").val();
           var venue = $("input#venue").val();
           var oo = $("input#oo").val();
           var obj = $("textarea#obj").val();
           var rem = $("textarea#rem").val();
           var action = "upload"
           
           $.ajax({
            data: {
                action: action,
                title: title,
                dateFrom:dateFrom,
                dateTo:dateTo,
                smt:smt,
                nh:nh,
                type:type,
                venue:venue,
                oo:oo,
                obj:obj,
                rem:rem
            },
            url: "proc_lnd.php",
            type: "POST",
            success: function(data){
                alert(data)
            }
            
           })
        })*/

        function getTotal(){
            var total = 0;
            $("input#amount").each(function(){
                if($(this).text != ""){
                    var conv = Number($(this).val());
                    total += conv;
                }
            })
            return total;
        }
    })
</script>
<?php include 'navbar.php' ?>
    <div class="container bg-white mt-2 border rounded">
        <h1>Add Existing Seminar Data</h1>
        <form id="form" enctype="multipart/form-data">
           <div class="row">
                <div class="col">
                <label for="">Title Of Seminar</label>
                <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="col">
                <div class="row">
                    <div class="col-4">
                    <label for="">From</label>
                    <input type="date" class="form-control" id="dateFrom" name="dateFrom">    
                    </div>
                    <div class="col-4"> 
                    <label for="">To</label>
                    <input type="date" class="form-control" id="dateTo" name="dateTo">
                    </div>
                </div>
                </div>
           </div>
           <div class="row mt-2">
            <div class="col">
                <label for="">SMTs/RSs/Conducted By</label>
                <input type="text" class="form-control" name="smt">
            </div>
            <div class="col">
                <label for="">No. of Hours</label>
                <input type="number" class="form-control w-25" name="nh">

            </div>
           </div>
           <div class="row mt-2">
            <div class="col">
                <label for="">Type of L&D Inervention</label>
                <select name="type" class="form-control" >
                    <option value="Managerial">
                        Leadership/Managerial
                    </option>
                    <option value="Technical">
                        Technical
                    </option>
                    <option value="Foundation">
                        Foundation
                    </option>
                </select>
            </div>

            <div class="col">
                <label for="">Venue</label>
                <input type="text" class="form-control" name="venue">
            </div>
           </div>
            <hr>
           <div id="expenses">
           <div class="row mt-2 mb-2">
            <div class="col exp">
                <h4>Expenses</h4>
                <label for="">Type of Expenses</label>
                <input type="text" class="form-control" id="expenses" name="expenses">
            </div>

            <div class="col am">
                <h4>&nbsp</h4>
                <label for="">Amount</label>
                <input type="number" class="form-control w-50" id="amount" name="amount">
            </div>
           </div>

           <div class="row mt-2 mb-2">
            <div class="col exp">
                <input type="text" class="form-control" id="expenses" name="expenses">
            </div>

            <div class="col am">
                <input type="number" class="form-control w-50" id="amount" name="amount">
            </div>
           </div>
           </div>

           <div class="row mb-2 mt-2">
           <div class="col"><button class="btn btn-primary" id="addExp">Additional Expenses</button></div>
            <div class="col"><h4>Total: <span id="total">0</span></h4></div>
           </div>

           <hr>

           <div class="row">
            <h4>Office Order/Travel Order</h4>
            <div class="col">
                <input type="file" class="form-control w-50" name="oo">
            </div>
           </div>

           <hr>

            <div class="row">
                <h4>Objective</h4>
                    <div class="col">
                    <textarea name="obj" cols="10" rows="10" class="form-control mb-2" ></textarea>
                    </div>
            </div>

            <hr>

            
                <div id="refFile">
                    <div class="row mb-2">  
                    <h4>Reference Files</h4>
                    <div class="col">
                        <input type="file" name="file[]" class="form-control w-50" multiple>
                    </div>
                </div>
                </div>
            <hr>

           <div class="row">
                <div class="col">
                <h4>Remarks</h4>
                <textarea name="rem" cols="10" rows="10" class="form-control mb-2"></textarea>
                </div>
           </div>

           <div class="row">
                <div class="col d-flex justify-content-end m-2"><button class="btn btn-primary" id="save" name="submit" type="submit"><i class="fi fi-rr-upload pe-1"></i>Save</button></div>            
           </div>
</form>
</body>
</html>