
        <?php
            include "connection.php";

            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $select_stmt = mysqli_prepare($con, "SELECT * FROM orgchart WHERE id = ?");

                // Bind the parameters to the prepared statement
                mysqli_stmt_bind_param($select_stmt, "i", $id);

                // Execute the SELECT statement
                mysqli_stmt_execute($select_stmt);

                // Get the result set from the executed SELECT statement
                $result_set = mysqli_stmt_get_result($select_stmt);

                // Fetch the data from the result set
                $row = mysqli_fetch_assoc($result_set);
            }
        ?>