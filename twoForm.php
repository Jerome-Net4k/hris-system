<label for="month">Select Month:</label>
  <select id="month" name="month">
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>

  <script>
    //Edit the month selection option
    // Get the month value from the PHP code
    var selectedMonth = '<?php echo date('F', strtotime($monthRecords[0]['leavemonth'])); ?>';

    // Find the select element
    var monthSelect = document.getElementById('month');

    // Loop through the options and set the selected option based on the value
    for (var i = 0; i < monthSelect.options.length; i++) {
      if (monthSelect.options[i].text === selectedMonth) {
        monthSelect.options[i].selected = true;
        break;
      }
    }
  </script>
          <td>'.date('F', strtotime($monthRecords[0]['leavemonth'])).' </td>