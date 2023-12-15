<?php
  session_start();
  if(!isset($_SESSION['user'])){
    header("Location:views_login.php");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRIS</title>
    <link rel="stylesheet" href="landing.css">
   <?php include 'partials_header.php'; ?>

    <style>
        *{
            font-family: 'Poppins', sans-serif;
        }
      body{
    background-image: url('images/bg.jpg');
    background-size:     cover;                      /* <------ */
    background-repeat:   no-repeat;
    background-attachment: fixed;

}

.header{
    width: 35%;
    text-align: center;
}
td,th{
    text-align: center;
}
.filter{
    max-width: 120px;
}
.search{
    width: 7%;
}
.sad:hover{
    color: azure;
}
.mainLogo{
    margin-left: 10px;
}

.roundTable{
    border-radius: 10px;
    
}
    </style>

   
</head>
<body>
    <?php include 'navbar.php'; ?>
     

     <div class="container-fluid mt-2 pb-3" style="background: rgba(21, 72, 195, 0.8);" >
     <div>
        <div class="fs-5 text-start text-white pt-3">
        <div class="fs-2 fw-bold"><u>LTO Vision</u></div>
          A front-line government agency showcasing fast and efficient <br>public service for a progressive land transport sector
        </div>
        </div>
        <div class="d-flex justify-content-center">
        <img src="images/logo.png" style="width: 500px; height: 500px; ">
        </div>

        <div class="fs-5 text-white text-end">
        <div class="fs-2 fw-bold"><u>LTO Mission</u></div>
          Rationalize the land transportation services and facilities and to <br>effectively implement the various transportation laws,
          rules and regulations.  <br> It is the responsibiliity of those involved in the public service to be more <br>vigilant in their part in the over-all 
          development scheme of the national leadership. Hence, <br> promotion of safety and comfort in land travel is a continuing commitment of the LTO.
      </div> 
      </div>

    </div>

<!--MISSION AND VISION-->
<div>
    <div class="container-fluid mt-2 pb-3" style="background: rgba(21, 72, 195, 0.8);" >
     <div>
        <div class="fs-5 text-start text-white pt-3">
        <div class="fs-2 fw-bold"><u>LTO Vision</u></div>
          A front-line government agency showcasing fast and efficient <br>public service for a progressive land transport sector
        </div>
        </div>
        <div class="d-flex justify-content-center">
        <img src="images/logo.png" style="width: 500px; height: 500px; ">
        </div>

        <div class="fs-5 text-white text-end">
        <div class="fs-2 fw-bold"><u>LTO Mission</u></div>
          Rationalize the land transportation services and facilities and to <br>effectively implement the various transportation laws,
          rules and regulations.  <br> It is the responsibiliity of those involved in the public service to be more <br>vigilant in their part in the over-all 
          development scheme of the national leadership. Hence, <br> promotion of safety and comfort in land travel is a continuing commitment of the LTO.
      </div> 
      </div>

    </div>





    
</body>
</html>