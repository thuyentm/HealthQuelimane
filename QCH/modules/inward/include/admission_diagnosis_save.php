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
	include_once 'class/MDSDataStore.php';
	$admission_diagnosis = new MDSDataStore("admission_diagnosis");
	if ($_POST['ADMDIAGNOSISID'] > 0){
		$admid = $_POST['ADMDIAGNOSISID'];
		$admission_diagnosis->openId($admid);
	}
        
        $admission_diagnosis->setValue("ADMID",$_POST['ADMID']);
        $admission_diagnosis->setValue("DiagnosisDate",$_POST['DiagnosisDate']);
        $admission_diagnosis->setValue("ICD_Code",$_POST['ICD_Code']);
        $admission_diagnosis->setValue("ICD_Text",$_POST['ICD_Text']);
        $admission_diagnosis->setValue("SNOMED_Code",$_POST['SNOMED_Code']);
        $admission_diagnosis->setValue("SNOMED_Text",$_POST['SNOMED_Text']);
        $admission_diagnosis->setValue("IMMR_Code",$_POST['IMMR_Code']);
        $admission_diagnosis->setValue("IMMR_Text",$_POST['IMMR_Text']);
        $admission_diagnosis->setValue("Remarks",$_POST['Remarks']);
        $admission_diagnosis->setValue("Active",$_POST['Active']);
        
	$id= $admission_diagnosis->save('rId');
	if ($id > 0) {
                makeItMain($id,$_POST['ADMID']);
		echo 'Error=false; res="'.$id.'"; ';
	}
	else{
		echo 'Error=true; res="Error in saving"; ';
	}
	
function makeItMain($id,$admid){
	//return $id;
	if (!$id)  return NULL; 
	if (!$admid)  return NULL; 
	include_once "class/MDSDataStore.php";
	include_once "class/MDSDataBase.php";
	include_once "class/MDSAdmission.php";
	$admission = new MDSAdmission();
	$admission->openId($admid);
	if (!$admission->isOpened) return null;
	$ds = new MDSDataStore("admission_diagnosis");
	$ds->openId($id);
	if ($ds->status(true,false) == false) { return " error=true;"; }
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();	

	$sql=" UPDATE admission_diagnosis SET Main = 0 WHERE ADMID = '".$admid."' ";
	$result=$mdsDB->mysqlQuery($sql); 
	
	if (!$result) { return " error=true;"; }
	$ds = new MDSDataStore("admission_diagnosis");
	$ds->openId($id);
	$ds->setValue("Main",1); 
	$status = $ds->save();
	
	if ($status) { 
		$admission->setValue("Discharge_SNOMED_Code",$ds->getValue("SNOMED_Code"));
		$admission->setValue("Discharge_SNOMED_Text",$ds->getValue("SNOMED_Text"));
		$admission->setValue("Discharge_ICD_Code",$ds->getValue("ICD_Code"));
		$admission->setValue("Discharge_ICD_Text",$ds->getValue("ICD_Text"));
		$admission->setValue("Discharge_IMMR_Code",$ds->getValue("IMMR_Code"));
		$admission->setValue("Discharge_IMMR_Text",$ds->getValue("IMMR_Text"));
		$admission->save();
	}
	return $status;
}
  ?>