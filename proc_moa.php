<?php 
    include 'table_moa.php';
    $moadata = new moadata();

    if(!isset($_GET['id'])){
        moarec($moadata);
    }

function moarec($moadata) {
include "connection.php";
        $input = $_POST["input"];
        $query = "SELECT * FROM moa_tbl";
        if ($input != "") {
          $query .= " WHERE name LIKE '{$input}%' ";
        }
      
        $result = mysqli_query($con, $query);
      
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            // generate the HTML for the table row, including the image tag
            echo '<tr>
                    <td>' . $row["name"] . '</td>
                    <td>' . date("F j, Y", strtotime($row["subdate"])) . '</td>
                    <td class="text-center">
                      <a href=\'moafiles/'.$row["moafile"].'\' target=\'_blank\' class=\'btn btn-outline-primary btn-sm\'><i class="pt-4 fi fi-rr-expand"></i> | VIEW</a>
                      <button class="btn btn-outline-primary btn-sm mr" id="update" value="' . $row["id"] . '" data-bs-toggle="modal" data-bs-target="#exampleModal1"><i class="fi fi-rr-pen-clip"></i> | UPDATE</button>
                    </td>
                  </tr>';
          }
        } else {
          echo '<tr>
                  <td colspan="3" class="text-center"><h1>No Record Found</h1></td>
                </tr>';
        };
      }
      
    
    ?>
