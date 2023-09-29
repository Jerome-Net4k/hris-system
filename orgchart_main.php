
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- Separate the header of the project -->
	<!-- Includes the script, css link and etc. -->
	<?php include ("partials_header2.php");?>

	<link href="css/style.css" rel="stylesheet"type="text/css"/>

<style>
	.nav-content{
		display:  flex;
		position: fixed;
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
</head>
<body>
	<?php require_once 'connection.php'; //connection?>
	
	<div class="nav-content">
		<div class="column">
			<a href="#">
				<img src="images/logo/logo.png" alt="" width="80" height="80" class="d-inline-block align-text-top">
			</a>
			<h3 class="text-white" style="margin-left:16px;">ORGANIZATIONAL CHART</h3>
		</div>
		<div class="column">
			<!-- search -->
			<div class="custom-select" style="width: 50%;">
				<div class="form-selected" id="searchchart" name="searchchart" required><i class="bi bi-search"></i> Search chart . . .</div>

				<div class="select-items select-hide">
					<input type="search" class="form-control w-100 select-search" placeholder="Search...">
					<!-- <div class="select-item">LOAD CHART</div> -->
					<?php include("orgchart_selectpos.php");?>
				</div>	
			</div>
			<button type="button" id="updateside" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="margin-left:5px;" disabled>UPDATE</button>
			<!-- <i class="fa-regular fa-pen-to-square"></i> -->
			<!-- <a href="orgchart_print.php" target="_blank" class="btn btn-primary" style="margin-left:5px;" disabled>PRINTCHART</a> -->
			<button type="button" id="printchartbtn" id="printchartbtn" class="btn btn-primary" style="margin-left:5px;" disabled>PRINTCHART</button>
		
			<button type="button" class="btn btn-primary addnewchart" id="addnewchart"addnewchart style="margin-left:5px;" data-bs-toggle="modal" data-bs-target="#myModal" disabled>ADD.NEW</button>
		</div>
	</div>
	
<!-- return to dashboard -->

<!-- Orgchart load -->
	<div class="container">
		<div class="tree" id="tree">
				<div id="content">
							
				</div>
		</div>
	</div>


<!-- Submitting data to database form. -->
	<div class="modal" id="myModal">
		<?php include ("orgchart_addform.php");?>	
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
	<div class="modal" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  	<div class="modal-dialog modal-dialog-centered">
    	<div class="modal-content">
      		<div class="modal-header">
                <h4 class="modal-title" id="personelname"></h4>
				<button class="btn-close" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"></button>
				
            </div>
			<form id="delmyform" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
				<p class="text-center mt-3" style="color: red;">NOTE: This record will delete permanently!</p>
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
				</div>
			</form>
        </div>
    </div> 
    </div>


	<div class="modal fade" id="chartoption" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">ORGCHART OPTION</h4>
					<button class="btn-close" data-bs-dismiss="#chartoption" data-bs-toggle="modal"></button>
				</div>

				<div class="modal-body text-center">
					<h4 style="color: red;" id="selectposchart"></h4>
					<p>POSITION</p>
					<hr>
  					<button class="btn btn-success form-control mb-2" value="">ORG CHART DEPARTMENT</button>
  					<button class="btn btn-info form-control" value="">ORG CHART DEPARTMENT</button>
					<hr>
					<p>* Choose the desired chart to load.</p>
				</div>
			</div>
		</div>
	</div>



 </body>
</html>  
