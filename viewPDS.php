<!DOCTYPE html>
<html lang="en">
<head>
   <?php include 'header.php';?>
    <title>Document</title>
</head>
<style>
    tr,th {
        font-size: .9em;
    }
</style>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-center pt-2 pb-2">
            <h1>PERSONAL DATA SHEET</h1>
        </div>
        <div class="d-flex justify-content-center">
        <table class="table table-bordered">
               <thead>
                    <tr class="bg-secondary">
                        <th class="text-center fw-bolder" colspan="4">I. PERSONAL INFORMATION</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th rowspan="4" class="w-25">2. Surname<br>&nbspFirst Name<br>&nbspMIDDLE NAME</th>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp</td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp</td>
                            <td class="fw-lighter w-25">NAME EXTENSION(JR., SR.):</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp</td>
                        </tr>
                        <tr>
                            <td>3. DATE OF BIRTH (mm/dd/yyy)</td>
                            <td colspan="2"></td>
                            <td rowspan="3" class="w-50"></td>
                        </tr>
                        <tr>
                            <td>4. PLACE OF BIRTH</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>5. SEX</td>
                            <td colspan="2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="male" value="male">
                                <label class="form-check-label" for="inlineCheckbox1">Male</label>
                                    </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="female" value="female">
                                <label class="form-check-label" for="inlineCheckbox2">Female</label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
</body>
</html>