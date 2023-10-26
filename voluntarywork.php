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
    <title>New Account</title>
    <script>
        $(Document).ready(function(){
            $("#add").on("click",function(){
                    $("#body").append('<tr> <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td> <td id="from"> <input type="date" class="form-control" id="from"> </td> <td id="to"> <input type="date" class="form-control" id="to"> </td> <td id="noh"><input type="text" class="form-control" id="noh"></td> <td id="pos"><input type="text" class="form-control" id="pos"></td> </tr>')
            })
            
            $("button#next").on("click",function(){
                var nameOrg = "";
                var from = "";
                var to = "";
                var noh = "";
                var pos = "";
                $("td#nameOrg").each(function(){
                    var findNameOrg = $(this).find("input#nameOrg").val();
                    nameOrg += findNameOrg + ",";
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

                $("td#pos").each(function(){
                    var findPos = $(this).find("input#pos").val();
                    pos += findPos + ",";
                })
                
                var convNameOrg = nameOrg.substr(0,nameOrg.length-1); 
                var convFindFrom = from.substr(0,from.length-1);
                var convTo = to.substr(0,to.length-1);
                var convNoh = noh.substr(0,noh.length-1);
                var convPos = pos.substr(0,pos.length-1);

                $.ajax({
                data: {
                    convNameOrg: convNameOrg,
                    convFindFrom: convFindFrom,
                    convTo: convTo,
                    convNoh: convNoh,
                    convPos: convPos
                },
                type: "POST",
                url: "storeVoluntaryWork.php",
                success: function(data){
                    window.location.href="lnd.php";
                }
                })

            
                
            })

            $("button#prev").on("click",function(){
                window.location.href="workExp.php"
            })

        })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container rounded bg-white mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">VI. Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col" class="text-center" rowspan="2">NAME & ADDRESS OF ORGANIZATION <BR> (Write in full)</th>
            <th scope="col" class="text-center" colspan="2">INCLUSIVE DATES</th>
            <th scope="col" style="width: 100px" class="text-center" rowspan="2">NUMBER OF HOURS</th>
            <th scope="col" style="width: 320px" class="text-center" rowspan="2">POSITION / NATURE OF WORK</th>
        </tr>

        <tr>
            <th class="text-center">FROM</th>
            <th class="text-center">TO</th>
        </tr>
    </thead>

    <tbody id="body">
    <tr>
    <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td>
        <td id="from">
        <input type="date" class="form-control" id="from">
        </td>
        <td id="to">
        <input type="date" class="form-control" id="to">
        </td>
        <td id="noh"><input type="number" class="form-control" id="noh"></td>
        <td id="pos"><input type="text" class="form-control" id="pos"></td>
    </tr>

    <tr>
    <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td>
        <td id="from">
        <input type="date" class="form-control" id="from">
        </td>
        <td id="to">
        <input type="date" class="form-control" id="to">
        </td>
        <td id="noh"><input type="number" class="form-control" id="noh"></td>
        <td id="pos"><input type="text" class="form-control" id="pos"></td>
    </tr>

    <tr>
    <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td>
        <td id="from">
        <input type="date" class="form-control" id="from">
        </td>
        <td id="to">
        <input type="date" class="form-control" id="to">
        </td>
        <td id="noh"><input type="number" class="form-control" id="noh"></td>
        <td id="pos"><input type="text" class="form-control" id="pos"></td>
    </tr>

    <tr>
    <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td>
        <td id="from">
        <input type="date" class="form-control" id="from">
        </td>
        <td id="to">
        <input type="date" class="form-control" id="to">
        </td>
        <td id="noh"><input type="number" class="form-control" id="noh"></td>
        <td id="pos"><input type="text" class="form-control" id="pos"></td>
    </tr>

    <tr>
    <td id="nameOrg"><input type="text" class="form-control" id="nameOrg"></td>
        <td id="from">
        <input type="date" class="form-control" id="from">
        </td>
        <td id="to">
        <input type="date" class="form-control" id="to">
        </td>
        <td id="noh"><input type="number" class="form-control" id="noh"></td>
        <td id="pos"><input type="text" class="form-control" id="pos"></td>
    </tr>


    
    
</tbody>
<table>

    <div>
    <div class="d-flex justify-content-end pb-2 me-2">
        <button class="btn btn-dark p-1 m-2" id="add"><i class="fi fi-rr-add p-1"></i>Add Row</button>
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-primary m-2 p-1" id="next">Next</button>
    </div>
</div>
</div>
        

</div>
</div>

</body>
</html>