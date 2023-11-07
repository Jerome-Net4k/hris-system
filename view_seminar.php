<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'partials_header.php';?>
    <?php include 'connection.php';?>
    <?php include 'navbar.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <link rel="stylesheet" type="text/css" href="loading.css">
    <script src="loading.js" defer></script>
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
