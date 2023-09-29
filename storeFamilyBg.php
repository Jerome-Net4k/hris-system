<?php
include 'connection.php';
session_start();

    $_SESSION['spSname'] = $_POST['spSname'];
    $_SESSION['spFname'] = $_POST['spFname'];
    $_SESSION['spMname'] = $_POST['spMname'];
    $_SESSION['spExt'] = $_POST['spExt'];
    $_SESSION['spOccu'] = $_POST['spOccu'];
    $_SESSION['spEmpName'] = $_POST['spEmpName'];
    $_SESSION['spBadd'] = $_POST['spBadd'];
    $_SESSION['spTel'] = $_POST['spTel'];
    $_SESSION['fSname'] = $_POST['fSname'];
    $_SESSION['fFname'] = $_POST['fFname'];
    $_SESSION['fMname'] = $_POST['fMname'];
    $_SESSION['fExt'] = $_POST['fExt'];
    $_SESSION['mSname'] = $_POST['mSname'];
    $_SESSION['mFname'] = $_POST['mFname'];
    $_SESSION['mMname'] = $_POST['mMname'];
    $_SESSION['mExt'] = $_POST['mExt'];
    $_SESSION['ChildNconvert'] = $_POST['ChildNconvert'];
    $_SESSION['ChildBconvert'] = $_POST['ChildBconvert'];
    echo 'nc';

?>