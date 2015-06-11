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
include_once 'class/MDSLeftMenu.php';
include_once 'class/MDSPager.php';

function loadDoctorDefaultPage(){
	include_once 'class/MDSUser.php';
	echo	loadHeader("Welcome page");
	$cont = "<div class='dr_page_cont'>";
	$cont_end = "</div'>";
        echo $cont;
	$user = new MDSUser();
	echo $user->userGreet();
	$opd_patient  = "";
}
function  loadOpd($pid){
	$qry = "SELECT opd_visits.OPDID , SUBSTRING(opd_visits.DateTimeOfVisit,1,10) as dte,opd_visits.VisitType,opd_visits.Complaint,
	CONCAT(u.Title,u.FirstName,' ',u.OtherName ) 
	FROM opd_visits,`user` as u
	where (opd_visits.PID =$pid) and (u.UID = opd_visits.Doctor) 	";
    $visit_page = new MDSPager($qry);
    $visit_page->setDivId("opd_cont"); //important
    $visit_page->setDivClass('');
    $visit_page->setRowid('OPDID'); 
    $visit_page->setCaption("Previous visits"); 
	$visit_page->setShowHeaderRow(false);
	$visit_page->setShowFilterRow(false);
    $visit_page->setColNames(array("ID","","","",""));
    $visit_page->setRowNum(25);
    $visit_page->setColOption("OPDID",array("search"=>false,"hidden" => true));
	$visit_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>75));
    $visit_page->gridComplete_JS = "function() {
        $('#opd_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=opd&mod=&action=View&OPDID='+rowId;
        });
        }";
    $visit_page->setOrientation_EL("L");
    echo $visit_page->render();   
}
function  loadAdmission($pid){
	$qry = "SELECT admission.ADMID , SUBSTRING(admission.AdmissionDate,1,10) as dte,admission.Complaint,admission.OutCome,
	CONCAT(user.Title,user.OtherName ) 
	FROM admission,user 
	where (admission.PID ='".$pid."') and (user.UID = admission.Doctor) 	";
    $admission_page = new MDSPager($qry);
    $admission_page->setDivId("adm_cont"); //important
    $admission_page->setDivClass('');
    $admission_page->setRowid('ADMID'); 
    $admission_page->setCaption("Previous admissions"); 
	$admission_page->setShowHeaderRow(false);
	$admission_page->setShowFilterRow(false);
    $admission_page->setColNames(array("ID","","","",""));
    $admission_page->setRowNum(25);
    $admission_page->setColOption("ADMID",array("search"=>false,"hidden" => true));
	$admission_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>75));
    $admission_page->gridComplete_JS = "function() {
        $('#adm_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=admission&mod=&action=View&ADMID='+rowId;
        });
        }";
    $admission_page->setOrientation_EL("L");
    echo $admission_page->render();   
}
function loadExam($pid){
	$qry = "SELECT patient_exam.PATEXAMID , 
	SUBSTRING(patient_exam.ExamDate,1) as dte,
	CONCAT(patient_exam.sys_BP,' / ',patient_exam.diast_BP) as bp,
	CONCAT(patient_exam.Weight,'Kg.') as weight,
	CONCAT(patient_exam.Height,'m') as height,
	CONCAT(patient_exam.Temprature,'`C') as temprature
	FROM patient_exam	
	where (patient_exam.PID ='".$pid."') and(patient_exam.Active = 1)";
    $admission_page = new MDSPager($qry);
    $admission_page->setDivId("exam_cont"); //important
    $admission_page->setDivClass('');
    $admission_page->setRowid('PATEXAMID'); 
    $admission_page->setCaption("Examinations"); 
	$admission_page->setShowHeaderRow(false);
	$admission_page->setShowFilterRow(false);
    $admission_page->setColNames(array("ID","","","","",""));
    $admission_page->setRowNum(25);
    $admission_page->setColOption("PATEXAMID",array("search"=>false,"hidden" => true));
	$admission_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>100));
	$admission_page->setColOption("bp",array("search"=>false,"hidden" => false,"width"=>85));
	$admission_page->setColOption("weight",array("search"=>false,"hidden" => false,"width"=>50));
	$admission_page->setColOption("height",array("search"=>false,"hidden" => false,"width"=>50));
	$admission_page->setColOption("temprature",array("search"=>false,"hidden" => false,"width"=>50));
	
	
    $admission_page->gridComplete_JS = "function() {
        $('#exam_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=patient_exam&mod=&action=New&PATEXAMID='+rowId+'&PID=$pid';
        });
        }";
    $admission_page->setOrientation_EL("L");
    echo $admission_page->render();   
}
function loadHistory($pid){
	$qry = "SELECT patient_history.PATHISTORYID , 
	SUBSTRING(patient_history.HistoryDate,1,10) as dte,
	patient_history.SNOMED_Text,
	patient_history.Remarks
	FROM patient_history	
	where (patient_history.PID ='".$pid."') and(patient_history.Active = 1)";
    $history_page = new MDSPager($qry);
    $history_page->setDivId("his_cont"); //important
    $history_page->setDivClass('');
    $history_page->setRowid('PATHISTORYID'); 
    $history_page->setCaption("History"); 
	$history_page->setShowHeaderRow(false);
	$history_page->setShowFilterRow(false);
    $history_page->setColNames(array("ID","","",""));
    $history_page->setRowNum(25);
    $history_page->setColOption("PATHISTORYID",array("search"=>false,"hidden" => true));
	$history_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>70));
    $history_page->gridComplete_JS = "function() {
        $('#his_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=patient_history&mod=&action=Edit&PATHISTORYID='+rowId+'&PID=$pid';
        });
        }";
    $history_page->setOrientation_EL("L");
    echo $history_page->render();   
}
function loadAlergy($pid){
	$qry = "SELECT patient_alergy.ALERGYID , 
	SUBSTRING(patient_alergy.CreateDate,1,10) as dte,
	patient_alergy.Name,
	patient_alergy.Status,
	patient_alergy.Remarks
	FROM patient_alergy	
	where (patient_alergy.PID ='".$pid."') and (patient_alergy.Active = 1)";
    $alergy_page = new MDSPager($qry);
    $alergy_page->setDivId("alergy_cont"); //important
    $alergy_page->setDivClass('');
    $alergy_page->setRowid('ALERGYID'); 
    $alergy_page->setCaption("Alergies"); 
	$alergy_page->setShowHeaderRow(false);
	$alergy_page->setShowFilterRow(false);
    $alergy_page->setColNames(array("ID","","","",""));
    $alergy_page->setRowNum(25);
    $alergy_page->setColOption("ALERGYID",array("search"=>false,"hidden" => true));
	$alergy_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>70));
    $alergy_page->gridComplete_JS = "function() {
        $('#alergy_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=alergy&mod=&action=Edit&ALERGYID='+rowId+'&PID=$pid';
        });
        }";
    $alergy_page->setOrientation_EL("L");
    echo $alergy_page->render();   
}
function loadLabOrder($pid){
	$qry = "SELECT lab_order.LAB_ORDER_ID , 
	SUBSTRING(lab_order.OrderDate,1,10) as dte,
	lab_order.TestGroupName,
	lab_order.Status,
	lab_order.Remarks
	FROM lab_order	
	where (lab_order.PID ='".$pid."') and (lab_order.Active = 1)";
    $lab_order_page = new MDSPager($qry);
    $lab_order_page->setDivId("lab_cont"); //important
    $lab_order_page->setDivClass('');
    $lab_order_page->setRowid('LAB_ORDER_ID'); 
    $lab_order_page->setCaption("Latest lab results"); 
	$lab_order_page->setShowHeaderRow(false);
	$lab_order_page->setShowFilterRow(false);
    $lab_order_page->setColNames(array("ID","","","",""));
    $lab_order_page->setRowNum(25);
	$lab_order_page->setColOption("LAB_ORDER_ID",array("search"=>false,"hidden" => false,"width"=>30));
	$lab_order_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>80));
	$lab_order_page->setColOption("TestGroupName",array("search"=>false,"hidden" => false,"width"=>120));
	$lab_order_page->setColOption("Status",array("search"=>false,"hidden" => false,"width"=>70));
	
    $lab_order_page->gridComplete_JS = "function() {
		$('div[id ^= \"pager\"]').hide();
        $('#lab_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='home.php?page=opdLabOrder&mod=&action=View&LABORDID='+rowId+'&PID=$pid';
        });
        }";
    $lab_order_page->setOrientation_EL("L");
    echo $lab_order_page->render();   
}
function loadAttachment($pid){
	$qry = "SELECT attachment.Attach_Hash , 
	SUBSTRING(attachment.CreateDate,1,10) as dte,
	attachment.Attach_Name,
	attachment.Attach_Type,
	attachment.Attach_Description
	FROM attachment	
	where (attachment.PID ='".$pid."') and (attachment.Active = 1)";
    $attach_page = new MDSPager($qry);
    $attach_page->setDivId("attach_cont"); //important
    $attach_page->setDivClass('');
    $attach_page->setRowid('Attach_Hash'); 
    $attach_page->setCaption("Files attached to the patient record"); 
	$attach_page->setShowHeaderRow(false);
	$attach_page->setShowFilterRow(false);
    $attach_page->setColNames(array("ID","","","",""));
    $attach_page->setRowNum(25);
	$attach_page->setColOption("Attach_Hash",array("search"=>false,"hidden" => true,"width"=>30));
	$attach_page->setColOption("dte",array("search"=>false,"hidden" => false,"width"=>60));
	$attach_page->setColOption("Attach_Name",array("search"=>false,"hidden" => false,"width"=>70));
	$attach_page->setColOption("Attach_Type",array("search"=>false,"hidden" => false,"width"=>60));
    $attach_page->gridComplete_JS = "function() {
		$('div[id ^= \"pager\"]').hide();
        $('#attach_cont .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            var params = 'menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width='+screen.availWidth+',height='+screen.availHeight;
		    var url = 'attachment_view.php?hash='+rowId;
			window.open('include/' + url + '', 'lookUpW', params);
        });
        }";
    $attach_page->setOrientation_EL("L");
