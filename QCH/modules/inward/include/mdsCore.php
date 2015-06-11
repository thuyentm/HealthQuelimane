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
include 'config.php';

function loadHeader($head) {
    $out = "<img class='pageHelp' src='images/help.png' width=30 height=30 valign=middle>\n";
    echo "<div id='mdsHead' class='mdshead'>" . getPrompt($head) . "</div>\n";
}

function js($cmd) {
    echo "<script language=javascript>";
    echo $cmd;
    echo "</script>";
}

function getMDSDate($dte_arr) {
    return $dte_arr[year] . "-" . $dte_arr[month] . "-" . $dte_arr[day];
}

function getDoctorList($id, $value) {
    $con = mysql_connect(HOST, USERNAME, PASSWORD);
    if (!$con) {
        die('Could not connect: ' );
    }
    mysql_select_db(DB, $con) or die("cannot select DB");

    $out = "";
    $sql = "SELECT UID,Title,FirstName,OtherName ";
    $sql .= " FROM user WHERE (Active = TRUE) AND ((Post = 'Doctor') OR (Post = 'Consultant')) ";
    $sql .= " ORDER BY OtherName ";
    $result = mysql_query($sql);
    if (!$result) {
        $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
        $out .="<option value='No Data'>No Data</option>\n";
        $out .="</select>\n";
        return $out;
    }
    $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
    $out .="<option value=''></option>\n";
    while ($row = mysql_fetch_array($result)) {
        $dr_name = $row["Title"] . " " . ucwords($row["FirstName"]) . " " . ucwords($row["OtherName"]);
        if ($row["UID"] == $value) {

            $out .="<option value='" . $row["UID"] . "' selected>" . $dr_name . "</option>\n";
        } else {
            if ($_SESSION["UID"] == $row["UID"]) {
                $out .="<option value='" . $row["UID"] . "' selected>" . $dr_name . "</option>\n";
            } else {
                $out .="<option value='" . $row["UID"] . "' >" . $dr_name . "</option>\n";
            }
        }
    }
    $out .="</select>\n";
    mysql_close($con);
    return $out;
}

function getLabDepartmentList($id, $value) {
    $con = mysql_connect(HOST, USERNAME, PASSWORD);
    if (!$con) {
        die('Could not connect: ' );
    }
    mysql_select_db(DB, $con) or die("cannot select DB");

    $out = "";
    $sql = "SELECT Name,Active ";
    $sql .= " FROM lab_test_department  ";
    $sql .= " ORDER BY Name ";
    $result = mysql_query($sql);
    if (!$result) {
        $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
        $out .="<option value='No Data'>No Data</option>\n";
        $out .="</select>\n";
        return $out;
    }
    $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
    $out .="<option value=''></option>\n";
    while ($row = mysql_fetch_array($result)) {
        $d_name = $row["Name"];
        $active = $row["Active"];
        if ($d_name == $value) {
            $out .="<option value='" . $d_name . "' selected>" . $d_name . "</option>\n";
        } else {
            if ($active == 1) {
                $out .="<option value='" . $d_name . "' >" . $d_name . "</option>\n";
            }
        }
    }
    $out .="</select>\n";
    mysql_close($con);
    return $out;
}

function getLabGroupList($id, $value) {
    $con = mysql_connect(HOST, USERNAME, PASSWORD);

    if (!$con) {
        die('Could not connect: ');
    }
    mysql_select_db(DB, $con) or die("cannot select DB");

    $out = "";
    $sql = "SELECT Name ";
    $sql .= " FROM lab_test_group  where Active = 1 ";
    $sql .= " ORDER BY Name ";
    $result = mysql_query($sql);
    if (!$result) {
        $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
        $out .="<option value='No Data'>No Data</option>\n";
        $out .="</select>\n";
        return $out;
    }
    $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
    $out .="<option value=''></option>\n";
    while ($row = mysql_fetch_array($result)) {
        $d_name = $row["Name"];
        if ($d_name == $value) {
            $out .="<option value='" . $d_name . "' selected>" . $d_name . "</option>\n";
        } else {
            $out .="<option value='" . $d_name . "' >" . $d_name . "</option>\n";
        }
    }
    $out .="</select>\n";
    mysql_close($con);
    return $out;
}

function getComplaintList($id, $value) {
    $con = mysql_connect(HOST, USERNAME, PASSWORD);

    if (!$con) {
        die('Could not connect: ' );
    }
    mysql_select_db(DB, $con) or die("cannot select DB");

    $out = "";
    $sql = " SELECT Name,isNotify ";
    $sql .= " FROM complaints WHERE Active = TRUE ";
    $sql .= " ORDER BY Name ";
    $result = mysql_query($sql);
    if (!$result) {
        $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
        $out .="<option value='No Data'>Error</option>\n";
        $out .="</select>\n";
        return $out;
    }
    $out .="<select class='input'  id='" . $id . "'   name='" . $id . "' >\n";
    $out .="<option value=''></option>\n";
    while ($row = mysql_fetch_array($result)) {
        if ($row["Name"] == $value) {
            $out .="<option value='" . $row["Name"] . "' selected>" . $row["Name"] . "</option>\n";
        } else {
            $out .="<option value='" . $row["Name"] . "'>" . $row["Name"] . "</option>\n";
        }
    }
    $out .="</select>\n";
    mysql_close($con);
    return $out;
}

function getPrompt($txt) {

    include 'lprompt.inc';
    //return $txt;
    $lang = $_SESSION["LANG"];
    if ($lang == "Tamil") {
        $lang = "TM";
    } else if ($lang == "Sinhala") {
        $lang = "SL";
    } else {
        $lang = "EN";
    }
    $rTxt = "";
    if (isset($Prompt[$txt][$lang])) {
        $rTxt = $Prompt[$txt][$lang];
        return $rTxt;
    } else {
        return $txt;
    }
}

function getLoggedUser() {
    return $_SESSION["FirstName"] . " " . $_SESSION["OtherName"];
}

function getHospital() {
    return $_SESSION["Hospital"];
}

function mdsError($err) {
    $text = "<div class='mdsAccessError'>" . $err . "<br><a href='javascript:window.history.back()'>Return</a></div>";
    return $text;
}
function diplayMessage($text,$head,$w,$h){
    $js = '';
        $js .='<script language="javascript"> ';
        $js .='$(\'<div id="mds_msg" title="'.$head.'"></div>\').appendTo("body");';
    $js .='$("#mds_msg").html("Getting information...");';
   
    $js .='$("#mds_msg").html("'.$text.'");';
    $js .='$("#mds_msg").dialog({';
        $js .=' width:'.$w.',';
        $js .=' height:'.$h.',';
        $js .=' autoOpen:true,';
        $js .=' modal: true,';
        $js .=' resizable:false,';
        $js .=' position:"center",';
        $js .=' close: function(event, ui){ ';
            $js .= 'history.back()';
        $js .=' }';
    $js .=' });';   
    $js .=' </script>';
    return $js;
}
function sanitize($data){
        $data=trim($data);
        $data=htmlspecialchars($data);
        $data = mysql_escape_string($data);
        $data = stripslashes($data);
        return $data;
}
////////////////////////////Form Render

function getDiffDays($startDate, $endDate) {

    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    return intval(abs(($startDate - $endDate) / 86400));
    
}

?>