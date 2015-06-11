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

  
/*
  `ADMDIAGNOSISID` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) NOT NULL ,
  
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(20) DEFAULT NULL,
  `SNOMED_Text` varchar(200) DEFAULT NULL,
  `IMMR_Code` varchar(10) DEFAULT NULL,
  `IMMR_Text` varchar(200) DEFAULT NULL,
  
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
*/


/////////////////////////admission_diagnosis_entryForm//////              


$admission_diagnosis_entryForm = array();
$admission_diagnosis_entryForm["OBJID"] = "ADMDIAGNOSISID";
$admission_diagnosis_entryForm["TABLE"] = "admission_diagnosis";
$admission_diagnosis_entryForm["SAVE"] = "admission_diagnosis_save.php";
$admission_diagnosis_entryForm["AUDIT_INFO"] = true;
$admission_diagnosis_entryForm["NEXT"]  = "home.php?page=admission&action=View&PID=".$_GET["PID"]."&ADMID=".$_GET["ADMID"]."&ADMDIAGNOSISID=";	
$admission_diagnosis_entryForm["NEXT1"]  = "home.php?page=admission&action=View&ADMID=";	

$admission_diagnosis_entryForm["FLD"][0]=array(
                                    "Id"=>"DiagnosisDate", "Name"=>"Diagnosis entry date",
                                    "Type"=>"timestamp",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
/*$admission_diagnosis_entryForm["FLD"][1]=array(
                                    "Id"=>"SNOMED_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );
 $admission_diagnosis_entryForm["FLD"][2]=array(
                                    "Id"=>"SNOMED_Text",    "Name"=>"SNOMED Diagnosis",  "Type"=>"snomed_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"disorderForm",
                                    "valid"=>""
                                    );*/
									
$admission_diagnosis_entryForm["FLD"][1]=array(
                                    "Id"=>"ICD_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$admission_diagnosis_entryForm["FLD"][2]=array(
                                    "Id"=>"ICD_Text",    "Name"=>"ICD Diagnosis",  "Type"=>"icd_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$admission_diagnosis_entryForm["FLD"][3]=array(
                                    "Id"=>"IMMR_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$admission_diagnosis_entryForm["FLD"][4]=array(
                                    "Id"=>"IMMR_Text",    "Name"=>"IMMR Diagnosis",  "Type"=>"immr_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
 

$admission_diagnosis_entryForm["FLD"][5]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);    
$admission_diagnosis_entryForm["FLD"][6]=array(
								"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"Diagnosis active or not", "Ops"=>""
								);     								
$admission_diagnosis_entryForm["FLD"][7]=array(
								"Id"=>"ADMID",     "Name"=>"ADMID",    "Type"=>"hidden",     "Value"=>$_GET["ADMID"],
								"Help"=>"", "Ops"=>"","valid"=>"*"
								);  									
							
$admission_diagnosis_entryForm["FLD"][8]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$admission_diagnosis_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$admission_diagnosis_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////admission_diagnosis_entryForm		          
?>