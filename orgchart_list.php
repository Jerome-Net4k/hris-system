<!doctype html>
<html>
<head>
    <?php include ("partials_header2.php");?>
</head>
<style>
    .nav-content{
		display:  flex;
		/* position: fixed; */
		flex-wrap: wrap;
		width: 100%;
		/* height: 50px; */
		background-color: #1548C3;
		padding: 13.5px 12px;
		z-index: 100;
	}
	.column {
		display: flex;
		place-items: center;
		flex: 1;
		/* margin: 10px;
		padding: 10px; */
		/* background-color: #f2f2f2; */
	}
	.orgchart-list{
		width: 300px;

	}
	.custom-select {
    position: relative;
    display: inline-block;
  	}
	.custom-select{
		width: 70%;	
	}
	.select-items{
		width: 100%;
	}
  
  .form-selected {
	position: sticky;
    background-color: #eee;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .select-items {
    position: absolute;
    z-index: 9999;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #fff;
    border-radius: 4px;
    overflow-y: scroll;
    max-height: 200px;
    border: 1px solid #ccc;
  }
  
  .select-item {
    padding: 8px 16px;
    cursor: pointer;
  }
  .select-items .select-search{
	/* position: -webkit-sticky; */
	position: sticky;
	top: 0;
  }
  .select-hide {
    display: none;
  }
  
  .select-search {
    margin-top: 4px;
    padding: 8px;
    border: 1px solid #ccc;
    border-top: none;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
  }
</style>
<script>
    $(document).ready(function() {
        $(".select-item").on("click", function() {
            var sel = $(this).text();
            window.location = "orgchart_list.php?select=" + sel;
        });

        $("#updateside").click("click",function(){
				// var sidecontent = $(this).val();
				var sidecontent = $("#searchchart").text();
				alert(sidecontent);
			  	if(sidecontent != ""){
					// alert(sidecontent);
					$.ajax({
					// alert(under);
						// it direct to the php file with this ID input
						url: "orgchart_search.php",//orgsearchunder.php
						method: "POST",
						data:{sidecontent:sidecontent}, //the value of this is the value you want to search

						// if the data successful the data will show
						success:function(data){
						// alert(under);
							$("#load-to-update").html(data);
							var upname = $("#upname").val();
							var upid = $("#upid").val();
							var upimg = $("#up-img").val();
							$("#deleid").val(upid);
							$("#delename").val(upname + ".png");
							$("#personelname").text(upname);
						}
					});
			  	}else{
					// display none
					$("#load-to-update").html("<b style='font-size: 25px;'>NO DATA FOUND</b>");
			  	}
		});

    });
</script>
<body>
	<?php include "connection.php";
    	$alert= "";
    	if(isset($_POST['but_update'])){
            if(isset($_POST['update'])){
                foreach($_POST['update'] as $updateid){
 
                    $name = $_POST['name_'.$updateid];
                    $sg = $_POST['sg_'.$updateid];
                    $position = $_POST['position_'.$updateid];
                    $head_office = $_POST['head_office_'.$updateid];
                    $subline = $_POST['subline_'.$updateid];
                    $image = $_POST['image_'.$updateid];
 
                    if($name !='' && $position != '' ){
                        $updateUser = "UPDATE orgchart SET 
                            name='".$name."',sg='".$sg."',position='".$position."',head_office='".$head_office."',subline='".$subline."'
                        WHERE id=".$updateid;
                        mysqli_query($con,$updateUser);
                    }
                     
                }
                $alert = '<div class="alert alert-success alert-dismissible">
						    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
						    <strong>Success!</strong> This alert box could indicate a successful or positive action.
						  </div>';
            }else{
                $alert = '<div class="alert alert-warning alert-dismissible">
						    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
						    <strong>Uncheck!</strong> Something wrong, Please check the data first.
						  </div>';
            }
        }
    ?>

