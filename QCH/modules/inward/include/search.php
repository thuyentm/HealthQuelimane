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
//include 'checksession.php';
//include 'config.php';
//include 'mdsCore.php';

session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}
//include_once 'class/MDSLeftMenu.php';
include_once 'class/MDSPager.php';
function loadSearchScreen($action) {
    $out = loadHeader("Patient search");
    
    $_SESSION["PID"] = "";
    //$l_menu = new MDSLeftMenu();
    //$out .= $l_menu->renderSearchLeftMenu();
        $pager2 = new MDSPager("select LPID,PID, Full_Name_Registered, Personal_Used_Name, DateOfBirth, Gender, Personal_Civil_Status, NIC, Address_Village from patient ");
        $pager2->setDivId('tablecont1'); //important
        $pager2->setDivStyle('width:95%;margin:0 auto;');
        $pager2->setRowid('PID'); 
//        $pager2->setWidth("95%");
        $tools = "<input class=\'formButton\' type=\'button\' ID=\'spid\' value=\'Search Patient by ID\'>";
        $pager2->setCaption($tools); 
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("Id","PId","Name","Initials","Date of Birth","Gender","Civil Status","NIC","Village"));
        $pager2->setColOption("PID", array("search"=>true,"hidden" => true,"height"=>100));
        $pager2->setColOption("LPID", array("search"=>true,"width"=>50));
        $pager2->setColOption("Full_Name_Registered", array("search"=>true,"width"=>300));
        $pager2->setColOption("Personal_Used_Name", array("search"=>true,"width"=>50));
        //$pager2->setColOption("DateOfBirth", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>"")));
        $pager2->setColOption("Gender", array("stype" => "select", "searchoptions" => array("value" => ":All;Male:Male;Female:Female")));
        //"Single","Married","Divorced","Widow","UnKnown"
        $pager2->setColOption("Personal_Civil_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Single:Single;Married:Married;Divorced:Divorced;Widow:Widow;UnKnown:UnKnown","defaultValue"=>"All")));
        //$pager2->setColOption("CreateDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>"")));
        $pager2->setSortname('LPID');
        $pager2->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'#FFFFFF','cursor':'pointer'});
            }).mouseout(function(e){
            $(this).css('background',c);
            }).mousedown(function(e){
                var rowId = $(this).attr('id');
                window.location='home.php?page=patient&action=View&PID='+rowId;
            });
                $('#spid').click(function(){
                   getSearchText('patient');
                })
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();
   
}

function loadLookUpScreen($srch) {
    $out = "";
    $out .="<div id='mdsHead' class='mdshead'>" . $srch . " lookup</div>\n";
    $tbl = <<<'EOT'
   <div class="tablecont">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="70%">
	<thead> 
		<tr> 
			<th width="10%">ID</th> 
			<th width="25%">Village</th> 
			<th width="25%">DS Division</th> 
                        <th width="25%">District</th> 
		</tr> 
	</thead > 
	<tbody > 
		<tr> 
			<th width="10%">ID</th> 
			<th width="25%">Village</th> 
			<th width="25%">DS Division</th> 
            <th width="25%">District</th> 
		</tr>
	</tbody> 
</table> 
</div>
<script language="javascript">
                     var ihtml=$.ajax({
                                       url: "server_process.php",
                                       global: false,
                                       type: "POST",
                                       async:false
                                    }).responseText;
                     $('#example tbody').html(ihtml);
</script>

EOT;
    echo $out . $tbl;
}

function getDistricts($dDistrict) {
    $out = "";

    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT DistrictName ";
    $sql .= " FROM district ORDER BY DistrictName";
    $result = mysql_query($sql);
    if ($result) {
        $out .="<span class='cmb'>District : ";
        $out .="<select id = 'ds' onchange='getVillage()'>";
        $out .="<option >" . $dDistrict . "</option>";
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            if (strcmp($dDistrict, $aRow[0]) == -3) {
                $out .="<option  id='ds" . $i . "' value = " . $i . " selected>" . $aRow[0] . "</option>\n";
            } else {
                $out .="<option  id='ds" . $i . "' value = " . $i . " >" . $aRow[0] . "</option>\n";
            }
        }
        $out .="</select ></span>";
    }
    echo $out . "&nbsp;&nbsp;&nbsp;";
}

function getDSDivsions($dDistrict, $dDsdivision) {
    $out = "";

    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT DISTINCT DSDivision ";
    $sql .= " FROM village WHERE (Active = 1) AND (District = \"" . $dDistrict . "\")  ORDER BY DSDivision ";
    $result = mysql_query($sql);
    //$out .=$result.$sql;
    if ($result) {
        $out .="<span class='cmb'>DSDivision : ";
        $out .="<select id='dsd' onchange='getVillage();'>";
        $out .="<option ></option>";
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            if (strcmp($dDsdivision, $aRow[0]) == -3) {
                $out .="<option id='dsd" . $i . "' value = " . $i . " selected>" . $aRow[0] . "</option>\n";
            } else {
                $out .="<option id='dsd" . $i . "' value = " . $i . ">" . $aRow[0] . "</option>\n";
            }
        }
        $out .="</select ></span>";
    }
    echo $out . "&nbsp;&nbsp;&nbsp;";
}

function getGNDivisions($dDistrict, $dDsdivision) {
    $out = "";
    include 'config.php';
    $gaSql['user'] = USERNAME;
    $gaSql['password'] = PASSWORD;
    $gaSql['db'] = DB;
    $gaSql['server'] = HOST;


    $gaSql['link'] = mysql_pconnect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
            die('Could not open connection to server');

    mysql_select_db($gaSql['db'], $gaSql['link']) or
            die('Could not select database ' . $gaSql['db']);

    $sql = "SELECT GNDivision,DSDivision,District ";
    $sql .= " FROM village WHERE (Active = 1) AND (DSDivision = \"" . $dDsdivision . "\") ORDER BY GNDivision";
    $result = mysql_query($sql);
    $out .="<div class='tablecont'>\n";
    $out .="<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'>\n";
    $out .="<thead> \n";
    $out .="<tr> \n";
    $out .="<th width='10%'>District</th> \n";
    $out .="<th width='25%'>DS Division</th> \n";
    $out .="<th width='25%'>Village</th> \n";
    $out .="</tr> \n";
    $out .="</thead> \n";
    $out .="<tbody> \n";


    if ($result) {
        $i = 0;
        while ($aRow = mysql_fetch_array($result)) {
            $i++;
            $aRow[0] = rtrim($aRow[0]);
            $aRow[1] = rtrim($aRow[1]);
            $aRow[2] = rtrim($aRow[2]);
            if ($i % 2 == 1) {
                $out .="<tr class='odd' style='cursor:pointer' onclick=\"villageSelect('" . $aRow[0] . "','" . $aRow[1] . "','" . $aRow[2] . "');\">";
            } else {
                $out .="<tr class='even' style='cursor:pointer' onclick=\"villageSelect('" . $aRow[0] . "','" . $aRow[1] . "','" . $aRow[2] . "');\">";
            }
            $out .="<td>" . $aRow[2] . "</td><td>" . $aRow[1] . "</td><td><b>" . $aRow[0] . "<b></td>";
            $out .="</tr>\n";
        }
    }
    $out .="</tbody> \n";
    $out .="</table> \n";
    $out .="</div>\n";
    echo $out . "&nbsp;&nbsp;&nbsp;";
}

?>