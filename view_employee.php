<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'partials_header.php';?>
    <?php include 'connection.php';?>
    <?php include 'navbar.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>
   <?php
   include 'connection.php';
   
   if (isset($_GET['bpNo'])) {
       $bpNo = $_GET['bpNo'];
   
       // Fetch employee details
       try {
           $employeeSql = "SELECT * FROM emp_table WHERE bpNo = :bpNo";
           $employeeStmt = $conn->prepare($employeeSql);
           $employeeStmt->bindParam(':bpNo', $bpNo);
           $employeeStmt->execute();
   
           // Display the employee data
           $employeeRow = $employeeStmt->fetch(PDO::FETCH_ASSOC);
           var_dump($employeeRow);
       } catch (PDOException $e) {
           echo "Error: " . $e->getMessage();
       }
   
       // Fetch seminars attended by the employee
       try {
           $seminarSql = "SELECT * FROM lnd_table WHERE empNo = :empNo";
           $seminarStmt = $conn->prepare($seminarSql);
           $seminarStmt->bindParam(':empNo', $employeeRow['empNo']);
           $seminarStmt->execute();
   
           // Display the seminar data
           $seminarData = $seminarStmt->fetchAll();
           var_dump($seminarData);
       } catch (PDOException $e) {
           echo "Error: " . $e->getMessage();
       }
   
       $conn = null;
   } else {
       echo "Invalid request.";
   }
   ?>
   
   <!DOCTYPE html>
   <html>
   <head>
       <!-- Include Bootstrap CSS -->
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   </head>
   <body>
       <!-- Employee Details -->
       <h1>Employee Details</h1>
       <p><strong>BP NO:</strong> <?= $employeeRow["bpNo"] ?></p>
       <p><strong>Last Name:</strong> <?= $employeeRow["lname"] ?></p>
       <p><strong>First Name:</strong> <?= $employeeRow["fname"] ?></p>
   
       <!-- Seminars Attended Table -->
       <h2>Seminars Attended</h2>
       <table class="table">
           <thead>
               <tr>
                   <th>Title</th>
                   <th>Type</th>
                   <th>From Date</th>
                   <th>To Date</th>
               </tr>
           </thead>
           <tbody>
               <?php foreach ($seminarData as $seminarRow) { ?>
                   <tr>
                       <td><?= $seminarRow["title"] ?></td>
                       <td><?= $seminarRow["type"] ?></td>
                       <td><?= $seminarRow["lndFrom"] ?></td>
                       <td><?= $seminarRow["lndTo"] ?></td>
                   </tr>
               <?php } ?>
           </tbody>
       </table>
   
       <!-- Include Bootstrap and jQuery JavaScript -->
       <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   </body>
   </html>
