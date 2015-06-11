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
function loadPatientForm($action)
{
	include 'form_config/patientForm_config.php';
	include_once 'class/MDSForm.php';
	$out = "";
	$form = new MDSForm();
	$out .=addErrorDiv();
	if ($action == "Edit"){
		$out .=loadHeader("Edit patient registration");
	}
	else if($action == "New"){
		$_SESSION["PID"] = NULL;
		$out .=loadHeader("New patient registration");
	}
	$form->FrmName = "patientForm";
    $frm = $form->render($patientForm);
    echo $out.$frm;
}

function loadAdmissionEntryScreen($action){
	include 'form_config/admission_entryForm_config.php';
	//include_once 'class/MDSPatient.php';
	include_once 'class/MDSForm.php';
	$blocked = false;
	if ($_GET["ADMID"]){
		include_once 'class/MDSAdmission.php';
		$admission = new MDSAdmission();
		$admission->openId($_GET["ADMID"]);
		$blocked = !$admission->isOpened;
	}
	$pid = $out = $frm = "";
	$pid = $_GET["PID"];
	
	//echo $pcuid;
	if ($pid == "") { echo "Patient not found!"; return NULL; };
	//$patient = new MDSPatient();
	$form = new MDSForm();
	//$patient->openId($pid);
    $out .= addErrorDiv();
	$out .= loadHeader("".$_GET["action"]." admission");
	//$out .= $patient->patientBannerTiny();
	$form->FrmName = "admission_entryForm";
    $frm = $form->render($admission_entryForm,$blocked);	
	echo $out.$frm;
}

function loadAdmissionDischargeScreen(){
	include 'form_config/admission_discharge_entryForm_config.php';
	include_once 'class/MDSAdmission.php';
	include_once 'class/MDSForm.php';
	$pid = $admid = $out = $frm = "";
	$admid = $_GET["ADMID"];
	if ($admid == "") { echo "Admission not found!"; return NULL; };
	$admission = new MDSAdmission();
	$admission->openId($admid);
	$blocked = !$admission->isOpened;
	$patient = $admission->getAdmitPatient();
    $form = new MDSForm();
    $out .= addErrorDiv();
	$out .= loadHeader("Discharge patient");
	//$out .= $patient->patientBannerTiny();
	$form->FrmName = "admission_discharge_entryForm";
    $frm = $form->render($admission_discharge_entryForm,$blocked);	
	echo $out.$frm;
}


function loadAdmissionDiagnosisScreen(){
	include 'form_config/admission_diagnosis_entryForm_config.php';
	include_once 'class/MDSAdmission.php';
	include_once 'class/MDSForm.php';
	$pid = $admid = $out = $frm = "";
	$admid = $_GET["ADMID"];
	if ($admid == "") { echo "Admission not found!"; return NULL; };
	$admission = new MDSAdmission();
	$admission->openId($admid);
	$patient = $admission->patient;
	$form = new MDSForm();
    $out .= addErrorDiv();
	$out .= loadHeader("Diagnosis");
	//$out .= $patient->patientBannerTiny();
	$form->FrmName = "admission_diagnosis_entryForm";
	$blocked = !$admission->isOpened;
    $frm = $form->render($admission_diagnosis_entryForm,$blocked);	
	echo $out.$frm;
}

function loadAdmissionProcedureScreen(){
	include 'form_config/admission_procedures_entryForm_config.php';
	include_once 'class/MDSAdmission.php';
	include_once 'class/MDSForm.php';
	$pid = $admid = $out = $frm = "";
	$admid = $_GET["ADMID"];
	if ($admid == "") { echo "Admission not found!"; return NULL; };
	$admission = new MDSAdmission();
	$admission->openId($admid);
	$blocked = !$admission->isOpened;
	$patient = $admission->getAdmitPatient();
	$form = new MDSForm();
    $out .= addErrorDiv();
	$out .= loadHeader("Surgical procedures");
	//$out .= $patient->patientBannerTiny();
	$form->FrmName = "admission_procedures_entryForm";
    $frm = $form->render($admission_procedures_entryForm,$blocked);	
	echo $out.$frm;
}

function loadOpdVisitScreen($action){
    include 'form_config/opdForm_config.php';
	include_once 'class/MDSPatient.php';
	include_once 'class/MDSForm.php';
	$pid = $out = $frm = "";
    if (!$_SESSION['PID']) { echo "Patient not found!"; return NULL; };
	$pid = $_GET["PID"];
	if ($pid == "") { echo "Patient not found!"; return NULL; };
	$form = new MDSForm();
    $out .= addErrorDiv();
	if ($_GET["OPDID"]){
		include_once 'class/MDSOpd.php';
		$opd = new MDSOpd();
		$opd->openId($_GET["OPDID"]);
		$blocked = !$opd->isOpened;
	}
	if ($action == "Edit"){
		$out .= loadHeader("Edit OPD Visit");
	}
	else if($action == "New"){
		$_SESSION["OPDID"] = NULL;
		$out .= loadHeader("New OPD Visit");
	}
	$form->FrmName = "opdForm";
    $frm = $form->render($opdForm,$blocked);	
	echo $out.$frm;
}