<!-- Adding new personnel -->
<?php
    if (isset($_GET['select'])){
        $pos = $_GET['select'];
        ?>
        <div class="nav-content">
            <div class="column">
                <a href="#">
                    <img src="images/logo/logo.png" alt="" width="80" height="80" class="d-inline-block align-text-top">
                </a>
                <!-- <h3>Organization chart</h3> -->
                <h3 class="text-white" style="margin-left:16px;">ORGANIZATIONAL UPDATE RECORDS</h3>
            </div>
            <div class="column">
                <div class="custom-select" style="width: 100%">
                <div class="form-selected">
                    <i class="bi bi-search"></i>
                    <span id="searchchart" name="searchchart" class="searchedit"><?php echo $pos;?></span>
                </div>

                <div class="select-items select-hide">
                    <input type="search" class="form-control w-70 select-search" placeholder="Search...">
                    <div class="select-item"></div>
                    <?php include("orgchart_selectpos.php");?>
                </div>
                </div>
                <button type="button" id="updateside" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="margin-left:5px;">UPDATE</button>
			    <button type="button" id="printchartbtn" id="printchartbtn" class="btn btn-primary" style="margin-left:5px;">PRINTCHART</button>
                <!-- <button type="button" class="btn btn-primary addnewchart" id="addnewchart"addnewchart style="margin-left:5px;" data-bs-toggle="modal" data-bs-target="#myModal">ADD NEW PERSONNEL</button> -->
            </div>
            
            <div class="column">
                <button type="button" class="btn btn-primary addnewchart" id="addnewchart"addnewchart style="margin-left:5px;" data-bs-toggle="modal" data-bs-target="#myModal">ADD NEW PERSONNEL</button>
            </div>

        </div>
        <div class="return-chart mt-4 mx-5">
            <p class="text-primary b"><a href="orgchart_main.php" style="text-decoration: none;"><i class='fas fa-arrow-left' style='font-size:18px'></i> <b> RETURN TO CHART</b></a></p>
        </div>


    <div class='container'>
        <!-- <div class="table-responsive"> -->
            <?php echo $alert; ?>
            <form method='post'>
            	<div class="d-flex justify-content-start mb-2">
                	<input type='submit' value='Update Selected Records' class="btn btn-success" name='but_update'>
            	</div>

                <table class="table table-hover">
                    <tr style='background: whitesmoke;'>
                        <!-- Check/Uncheck All-->
                        <th><input type='checkbox' id='checkAll' class="form-check-input"></th>
                        <th>Name</th>
                        <th style="width: 100px;">sg</th>
                        <th>position</th>
                        <th style="width: 70px;">Head office</th>
                        <th style="width: 70px;">Subline</th>
                        <th>image</th>
                        <th>action</th>
                    </tr>
                    <?php
                        $query = "SELECT * FROM orgchart where under='$pos'"; // asc limit 10
                        $result = mysqli_query($con,$query);
     
                        while($row = mysqli_fetch_array($result) ){
                            $id = $row['id'];
                            $name = $row['name'];
                            $sg = $row['sg'];
                            $position = $row['position'];
                            $head_office = $row['head_office'];
                            $subline = $row['subline'];
                            $image = $row['image'];
                        ?>
                            <tr>
                                <td>
                                    <input type='checkbox' class="form-check-input" name='update[]' value='<?= $id ?>' >
                                </td>
                                <td>
                                    <input type='text' class="form-control" name='name_<?= $id ?>' value='<?= $name ?>' >
                                </td>
                                <td>
                                    <input type='text' class="form-control" name='sg_<?= $id ?>' value='<?= $sg ?>' >
                                </td>
                                <td>
                                    <input type='text' class="form-control" name='position_<?= $id ?>' value='<?= $position ?>' >
                                </td>
                                <td>
                                    <input type='text' class="form-control" name='head_office_<?= $id ?>' value='<?= $head_office ?>' data-bs-toggle="tooltip" data-bs-placement="right" title="Write 'YES' if true! 'NO' if not!">
                                </td>
                                <td>
                                    <input type='text' class="form-control" name='subline_<?= $id ?>' value='<?= $subline ?>' data-bs-toggle="tooltip" data-bs-placement="right" title="Write 'YES' if true! 'NO' if not!">
                                </td>
                                <td>
                                    <input type='file' name='image_<?= $id ?>' value='<?= $image ?>' style="width: 180px;">
                                </td>
                                <td style="display: flex;">
                                    <!-- <a href="orgchart_search_updel.php?delete=<?php echo $row['id'];?>" class="btn btn-danger mb-2">REMOVE</a> -->
                                                                
                                    <a data-bs-toggle="modal" data-bs-target="#RemovemyModal2" class="btn btn-danger mb-2 editbtndelete">DELETE</a>
                                    <!-- <a href="orgchart_delete.php?id=<?= $id ?>" class="btn btn-danger mb-2">REMOVE</a> -->
                                    <a href="orgchart_list.php?select=<?= $row['position'] ?>" class="btn btn-success mb-2" style="margin-left:5px;">UNDER</a>
                                    <!-- <a href="" data-bs-toggle="modal" data-bs-target="#MovemyModal" class="btn btn-primary mb-2 editbtnmoveto" style="margin-left:5px;">MOVE TO</a> -->
                                </td>
                            </tr>
                            
                        <?php
                        }?>
                    
                </table>
<!-- Add new personnel under this -->
                <!--  -->
            </form>
            
            <!-- </div> -->
        <?php }else{
            echo 'No data found!.';
       } ?>
        
<!-- Add form -->
        <div class="modal" id="myModal">
            <?php include ("orgchart_addform.php");?>
        </div>
        

