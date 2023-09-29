<?php
    require_once 'connection.php';

    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action == 'load') {
            load();
        }
        if ($action == 'save') {
            if (!empty($_POST['gsis']) && !empty($_POST['fname']) && !empty($_POST['sname']) && !empty($_POST['mname']) && !empty($_POST['pass'])) {
                if (!checkDuplicateUser($_POST['gsis'])) {
                    $gsis = $_POST['gsis'];
                    $fname = $_POST['fname'];
                    $mname = $_POST['mname'];
                    $sname = $_POST['sname'];
                    $pass = $_POST['pass'];

                    insertUser($gsis, $fname, $sname, $mname);
                    echo 'success';
                } else {
                    echo 'duplicate';
                }
            } else {
                echo 'check';
            }
        }
        if ($action == 'insertPassword') {
            if (!empty($_POST['gsis']) && !empty($_POST['newPassword'])) {
                $gsis = $_POST['gsis'];
                
                $newPassword = $_POST['newPassword'];

                // Check if the user exists and proceed if valid
                $userData = fetchUserData($gsis);
                if ($userData) {
                    insertPassword($gsis, $newPassword);
                } else {
                    echo 'invalid';
                }
            } else {
                echo 'check';
            }
        }
    }

    function fetchUserData($gsis)
    {
        include 'connection.php';
        $query = "SELECT * FROM `personalinfo_table` WHERE `gsis` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $gsis);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    function insertUser($gsis, $fname, $sname, $mname)
    {
        include 'connection.php';
        $query = "INSERT INTO `personalinfo_table` (`gsis`, `fname`, `sname`, `mname`) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssss', $gsis, $fname, $sname, $mname);
        $stmt->execute();
    }

    function insertPassword($gsis, $newPassword)
    {
        include 'connection.php';
        $query = "UPDATE personalinfo_table SET pass = ? WHERE gsis = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $newPassword, $gsis);
        $stmt->execute();

        // Fetch the updated password from the database
        $query = "SELECT pass FROM personalinfo_table WHERE gsis = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $gsis);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Display the password form in the modal
        echo '<div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="' . $userData['username'] . '" readonly>
        </div>
        <div class="form-group">
            <label for="currentPassword">Current Password:</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="' . $row['pass'] . '" readonly>
        </div>
        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword">
        </div>';
    }

    function load()
    {
        include 'connection.php';
        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : ''; // Get the search term if it exists
        $query = "SELECT * FROM `personalinfo_table` WHERE `gsis` LIKE CONCAT('%', ?, '%') OR `mname` LIKE CONCAT('%', ?, '%') OR `fname` LIKE CONCAT('%', ?, '%') OR `sname` LIKE CONCAT('%', ?, '%')";

        $stmt = $con->prepare($query);
        $stmt->bind_param('ssss', $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . $row['gsis'] . '</td>
                <td>' . $row['sname'] . '</td>
                <td>' . $row['fname'] . '</td>
                <td>' . $row['mname'] . '</td>
                
                <td>
                <div class="password-toggle-wrapper">';

            if (!empty($row['pass'])) {
                echo '<input type="password" value="' . $row['pass'] . '" readonly class="password-toggle-field" />';
            } else {
                echo '<input type="password" placeholder="password" class="password-toggle-field" />';
            }

            echo '
            </div>

                </td>
                <td>
                <button class="btn btn-primary btn-sm insert-password-btn" data-bs-toggle="modal" data-bs-target="#insertmodal" data-gsis="' . $row['gsis'] . '" data-pass="' . $row['pass'] . '">Update/Insert Password <i class="bi bi-key"></i></button>
            </td>
            
                </tr>';
        }
    }

    function checkLoginCredentials($username, $password)
    {
        include 'connection.php';
        $query = "SELECT * FROM `user_table` WHERE `user_name` = ? AND `password` = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
?>

<script>
    function togglePassword(element) {
        var passwordField = $(element).closest('.password-toggle-wrapper').find('.password-toggle-field');
        if ($(element).is(':checked')) {
            passwordField.attr('type', 'text');
        } else {
            passwordField.attr('type', 'password');
        }
    }
</script>
