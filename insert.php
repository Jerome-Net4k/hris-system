<!DOCTYPE html>
<html lang="en">
<head>
   <?php include 'partials_header.php'; ?>
    <title>Document</title>

    <script>
        $(document).ready(function(){

            $("button#add").on("click",function(){
                $(".content").append('<div class="row"> <div class="col" id="itemNum"> <input type="text" class="form-control" id="itemNum"> <label for="">Item Number</label> </div> <div class="col" id="pos"> <input type="text" class="form-control" id="pos"> <label for="">Position Title</label> </div> <div class="col" id="sg"> <input type="text" class="form-control" id="sg"> <label for="">Salary Grade</label> </div> <div class="col" id="level"> <input type="text" class="form-control" id="level"> <label for="">Level</label> </div> <div class="col" id="attribution"> <input type="text" class="form-control" id="attribution"> <label for="">Attribution</label> </div> <div class="col" id="div"> <input type="text" class="form-control" id="div"> <label for="">Division</label> </div> </div>');
            })

            $("button#save").on("click",function(){

                var itemNum = "",pos = "",sg = "",type = "",level = "",div = "",attr="";

                $("div#itemNum").each(function(){
                    var findItem = $(this).find("input#itemNum").val();
                    itemNum += findItem + ",";
                })

                $("div#pos").each(function(){
                    var findPos = $(this).find("input#pos").val();
                    pos += findPos + ",";
                })

                $("div#sg").each(function(){
                    var findSg = $(this).find("input#sg").val();
                    sg += findSg + ",";
                })

                $("div#level").each(function(){
                    var findLevel = $(this).find("input#level").val();
                    level += findLevel + ",";
                })

                $("div#div").each(function(){
                    var findDiv = $(this).find("input#div").val();
                    div += findDiv + ",";
                })
                $("div#attribution").each(function(){
                    var findAttr = $(this).find("input#attribution").val();
                    attr += findAttr + ",";
                })

                var convItem = itemNum.substr(0,itemNum.length-1)
                var convPos = pos.substr(0,pos.length-1);
                var convSg = sg.substr(0,sg.length-1);
                var convType = type.substr(0,type.length-1);
                var convLevel = level.substr(0,level.length-1);
                var convDiv = div.substr(0,div.length-1);
                var convAttr = attr.substr(0,attr.length-1);

                $.ajax({
                    data: {
                        convItem:convItem,
                        convPos:convPos,
                        convSg:sg,
                        convType:convType,
                        convLevel:convLevel,
                        convDiv:convDiv,
                        convAttr:convAttr
                    },
                    type: "POST",
                    url: "dbUpload.php",
                })
            })

           setInterval(function(){
            $.ajax({
                type: "POST",
                url: "getPlantila.php",
                success: function(data){
                    $("#content").html(data);
                }
            })
           },500)
        })
    </script>
</head>
<body>
    
    <div class="container-fluid">
       <div class="row">
        <div class="col border">
        <div class="mt-5">
            <div class="input-group d-flex justify-content-end pb-2">
            <button class="btn btn-dark" id="add">Add</button>
            <button class="btn btn-success" id="save">Save</button>
            </div>
            <div class="content">
                <div class="row">
                <div class="col" id="itemNum">
                    <input type="text" class="form-control" id="itemNum">
                    <label for="">Item Number</label>
                </div>
                <div class="col" id="pos">
                    <input type="text" class="form-control" id="pos">
                    <label for="">Position Title</label>
                </div>
                <div class="col" id="sg">
                    <input type="text" class="form-control" id="sg">
                    <label for="">Salary Grade</label>
                </div>
                <div class="col" id="level">
                    <input type="text" class="form-control" id="level">
                    <label for="">Level</label>
                </div>
                <div class="col" id="attribution">
                    <input type="text" class="form-control" id="attribution">
                    <label for="">Attribution</label>
                </div>
                <div class="col" id="div">
                    <input type="text" class="form-control" id="div">
                    <label for="">Division</label>
                </div>
            </div>

            
    </div>
            
        </div>
        </div>
        <div class="col">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>
                        Item Number
                    </th>
                    <th>
                        Position Title
                    </th>
                    <th>
                        Salary Grade
                    </th>
                    <th>
                        Year
                    </th>
                    <th>
                        Division
                    </th>
                    </tr>
                </thead>
                <tbody id="content">

                </tbody>
            </table>
        </div>
       </div>
    </div>
</body>
</html>