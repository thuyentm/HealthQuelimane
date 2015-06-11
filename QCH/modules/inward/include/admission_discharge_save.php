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
	include_once 'class/MDSPatient.php';

	
	
	$admission = new MDSAdmission();
	if ($_POST['ADMID'] > 0){
		$admid = $_POST['ADMID'];
		$admission->openId($admid);
	}

        $admission->setValue("DischargeDate",$_POST['DischargeDate']);
        $admission->setValue("DeathDate",$_POST['DeathDate']);
        $admission->setValue("Discharge_ICD_Code",$_POST['Discharge_ICD_Code']);
        $admission->setValue("Discharge_ICD_Text",$_POST['Discharge_ICD_Text']);
        $admission->setValue("Discharge_SNOMED_Code",$_POST['Discharge_SNOMED_Code']);
        $admission->setValue("Discharge_SNOMED_Text",$_POST['Discharge_SNOMED_Text']);
        $admission->setValue("Discharge_IMMR_Code",$_POST['Discharge_IMMR_Code']);
        $admission->setValue("Discharge_IMMR_Text",$_POST['Discharge_IMMR_Text']);
        $admission->setValue("OutCome",$_POST['OutCome']);
        $admission->setValue("Discharge_Remarks",$_POST['Discharge_Remarks']);
        $admission->setValue("ReferTo",$_POST['ReferTo']);
        
        
	$id= $admission->save('rId');
	if ($id > 0) {
            if ($_POST['OutCome'] == "Died"){
                if ($_POST['PID'] > 0){
                    $patient = new MDSPatient();
                    $patient->openId((string)($_POST['PID']));
                    $patient->setValue("CStatus","Died");      
                    if ($_POST['OutCome'] == "Died"){
                        $patient->setValue("DeathDate",$_POST['DeathDate']);      
                    }
                    $patient->save();
                }
            }
		echo 'Error=false; res="'.$id.'"; ';
	}
	else{
		echo 'Error=true; res="BHT Already exisit"; ';
	}
	

  ?>