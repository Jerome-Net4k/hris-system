<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'partials_header.php' ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>Document</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container-fluid pt-2">

    <h1>201 Files</h1>
    
    <div class="row pt-2 rounded bg-white">
        <div class="col m-1 border">
            <h2>Regular Active</h2>
            <div class="row mb-2">
                <div class="col">
                    <h4>Region:</h4>
                </div>
                <div class="col-10 ps-1">
                    <select name="" id="" class="form-control w-25 p-1">
                        <option value="">Central Office</option>
                    </select>
                </div>
            </div>
                <div class="input-group w-50">
                <select name="" id="" class="form-control" style="max-width: 28%;">
                    <option value="">Assigned No.</option>
                    <option value="">Surname</option>
                    <option value="">Firstname</option>
                    <option value="">Middle Name</option>
                    <option value="">Region</option>
                </select>
                <input type="text" class="form-control">
                <button class="btn btn-primary">Search</button>
                </div>
            
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Region</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>1</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                    </tr>

                    <tr>
                    <td>2</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                    </tr>

                    <tr>
                    <td>3</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                    </tr>
                    <tr>
                    <td>4</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                    </tr>

                    <tr>
                    <td>5</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col border m-1">
            <h2>Inactive</h2>
            <div class="input-group w-50">
                <select name="" id="" class="form-control" style="max-width: 28%;">
                    <option value="">201 No.</option>
                    <option value="">Surname</option>
                    <option value="">Firstname</option>
                    <option value="">Middle Name</option>
                    <option value="">Region</option>
                </select>
                <input type="text" class="form-control">
                <button class="btn btn-primary">Search</button>
            </div>
            <table class="table table-bordered mt-2">
            <thead>
                    <tr>
                        <th style="width: 90px">201 No.</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Region</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <td>000001</td>
                    <td>Adduru</td>
                    <td>Ronald Karl</td>
                    <td>Cabunoc</td>
                    <td>Central Office</td>
                </tbody>
            </table>
        </div>
    </div>

    </div>
</body>
</html>