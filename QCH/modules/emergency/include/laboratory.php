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
    $menu .="<a>Department</a>\n";
    $menu .="<div> \n";
    $menu .="<input type='button' class='submenuBtn' value='OPD Lab Orders'  onclick=self.document.location='home.php?page=laboratory'>\n";
    $menu .="<input type='button' class='submenuBtn' value='Admission Lab Orders'  onclick=self.document.location='home.php?page=inlaboratory'>\n";
    $menu .="<input type='button' class='submenuBtn' value='Collection Room' onclick=self.document.location='home.php?page=collectionroom' >\n";

    //$menu .="<input type='button' class='submenuBtn' value='CLINIC Prescriptions'>\n";
    $menu .="</div> \n";

    $menu .="<a>" . getPrompt("Reports") . "</a>\n";
    $menu .="<div> \n";
    $menu .="<input type='button' class='submenuBtn' value='Laboratory tests carried out' onclick=openDialogBox('date_range_selector','Labtests&nbsp;Done','lab_tests')>\n";
    $menu .="</div> \n";

//		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
    //$menu .="<input type='button' class='submenuBtn' value='CLINIC Prescriptions'>\n";
//			$menu .="</div> \n";
    //$menu .="<a>Alerts</a>\n"; 
    //$menu .="<div>\n"; 
    //$menu .="<p>\n"; 
    //$menu .="There is a message for you!\n";
    //$menu .="</p>\n"; 
    //$menu .="</div>\n";
    $menu .=" </div> \n";
    $menu .="</div> \n";
    $menu .="<script language='javascript'>\n";
    $menu .="$('#list1a').accordion();\n";
    $menu .="</script>\n";

    echo $menu;
}

function loadLaboratoryTable() {
    $tbl = "";
//   $tbl .= "<div class='tablecont'> \n";
//   $tbl .= "<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'> \n";
//	$tbl .= "<thead> \n";
//		$tbl .= "<tr> \n";
//			$tbl .= "<th width='5%'>".getPrompt("ID")."</th> \n";
//			$tbl .= "<th width='30%'>".getPrompt("Name")."</th> \n";
//			$tbl .= "<th style='width:15%'>".getPrompt("Order Date")."</th> \n";
//			$tbl .= "<th style='width:10%'>".getPrompt("Dept")."</th> \n";
//			$tbl .= "<th style='width:20%'>".getPrompt("Order By")."</th> \n";
//			$tbl .= "<th style='width:5%'>".getPrompt("Status")."</th> \n";
//			$tbl .= "<th style='width:1%'>".getPrompt("OBJID")."</th> \n";
//		$tbl .= "</tr> \n";
//	$tbl .= "</thead> \n";
//	$tbl .= "<tbody> \n";
//	$tbl .= "</tbody> \n";
//	$tbl .= "</table> \n";
//	$tbl .= "</div> \n";
//
//	$tbl .= "<script language='javascript'>\n";
//		$tbl .= "oTable = $('#example').dataTable( { \n";
//
//		$tbl .= "'aaSorting': [[1, 'asc']], \n";
//		$tbl .= "'aoColumns': [  \n";
//			$tbl .= "{ 'bSearchable': false } , \n";
//			$tbl .= "{ 'bSearchable': true }  , \n";
//			$tbl .= "{ 'bSearchable': false}  , \n";
//			$tbl .= "{ 'bSearchable': false}  , \n";
//			$tbl .= "{ 'bSearchable': false}  , \n";
//			$tbl .= "{ 'bSearchable': true}   , \n";
//			$tbl .= "{'bSearchable': false, 'bVisible':    false } \n";
//		$tbl .= "], \n";
//		//$tbl .= "'bJQueryUI': true, \n";
//		$tbl .= "'bAutoWidth': false, \n";
//		$tbl .= "'bProcessing': true, \n";
//		$tbl .= "'bServerSide': true, \n";
//		$tbl .= "'sPaginationType': 'full_numbers', \n";
//		
//		if ( $_GET["Status"] == "" ) { $status = "Pending";}
//		else { $status = $_GET["Status"];}
//		if ( $_GET["Date"] == "" ) { $date = date("Y-m-d");}
//		else { $date = $_GET["Date"];}
//		
//		$tbl .= "'sAjaxSource': 'include/lookup/labaratory.php?FORM=OPDLabOrderForm&Status=".$status."&Date=".$date."'\n";
//		$tbl .= "} ); \n";
//
//		$tbl .= "$('#example tbody tr').live('click', function(e){ \n";
//			$tbl .= "if ( e.which !== 1 ) return; \n";
//			$tbl .= "var aData = oTable.fnGetData( this ); \n";
//			$tbl .= "self.document.location='home.php?page=opdLabOrder&action=Edit&LABORDID='+aData[0]+'&OPDID='+aData[6]+'' \n";
//			//self.document.location='home.php?page=opdLabOrder&action=Edit&LABORDID='+aData[0]+'&OPDID='+aData[7]+'';
//		$tbl .= "}); \n";
//	$tbl .= "</script> \n";
//	return $tbl;
//SELECT SQL_CALC_FOUND_ROWS lab_order.LAB_ORDER_ID, patient.Personal_Title, patient.Full_Name_Registered, patient.PID, lab_order.OrderDate, lab_order.Dept, lab_order.OrderBy, lab_order.Status, lab_order.OBJID FROM lab_order, patient WHERE ( lab_order.PID = patient.PID ) AND ( lab_order.Status = '' )         

    $qry = " SELECT  
           lab_order.LAB_ORDER_ID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           lab_order.OrderDate, 
           lab_order.OrderBy, 
           lab_order.Collection_Status, 
           lab_order.Status, 
		   lab_order.Priority	,
           lab_order.OBJID 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.Dept = 'OPD') ";

    $pager2 = new MDSPager($qry);
    $pager2->setDivId('prefCont'); //important
    $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
    $pager2->setRowid('LAB_ORDER_ID');
    $pager2->setHeight(400);
    $pager2->setCaption("OPD Lab order list");
    //$pager->setSortname("OrderDate");
    $pager2->setColOption("OBJID", array("search" => true, "hidden" => true));
	$pager2->setColOption("LAB_ORDER_ID",array("search"=>true,"hidden" => false,"width"=>50));
	$pager2->setColOption("PID",array("search"=>true,"hidden" => false,"width"=>100));
    $pager2->setColNames(array("LabID", "Patient-ID", "Name", "Date", "By", "Sample Collection", "Status", "Priority",""));
    $pager2->setColOption("LAB_ORDER_ID", array("search" => false));
    //$pager2->setColOption("OrderDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
    $pager2->setColOption("OrderDate", $pager2->getDateSelector(date("Y-m-d")));
    $pager2->setColOption("Collection_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Done")));
    $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Pending")));
	$pager2->setColOption("Priority", array("stype" => "select", "searchoptions" => array("value" => ":All;Urgent:Urgent;Normal:Normal", "Default" => "All")));
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
                window.location='home.php?page=opdLabOrder&action=Edit&LABORDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=laboratory')+'';;
            });
            }";
    return $pager2->render();
}

function loadLaboratory() {
    $out = $Btns = $jq = "";
    $pharCont = "";
    $head.=loadHeader("Laboratory");
    $lbar = "" . loadLaboratoryMenu() . "";
    $pharCont = loadLaboratoryTable();

    $out = $head . $lbar . $pharCont;
    echo $out;
}

?>