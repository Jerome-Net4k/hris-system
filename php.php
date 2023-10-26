<h4>List of Participants</h4>
  <!-- Participant table -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Select Employee</th>
        <th>Employee ID (empNo)</th>
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
              <option value="<?php echo $employee['empNo']; ?>" 
                      data-fname="<?php echo $employee['fname']; ?>"
                      data-lname="<?php echo $employee['lname']; ?>"
                      data-division="<?php echo $employee['division']; ?>">
                <?php echo $employee['fname']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <input type="text" class="form-control" placeholder="Employee ID" name="empNo" value="" disabled required />
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
  function setupAutoFill($select, $inputs) {
    $select.on('change', function () {
      var selectedOption = $select.find('option:selected');
      $inputs.each(function (index, input) {
        var inputName = $(input).attr('name');
        if (inputName !== undefined) {
          $(input).val(selectedOption.data(inputName));
        }
      });
    });
  }

  // Initial setup for the first participant
  setupAutoFill($('#selectname'), $('#empNo, #firstName, #lastName, #division'));

  $('#addParticipant').on('click', function () {
    var newRow = `
      <tr>
        <td>
          <select name="employee" class="form-control selectname">
            <option value="">Select Employee</option>
            <?php foreach ($employees as $employee): ?>
              <option value="<?php echo $employee['empNo']; ?>"
                      data-empNo="<?php echo $employee['empNo']; ?>"
                      data-fname="<?php echo $employee['fname']; ?>"
                      data-lname="<?php echo $employee['lname']; ?>"
                      data-division="<?php echo $employee['division']; ?>">
                <?php echo $employee['fname']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <input type="text" class="form-control empNo" placeholder="Employee ID" name="empNo" value="" required />
        </td>
        <td>
          <input type="text" class="form-control firstName" placeholder="First Name" name="firstName" value="" required />
        </td>
        <td>
          <input type="text" class="form-control lastName" placeholder="Last Name" name="lastName" value="" required />
        </td>
        <td>
          <input type="text" class="form-control division" placeholder="Division" name="division" value="" required />
        </td>
      </tr>
    `;

    $('.participants tbody').append(newRow);
    var $newSelect = $('.participants tbody').find('select:last');
    setupAutoFill($newSelect, $newSelect.closest('tr').find('input'));
  });

  // Handle change event for dynamically added dropdowns
  $('body').on('change', '.selectname', function () {
    var $select = $(this);
    var $row = $select.closest('tr');
    var selectedOption = $select.find('option:selected');
    $row.find('.empNo').val(selectedOption.data('empNo'));
    $row.find('.firstName').val(selectedOption.data('fname'));
    $row.find('.lastName').val(selectedOption.data('lname'));
    $row.find('.division').val(selectedOption.data('division'));
  });
</script>
</body>
</html>