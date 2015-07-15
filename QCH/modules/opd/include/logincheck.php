<?php

/*
  --------------------------------------------------------------------------------
  HHIMS - Hospital Health Information Management System
  Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
  <http: www.hhims.org/>
  ----------------------------------------------------------------------------------
  This program is free software: you can redistribute it and/or modify it under the
  terms of the GNU Affero General Public License as published by the Free Software
  Foundation, either version 3 of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,but WITHOUT ANY
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
  A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License along
  with this program. If not, see <http://www.gnu.org/licenses/> or write to:
  Free Software  HHIMS
  C/- Lunar Technologies (PVT) Ltd,
  15B Fullerton Estate II,
  Gamagoda, Kalutara, Sri Lanka
  ----------------------------------------------------------------------------------
  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
  Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
  URL: http: www.hhims.org
  ----------------------------------------------------------------------------------
 */

include 'login.php';
include 'class/MDSLogger.php';
include 'class/MDSHospital.php';

$username = $_POST['username'];
$password = $_POST['password'];
$cnt = $_POST['count'];
$FirstName = NULL;
$OtherName = NULL;
$Hospital = NULL;
$UserGroup = NULL;
$Department = NULL;
$Uid = NULL;

$html = "<div style='position:absolute;width:90%;height:50px;border:2px solid red;text-align:center;background-color:#f1f1f1;'>
                Please try to login again in <span id='time'>15</span>sec.
                <div id='link'></div>
                </div>
                <script language='javascript'>
                    var countdownfrom=15;
                    var time = document.getElementById('time');
                    var currentsecond=parseInt(time.innerHTML); 
                    var t=setTimeout('display()',15000);
                    countredirect();
                    var t1=null;
                    function countredirect(){ 
                        if (currentsecond!=1){ 
                            currentsecond-=1 
                            var time = document.getElementById('time');
                            time.innerHTML=currentsecond; 
                            t1=setTimeout('countredirect()',1000) ;
                        } 
                        else{ 
                            var l = document.getElementById('link');
                            l.innerHTML= '<a id=\'link\' href=\'../login.php\'>Login</a>';
                            clearTimeout(t1);
                            t1=null;
                            self.document.location='../login.php';
                            return;
                        } 
                    }
                </script>
                ";

if ($_COOKIE["lock"] == 1) {
    setcookie("lock", 1, time() + 15);
    echo $html;
    quit;
} else {
    list ($Uid, $FirstName, $OtherName, $UserGroup, $Department, $Hospital, $HID, $LANG ) = doAuth($username, $password);
    if ($Department != 1 && $Department != 4 && $Department != 5 && $Department != 6 && $Department != 7 && $Department != 10) {
        $mlog = MDSLogger::GetInstance();
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $mlog->saveAccessLog("../logs/", "User:" . $username . " PW: " . $password);
        session_start();
        if (!isset($_COOKIE["count"])) {
            setcookie("count", 1);
        } else {
            setcookie("count", $_COOKIE["count"] + 1);
        }
        if ($_COOKIE["count"] > 2) {
            setcookie("count", 4, time() + 15);
            setcookie("lock", 1, time() + 15);
            echo $html;
            exit;
        } else {
            echo "<script>window.location='../login.php?err=" . md5("-1") . "'</script>";
            exit;
        }
    }
    if ($Uid > 0) {
        session_register("username");
        $_SESSION["UID"] = $Uid;
        $_SESSION["FirstName"] = $FirstName;
        $_SESSION["OtherName"] = $OtherName;
        $_SESSION["Hospital"] = $_POST['LIC_HOS'];
        $_SESSION["UserGroup"] = $UserGroup;
        $_SESSION["HID"] = $HID;
        $_SESSION["LANG"] = $LANG;
        $_SESSION["LIC"] = $_POST['LIC'];
        $_SESSION["LIC_HOS"] = $_POST['LIC_HOS'];
        $_SESSION["BC"] = $_POST['BC'];
        $_SESSION["AP"] = $_POST['AP'];
        $_SESSION["AA"] = $_POST['AA'];
        if ($HID) {
            $c_Hospital = new MDSHospital();
            $c_Hospital->openId($HID);
            $_SESSION["DISPLAY_DRUG_COUNT"] = $c_Hospital->getValue("Display_Drug_Count");
            $_SESSION["DISPLAY_ZERO_DRUG_COUNT"] = $c_Hospital->getValue("Display_Zero_Drug_Count");
            $_SESSION["DISPENSE_DRUG_COUNT"] = $c_Hospital->getValue("Dispense_Drug_Count");
            $_SESSION["DISPLAY_PREVIOUS_DRUG"] = $c_Hospital->getValue("Display_Previous_Drug");
            $_SESSION["USE_ONE_FIELD_NAME"] = $c_Hospital->getValue("Use_One_Field_Name");
            $_SESSION["USE_CALENDAR_DOB"] = $c_Hospital->getValue("Use_Calendar_DOB");
            $_SESSION["INSTANT_VALIDATION"] = $c_Hospital->getValue("Instant_Validation");
            $_SESSION["NUMBER_NIC_VALIDATION"] = $c_Hospital->getValue("Number_NIC_Validation");
            $_SESSION["VISIT_ICD"] = $c_Hospital->getValue("Visit_ICD_Field");
            $_SESSION["VISIT_SNOMED"] = $c_Hospital->getValue("Visit_SNOMED_Field");
            $_SESSION["TOKEN_FOOTER_TEXT"] = $c_Hospital->getValue("Token_Footer_Text");
            $c_Hospital->setValue("Name", $_SESSION["LIC_HOS"]);
            $c_Hospital->save();
        }
        $mlog = MDSLogger::GetInstance();
        $mlog->saveUserLog('../logs/', 'logged_in');
        setcookie("count", 0);
        echo "<script>window.location='../index.php'</script>";
        exit;
    } else {

        $mlog = MDSLogger::GetInstance();
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $mlog->saveAccessLog("../logs/", "User:" . $username . " PW: " . $password);
        session_start();
        if (!isset($_COOKIE["count"])) {
            setcookie("count", 1);
        } else {
            setcookie("count", $_COOKIE["count"] + 1);
        }
        if ($_COOKIE["count"] > 2) {
            setcookie("count", 4, time() + 15);
            setcookie("lock", 1, time() + 15);
            echo $html;
            exit;
        } else {
            echo "<script>window.location='../login.php?err=" . md5("-1") . "'</script>";
            exit;
        }
    }
}
?>
