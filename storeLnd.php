<?php

session_start();

$_SESSION['convTitle'] = $_POST['convTitle'];
$_SESSION['convFrom'] = $_POST['convFrom'];
$_SESSION['convLndTo'] = $_POST['convTo'];
$_SESSION['convNoh'] = $_POST['convNoh'];
$_SESSION['convType'] = $_POST['convType'];
$_SESSION['convSponsor'] = $_POST['convSponsor'];

$convTitle = explode(',', $_SESSION['convTitle']);
$convFrom = explode(',',$_SESSION['convFrom']);
$convTo = explode(',',$_SESSION['convTo']);
$convNoh = explode(',',$_SESSION['convNoh']);
$convType = explode(',',$_SESSION['convType']);
$convSponsor = explode(',',$_SESSION['convSponsor']);



?>