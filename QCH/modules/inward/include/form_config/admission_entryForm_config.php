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
  `AdmissionDate` datetime,
  `Complaint` varchar(200) NOT NULL,
  `Doctor` int(11) DEFAULT NULL,
  `Ward` int(5),
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(10) DEFAULT NULL,
  `ICD_Code_Discharge` varchar(10) DEFAULT NULL,
  `ICD_Text_Discharge` varchar(200) DEFAULT NULL,
  `SNOMED_Code_Discharge` varchar(10) DEFAULT NULL,
  `DischargeDate` datetime,
  `Remarks` varchar(200) NOT NULL ,
*/


/////////////////////////admission_entry//////              


$admission_entryForm = array();
$admission_entryForm["OBJID"] = "ADMID";
$admission_entryForm["TABLE"] = "admission";
$admission_entryForm["SAVE"] = "admission_save.php";
$admission_entryForm["AUDIT_INFO"] = true;
$admission_entryForm["NEXT"]  = "home.php?page=admission&action=View&PID=".$_GET["PID"]."&ADMID=";	
$admission_entryForm["NEXT1"]  = "home.php?page=admission&action=View&ADMID=";	

$pid=$_GET["PID"];
$date=date("Y-m-d H:i:s");

$admission_entryForm["FLD"][0]=array(
                                    "Id"=>"AdmissionDate", "Name"=>"Date and time of admission",
                                    "Type"=>"timestamp",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$admission_entryForm["FLD"][1]=array(
                                    "Id"=>"OnSetDate", "Name"=>"Onset Date",    "Type"=>"date",
                                    "Value"=>date("Y-m-d"),     "Help"=>"Onset Date",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$admission_entryForm["FLD"][2]=array(
                                    "Id"=>"BHT", "Name"=>"Bed Head No",    "Type"=>"bht",
                                    "Value"=>"",     "Help"=>"Bed Head Ticket number",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$admission_entryForm["FLD"][3]=array(
                                    "Id"=>"Doctor",   "Name"=>"Doctor",    "Type"=>"doctor",
                                    "Value"=>"", "Help"=>"Doctor",     "Ops"=>"",
                                    "valid"=>"*"
                                    );     		
$admission_entryForm["FLD"][4]=array(
                                    "Id"=>"Complaint",    "Name"=>"Complaints / Injury",  "Type"=>"complaint",
                                    "Value"=>"",   "Help"=>"Complaint/Injury ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );

$admission_entryForm["FLD"][5]=array(
								"Id"=>"exam_sketch",     "Name"=>"Sketch of Injury Points",    "Type"=>"textar",
								"Help"=>"Sketch of Injury Points", 
								);								
								
$admission_entryForm["FLD"][6]=array(
                                    "Id"=>"Status",    "Name"=>"Severity",  "Type"=>"status_type",
                                    "Value"=>"",   "Help"=>"Severity of the Patient",  "Ops"=>"",
                                    "valid"=>"*"
                                    );								
$admission_entryForm["FLD"][7]=array(
                                    "Id"=>"Ward",    "Name"=>"Ward",  "Type"=>"ward",
                                    "Value"=>"",   "Help"=>"Admission ward ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
 
$admission_entryForm["FLD"][8]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);     
$admission_entryForm["FLD"][9]=array(
								"Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$pid,
								"Help"=>"", "Ops"=>""
								);  
$admission_entryForm["FLD"][10]=array(
								"Id"=>"ADMID",     "Name"=>"ADMID",    "Type"=>"hidden",     "Value"=>$_GET["ADMID"],
								"Help"=>"", "Ops"=>""
								);  									
$admission_entryForm["FLD"][11]=array(
								"Id"=>"HID",     "Name"=>"HID",    "Type"=>"hidden",     "Value"=>$_SESSION["HID"],
								"Help"=>"", "Ops"=>""
								);  								
$admission_entryForm["FLD"][12]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$admission_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData();canvas_save2(" . $pid ."," . json_encode($date) .");",
							"Next"=>""
							);                                            
  
$admission_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////OPD FORM END			          
?>