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
  `ADMID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` varchar(100) NOT NULL ,
  `BHT` varchar(100) NOT NULL ,
  `AdmissionDate` datetime NOT NULL,
  `Doctor` int(11) DEFAULT NULL,
  `Ward` int(5) NOT NULL,
  `Complaint` varchar(200) NOT NULL,
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(10) DEFAULT NULL,
  `IMMR_Code` varchar(10) DEFAULT NULL,
  `IMMR_Text` varchar(10) DEFAULT NULL,
  `ICD_Code_Discharge` varchar(10) DEFAULT NULL,
  `ICD_Text_Discharge` varchar(200) DEFAULT NULL,
  `SNOMED_Code_Discharge` varchar(10) DEFAULT NULL,
  `DischargeDate` varchar(30)  DEFAULT NULL,
  `OutCome` varchar(30)  DEFAULT NULL,
  `DischargeRemarks` varchar(200) NOT NULL ,
  `ReferTo` varchar(30)  DEFAULT NULL
  `Remarks` varchar(200) NOT NULL ,
*/


/////////////////////////admission_discharge_entry//////              


$admission_discharge_entryForm = array();
$admission_discharge_entryForm["OBJID"] = "ADMID";
$admission_discharge_entryForm["TABLE"] = "admission";
$admission_discharge_entryForm["SAVE"] = "admission_discharge_save.php";
$admission_discharge_entryForm["AUDIT_INFO"] = true;
$admission_discharge_entryForm["NEXT"]  = "home.php?page=admission&action=View&PID=".$_GET["PID"]."&ADMID=";	
$admission_discharge_entryForm["NEXT1"]  = "home.php?page=admission&action=View&ADMID=";	

$admission_discharge_entryForm["FLD"][0]=array(
                                    "Id"=>"DischargeDate", "Name"=>"Date and time of Discharge",
                                    "Type"=>"datetime",  "Value"=>"",
                                    "Help"=>"Date and time of Discharge", "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$admission_discharge_entryForm["FLD"][1]=array(
                                    "Id"=>"OutCome", "Name"=>"OutCome",    "Type"=>"out_come",
                                    "Value"=>array("Discharged recovered","Discharged to be followed up","Referred to another institution","Left against medical advice","Died","Other"), 
									"Default"=>"Discharged recovered",
									"Help"=>"Outcome of this admission",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$admission_discharge_entryForm["FLD"][2]=array(
                                    "Id"=>"DeathDate", "Name"=>"Date of Death",
                                    "Type"=>"death_date",  "Value"=>"",
                                    "Help"=>"Date of Death", "Ops"=>"",
                                    "valid"=>""
                                    );

$admission_discharge_entryForm["FLD"][3]=array(
                                    "Id"=>"Discharge_SNOMED_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$admission_discharge_entryForm["FLD"][4]=array(
                                    "Id"=>"Discharge_SNOMED_Text",    "Name"=>"Discharge SNOMED",  "Type"=>"snomed_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"disorderForm",
                                    "valid"=>""
                                    );
$admission_discharge_entryForm["FLD"][5]=array(
                                    "Id"=>"Discharge_ICD_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$admission_discharge_entryForm["FLD"][6]=array(
                                    "Id"=>"Discharge_ICD_Text",    "Name"=>"Discharge ICD",  "Type"=>"icd_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$admission_discharge_entryForm["FLD"][7]=array(
                                    "Id"=>"Discharge_IMMR_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$admission_discharge_entryForm["FLD"][8]=array(
                                    "Id"=>"Discharge_IMMR_Text",    "Name"=>"Discharge IMMR",  "Type"=>"immr_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									

 
$admission_discharge_entryForm["FLD"][9]=array(
								"Id"=>"ReferTo",     "Name"=>"Refer To",    "Type"=>"text",     "Value"=>"",
								"Help"=>"Patient refer to", "Ops"=>""
								); 
$admission_discharge_entryForm["FLD"][10]=array(
								"Id"=>"Discharge_Remarks",     "Name"=>"Discharge Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);     								
$admission_discharge_entryForm["FLD"][11]=array(
								"Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],
								"Help"=>"", "Ops"=>""
								);  
$admission_discharge_entryForm["FLD"][12]=array(
								"Id"=>"ADMID",     "Name"=>"ADMID",    "Type"=>"hidden",     "Value"=>$_GET["ADMID"],
								"Help"=>"", "Ops"=>""
								);  									
$admission_discharge_entryForm["FLD"][13]=array(
								"Id"=>"HID",     "Name"=>"HID",    "Type"=>"hidden",     "Value"=>$_SESSION["HID"],
								"Help"=>"", "Ops"=>""
								);  								
$admission_discharge_entryForm["FLD"][14]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$admission_discharge_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$admission_discharge_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////OPD FORM END			          
?>