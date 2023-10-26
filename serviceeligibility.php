<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'partials_header.php'; ?>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
    <title>New Account</title>
  
<script>
        $(Document).ready(function(){
          $("input:text").keyup(function(){
            var val = $(this).val();
            $(this).val(val.toUpperCase());
            })
            
            $("#add").on("click",function(){
                    $("#body").append('<tr> <td id="career"><input type="text" class="form-control" id="career"></td> <td id="rating"><input type="text" class="form-control" id="rating"></td> <td id="doe"><input type="date" class="form-control" id="doe"></td> <td id="poe"><input type="text" class="form-control" id="poe"></td> <td id="lNum"> <input type="text" class="form-control" id="lNum"> </td> <td id="dov"> <input type="date" class="form-control" id="dov"> </td> </tr>')
            })

            $("button#next").on("click",function(){
                var career = "";
                var rating = "";
                var doe = "";
                var poe = "";
                var lNum = "";
                var dov = "";
                $("td#career").each(function(){
                  var getCareer = $(this).find("select#career").val();
                  career += getCareer + ",";
                })
                $("td#rating").each(function(){
                  var getRating = $(this).find("input#rating").val();
                  rating += getRating + ",";
                })
                $("td#doe").each(function(){
                  var getDoe = $(this).find("input#doe").val();
                  doe += getDoe + ",";
                })
                $("td#poe").each(function(){
                  var getPoe = $(this).find("input#poe").val();
                  poe += getPoe + ",";
                })
                $("td#lNum").each(function(){
                  var getLNum = $(this).find("input#lNum").val();
                  lNum += getLNum + ",";
                })
                $("td#dov").each(function(){
                  var getDov = $(this).find("input#dov").val();
                  dov += getDov + ",";
                })

                var convCareer = career.substring(0,career.length-1);
                var convRating = rating.substring(0,rating.length-1);
                var convDoe = doe.substring(0,doe.length-1);
                var convPoe = poe.substring(0,poe.length-1);
                var convLNum = lNum.substring(0,lNum.length-1);
                var convDov = dov.substring(0,dov.length-1);

                $.ajax({
                  data: {convCareer: convCareer,
                  convRating: convRating,
                  convDoe: convDoe,
                  convPoe: convPoe,
                  convLNum: convLNum,
                  convDov: convDov},
                  type: "POST",
                  url: "storeServiceEligibility.php",
                  success: function(data){
                    window.location.href="workExp.php";
                  }
                })
            })

            $("button#prev").on("click",function(){
                window.location.href="educbg.php"
            })
        })
    </script>
