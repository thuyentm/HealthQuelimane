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


$pcu_entryForm = array();
$pcu_entryForm["OBJID"] = "PCUID";
$pcu_entryForm["TABLE"] = "pcu_visits";
//$pcu_entryForm["SAVE"] = "pcu_save.php";
$pcu_entryForm["AUDIT_INFO"] = true;
$pcu_entryForm["NEXT"]  = "home.php?page=pcu&action=View&PCUID=";	
$pcu_entryForm["NEXT1"]  = "home.php?page=pcu&action=View&PCUID=";	

$pid=$_GET["PID"];
$date=date("Y-m-d H:i:s");

$pcu_entryForm["FLD"][0]=array(
                                    "Id"=>"DateTimeOfVisit", "Name"=>"Date and time of Visit",
                                    "Type"=>"timestamp",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$pcu_entryForm["FLD"][1]=array(
                                    "Id"=>"OnSetDate", "Name"=>"Onset Date",    "Type"=>"date",
                                    "Value"=>date("Y-m-d"),     "Help"=>"Onset Date",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
/*$pcu_entryForm["FLD"][2]=array(
                                    "Id"=>"BHT", "Name"=>"Bed Head No",    "Type"=>"bht",
                                    "Value"=>"",     "Help"=>"Bed Head Ticket number",   "Ops"=>"",
                                    "valid"=>""
                                    );
							
$pcu_entryForm["FLD"][3]=array(
                                    "Id"=>"Complaint",    "Name"=>"Complaints / Injury",  "Type"=>"complaint",
                                    "Value"=>"",   "Help"=>"Complaint/Injury ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );*/
$pcu_entryForm["FLD"][2]=array (
                                    "Id"=>"Weight",    "Name"=>"Weight in Kg",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>" min = 0 max =300 step=5",
                                    "valid"=>""
                                  );
$pcu_entryForm["FLD"][3]=array(
                                    "Id"=>"Height",    "Name"=>"Height in M",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"min = 0 max =2,5 step=0.1",
                                    "valid"=>""
                                    );								
$pcu_entryForm["FLD"][4]=array(
                                    "Id"=>"sys_BP",    "Name"=>"sys BP",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );									

$pcu_entryForm["FLD"][5]=array(
								"Id"=>"diast_BP",     "Name"=>"diast BP",    "Type"=>"number",     "Value"=>"80",
								"Help"=>"", "Ops"=>" min = 20 max =200 step=5 normal=80"
								);	
$pcu_entryForm["FLD"][6]=array(
								"Id"=>"Temprature",     "Name"=>"Temperature in 'c",    "Type"=>"number",     "Value"=>"36.6",
								"Help"=>"", "Ops"=>" min = 15 max =50 step=0.5 normal=36.6"
								);
$pcu_entryForm["FLD"][7]=array(
                                    "Id"=>"Pulse",    "Name"=>"Pulse",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$pcu_entryForm["FLD"][8]=array(
                                    "Id"=>"Saturation",    "Name"=>"Saturation",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$pcu_entryForm["FLD"][9]=array(
                                    "Id"=>"Respiratory",    "Name"=>"Respiratory",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$pcu_entryForm["FLD"][10]=array(
								"Id"=>"Alert",     "Name"=>"Alert",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								); 
$pcu_entryForm["FLD"][11]=array(
								"Id"=>"Voice",     "Name"=>"Voice",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
$pcu_entryForm["FLD"][12]=array(
								"Id"=>"Pain",     "Name"=>"Pain",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
$pcu_entryForm["FLD"][13]=array(
								"Id"=>"UNR",     "Name"=>"Un-Responsive",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
							
$pcu_entryForm["FLD"][14]=array(
                                    "Id"=>"Status",    "Name"=>"Severity",  "Type"=>"severity",
                                    "Value"=>"",   "Help"=>"Severity of the Patient",  "Ops"=>"",
                                    "valid"=>"*"
                                    );								
/*$pcu_entryForm["FLD"][17]=array(
                                    "Id"=>"Ward",    "Name"=>"Ward",  "Type"=>"textvisit",
                                    "Value"=>"PCU",   "Help"=>"Admission ward ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );*/
 
$pcu_entryForm["FLD"][15]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);     
$pcu_entryForm["FLD"][16]=array(
								"Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$pid,
								"Help"=>"", "Ops"=>""
								);  
$pcu_entryForm["FLD"][17]=array(
								"Id"=>"PCUID",     "Name"=>"PCUID",    "Type"=>"hidden",     "Value"=>$_GET["PCUID"],
								"Help"=>"", "Ops"=>""
								);  									
$pcu_entryForm["FLD"][18]=array(
								"Id"=>"HID",     "Name"=>"HID",    "Type"=>"hidden",     "Value"=>$_SESSION["HID"],
								"Help"=>"", "Ops"=>""
								); 
$pcu_entryForm["FLD"][19]=array(
								"Id"=>"Doctor_Seen",     "Name"=>"Doctor_Seen",    "Type"=>"hidden",     "Value"=>No,
								"Help"=>"", "Ops"=>""
								); 							
$pcu_entryForm["FLD"][20]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$pcu_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData();",
							"Next"=>""
							);                                            
  
$pcu_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////OPD FORM END	
//canvas_save2(" . $pid ."," . json_encode($date) .");
?>