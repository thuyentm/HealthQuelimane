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
	include_once 'class/MDSHospital.php';
	include_once 'class/MDSPatient.php';
	$hospital = new MDSHospital();
	//$patient = new MDSPatient();
	$hospital->openId($_SESSION["HID"]);
	//$patient->openId((string)($_POST['PID']));
	$admission = new MDSAdmission();
	if ($_POST['ADMID'] > 0){
		$admid = $_POST['ADMID'];
		$admission->openId($admid);
	}
	$admission->setValue("PID",(($_POST['PID'])));
	$admission->setValue("PCUID",(($_POST['PCUID'])));
	$admission->setValue("AdmissionDate",$_POST['AdmissionDate']);
	$admission->setValue("BHT",$_POST['BHT']);
	$admission->setValue("Complaint",$_POST['Complaint']);
	/*$admission->setValue("Weight",$_POST['Weight']);
	$admission->setValue("Height",$_POST['Height']);
	$admission->setValue("sys_BP",$_POST['sys_BP']);
	$admission->setValue("diast_BP",$_POST['diast_BP']);
	$admission->setValue("Temprature",$_POST['Temprature']);
	$admission->setValue("pulse",$_POST['pulse']);
	$admission->setValue("saturation",$_POST['saturation']);
	$admission->setValue("respiratory",$_POST['respiratory']);
	$admission->setValue("Alert",$_POST['Alert']);
	$admission->setValue("Voice",$_POST['Voice']);
	$admission->setValue("Pain",$_POST['Pain']);
	$admission->setValue("UNR",$_POST['UNR']);
	$admission->setValue("Status",$_POST['Status']);*/
	$admission->setValue("Doctor",(($_POST['Doctor'])));
	$admission->setValue("HID",(($_POST['HID'])));
	$admission->setValue("Doctor_Seen",(($_POST['Doctor_Seen'])));
	$admission->setValue("Ward",(($_POST['Ward'])));
	$admission->setValue("AdmitTo",(($_POST['Ward'])));
	$admission->setValue("Remarks",(($_POST['Remarks'])));
        $admission->setValue("DeathDate",NULL);
	///if ($admission->getValue("DischargeDate")){
	///$admission->setValue("DischargeDate","");
	//}
	$id= $admission->save('rId');
	if ($id > 0) {
		$hospital->setvalue("Current_BHT",$_POST['BHT']);
		//$patient->setValue("Cward",$_POST['Ward']);
		$hospital->save();
		//$patient->save();
		echo 'Error=false; res="'.$id.'"; ';
	}
	else{
		echo 'Error=true; res="BHT Already exisit"; ';
	}
	

  ?>