</head>
<body>
<?php include 'navbar.php'; ?>
    
                                    <!--END OF NAVBAR!-->


    <div class="container-fluid table-responsive rounded bg-white mt-4 mb-4">
    <h1 class="fw-bolder text-center mb-2">PERSONAL DATA SHEET</h1>
    <hr>

    <div class="fs-4 text-center fst-italic mb-2">IV. CIVIL SERVICE ELIGIBILITY</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <Th rowspan="2" class="text-center">CAREER SERVICE/RA 1080<br>(BOARD/ BAR) <BR>UNDER SPECIAL LAWS/CES/CSEE <BR> BARANGAY ELIGIBILITY/ DRIVER LICENSE</th>
            <th style="width: 150p; padding-bottom: 50px" rowspan="2" class="text-center">RATING <BR> (if Applicable)</th>
            <th style="width: 150px; padding-bottom: 50px" rowspan="2" class="text-center">DATE OF EXAMINATION /<BR> CONFERMENT</th>
            <th rowspan="2" class="text-center" style="padding-bottom: 50px">PLACE OF EXAMINATION/<br>CONFERMENT</th>
            <th  class="text-center" colspan="3" style="padding-bottom: 40px">LICENSE (if applicable)</th>
        </tr>
        <tr>
          <th class="text-center" style="padding-bottom: 20px">NUMBER</th>
          <th class="text-center" style="padding-bottom: 20px">DATE OF VALIDITY</th>
        </tr>
    </thead>
    <tbody id="body">
    

      <tr>
      <td id="career"><select name="" id="career" class="form-control">
        <option value="CIVIL SERVICE ELIGIBLE - PROFESSIONAL">CIVIL SERVICE ELIGIBLE - PROFESSIONAL(CSP)</option>
        <option value="CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL">CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL(CSSP)</option>
        <option value="BAR/BOARD ELIGIBILITY">BAR/BOARD ELIGIBILITY(RA1080)</option>
        <option value="BARANGAY HEALTH WORKER ELIGIBLITY">BARANGAY HEALTH WORKER ELIGIBLITY(BWHE)</option>
        <option value="BARANGAY NUTRITION SCHOLAR ELIGIBILITY">BARANGAY NUTRITION SCHOLAR ELIGIBILITY(BNSE)</option>
        <option value="Barangay Official Eligibility">Barangay Official Eligibility(BOE)</option>
        <option value="Electronic Data Processing Specialist Eligibility">Electronic Data Processing Specialist Eligibility(EDPSE)</option>
        <option value="Foreign School Honor Graduate Eligibility">Foreign School Honor Graduate Eligibility(FSHGE)</option>
        <option value="Honor Graduate Eligibility">Honor Graduate Eligibility(PD 907)</option>
        <option value="Sanggunian Member Eligibility">Sanggunian Member Eligibility(SME)</option>
        <option value="Scientific and Technological Specialists Eligibility">Scientific and Technological Specialists Eligibility(STSE)</option>
        <option value="Skills Eligibility - Category II">Skills Eligibility - Category II(CATII)</option>
        <option value="Veteran Preference Rating Eligibility">Veteran Preference Rating Eligibility(VPRE)</option>
        <option value="Licensure Examination for Teachers">Licensure Examination for Teachers(LET)</option>
        <option value="Professional Driver's License/Non-Professional Driver's License">Professional Driver's License/Non-Professional Driver's License</option>
        <option value="Others">Others</option>
      </select></td>
      <td id="rating"><input type="text" class="form-control" id="rating"></td>
      <td id="doe"><input type="date" class="form-control" id="doe"></td>
      <td id="poe"><input type="text" class="form-control" id="poe"></td>
      <td id="lNum">
      <input type="text" class="form-control" id="lNum">
      </td>
      <td id="dov">
      <input type="date" class="form-control" id="dov">   
        </td>
    </tr>

    <tr>
      <td id="career"><select name="" id="career" class="form-control">
        <option value="CIVIL SERVICE ELIGIBLE - PROFESSIONAL">CIVIL SERVICE ELIGIBLE - PROFESSIONAL(CSP)</option>
        <option value="CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL">CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL(CSSP)</option>
        <option value="BAR/BOARD ELIGIBILITY">BAR/BOARD ELIGIBILITY(RA1080)</option>
        <option value="BARANGAY HEALTH WORKER ELIGIBLITY">BARANGAY HEALTH WORKER ELIGIBLITY(BWHE)</option>
        <option value="BARANGAY NUTRITION SCHOLAR ELIGIBILITY">BARANGAY NUTRITION SCHOLAR ELIGIBILITY(BNSE)</option>
        <option value="Barangay Official Eligibility">Barangay Official Eligibility(BOE)</option>
        <option value="Electronic Data Processing Specialist Eligibility">Electronic Data Processing Specialist Eligibility(EDPSE)</option>
        <option value="Foreign School Honor Graduate Eligibility">Foreign School Honor Graduate Eligibility(FSHGE)</option>
        <option value="Honor Graduate Eligibility">Honor Graduate Eligibility(HGE)</option>
        <option value="Sanggunian Member Eligibility">Sanggunian Member Eligibility(SME)</option>
        <option value="Scientific and Technological Specialists Eligibility">Scientific and Technological Specialists Eligibility(STSE)</option>
        <option value="Skills Eligibility - Category II">Skills Eligibility - Category II(CATII)</option>
        <option value="Veteran Preference Rating Eligibility">Veteran Preference Rating Eligibility(VPRE)</option>
        <option value="Licensure Examination for Teachers">Licensure Examination for Teachers(LET)</option>
        <option value="Professional Driver's License/Non-Professional Driver's License">Professional Driver's License/Non-Professional Driver's License</option>
        <option value="Others">Others</option>
      </select></td>
      <td id="rating"><input type="text" class="form-control" id="rating"></td>
      <td id="doe"><input type="date" class="form-control" id="doe"></td>
      <td id="poe"><input type="text" class="form-control" id="poe"></td>
      <td id="lNum">
      <input type="text" class="form-control" id="lNum">
      </td>
      <td id="dov">
      <input type="date" class="form-control" id="dov">   
        </td>
    </tr>

    <tr>
      <td id="career"><select name="" id="career" class="form-control">
        <option value="CIVIL SERVICE ELIGIBLE - PROFESSIONAL">CIVIL SERVICE ELIGIBLE - PROFESSIONAL(CSP)</option>
        <option value="CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL">CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL(CSSP)</option>
        <option value="BAR/BOARD ELIGIBILITY">BAR/BOARD ELIGIBILITY(RA1080)</option>
        <option value="BARANGAY HEALTH WORKER ELIGIBLITY">BARANGAY HEALTH WORKER ELIGIBLITY(BWHE)</option>
        <option value="BARANGAY NUTRITION SCHOLAR ELIGIBILITY">BARANGAY NUTRITION SCHOLAR ELIGIBILITY(BNSE)</option>
        <option value="Barangay Official Eligibility">Barangay Official Eligibility(BOE)</option>
        <option value="Electronic Data Processing Specialist Eligibility">Electronic Data Processing Specialist Eligibility(EDPSE)</option>
        <option value="Foreign School Honor Graduate Eligibility">Foreign School Honor Graduate Eligibility(FSHGE)</option>
        <option value="Honor Graduate Eligibility">Honor Graduate Eligibility(HGE)</option>
        <option value="Sanggunian Member Eligibility">Sanggunian Member Eligibility(SME)</option>
        <option value="Scientific and Technological Specialists Eligibility">Scientific and Technological Specialists Eligibility(STSE)</option>
        <option value="Skills Eligibility - Category II">Skills Eligibility - Category II(CATII)</option>
        <option value="Veteran Preference Rating Eligibility">Veteran Preference Rating Eligibility(VPRE)</option>
        <option value="Licensure Examination for Teachers">Licensure Examination for Teachers(LET)</option>
        <option value="Professional Driver's License/Non-Professional Driver's License">Professional Driver's License/Non-Professional Driver's License</option>
        <option value="Others">Others</option>
      </select></td>
      <td id="rating"><input type="text" class="form-control" id="rating"></td>
      <td id="doe"><input type="date" class="form-control" id="doe"></td>
      <td id="poe"><input type="text" class="form-control" id="poe"></td>
      <td id="lNum">
      <input type="text" class="form-control" id="lNum">
      </td>
      <td id="dov">
      <input type="date" class="form-control" id="dov">   
        </td>
    </tr>

    <tr>
      <td id="career"><select name="" id="career" class="form-control">
        <option value="CIVIL SERVICE ELIGIBLE - PROFESSIONAL">CIVIL SERVICE ELIGIBLE - PROFESSIONAL(CSP)</option>
        <option value="CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL">CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL(CSSP)</option>
        <option value="BAR/BOARD ELIGIBILITY">BAR/BOARD ELIGIBILITY(RA1080)</option>
        <option value="BARANGAY HEALTH WORKER ELIGIBLITY">BARANGAY HEALTH WORKER ELIGIBLITY(BWHE)</option>
        <option value="BARANGAY NUTRITION SCHOLAR ELIGIBILITY">BARANGAY NUTRITION SCHOLAR ELIGIBILITY(BNSE)</option>
        <option value="Barangay Official Eligibility">Barangay Official Eligibility(BOE)</option>
        <option value="Electronic Data Processing Specialist Eligibility">Electronic Data Processing Specialist Eligibility(EDPSE)</option>
        <option value="Foreign School Honor Graduate Eligibility">Foreign School Honor Graduate Eligibility(FSHGE)</option>
        <option value="Honor Graduate Eligibility">Honor Graduate Eligibility(HGE)</option>
        <option value="Sanggunian Member Eligibility">Sanggunian Member Eligibility(SME)</option>
        <option value="Scientific and Technological Specialists Eligibility">Scientific and Technological Specialists Eligibility(STSE)</option>
        <option value="Skills Eligibility - Category II">Skills Eligibility - Category II(CATII)</option>
        <option value="Veteran Preference Rating Eligibility">Veteran Preference Rating Eligibility(VPRE)</option>
        <option value="Licensure Examination for Teachers">Licensure Examination for Teachers(LET)</option>
        <option value="Professional Driver's License/Non-Professional Driver's License">Professional Driver's License/Non-Professional Driver's License</option>
        <option value="Others">Others</option>
      </select></td>
      <td id="rating"><input type="text" class="form-control" id="rating"></td>
      <td id="doe"><input type="date" class="form-control" id="doe"></td>
      <td id="poe"><input type="text" class="form-control" id="poe"></td>
      <td id="lNum">
      <input type="text" class="form-control" id="lNum">
      </td>
      <td id="dov">
      <input type="date" class="form-control" id="dov">   
        </td>
    </tr>
    <tr>
      <td id="career"><select name="" id="career" class="form-control">
        <option value="CIVIL SERVICE ELIGIBLE - PROFESSIONAL">CIVIL SERVICE ELIGIBLE - PROFESSIONAL(CSP)</option>
        <option value="CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL">CIVIL SERVICE ELIGIBLE - SUB-PROFESSIONAL(CSSP)</option>
        <option value="BAR/BOARD ELIGIBILITY">BAR/BOARD ELIGIBILITY(RA1080)</option>
        <option value="BARANGAY HEALTH WORKER ELIGIBLITY">BARANGAY HEALTH WORKER ELIGIBLITY(BWHE)</option>
        <option value="BARANGAY NUTRITION SCHOLAR ELIGIBILITY">BARANGAY NUTRITION SCHOLAR ELIGIBILITY(BNSE)</option>
        <option value="Barangay Official Eligibility">Barangay Official Eligibility(BOE)</option>
        <option value="Electronic Data Processing Specialist Eligibility">Electronic Data Processing Specialist Eligibility(EDPSE)</option>
        <option value="Foreign School Honor Graduate Eligibility">Foreign School Honor Graduate Eligibility(FSHGE)</option>
        <option value="Honor Graduate Eligibility">Honor Graduate Eligibility(HGE)</option>
        <option value="Sanggunian Member Eligibility">Sanggunian Member Eligibility(SME)</option>
        <option value="Scientific and Technological Specialists Eligibility">Scientific and Technological Specialists Eligibility(STSE)</option>
        <option value="Skills Eligibility - Category II">Skills Eligibility - Category II(CATII)</option>
        <option value="Veteran Preference Rating Eligibility">Veteran Preference Rating Eligibility(VPRE)</option>
        <option value="Licensure Examination for Teachers">Licensure Examination for Teachers(LET)</option>
        <option value="Professional Driver's License/Non-Professional Driver's License">Professional Driver's License/Non-Professional Driver's License</option>
        <option value="Others">Others</option>
      </select></td>
      <td id="rating"><input type="text" class="form-control" id="rating"></td>
      <td id="doe"><input type="date" class="form-control" id="doe"></td>
      <td id="poe"><input type="text" class="form-control" id="poe"></td>
      <td id="lNum">
      <input type="text" class="form-control" id="lNum">
      </td>
      <td id="dov">
      <input type="date" class="form-control" id="dov">   
        </td>
    </tr>
    

</tbody>
<table>

  <div class="d-flex justify-content-end pb-2 me-2">
        <button class="btn btn-dark p-1 m-2" id="add"><i class="fi fi-rr-add p-1"></i>Add Row</button>
        <button class="btn btn-primary m-2 p-1" id="prev">Previous</button>
        <button class="btn btn-primary m-2 p-1" id="next">Next</button>
    </div>
</div>
</div>
        

</div>
</div>

</body>
</html>