function loadPcuVisitScreen($action){
    include 'form_config/pcu_entryForm_config.php';
	include_once 'class/MDSPatient.php';
	include_once 'class/MDSForm.php';
	$pid = $out = $frm = "";
    if (!$_SESSION['PID']) { echo "Patient not found!"; return NULL; };
	$pid = $_GET["PID"];
	if ($pid == "") { echo "Patient not found!"; return NULL; };
	$form = new MDSForm();
    $out .= addErrorDiv();
	if ($_GET["PCUID"]){
		include_once 'class/MDSPcu.php';
		$pcu = new MDSPcu();
		$pcu->openId($_GET["PCUID"]);
		$blocked = !$pcu->isOpened;
	}
	if ($action == "Edit"){
		$out .= loadHeader("Edit PCU Visit");
	}
	else if($action == "New"){
		$_SESSION["PCUID"] = NULL;
		$out .= loadHeader("New PCU Visit");
	}
	$form->FrmName = "pcu_entryForm";
    $frm = $form->render($pcu_entryForm,$blocked);	
	echo $out.$frm;
}

function loadopdPrescribeScreen(){
    include 'form_config/prescribeItemsForm_config.php';
	include_once 'class/MDSOpd.php';
	include 'prescription.php';
	if (!$_GET['OPDID']) return NULL; 
	$opd = new MDSOpd();
	$opd->openId($_GET['OPDID']);
	$mode = $_GET['MODE']; 
	//view=1bda80f2be4d3658e0baa43fbe7ae8c1 edit=de95b43bceeb4b998aed4aed5cef1ae7
	if ($mode=="") {
	$mode="de95b43bceeb4b998aed4aed5cef1ae7";
	}
    $out = "";
    $out .=loadHeader("OPD Prescription");
    $out .= addErrorDiv();
	$frm = renderPrescriptionForm($prescribeItemsForm,"prescribeItemsForm","OPD",$opd,$mode);
    echo $out.$frm;
}
function loadADMPrescribeScreen(){
    include 'form_config/prescribeItemsForm_config.php';
	include_once 'class/MDSAdmission.php';
	include 'prescription.php';
	if (!$_GET['ADMID']) return NULL; 
	$adm = new MDSAdmission();
	$adm->openId($_GET['ADMID']);
	$mode = $_GET['MODE']; 
	//view=1bda80f2be4d3658e0baa43fbe7ae8c1 edit=de95b43bceeb4b998aed4aed5cef1ae7
	if ($mode=="") {
	$mode="de95b43bceeb4b998aed4aed5cef1ae7";
	}
    $out = "";
    $out .=loadHeader("Admission Prescription");
    //$out .= addErrorDiv();
	$frm = renderADMPrescriptionForm($prescribeItemsForm,"prescribeItemsForm","ADM",$adm,$mode);
    echo $out.$frm;
}
function loadopdLabOrderScreen($action){
    include 'form_config/labOrderForm_config.php';
	
	include 'lab_order.php';

    $out = "";
    $out .=loadHeader("".$action." OPD Lab Order");
    $out .= addErrorDiv();
	if ($_GET['LABORDID']) {
		$frm = renderLabOrderFormEdit($labOrderItemsForm,"labOrderItemsForm","OPD","",$_GET['LABORDID']);
	}
	else { //new
		include_once 'class/MDSOpd.php';
		if (!$_GET['OPDID']) return NULL; 
		$opd = new MDSOpd();
		$opd->openId($_GET['OPDID']);
		$frm = renderLabOrderForm($labOrderItemsForm,"labOrderItemsForm","OPD",$opd);
	}
    echo $out.$frm;
}


function loadADMLabOrderScreen($action){
    include 'form_config/labOrderForm_config.php';
	include 'lab_order.php';

    $out = "";
    $out .=loadHeader("".$action." Admission Lab Order");
    $out .= addErrorDiv();
	if (isset($_GET['LABORDID'])) {
		$frm = renderLabOrderFormEdit($labOrderItemsForm,"labOrderItemsForm","ADM","",$_GET['LABORDID']);
	}
	else { //new
		include_once 'class/MDSAdmission.php';
		if (!$_GET['ADMID']) return NULL; 
		$admission = new MDSAdmission();
		$admission->openId($_GET['ADMID']);
		$frm = renderLabOrderForm($labOrderItemsForm,"labOrderItemsForm","ADM",$admission);
	}
    echo $out.$frm;
}

function loadopdDispenceScreen(){
	include 'prescription.php';
	$out = "";
	$prsid = "";
	$prsid = $_GET["PRSID"];
    $out .=loadHeader("Dispense Form");
    $out .= addErrorDiv();
	$frm = renderDispenseForm($prsid);
    echo $out.$frm;
}
function loadADMDispenceScreen(){
	include 'prescription.php';
	$out = "";
	$prsid = "";
	$prsid = $_GET["PRSID"];
    $out .=loadHeader("Dispense Form");
    $out .= addErrorDiv();
	$frm = renderADMDispenseForm($prsid);
    echo $out.$frm;
}
function addErrorDiv(){
		return "<div id='MDSError' class='mdserror'></div>";
}
   ?>