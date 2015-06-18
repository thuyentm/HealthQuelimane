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

include_once 'class/MDSPatient.php';
include_once 'class/MDSPager.php';
//include_once '../config.php';

function loadDoctorMenu() {
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";
		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>Commands</a>\n";
			$menu .="<div>\n";
			
			$menu .="<input type='button' class='submenuBtn' value='Waiting Patients'  onclick=self.document.location='home.php?page=patientlist&show=waitingpatient'>\n";
			$menu .="<input type='button' class='submenuBtn' value='Observed Patients'  onclick=self.document.location='home.php?page=patientlist&show=observationpatient'>\n";
			$menu .="</div>\n";
	$menu .=" </div>\n";
	$menu .="</div>\n";
	$menu .="<script language='javascript'>\n";
		$menu .="$('#list1a').accordion();\n";
	$menu .="</script>\n";
	echo $menu ;
}
function loadLaboratoryTable($mode,$user){
   $tbl = "";
   $OBJID = "PID";
   $clmns= array();
   $caption = "Patient list";
   $dte_field = "";
   $status = "";
   $link = "";

   
   if ($mode == "waitingpatient") {
	$qry = "SELECT  Emergency_Admission.DateTimeOfVisit,
			Emergency_Admission.EMRID ,
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details,
			Emergency_Admission.Status			
			FROM Emergency_Admission, patient 
			where (patient.PID = Emergency_Admission.PID ) AND (Emergency_Admission.Observation='No')";
		//(admission.Doctor ='".$user->getId()."') AND
		$OBJID = "EMRID";
		$caption = "Waiting patient list";	
		$clmns = array("Visit Date","","Name","Details","Severity");
		$dte_field = "DateTimeOfVisit";
		$link ="'home.php?page=emergency&action=View&EMRID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=waitingpatient')";
   } 
   
      else if ($mode == "observationpatient") {
	$qry = "SELECT  Emergency_Admission.DateTimeOfVisit,
			Emergency_Admission.EMRID ,
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details
			FROM Emergency_Admission, patient 
			where (patient.PID = Emergency_Admission.PID ) AND (Emergency_Admission.Observation='Yes')";
		//(admission.Doctor ='".$user->getId()."') AND
		$OBJID = "EMRID";
		$caption = "Observed patient list";	
		$clmns = array("Visit Date","","Name","Details");
		$dte_field = "DateTimeOfVisit";
		$link ="'home.php?page=emergency&action=View&EMRID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=observationpatient')";
   }
   


	$pager2 = new MDSPager($qry);	
	
	$pager2->setDivId('prefCont'); 
	$pager2->setDivClass('');
	//$pager2->SetColor($color);
	$pager2->setRowid($OBJID);
	//$pager2->setRowclass($OBJID);
	$pager2->setHeight(400); 
	$pager2->setCaption($caption); 
	$pager2->setColNames($clmns);
	$pager2->setColOption($OBJID, array("search"=>true,"hidden" => true));
	$pager2->setColOption($dte_field, $pager2->getDateSelector(date("Y-m-d")));
	//$pager2->setColOption("Status", array("width"=>100,"bgcolor"=>'#FF0000',"search"=>true,"hidden" => false));
	if (($mode != "presorder")){
	$pager2->setColOption("Details", array("width"=>300,"search"=>false,"hidden" => false));
	}
	//$pager2->setColOption("Status", array("bgcolor"=>"#FF0000","hidden" => false));
	if (($mode == "labresult")||($mode == "admlabresult")) {
		$pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done","Default"=>"Pending")));
	}

        if($_SESSION["UserGroup"]=="ODoctor" && $mode == "waitingpatient"){
		$pager2->gridComplete_JS = "function(){
        
		var c =null;
		$('.jqgrow').mouseover(function(e) {
			var rowId = $(this).attr('id');
			c = $(this).css('background');
			$(this).css({'background':'white','cursor':'pointer'});
		}).mouseout(function(e){
			$(this).css('background',c);
		}).click(function(e){ 
                       var r=confirm('Are you observe this patient?');
                      if(r==true){
			var rowId = $(this).attr('id');
			window.location=$link;
                        }
                        else{
                        return false;
                        }
		});	
		

		

				
		}";	
        }
        else{
            
         $pager2->gridComplete_JS = "function(){
        
		var c =null;
		$('.jqgrow').mouseover(function(e) {
			var rowId = $(this).attr('id');
			c = $(this).css('background');
			$(this).css({'background':'white','cursor':'pointer'});
		}).mouseout(function(e){
			$(this).css('background',c);
		}).click(function(e){ 
                    
			var rowId = $(this).attr('id');
			window.location=$link;
                       
		});	
		

		

				
		}";     
            
            
            
            
            
        }

		
	//$i++;
		//}
	

	return $pager2->render();	
	
	

	
}


function loadDoctorDefaultPage(){
	include_once 'class/MDSUser.php';
	$user = new MDSUser();
	$user->openId($_SESSION["UID"]);
	$greet = $user->userGreet();
	echo loadHeader($greet);
	loadDoctorMenu();
	$mode = "";
	if((isset($_GET["show"]))&&($_GET["show"] != "")){
		$mode = $_GET["show"];
		echo loadLaboratoryTable($mode,$user);
	}
	else{
		echo loadLaboratoryTable("waitingpatient",$user);
	}
}

?>