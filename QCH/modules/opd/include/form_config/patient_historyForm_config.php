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

//ppatient_history
$patient_historyForm = array();
$patient_historyForm["OBJID"] = "PATHISTORYID";
$patient_historyForm["TABLE"] = "patient_history";
$patient_historyForm["LIST"] = array( 'PATHISTORYID','Name', 'Status','Remarks','Active');
$patient_historyForm["DISPLAY_LIST"] = array( 'ID','Name', 'Status','Remarks','Active');
$patient_historyForm["AUDIT_INFO"] = true;
$patient_historyForm["NEXT"]  = "home.php?page=patient&PID=".$_GET["PID"]."&action=View&A=";	

$patient_historyForm["FLD"][0]=array(
                                    "Id"=>"HistoryDate", "Name"=>"Date/Age/Year",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Date or age or period ", "Ops"=>"",
                                    "valid"=>""
                                    );
$patient_historyForm["FLD"][1]=array(
                                    "Id"=>"History_Type",    "Name"=>"",  "Type"=>"tezt",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
/*$patient_historyForm["FLD"][2]=array(
                                    "Id"=>"SNOMED_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$patient_historyForm["FLD"][3]=array(
                                    "Id"=>"SNOMED_Text",    "Name"=>"SNOMED",  "Type"=>"snomed_text_select",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );*/
$patient_historyForm["FLD"][2]=array(
                                    "Id"=>"ICD_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$patient_historyForm["FLD"][3]=array(
                                    "Id"=>"ICD_Text",    "Name"=>"ICD Diagnosis",  "Type"=>"icd_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$patient_historyForm["FLD"][4]=array(
                                    "Id"=>"IMMR_Code",    "Name"=>"",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$patient_historyForm["FLD"][5]=array(
                                    "Id"=>"IMMR_Text",    "Name"=>"IMMR Diagnosis",  "Type"=>"immr_text",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );								
									

$patient_historyForm["FLD"][6]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);    
$patient_historyForm["FLD"][7]=array(
								"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"Diagnosis active or not", "Ops"=>""
								);     		
	$patient_historyForm["FLD"][8]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $patient_historyForm["FLD"][9]=array(
                                    "Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
  
$patient_historyForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
/*     $patient_historyForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $patient_historyForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>