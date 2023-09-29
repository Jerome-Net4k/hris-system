<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php'; ?>
    <title>Document</title>

    <script>
        $(document).ready(function(){
            $("button#chg").on("click",function(){
                var directory = "uploads/officeOrder_TravelOrder/";

            })
            $("#directory").load("testingAlert.php",function(data){
                $("#directory").html(data);
            })
        })
    </script>
</head>
<body>
    <button class="btn btn-primary m-5" id="chg">Change Directory</button>
    <h1 id="directory"></h1>
</body>
</html>