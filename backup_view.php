<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'partials_header.php';?>
    <?php include 'connection.php';?>
    <?php include 'navbar.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>

    <style>
* {
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

.row {
  margin-left: 0px;
  margin-right: 0px;
  text-align: left;
  display: flex;
}

.column {
  width: 30%;
  padding: 5px;
  text-align: left;
  overflow-x: hidden;
}



table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  table-layout: fixed;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  background-color: #fff;
  font-size: 12px;  
}


th {
  color: white; /* Header text color */
  text-align: left , 100%;  
  padding: 16px;
  background-color: #0d6efd; 
  top: 0;    
  position: sticky;
}

td {
padding: 16px;
white-space: pre-wrap;
text-align: left;
}

tbody {
  height: 680px;
  overflow-y: auto;
}

.sticky-header {
  position: sticky;
  top: 0;
  background-color: #0d6efd;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}


tr:hover {
  background-color: #cce6ff;   
}


caption {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 10px;
  caption-side: Center;
}
h3 {
text-align: center;
}
/* Add this CSS to your existing styles */
.table-header {
background-color: #666; /* Header background color */
color: white; /* Header text color */
text-align: center; /* Center align text within the header cell */
padding: 16px;
}


</style>
   
   <!DOCTYPE html>
   <html>
   <head>
       <!-- Include Bootstrap CSS -->
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   </head>
   <body>
   <?php

// Database configuration
$servername = "localhost";  // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "hr_management"; // Replace with your database name

// Create a database connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}




// Get the bpNo value from the query parameter or a form submission
$bpNo = $_GET['bpNo']; // You should sanitize and validate user input

// Query to fetch employee data based on bpNo that matches empNo in lnd_table
$sql = "SELECT e.* FROM emp_table e
        INNER JOIN lnd_table l ON e.bpNo = l.empNo
        WHERE e.bpNo = '$bpNo'";

$result = mysqli_query($connection, $sql);

if ($result) {
    // Display the table headers
    echo "<table>";

    while ($row = mysqli_fetch_assoc($result)) {
        // Display the employee data in rows
        echo "<tr>";
        echo "<td>" . $row['bpNo'] . "</td>";
        echo "<td>" . $row['lname'] . "</td>";
        echo "<td>" . $row['fname'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>


      </tbody>
    </table>
  </div>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </body>
   </html>
