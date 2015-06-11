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
			$menu .="<input type='button' class='submenuBtn' value='My OPD Patients'  onclick=self.document.location='home.php?page=patientlist&show=opdpatient'>\n";
			$menu .="<input type='button' class='submenuBtn' value='My OPD lab Orders'  onclick=self.document.location='home.php?page=patientlist&show=labresult'>\n";
			$menu .="<input type='button' class='submenuBtn' value='My Prescribe Orders'  onclick=self.document.location='home.php?page=patientlist&show=presorder'>\n";
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
   if ($mode == "opdpatient") {
		$qry = "SELECT  opd_visits.DateTimeOfVisit,
			opd_visits.OPDID ,
			opd_visits.Complaint,			
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details
			
			FROM opd_visits, patient 
			where (opd_visits.Doctor ='".$user->getId()."') AND (patient.PID = opd_visits.PID ) AND (opd_visits.VisitType = 'OPD Visit')";
		// (opd_visits.Doctor ='".$user->getId()."') AND 
		$OBJID = "OPDID";
		$caption = "My OPD patient list";	
		$clmns = array("Visit Date","","Complaint","Name","Details");
		//$status = "Status";	
		$dte_field = "DateTimeOfVisit";
		$link ="'home.php?page=opd&action=View&OPDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=opdpatient')";
		
   }
    
   else if ($mode == "labresult") {
	$qry = "SELECT  
			lab_order.OrderDate, 
           lab_order.LAB_ORDER_ID, 
           concat('(',lab_order.LAB_ORDER_ID,')',lab_order.TestGroupName),		   
           concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
           concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details ,
		   lab_order.Status 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.OrderBy = '".$user->getName()."' ) AND (lab_order.Dept = 'OPD')";
		$OBJID = "LAB_ORDER_ID";
		$caption = "My lab orders";	
		$clmns = array("Order date","","Test name","Name","Details","Status");
		$dte_field = "OrderDate";
		$link ="'home.php?page=opdLabOrder&action=View&LABORDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=labresult')";
   }   

   
      else if ($mode == "presorder") {
$qry = "SELECT   prescribe_items.CreateDate,
			 prescribe_items.PRS_ITEM_ID,
			 opd_presciption.PID,
			 patient.Full_Name_Registered,
			 drugs.Name,
			 prescribe_items.Dosage,
			 prescribe_items.Frequency,
			 prescribe_items.HowLong
			 FROM prescribe_items ,opd_presciption,patient,admission,drugs
			where (opd_presciption.PRSID = prescribe_items.PRES_ID) AND (patient.PID =  opd_presciption.PID) AND (admission.PID =  opd_presciption.PID) AND ( prescribe_items.DRGID =  drugs.DRGID) AND (opd_presciption.Dept = 'ADM') AND (prescribe_items.CreateUser = '".$user->getName()."')"; 
		
		// (opd_visits.Doctor ='".$user->getId()."') AND 
			
		/*	$qry = "SELECT  opd_visits.DateTimeOfVisit,
			opd_visits.OPDID ,
			opd_visits.Complaint,			
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			
			opd_visits.Status 
			FROM opd_visits, patient 
			where (opd_visits.PID=2 )"; */			
			
		$OBJID = "PRS_ITEM_ID";
		$caption = "My Prescribe Order list";	
		$clmns = array("Order Date","","Patient ID","Patient Name","Drug","Dose","Frequency","HowLong");
		//$status = "Status";	
		$dte_field = "CreateDate";
		$link ="'home.php?page=prescribe&action=OrderView&PRS_ITEM_ID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=orderlist')";
   }

		
 
   
   
     /* 
		   if($status=='High Critical') $color=='red';
		  if($status=='Critical') $color=='blue';
		  if($status=='Normal') $color=='green';
		 
		 
       $con = mysql_connect(HOST, USERNAME, PASSWORD);
        if (!con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db(DB);
		
	$result = mysql_query($qry);
	
	$get_status = array();
for ($i = 0; $i < mysql_num_fields($result); ++$i) {
    $table = mysql_field_table($result, $i);
    $field = mysql_field_name($result, $i);
    array_push($get_status, "$table.$field");
}

if($get_status['opd_visits.Status']='Critical'){

		if(status='High Critical'){
		$('#rid').css({'background':'red'});
		}
		
		if(status=''){
		$(this).css('background',c);
		}
	if(status='High Critical'){
		$('#1').css({'background':'red'});
		}
$('#'+rid).css({'background':'yellow'});

		if(status=='Critical'){	
				
			$('#'+rid).css({'background':'yellow'});				
		}
		
			if(status=='High Critical'){
				
		$('#'+rid).css({'background':'red'});
		
		}

		
		if(status=''){
		$(this).css('background',c);
		}
$('#'+rid).css({'background':'yellow'});
}*/
	//$status;


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
		echo loadLaboratoryTable("opdpatient",$user);
	}
}

?>