<!-- Move to form -->
        <div class="modal" id="MovemyModal">
            <div class="modal-dialog">
             <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ORGANIZATION CHART</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
                <div class="modal-body">
                    <h4 class="fw-bolder text-center">Move this personnel</h4>

                    <form id="movemyform" method="POST">
                        <input type="text" id="moveid" name="moveid">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" id="movename" name="movename" placeholder=" " class="form-control required" required>
                                <label for="sname">Name on the position</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" id="moveposition" name="moveposition"  placeholder=" " class="form-control required" required>
                                <label for="sname">POSITION</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" id="moveunder" name="moveunder"  placeholder=" " class="form-control required" required>
                                <label for="sname">WHERE TO MOVE?</label>
                            </div>
                            <div style="position: relative;">fsdsdsdsdsdsdsd</div>
                        </div>
            
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary mb-2" id="submit" name="submit">Move now</button>
                            <!-- <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button> -->
                        </div>
                    </form>
                </div>
            </div>
            </div> 
        </div>

<!-- remove the id -->
        <div class="modal" id="RemovemyModal2">
            <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">ORGANIZATION CHART</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
				<p class="text-center mt-3" style="color: red;">NOTE: This record will delete permanently!</p>

            <form id="delmyform" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
                <form id="delmyform" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="delename" name="delename">
					<input type="hidden" id="deleid" name="deleid">
					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="typeyes" name="typeyes" placeholder=" " class="form-control required" required>
							<label for="sname">Please type yes/YES to continue deleting...</label>
						</div>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer"> 
						<button type="submit" class="btn btn-danger mb-2" name="delsubmit" id="delsubmit">Delete</button>
					</div>
                </form>
				</div>
			</form>

            </div>
            </div> 
        </div>

    </div>
    
<!-- orgchart sidebar code -->
	
		<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">UPDATE RECORD</h4>
					<button class="btn-close" data-bs-dismiss="#exampleModalToggle" data-bs-toggle="modal"></button>
				</div>

				<div class="container container-sidebar bg-white rounded mt-4 mb-4">
				
					<form id="upmyform" method="POST" enctype="multipart/form-data">
					<!-- <form action="orgchart_search_update.php" method="POST" enctype="multipart/form-data"> -->
						<div id="load-to-update">
							
						</div>
					<!-- <button class="btn btn-danger" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">DELETE</button> -->
					</form>
				</div>
			</div>
		</div>
		</div>
	<!-- remove -->
	<!-- <div class="modal" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  	<div class="modal-dialog modal-dialog-centered">
    	<div class="modal-content">
      		<div class="modal-header">
                <h4 class="modal-title">ORGANIZATION CHART</h4>
				<button class="btn-close" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"></button>
            </div>

			<form id="delmyform" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="text" id="delename" name="delename">
					<input type="text" id="deleid" name="deleid">
					<div class="col">
						<div class="form-floating mb-2">
							<input type="text" id="typeyes" name="typeyes" placeholder=" " class="form-control required" required>
							<label for="sname">Please type yes/YES to continue deleting...</label>
						</div>
					</div>
					<div class="modal-footer"> 
						<button type="submit" class="btn btn-danger mb-2" name="delsubmit" id="delsubmit">Delete</button>
					</div>
				</div>
			</form>
        </div>
    </div> 
    </div> -->


</body>
<!-- For checkbox all -->
        <script type="text/javascript">
            $(document).ready(function(){
                // Check/Uncheck ALl
                $('#checkAll').change(function(){
                    if($(this).is(':checked')){
                        $('input[name="update[]"]').prop('checked',true);
                    }else{
                        $('input[name="update[]"]').each(function(){
                            $(this).prop('checked',false);
                        }); 
                    }
                });
                
                // Checkbox click
                $('input[name="update[]"]').click(function(){
                    var total_checkboxes = $('input[name="update[]"]').length;
                    var total_checkboxes_checked = $('input[name="update[]"]:checked').length;
 
                    if(total_checkboxes_checked == total_checkboxes){
                        $('#checkAll').prop('checked',true);
                    }else{
                        $('#checkAll').prop('checked',false);
                    }
                });
           
                $('.editbtndelete').on('click', function() {
                    alert("asdf");
                    var $tr = $(this).closest('tr');
                    var data = $tr.find("td:not(:last-child)").map(function() {
                        return $(this).find("input").val();
                    }).get();
                    console.log(data);
                    $('#delename').val(data[1] + '.png');
                    $('#deleid').val(data[0]);
                });

                $('.editbtnmoveto').on('click', function() {
                    // alert("asdf");
                    var $tr = $(this).closest('tr');
                    var data = $tr.find("td:not(:last-child)").map(function() {
                        return $(this).find("input").val();
                    }).get();
                    console.log(data);
                    $('#moveid').val(data[0]);
                    $('#movename').val(data[1]);
                    $('#moveposition').val(data[3]);
                });



            });
        </script>
        
        <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        </script>


</html>