//    echo $attach_page->render();   
}
function loadPatientSummary($action) {
	$pid = $_GET['PID']; 
	$opdid = $_GET['OPDID'];
	if (!$pid) {
		die(diplayMessage('<br>Patient not found <br><input class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,150));
	}
	//else if ($opdid >0) {
				//$row = getPatientForOPD($opdid) ;
	//}
	$patient = new MDSPatient();
	$l_menu = new MDSLeftMenu();
	$patient->openId($pid);
        if (!$patient->getId()) {
            die(diplayMessage('<br>Patient not found <br><input  class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,100));
        }
	$out = "";
	echo loadHeader("Patient overview");
	echo $l_menu->renderLeftMenu("Patient",$patient);
        echo $lbar;
	echo $patient->patientBanner();


	//echo $patient->loadOpdInfo();
	//echo $patient->loadAdmissionInfo();
	//$opdPrescription = $patient->loadOpdPrescriptionInfo();
	//$opdLabOrders= $patient->loadOpdLabOrderInfo();
	//echo $patient->loadPatientAllergy(1);
	//echo $patexam = $patient->loadExams(1);
	//echo $patient->loadHistory(1);
	echo "<div id='patient_view_cont' class='patient_view_cont' >
	<table width=100% border=0>
	<tr><td width=50% id='opd_cont' valign=top></td>
	<td width=50% id='other_cont' valign=top rowspan=3>
	<div id='exam_cont' style='padding-bottom:3;'></div>
	<div id='his_cont' style='padding-bottom:3;'></div>
	<div id='alergy_cont' style='padding-bottom:3;'></div>
	<div id='file_cont' style='padding-bottom:3;'></div>
	<div id='lab_cont' style='padding-bottom:3;'></div>
	</td>
	</tr>
	<tr><td width=50% id='adm_cont' valign=top></td></tr>
	<tr><td width=50% id='attach_cont' valign=top></td></tr>
	</table>
	</div>";
	loadOpd($pid);
	loadAdmission($pid);
	loadExam($pid);
	loadHistory($pid);
	loadAlergy($pid);
	loadLabOrder($pid);
	loadAttachment($pid);
}

?>
