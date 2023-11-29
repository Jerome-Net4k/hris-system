<?php

if($_POST['indicatorFil']=='CIS'){
    if(file_exists("si/Common Success Indicator.pdf")){
        echo '<iframe src="si/Common Success Indicator.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='ADHRDS'){
    if(file_exists("si/Admin-HRDS.pdf")){
        echo '<iframe src="si/Admin-HRDS.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='ADGSS'){
    if(file_exists("si/Admin-GSS.pdf")){
        echo '<iframe src="si/Admin-GSS.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='ADMD'){
    if(file_exists("si/Admin-Medical.pdf")){
        echo '<iframe src="si/Admin-Medical.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='ADPROCURE'){
    if(file_exists("si/Admin-Procurement.pdf")){
        echo '<iframe src="si/Admin-Procurement.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='ADPROPERTY'){
    if(file_exists("si/Admin-Property.pdf")){
        echo '<iframe src="si/Admin-Property.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='DMPAO'){
    if(file_exists("si/DMPAO.pdf")){
        echo '<iframe src="si/DMPAO.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='FDACCOUNTING'){
    if(file_exists("si/Financial-Accounting.pdf")){
        echo '<iframe src="si/Financial-Accounting.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='FDBUDGET'){
    if(file_exists("si/Financial-Budget.pdf")){
        echo '<iframe src="si/Financial-Budget.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='FDTREASURY'){
    if(file_exists("si/Financial-Treasury.pdf")){
        echo '<iframe src="si/Financial-Treasury.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='LESFED'){
    if(file_exists("si/LES-FED.pdf")){
        echo '<iframe src="si/LES-FED.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='LESIID'){
    if(file_exists("si/LES-IID.pdf")){
        echo '<iframe src="si/LES-IID.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='LESTSD'){
    if(file_exists("si/LES-TSD.pdf")){
        echo '<iframe src="si/LES-TSD.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='MD'){
    if(file_exists("si/Management.pdf")){
        echo '<iframe src="si/Management.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='MIDCCTSS'){
    if(file_exists("si/MID-CCTSS.pdf")){
        echo '<iframe src="si/MID-CCTSS.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='MIDCOMPUTER'){
    if(file_exists("si/MID-Computer.pdf")){
        echo '<iframe src="si/MID-Computer.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='MIDRECORDS'){
    if(file_exists("si/MID-Records.pdf")){
        echo '<iframe src="si/MID-Records.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='OAOED'){
    if(file_exists("si/OAssec, OED.pdf")){
        echo '<iframe src="si/OAssec, OED.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='OPSC3'){
    if(file_exists("si/OPS-C3.pdf")){
        echo '<iframe src="si/OPS-C3.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='OPSL'){
    if(file_exists("si/OPS-License.pdf")){
        echo '<iframe src="si/OPS-License.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='OPSR'){
    if(file_exists("si/OPS-Registration.pdf")){
        echo '<iframe src="si/OPS-Registration.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='PS'){
    if(file_exists("si/Planning Staff.pdf")){
        echo '<iframe src="si/Planning Staff.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
}else if($_POST['indicatorFil']=='TAS'){
    if(file_exists("si/TAS.pdf")){
        echo '<iframe src="si/TAS.pdf" width="100%" style="height:73vh"></iframe>';
    } else {
        echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
    }
} else {
    echo '<div style="height: 45vh;"><center><h1 style="margin-top: 15%;">File not available.</h1></center></div>';
}



?>