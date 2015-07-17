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
function loadProcedureRoomMenu() {
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";
		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>".getPrompt("Department")."</a>\n";
			$menu .="<div> \n";
                             $menu .="<input type='button' class='submenuBtn' value='Procedure Room'  onclick=self.document.location='home.php?page=procedureroom' >\n";
                             //$menu .="<input type='button' class='submenuBtn' value='Collection Room' onclick=self.document.location='home.php?page=collectionroom' >\n";
			$menu .="</div> \n";
	$menu .=" </div> \n";
	$menu .="</div> \n";
	$menu .="<script language='javascript'>\n";
	$menu .="$('#list1a').accordion();\n";
	$menu .="</script>\n";
	echo $menu ;
}

function loadPatientList(){
   $tbl = "";
 /*  $tbl .= "<div class='tablecont'> \n";
   $tbl .= "<table align='center' cellpadding='0' cellspacing='0' border='0' class='display' id='example' width='70%'> \n";
	$tbl .= "<thead> \n";
		$tbl .= "<tr> \n";
			$tbl .= "<th width='5%'>".getPrompt("ID")."</th> \n";
                        $tbl .= "<th width='5%'>".getPrompt("PID")."</th> \n";
			$tbl .= "<th width='10%'>".getPrompt("Date")."</th> \n";
			$tbl .= "<th style='width:15%'>".getPrompt("Name")."</th> \n";
			$tbl .= "<th style='width:30%'>".getPrompt("Treatment")."</th> \n";
			//$tbl .= "<th style='width:20%'>PrescribeBy</th> \n";
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
                        $tbl .= "{ 'bSearchable': false, 'bVisible': false}, \n";
			$tbl .= "{ 'bSearchable': true }, \n";
			$tbl .= "{ 'bSearchable': false} , \n";
			$tbl .= "{ 'bSearchable': false} , \n";
			$tbl .= "{ 'bSearchable': false} , \n";
			//$tbl .= "{ 'bSearchable': true} \n";
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
		
		$tbl .= "'sAjaxSource': 'include/lookup/procedureroom.php?FORM=opd_treatment_entryForm&Status=".$status."&Date=".$date."'\n";
		$tbl .= "} ); \n";

		$tbl .= "$('#example tbody tr').live('click', function(e){ \n";
			$tbl .= "if ( e.which !== 1 ) return; \n";
			$tbl .= "var aData = oTable.fnGetData( this ); \n";
			$tbl .= "self.document.location = 'home.php?page=opd_treatment_result&action=Edit&OPDTREATMENTID='+aData[0]+'&OPDID='+aData[1]+'&RETURN='+encodeURIComponent(self.document.location)+''; \n";
		$tbl .= "}); \n";
	$tbl .= "</script> \n";
       
         *         SELECT SQL_CALC_FOUND_ROWS opd_treatment.OPDTREATMENTID, opd_treatment.OPDID, patient.PID, patient.Personal_Title, patient.Full_Name_Registered, opd_treatment.Treatment, opd_treatment.CreateDate, opd_treatment.Status
        FROM    `patient`,`opd_visits`,`opd_treatment` 
        WHERE   ( patient.PID = opd_visits.PID ) AND (  opd_treatment.OPDID= opd_visits.OPDID )  AND ( opd_treatment.Status = 'Pending' )  AND ( opd_treatment.CreateDate LIKE '%2011-10-03%' )  AND(opd_treatment.Active = true  )
        ORDER BY  opd_treatment.OPDID
                    asc
        LIMIT 0, 25
    
         */
          $qry = " SELECT 
              opd_treatment.OPDTREATMENTID, 
              patient.PID, 
              concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
              opd_treatment.CreateDate,
              opd_treatment.Treatment,  
              opd_treatment.Status
        FROM    `patient`,`opd_visits`,`opd_treatment` 
        WHERE   ( patient.PID = opd_visits.PID ) AND (  opd_treatment.OPDID= opd_visits.OPDID )  AND (opd_treatment.Active = true  )  ";
       
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('OPDTREATMENTID'); 
        $pager2->setHeight(400); 
        $pager2->setCaption("Procedure list"); 
        $pager2->setColOption("PID", array("table_EL"=>"patient"));
        $pager2->setColOption("OPDTREATMENTID", array("search"=>true,"width"=>50));
        $pager2->setColNames(array("Order ID","Patient-ID","Name","Date","Treatment","Status"));
        $pager2->setColOption("OPDTREATMENTID", array("search"=>false));
        $pager2->setColOption("CreateDate", $pager2->getDateSelector(date("Y-m-d"),array("table_EL"=>"opd_treatment")));
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done","Default"=>"Pending")));
        
        
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
                window.location='home.php?page=opd_treatment_result&action=Edit&OPDTREATMENTID='+rowId+'&RETURN='+encodeURIComponent(self.document.location)+'';
            });
			
			
		
			
	
	
		
		
            }";
        return $pager2->render();   
	//return $tbl;
}



function loadProcedureRoom() {
	$out = $Btns = $jq = "";
	$pharCont = "<div id='prefCont'></div>";
	$head.=loadHeader("Procedure Room");
	$lbar ="".loadProcedureRoomMenu()."";
	$Btns .= "<input type='button' class='menuBtn' style='height:24' value='>>' onclick=self.location='home.php?page=procedureroom&Status='+$('#fltrStatus').val()+'&Date='+$('#fltrDate').val()+''>";
	$pharCont = loadPatientList();	
	$out = $head.$lbar.$pharCont;
	echo $out;
}

?>