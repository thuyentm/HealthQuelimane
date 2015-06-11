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
include_once 'class/MDSPager.php';
function loadLaboratoryMenu() {
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";
		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>".getPrompt("Department")."</a>\n";
			$menu .="<div> \n";
                             $menu .="<input type='button' class='submenuBtn' value='Procedure Room'  onclick=self.document.location='home.php?page=procedureroom' >\n";
                             $menu .="<input type='button' class='submenuBtn' value='Collection Room' onclick=self.document.location='home.php?page=collectionroom' >\n";
			$menu .="</div> \n";
	$menu .=" </div> \n";
	$menu .="</div> \n";
	$menu .="<script language='javascript'>\n";
	$menu .="$('#list1a').accordion();\n";
	$menu .="</script>\n";
	echo $menu ;
}
function loadLaboratoryTable(){
   $tbl = "";

       $qry = " SELECT  
           lab_order.LAB_ORDER_ID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           lab_order.OrderDate, 
           lab_order.OrderBy, 
           lab_order.Collection_Status, 
           lab_order.OBJID 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.Dept = 'OPD') ";
       
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('LAB_ORDER_ID'); 
        $pager2->setHeight(400); 
        $pager2->setCaption("Samples collection list"); 
        //$pager->setSortname("OrderDate");
        $pager2->setColOption("OBJID", array("search"=>true,"hidden" => true));
        $pager2->setColNames(array("LabID","Patient-ID","Name","Date","By","Collection Status",""));
        $pager2->setColOption("LAB_ORDER_ID", array("search"=>false));
        //$pager2->setColOption("OrderDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
        $pager2->setColOption("OrderDate", $pager2->getDateSelector(date("Y-m-d")));
        $pager2->setColOption("Collection_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done","Default"=>"Pending")));
       // $pager2->setColOption("Dept", array("stype" => "select", "searchoptions" => array("value" => ":All;OPD:OPD;ADM:InPatient","Default"=>"OPD")));
        
        
        $pager2->gridComplete_JS = "function() {
            var c =null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='home.php?page=opdSample&action=Edit&LAB_ORDER_ID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=collectionroom')+'';
                
            });
            }";
        //&RETURN='+encodeURIComponent('home.php?page=collectionroom)+'
        return $pager2->render();   
}



function loadLaboratory() {
   $out = $Btns = $jq = "";
   $pharCont = "";
   $head.=loadHeader("Laboratory");
  $lbar ="".loadLaboratoryMenu()."";
    $pharCont = loadLaboratoryTable();	
	
	$out = $head.$lbar.$pharCont;
    echo $out;
}

?>