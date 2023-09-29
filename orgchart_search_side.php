<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="customizedropdown.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <?php include ("partials_header2.php");?>
</head>
<style>
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
<body>
	<?php require_once 'connection.php'; //connection?>
    <!-- <div class="custom-select2" style="width: width-content;">
        <div class="select-selected2">Select an option</div>
        <div class="select-items2 select-hide2">
            <input type="text" class="select-search2" placeholder="Search...">
            <div class="select-item2">Option 1</div>
            <div class="select-item2">asdfa 2</div>
            <div class="select-item2">Opttttion 3</div>
            <div class="select-item2">rtr 4</div>
            <div class="select-item2">rt 5</div>
        </div>
    </div> -->
    		<div class="custom-select" style="width: width-content;">
				<div class="form-selected" id="under" name="under" required><i class="bi bi-search"></i> Search chart . . .</div>

				<div class="select-items select-hide">
					<input type="search" class="form-control select-search" placeholder="Search...">
					<div class="select-item">LOAD CHART</div>
					<?php include("orgchart_selectpos.php");?>
				</div>
			</div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		 // Get the custom select element
		 var customSelect = document.querySelector(".custom-select");

	// Get the selected element
	var selectSelected = customSelect.querySelector(".form-selected");

	// Get the items container element
	var selectItems = customSelect.querySelector(".select-items");

	// Get the item elements
	var selectItem = selectItems.querySelectorAll(".select-item");

	// Get the search input element
	var selectSearch = customSelect.querySelector(".form-control");

	// Add a click event listener to the selected element
	selectSelected.addEventListener("click", function() {
	// Toggle the active class on the selected element to show/hide the dropdown
	this.classList.toggle("select-arrow-active");

	// Toggle the active class on the items container to show/hide the items
	selectItems.classList.toggle("select-hide");
	});

	// Loop through the item elements and add a click event listener to each one
	for (var i = 0; i < selectItem.length; i++) {
	selectItem[i].addEventListener("click", function() {
		// Get the text content of the selected item
		var selectedText = this.textContent;

		// Set the text content of the selected element to the selected text
		selectSelected.textContent = selectedText;
		selectSelected.value = selectedText;

		// Remove the active class from all item elements
		for (var j = 0; j < selectItem.length; j++) {
		selectItem[j].classList.remove("same-as-selected");
		}

		// Add the active class to the selected item element
		this.classList.add("same-as-selected");

		// Hide the items container
		selectItems.classList.add("select-hide");

		// Remove the active class from the selected element
		selectSelected.classList.remove("select-arrow-active");
	});
	}

	// Add a keyup event listener to the search input to filter the items
	selectSearch.addEventListener("keyup", function() {
	// Get the value of the search input
	var input = this.value.toLowerCase();

	// Loop through the item elements and hide/show based on search input
	for (var i = 0; i < selectItem.length; i++) {
		// Get the text content of the current item
		var text = selectItem[i].textContent.toLowerCase();

		// If the search input matches the item text, show the item
		if (text.indexOf(input) > -1) {
		selectItem[i].style.display = "block";
		} else {
		// Otherwise, hide the item
		selectItem[i].style.display = "none";
		}
	}
	});
	</script>
</html>