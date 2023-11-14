<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php' ?>
    <title>Seminars</title>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="educbg.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
            $("input#idNo").keyup(function(){
            var id = $(this).val();
            var action = "getData";
            var row = $(this).closest("div.step").index();
            $.ajax({
                data: {id:id, action: action},
                type: "POST",
                url: "proc_psipop.php",
                success: function(data){
                    var conv = jQuery.parseJSON(data);
                    $(".step:eq("+row+")").find("input#name").val(conv.name)
                    $(".step:eq("+row+")").find("input#sg").val(conv.salary_grade)
                    $(".step:eq("+row+")").find("input#pos").val(conv.pos_title)
                    $(".step:eq("+row+")").find("input#office").val(conv.division)
                }
            })
        })
        },500)

        $("button#addPart").on("click",function(e){
            e.preventDefault();
            $("div.participants").append('<div class="row step mt-2"> <div class="col-1"> <input type="number" class="form-control" id="idNo"> </div> <div class="col-3"> <input type="text" class="form-control" id="name"> </div> <div class="col-2"> <input type="text" class="form-control" id="sg"> </div> <div class="col"> <input type="text" class="form-control" id="pos"> </div> <div class="col"> <input type="text" class="form-control" id="office"> </div> </div>');
        })

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
            var exp = "",am = "",id = "",name = "",sg = "", pos = "",office = "";
            $(".exp").each(function(){
                var findExp = $(this).find("#expenses").val();
                exp += findExp + ",";
            })
            $(".am").each(function(){
                var findAm = $(this).find("#amount").val();
                am += findAm + ",";
            })
            $(".step").each(function(){
                var findId = $(this).find("input#idNo").val();
                id += findId + ",";

                var findName = $(this).find("input#name").val();
                name += findName + ",";

                var findSg = $(this).find("input#sg").val();
                sg += findSg + ",";

                var findPos = $(this).find("input#pos").val();
                pos += findPos + ",";

                var findOffice = $(this).find("input#office").val();
                office += findOffice + ",";
            })
            var total = $("#total").text();
            var convExp = exp.substr(0,exp.length-1);
            var convAm = am.substr(0,am.length-1);
            var convId = id.substr(0,id.length-1);
            var convName = name.substr(0,name.length-1);
            var convSg = sg.substr(0,sg.length-1);
            var convPos = pos.substr(0,pos.length-1);
            var convOffice = office.substr(0,office.length-1);

            seminar_form.append('id',convId);
            seminar_form.append('name',convName);
            seminar_form.append('sg',convSg);
            seminar_form.append('pos',convPos);
            seminar_form.append('off',convOffice);

            seminar_form.append('am',convAm);
            seminar_form.append('exp',convExp);
            seminar_form.append('total',total);
            seminar_form.append('action','uploadNew');
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
        <h1>Add New Seminar Data</h1>
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

           <?php
// Replace the following line with your database connection code
$conn = mysqli_connect("localhost", "root", "", "hr_management");

// Replace the following line with your database query to fetch the list of employees
$sql = "SELECT bpNo, fname, lname, division FROM emp_table";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
  // Fetch the employees from the result set
  $employees = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  // Handle the error if the query failed
  echo "Error fetching employees from the database: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Include necessary CSS and JavaScript libraries -->
</head>
<body>
  <h4>List of Participants</h4>
  <!-- Participant table -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Select Employee</th>
        <th>BP NO</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Division</th>
      </tr>
    </thead>
    <tbody class="participants">
      <tr>
        <td>
          <select name="employee" class="form-control" id="selectname">
            <option value="">Select Employee</option>
            <?php foreach ($employees as $employee): ?>
              <option value="<?php echo $employee['bpNo']; ?>" 
                      data-fname="<?php echo $employee['fname']; ?>"
                      data-lname="<?php echo $employee['lname']; ?>"
                      data-division="<?php echo $employee['division']; ?>">
                      <?php echo $employee['fname'] . ' ' . $employee['lname']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Employee ID" name="bpNo" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="First Name" name="firstName" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Last Name" name="lastName" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Division" name="division" value="" disabled required />
        </td>
      </tr>
    </tbody>
  </table>

  <button class="btn btn-primary mt-2" id="addParticipant">Add Participant</button>

  <!-- JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
    $('body').on('change', '.selectname', function() {
      var selectedOption = $(this).find('option:selected');
      $(this).closest('tr').find('input[name="bpNo"]').val(selectedOption.val());
      $(this).closest('tr').find('input[name="firstName"]').val(selectedOption.data('fname'));
      $(this).closest('tr').find('input[name="lastName"]').val(selectedOption.data('lname'));
      $(this).closest('tr').find('input[name="division"]').val(selectedOption.data('division'));
    });

    // JavaScript to add a new participant input field
    $('#addParticipant').on('click', function() {
      $('.participants').append(`
      <tr>
        <td>
          <select name="employee" class="form-control selectname">
            <option value="">Select Employee</option>
            <?php foreach ($employees as $employee): ?>
              <option value="<?php echo $employee['bpNo']; ?>" 
                      data-fname="<?php echo $employee['fname']; ?>"
                      data-lname="<?php echo $employee['lname']; ?>"
                      data-division="<?php echo $employee['division']; ?>">
                <?php echo $employee['fname']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Employee ID" name="bpNo" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="First Name" name="firstName" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Last Name" name="lastName" value="" disabled required />
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Division" name="division" value="" disabled required />
        </td>
      </tr>
      `);
    });
  </script>
</body>
</html>





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