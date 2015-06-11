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
function loadPharmacyMenu() {
    $out="<div id='opd_prescription_pop' style='display:none'></div>";
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";

		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>Departments</a>\n"; 
			$menu .="<div>\n"; 
				
				$menu .="<input type='button' class='submenuBtn' value='OPD Pharmacy'   onclick=self.document.location='home.php?page=pharmacy'>\n";
								$menu .="<input type='button' class='submenuBtn' value='Clinic Pharmacy'   onclick=self.document.location='home.php?page=clinicpharmacy'>\n";
                                $menu .="<input type='button' class='submenuBtn' value='InPatient'   onclick=self.document.location='home.php?page=inpharmacy'>\n";
								$menu .="<input type='button' class='submenuBtn' value='OPD Pharmacy Screen'   onclick=window.open('pharmacy_screen.html','_blank','toolbar=0,location=0,menubar=0')>\n";
				
			$menu .="</div>\n";   
                        
			$menu .="<a>".getPrompt("Reports")."</a>\n";
			$menu .="<div> \n";
				$menu .="<input type='button' class='submenuBtn' value='Daily drugs dispensed'  onclick=reDirect('report','report=pharmacy_balance')>\n";
                                $menu .="<input type='button' class='submenuBtn' value='Current stock balance'  onclick=reDirect('report','report=drug_list')>\n";
                                $menu .="<input type='button' class='submenuBtn' value='Create drug order'  onclick=reDirect('report','report=pharmacy_stock&ops=1000')>\n";
                                $menu .="<input type='button' class='submenuBtn' value='Prescriptions' onclick=openDialogBox('date_range_selector','OPD&nbsp;Prescriptions','opd_prescriptions')>\n";
                                $menu .="<input type='button' class='submenuBtn' value='Prescription by Drug' onclick=openDialogBox('date_range_selector','Prescription&nbsp;by&nbsp;Drug','opd_drug_statistics')>\n";
			$menu .="</div> \n";
            
  
            
			$menu .="<a>Maintain</a>\n"; 
			$menu .="<div>\n"; 
				
				$menu .="<input type='button' class='submenuBtn' value='Drugs'   onclick=loadDataTable('Drugs','#2')>\n";
				
			$menu .="</div>\n";
	$menu .=" </div> \n";
	$menu .="</div> \n";
	$menu .="<script language='javascript'>\n";
	$menu .="$('#list1a').accordion();\n";
	$menu .="</script>\n";
	echo $menu.$out ;
}

