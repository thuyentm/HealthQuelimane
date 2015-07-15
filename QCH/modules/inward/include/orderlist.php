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

function loadNurseMenu() {
    $menu = "";
    $menu .="<div id='left-sidebar'>\n";
    $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
    $menu .="<a>Commands</a>\n";
    $menu .="<div>\n";
    $menu .="<input type='button' class='submenuBtn' value='Order List'  onclick=self.document.location='home.php?page=orderlist&show=orderlist'>\n";
    //$menu .="<input type='button' class='submenuBtn' value='OPD patients'  onclick=self.document.location='home.php?page=orderlist&show=opdpatient'>\n";
    //$menu .="<input type='button' class='submenuBtn' value='Clinic patients'  onclick=self.document.location='home.php?page=orderlist&show=clinicpatient'>\n";
    $menu .="<input type='button' class='submenuBtn' value='Ward patients'  onclick=self.document.location='home.php?page=orderlist&show=wardpatient'>\n";
    //$menu .="<input type='button' class='submenuBtn' value='OPD lab orders'  onclick=self.document.location='home.php?page=orderlist&show=labresult'>\n";
    //$menu .="<input type='button' class='submenuBtn' value='Ward lab orders'  onclick=self.document.location='home.php?page=orderlist&show=admlabresult'>\n";
    $menu .="</div>\n";
    $menu .=" </div>\n";
    $menu .="</div>\n";
    $menu .="<script language='javascript'>\n";
    $menu .="$('#list1a').accordion();\n";
    $menu .="</script>\n";
    echo $menu;
}

