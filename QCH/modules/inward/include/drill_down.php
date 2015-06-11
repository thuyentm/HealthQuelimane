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
include 'config.php';
//include 'mdsCore.php';

session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}
include_once 'class/MDSPager.php';
echo "hello".loadSearchScreen('');
function loadSearchScreen($action) {
    
    $_SESSION["PID"] = "";
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

?>