function loadPrescriptionTable(){
   $tbl = "";
   /*
   $tbl .= "<div class='tablecont'> \n";
   $tbl .= "<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'> \n";
	$tbl .= "<thead> \n";
		$tbl .= "<tr> \n";
			$tbl .= "<th width='5%'>".getPrompt("ID")."</th> \n";
			$tbl .= "<th width='30%'>".getPrompt("Name")."</th> \n";
			$tbl .= "<th style='width:15%'>".getPrompt("Prescribe Date")."</th> \n";
			$tbl .= "<th style='width:10%'>".getPrompt("Dept")."</th> \n";
			$tbl .= "<th style='width:20%'>".getPrompt("Prescribe By")."</th> \n";
			$tbl .= "<th style='width:5%'>".getPrompt("Status")."</th> \n";
		$tbl .= "</tr> \n";
	$tbl .= "</thead> \n";
	$tbl .= "<tbody> \n";
	$tbl .= "</tbody> \n";
	$tbl .= "</table> \n";
	$tbl .= "</div> \n";

	$tbl .= "<script language='javascript'>\n";
		$tbl .= "oTable = $('#example').dataTable( { \n";

		$tbl .= "'aaSorting': [[1, 'asc']], \n";
		$tbl .= "'aoColumns': [  \n";
			$tbl .= "{ 'bSearchable': false }, \n";
			$tbl .= "{ 'bSearchable': true  }, \n";
			$tbl .= "{ 'bSearchable': false }, \n";
			$tbl .= "{ 'bSearchable': false }, \n";
			$tbl .= "{ 'bSearchable': false }, \n";
			$tbl .= "{ 'bSearchable': true  }  \n";
		$tbl .= "], \n";
		//$tbl .= "'bJQueryUI': true, \n";
		$tbl .= "'bAutoWidth': false, \n";
		$tbl .= "'bProcessing': true, \n";
		$tbl .= "'bServerSide': true, \n";
		$tbl .= "'sPaginationType': 'full_numbers', \n";
		
		if ( $_GET["Status"] == "" ) { $status = "Pending";}
		else { $status = $_GET["Status"];}
		if ( $_GET["Date"] == "" ) { $date = date("Y-m-d");}
		else { $date = $_GET["Date"];}
		
		$tbl .= "'sAjaxSource': 'include/lookup/pharmacy.php?FORM=OPDPrescriptionForm&Status=".$status."&Date=".$date."'\n";
		$tbl .= "} ); \n";

		$tbl .= "$('#example tbody tr').live('click', function(e){ \n";
			$tbl .= "if ( e.which !== 1 ) return; \n";
			$tbl .= "var aData = oTable.fnGetData( this ); \n";
			$tbl .= "self.document.location = 'home.php?page=dispense&PRSID='+aData[0]+''; \n";
		$tbl .= "}); \n";
	$tbl .= "</script> \n";
	return $tbl;
     
    */
       $qry = "SELECT opd_presciption.PRSID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           
           opd_presciption.PrescribeDate, 
           opd_presciption.PrescribeBy, 
           opd_presciption.Status 
           FROM opd_presciption, patient 
           WHERE ( opd_presciption.PID = patient.PID ) 
           AND (opd_presciption.Active = true )  AND (Dept = 'OPD') AND (GetFrom = 'Stock')";
       
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('PRSID'); 
        $pager2->setHeight(400); 
        $pager2->setCaption("OPD Prescription list"); 
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("PRSID","Patient-ID","Name","Date","By","Status"));
        $pager2->setColOption("PRSID", array("search"=>false));
        $pager2->setColOption("PID", array("table_EL"=>"patient"));
        $pager2->setColOption("PrescribeDate", $pager2->getDateSelector(date("Y-m-d")));
        //$pager2->setColOption("PrescribeDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Ready:Ready;Dispensed:Dispensed","defaultValue"=>"Pending")));
        
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
                window.location='home.php?page=dispense&PRSID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=pharmacy');
            });
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();   
}
function loadClinicPrescriptionTable(){
   $tbl = "";

       $qry = "SELECT opd_presciption.PRSID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           
           opd_presciption.PrescribeDate, 
           opd_presciption.PrescribeBy, 
           opd_presciption.Status 
           FROM opd_presciption, patient 
           WHERE ( opd_presciption.PID = patient.PID ) 
           AND (opd_presciption.Active = true )  AND (Dept = 'OPD') AND (GetFrom = 'ClinicStock')";
       
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('PRSID'); 
        $pager2->setHeight(400); 
        $pager2->setCaption("CLINIC Prescription list"); 
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("PRSID","Patient-ID","Name","Date","By","Status"));
        $pager2->setColOption("PRSID", array("search"=>false));
        $pager2->setColOption("PID", array("table_EL"=>"patient"));
        $pager2->setColOption("PrescribeDate", $pager2->getDateSelector(date("Y-m-d")));
        //$pager2->setColOption("PrescribeDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Dispensed:Dispensed","defaultValue"=>"Pending")));
        
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
                window.location='home.php?page=dispense&PRSID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=clinicpharmacy');
            });
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();   
}
function loadADMPrescriptionTable(){
   $tbl = "";

       $qry = "SELECT opd_presciption.PRSID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           
           opd_presciption.PrescribeDate, 
           opd_presciption.PrescribeBy, 
           opd_presciption.Status 
           FROM opd_presciption, patient 
           WHERE ( opd_presciption.PID = patient.PID ) 
           AND (opd_presciption.Active = true )  AND (Dept = 'ADM')";
       
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('PRSID'); 
        $pager2->setHeight(400); 
        $pager2->setCaption("IN-PATIENT Prescription list"); 
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("PRSID","Patient-ID","Name","Date","By","Status"));
        $pager2->setColOption("PRSID", array("search"=>false));
        $pager2->setColOption("PID", array("table_EL"=>"patient"));
        $pager2->setColOption("PrescribeDate", $pager2->getDateSelector(date("Y-m-d")));
        //$pager2->setColOption("PrescribeDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Dispensed:Dispensed","defaultValue"=>"Pending")));
        
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
                window.location='home.php?page=indispense&PRSID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=inpharmacy');
            });
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();   
}

function loadPharmacy() {
	$out = $Btns = $jq = "";
	$pharCont = "<div id='prefCont'></div>";
	$head.=loadHeader("Pharmacy");
	$lbar ="".loadPharmacyMenu()."";
	$pharCont =loadPrescriptionTable();	
	$out = $head.$lbar.$pharCont.$jq;
	echo $out;
}
function loadClinicPharmacy() {
	
	$out = $Btns = $jq = "";
	$pharCont = "<div id='prefCont'></div>";
	$head.=loadHeader("Pharmacy");
	$lbar ="".loadPharmacyMenu()."";
	$pharCont =loadClinicPrescriptionTable();	
	$out = $head.$lbar.$pharCont.$jq;
	echo $out;
	
}
function loadADMPharmacy() {
	$out = $Btns = $jq = "";
	$pharCont = "<div id='prefCont'></div>";
	$head.=loadHeader("Pharmacy");
	$lbar ="".loadPharmacyMenu()."";
	$pharCont =loadADMPrescriptionTable();	
	$out = $head.$lbar.$pharCont.$jq;
	echo $out;
}
?>