function loadLaboratoryTable($mode, $user) {
    $tbl = "";
    $OBJID = "PID";
    $clmns = array();
    $caption = "Patient list";
    $dte_field = "";
    $status = "";
    $link = "";
    if ($mode == "orderlist") {


        $qry = "SELECT   prescribe_items.CreateDate,
			 prescribe_items.PRS_ITEM_ID,
			 opd_presciption.PID,
			 patient.Full_Name_Registered,
			 admission.Ward,
			 drugs.Name,
			 prescribe_items.Dosage,
			 prescribe_items.Frequency,
			 prescribe_items.HowLong,
			 prescribe_items.CreateUser,
			  prescribe_items.Received_nurse
			FROM prescribe_items ,opd_presciption,patient,admission,drugs
			where (opd_presciption.PRSID = prescribe_items.PRES_ID) AND (patient.PID =  opd_presciption.PID) AND (admission.PID =  opd_presciption.PID) AND ( prescribe_items.DRGID =  drugs.DRGID) AND (opd_presciption.Dept = 'ADM')";

        // (opd_visits.Doctor ='".$user->getId()."') AND 

        /* 	$qry = "SELECT  opd_visits.DateTimeOfVisit,
          opd_visits.OPDID ,
          opd_visits.Complaint,
          concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  ,

          opd_visits.Status
          FROM opd_visits, patient
          where (opd_visits.PID=2 )"; */

        $OBJID = "PRS_ITEM_ID";
        $caption = "Prescribe Order list";
        $clmns = array("Order Date", "", "Patient ID", "Patient Name", "Ward", "Drug", "Dose", "Frequency", "HowLong", "Ordered Doctor", "Received Nurse ");
        //$status = "Status";	
        $dte_field = "CreateDate";
        $link = "'home.php?page=prescribe&action=OrderView&PRS_ITEM_ID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=orderlist')";
    } else if ($mode == "opdpatient") {
        $qry = "SELECT  opd_visits.DateTimeOfVisit,
			opd_visits.OPDID ,
			opd_visits.Complaint,			
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details ,
			opd_visits.Status 
			FROM opd_visits, patient 
			where (patient.PID = opd_visits.PID ) AND (opd_visits.VisitType = 'OPD Visit')";
        // (opd_visits.Doctor ='".$user->getId()."') AND 
        $OBJID = "OPDID";
        $caption = "My OPD patient list";
        $clmns = array("Visit Date", "", "Complaint", "Name", "Details", "Severity");
        //$status = "Status";	
        $dte_field = "DateTimeOfVisit";
        $link = "'home.php?page=opd&action=View&OPDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=opdpatient')";
    } else if ($mode == "clinicpatient") {
        $qry = "SELECT  opd_visits.DateTimeOfVisit,
			opd_visits.OPDID ,
			opd_visits.Complaint,			
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details,
			opd_visits.VisitType,
			opd_visits.Status
			FROM opd_visits, patient 
			where (patient.PID = opd_visits.PID ) AND (opd_visits.VisitType != 'OPD Visit')";
        // (opd_visits.Doctor ='".$user->getId()."') AND 
        $OBJID = "OPDID";
        $caption = "My Clinic patient list";
        $clmns = array("Visit Date", "V", "Complaint", "Name", "Details", "Visit Type", "Severity");
        $dte_field = "DateTimeOfVisit";
        $link = "'home.php?page=opd&action=View&OPDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=clinicpatient')";
    } else if ($mode == "wardpatient") {
        $qry = "SELECT  admission.AdmissionDate,
			admission.BHT,
			admission.ADMID ,
			admission.Complaint,
			concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details,
			ward.Name,
			admission.Status
			FROM admission, patient ,ward
			where (patient.PID = admission.PID ) and (ward.WID = admission.Ward ) AND (admission.DischargeDate='')";
        //(admission.Doctor ='".$user->getId()."') AND
        $OBJID = "ADMID";
        $caption = "My ward patient list";
        $clmns = array("Admission Date", "BHT", "", "Complaints", "Name", "Details", "Ward", "Severity");
        $dte_field = "AdmissionDate";
        $link = "'home.php?page=admission&action=View&ADMID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=wardpatient')";
    } else if ($mode == "labresult") {
        $qry = "SELECT  
			lab_order.OrderDate, 
           lab_order.LAB_ORDER_ID, 
           concat('(',lab_order.LAB_ORDER_ID,')',lab_order.TestGroupName), 
		   lab_order.Status, 
           concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
           concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details 
             FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.OrderBy = '" . $user->getName() . "' ) AND (lab_order.Dept = 'OPD')";
        $OBJID = "LAB_ORDER_ID";
        $caption = "My lab orders";
        $clmns = array("Order date", "", "Test name", "Status", "Name", "Details");
        $dte_field = "OrderDate";
        $link = "'home.php?page=opdLabOrder&action=View&LABORDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=labresult')";
    } else if ($mode == "admlabresult") {
        $qry = "SELECT  
			lab_order.OrderDate, 
           lab_order.LAB_ORDER_ID, 
           concat('(',lab_order.LAB_ORDER_ID,')',lab_order.TestGroupName), 
		   lab_order.Status, 
           concat('(', patient.PID,')',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
           concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs / ',patient.Gender,' / ',patient.Personal_Civil_Status,' / ', patient.Address_Village)as Details 
             FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND (lab_order.OrderBy = '" . $user->getName() . "' ) AND (lab_order.Dept = 'ADM')";
        $OBJID = "LAB_ORDER_ID";
        $caption = "My lab orders";
        $clmns = array("Order date", "", "Test name", "Status", "Name", "Details");
        $dte_field = "OrderDate";
        $link = "'home.php?page=admLabOrder&action=View&LABORDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=orderlist&show=labresult')";
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
      } */
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
    $pager2->setColOption($OBJID, array("search" => true, "hidden" => true));
    $pager2->setColOption($dte_field, $pager2->getDateSelector());
    //$pager2->setColOption("Status", array("width"=>100,"bgcolor"=>'#FF0000',"search"=>true,"hidden" => false));
    if (($mode != "orderlist")) {
        $pager2->setColOption("Details", array("width" => 300, "search" => false, "hidden" => false));
    }
    //$pager2->setColOption("Status", array("bgcolor"=>"#FF0000","hidden" => false));
    if (($mode == "labresult") || ($mode == "admlabresult")) {
        $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Pending")));
    }

    $pager2->gridComplete_JS = "function(){
        
		
		var c =null;
		$('.jqgrow').mouseover(function(e) {
			var rowId = $(this).attr('id');
			c = $(this).css('background');
			$(this).css({'background':'yellow','cursor':'pointer'});
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

function loadNurseDefaultPage() {
    include_once 'class/MDSUser.php';
    $user = new MDSUser();
    $user->openId($_SESSION["UID"]);
    $greet = $user->userGreet();
    echo loadHeader($greet);
    loadNurseMenu();
    $mode = "";
    if ((isset($_GET["show"])) && ($_GET["show"] != "")) {
        $mode = $_GET["show"];
        echo loadLaboratoryTable($mode, $user);
    } else {
        echo loadLaboratoryTable("orderlist", $user);
    }
}

function ViewOrder($prs_item_id) {

    include_once 'MDSDatabase.php';
    $result1 = NULL;
    $mdsDB1 = MDSDataBase::GetInstance();
    $mdsDB1->connect();
    $sql1 = "SELECT  prescribe_items.CreateDate,drugs.Name,prescribe_items.Dosage,prescribe_items.Frequency, prescribe_items.HowLong, prescribe_items.CreateUser,prescribe_items.Received_nurse,opd_presciption.PID FROM prescribe_items LEFT JOIN drugs ON prescribe_items.DRGID=drugs.DRGID LEFT JOIN opd_presciption ON prescribe_items.PRES_ID=opd_presciption.PRSID WHERE PRS_ITEM_ID = '" . $prs_item_id . "'";
    $result1 = $mdsDB1->mysqlQuery($sql1);


    $out = "";
    $out .= "<div id='formCont' class='formCont' style='left:5px;' >\n";
    $out .= "<div class='prescriptionHead' style='font-size:23px;'>" . getPrompt("New Order") . "</div>";
    $out .= "<div class='prescriptionInfo'>\n";
    $out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
    $out .= "<tr>";
    while ($row1 = $mdsDB1->mysqlFetchArray($result1)) {
        $out .= "<td>" . getPrompt("Ordered Date") . ": </td><td>" . $row1["CreateDate"] . " </td>";
        $out .= "</tr>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Ordered Doctor") . ": </td><td >" . $row1["CreateUser"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Patient ID") . ": </td><td >" . $row1["PID"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Drug") . ": </td><td >" . $row1["Name"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Dose") . ": </td><td >" . $row1["Dosage"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Frequency") . ": </td><td >" . $row1["Frequency"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("How Long") . ": </td><td >" . $row1["HowLong"] . "</td>";
        $out .= "<tr>";
        $out .= "<td>" . getPrompt("Received Nurse") . ": </td><td>" . $row1["Received_nurse"] . "</td>";
    }
    $out .= "</tr>";
    $out .= "</table>\n";

    $out .= "</div>\n ";
    return $out;
}

?>