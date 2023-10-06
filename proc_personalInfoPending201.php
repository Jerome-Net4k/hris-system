<?php
include 'table_personalInfoTable.php';
$personalInfo = new personalInfo();
if(!isset($_POST['searchBar']) && !isset($_GET['id'])){
    loadPersonalInfo($personalInfo);
}
if(isset($_POST['searchBar'])){
    searchPersonalInfo($personalInfo);
}
if(isset($_GET['id'])){ 
    echo getPdsInfo($personalInfo);
}

function loadPersonalInfo($personalInfo){
    $result = $personalInfo->get_pendingTbl();
    $noCheck = $personalInfo->get_existNo();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<tr id="pendingRow' . $row['idno'] . '">
            <td>'.$row['surname'].'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['middlename'].'</td>
            <td>'.$row['ext'].'</td>
            <td>'.$row['region'].'</td>     
            <td>' .
            // '<form method="post" id="assignForm' . $row['idno'] . '" action="">' .
            // '<input type="hidden" name="idNo" value="' . $row['idno'] .'">' .
            // '<input type="text" id="idInput' . $row['idno'] . '" required oninput="checkNo' . $row['idno'] . '();">
            // <button type="submit" id="idInputSubmit' . $row['idno'] . '" form="assignForm' . $row['idno'] . '" value="Submit">SUBMIT</button>

            '<input type="text" id="idInput' . $row['idno'] . '" required oninput="checkNo' . $row['idno'] . '();">' .
            '<button id="pendingSubmit' . $row['idno'] . '" disabled>SUBMIT</button>' .
            // '<button id="test' . $row['idno'] . '">TEST</button>' .

            '</td>
            </tr>';


            echo '<script>

            function checkNo' . $row['idno'] . '(){
                var a = document.getElementById("idInput' . $row['idno'] . '").value;
                const numbers = '. $noCheck .';
                if(numbers.some(item => item.idNo == a) || a == "" || a == 0){
                document.getElementById("pendingSubmit' . $row['idno'] . '").disabled = true;
                } else {
                document.getElementById("pendingSubmit' . $row['idno'] . '").disabled = false;
                }

            }

            $("button#pendingSubmit' . $row['idno'] . '").on("click",function(){
                
                var assignNoInput = $("#idInput' . $row['idno'] . '").val();
                var idno = ' . $row['idno'] . ';
                var pendingTransfer = true;

                $.ajax({
                    data: {
                        assignNoInput:assignNoInput,
                        pendingTransfer:pendingTransfer,
                        idno:idno

                    },
                        type: "POST",
                        url: "uploadPDInactive.php",
                        beforeSend:function(){
                            return confirm("Assign this 201 No.??");
                         },
                        success: function(data){
                          if (data == "success"){
                            document.getElementById("pendingRow' . $row['idno'] . '").style.display = "none";
                            iziToast.success({
                                position: "topRight",
                                title: "OK",
                                message: "Successfully inserted record!",
                            });
                          } else{
                            iziToast.warning({
                      position: "topRight",
                      title: "Failed",
                      message: "Please check your input."
                      });
                          }
                        }
                      })
        })

            

            $("button#test' . $row['idno'] . '").on("click",function(){
      
                      $.ajax({
                              type: "POST",
                              url: "uploadPDInactive.php",
                              success: function(data){
                                
                              }
                            })
              })
        
              </script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
           
        }   
    }
    else{
        echo '<tr><td colspan="5" class="text-center"><h1>No Data Found</h1></td></tr>';
    }
}



?>