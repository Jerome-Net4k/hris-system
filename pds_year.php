<?php
if (isset($_POST['yearload']) && isset($_POST['endload'])) {
    $startyear = $_POST['yearload'];
    $endyear = $_POST['endload'];
    echo '<th style="width: 125px;">
    <div class="d-flex justify-content-center bpsort">GSIS #
        <div class="sort" data-value="bpNo">
            <div class="arrow arrow1 chevron1"></div>
        </div>
    </div>
</th>
<th style="width: 350px; position: sticky; left: 0; top: 0; background: white; z-index: 20">
    <div class="d-flex justify-content-center bpsort">NAME
        <div class="sort" data-value="lname">
            <div class="arrow arrow1 chevron2"></div>
        </div>
    </div>
</th>';
    for ($i = $startyear; $i > $endyear; $i--) {
        echo "<th style='padding: 0 15px;'>$i</th>";
    }
}
?>
    <script>
        const buttons = $('.sort');
        const arrows = $('.arrow');

        let arr = ['active', 'active1', 'active2'];

        buttons.on('click', function() {
            var sortval = $(this).data('value');
            const buttonIndex = buttons.index(this);
            arrows.each(function(arrowIndex) {
            const arrow = $(this);
            if (arrowIndex === buttonIndex) {
                if (!arrow.hasClass(arr[buttonIndex])) {
                arrow.addClass(arr[buttonIndex]);
                var sortwhat = "DESC";
                load2(sortval, sortwhat);
                } else {
                arrow.removeClass(arr[buttonIndex]);
                var sortwhat = "ASC";
                load2(sortval, sortwhat);
                // DECREMENT VALUE
                // alert("down");
                }
            } else {
                arrow.removeClass(arr[arrowIndex]);
            }
            });
        });
        
        function load2(sortval, sortwhat) {
            var selectedOption = $("#pdsyear").find(":selected");
            var yearload = new Date(selectedOption.val()).getFullYear();
            var endload = yearload - 15;
            // alert(sortval + sortwhat + endload +yearload);
            $.ajax({
                url: "pds_checklistproc.php",
                type: "POST",
                data: {
                    yearload: yearload,
                    endload:endload,
                    sortval:sortval,
                    sortwhat:sortwhat
                },
                success: function(data) {
                    $("#pdslist").html(data);
                }
            });
        }
</script>