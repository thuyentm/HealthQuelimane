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
include_once 'class/MDSAdmission.php';
include_once 'class/MDSLeftMenu.php';
include_once 'class/MDSPcu.php';

function loadOpdLabTestInfo($opdid){
	$out = "";
	$tools= "<input type='button'  title='Add/Edit this prescription' class='patBtn'  value='Edit' onclick=self.document.location='home.php?page=opdPrescription&OPDID=".$opdid."'>";
	$out .= "<div class='opdCont' style='width:900px;padding:5px;'>\n";
	$out .= "<table class='PrescriptionInfo' width=100% border=0 cellpadding=0>";
		$out .= "<tr><td class='td_brd'>#</td>\n";
		$out .= "<td class='td_brd'>Test Orderd</td>\n";
		$out .= "<td class='td_brd'>Value</td>\n";
		$out .= "<td class='td_brd'>Range</td>\n";
		$out .= "<td align=right></td><tr>";
	$out .= "</table>";
	$out .= "</div>";
	return $out;
}

function loadAdmissionSummary() {
	$admid = $_GET['ADMID'];
	$out = $lbar = $admInfo = $patInfo = $head = $admPrescription = $admLabOrder =$admDischarge = $admDiagnosis = $admprocedures=$patexam=$pathistory=$admnotes=$admtreatments=$admnotes="";
	if (!$admid) {
		die(diplayMessage('<br>Admission not found <br><input  class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,100));
		return null; 
	}

	$admission		= 	new MDSAdmission();
	$l_menu			= 	new MDSLeftMenu();
	$pcu            =   new MDSPcu();
	$admission->openId($admid);
	$lbar			= 	$l_menu->renderLeftMenu("Admission",$admission);
	$head			=	loadHeader("Patient Admission Information");
	$admInfo		= 	$admission->loadAdmission();	
	$admDiagnosis 	=	$admission->loadDiagnosis();
	$admprocedures 	= 	$admission->loadProcedures();
	$admDischarge 	= 	$admission->loadDischarge();
	$admnotes		=	$admission->loadNotes(); 
	$patInfo	 	= 	$admission->patient->patientBannerTiny();
	$admPrescription = $admission->loadPrescriptionItems();
	$admLabOrder = $admission->loadLabOrders();
	$pcuInfo        =   $admission->patient->loadTriage($admission->isOpened);
	$patexam = $admission->patient->loadExams($admission->isOpened);
	$pathistory = $admission->patient->loadHistory($admission->isOpened);
	$patallergies = $admission->patient->loadPatientAllergy($admission->isOpened);
	echo $head
		.$lbar
		.$patInfo
		.$admInfo
		.$pcuInfo
		.$pathistory
		.$patallergies
		.$patexam
		.$admDiagnosis
		.$admtreatments
		.$admLabOrder
                .$admPrescription
		.$admprocedures
		.$admnotes
		.$admDischarge ;
}

?>