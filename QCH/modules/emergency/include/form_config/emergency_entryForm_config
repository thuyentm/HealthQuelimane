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




/////////////////////////emergency_entry//////              


$emergency_entryForm = array();
$emergency_entryForm["OBJID"] = "PCUID";
$emergency_entryForm["TABLE"] = "emergency_admission";
//$emergency_entryForm["SAVE"] = "pcu_save.php";
$emergency_entryForm["AUDIT_INFO"] = true;
$emergency_entryForm["NEXT"]  = "home.php?page=emergency&action=View&EMRID=";	
$emergency_entryForm["NEXT1"]  = "home.php?page=emergency&action=View&EMRID=";	

$pid=$_GET["PID"];
$date=date("Y-m-d H:i:s");

$emergency_entryForm["FLD"][0]=array(
                                    "Id"=>"DateTimeOfVisit", "Name"=>"Date and time of Visit",
                                    "Type"=>"timestamp",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$emergency_entryForm["FLD"][1]=array(
                                    "Id"=>"OnSetDate", "Name"=>"Onset Date",    "Type"=>"date",
                                    "Value"=>date("Y-m-d"),     "Help"=>"Onset Date",   "Ops"=>"",
                                    "valid"=>"*"
                                    );

$emergency_entryForm["FLD"][2]=array (
                                    "Id"=>"Weight",    "Name"=>"Weight in Kg",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>" min = 0 max =300 step=5",
                                    "valid"=>""
                                  );
$emergency_entryForm["FLD"][3]=array(
                                    "Id"=>"Height",    "Name"=>"Height in M",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"min = 0 max =2,5 step=0.1",
                                    "valid"=>""
                                    );								
$emergency_entryForm["FLD"][4]=array(
                                    "Id"=>"sys_BP",    "Name"=>"sys BP",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );									

$emergency_entryForm["FLD"][5]=array(
								"Id"=>"diast_BP",     "Name"=>"diast BP",    "Type"=>"number",     "Value"=>"80",
								"Help"=>"", "Ops"=>" min = 20 max =200 step=5 normal=80"
								);	
$emergency_entryForm["FLD"][6]=array(
								"Id"=>"Temprature",     "Name"=>"Temperature in 'c",    "Type"=>"number",     "Value"=>"36.6",
								"Help"=>"", "Ops"=>" min = 15 max =50 step=0.5 normal=36.6"
								);
$emergency_entryForm["FLD"][7]=array(
                                    "Id"=>"Pulse",    "Name"=>"Pulse",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$emergency_entryForm["FLD"][8]=array(
                                    "Id"=>"Saturation",    "Name"=>"Saturation",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$emergency_entryForm["FLD"][9]=array(
                                    "Id"=>"Respiratory",    "Name"=>"Respiratory",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
$emergency_entryForm["FLD"][10]=array(
								"Id"=>"Alert",     "Name"=>"Alert",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								); 
$emergency_entryForm["FLD"][11]=array(
								"Id"=>"Voice",     "Name"=>"Voice",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
$emergency_entryForm["FLD"][12]=array(
								"Id"=>"Pain",     "Name"=>"Pain",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
$emergency_entryForm["FLD"][13]=array(
								"Id"=>"UNR",     "Name"=>"Un-Responsive",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"", "Ops"=>""
								);
							
$emergency_entryForm["FLD"][14]=array(
                                    "Id"=>"Status",    "Name"=>"Severity",  "Type"=>"severity",
                                    "Value"=>"",   "Help"=>"Severity of the Patient",  "Ops"=>"",
                                    "valid"=>"*"
                                    );								

 
$emergency_entryForm["FLD"][15]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);     
$emergency_entryForm["FLD"][16]=array(
								"Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$pid,
								"Help"=>"", "Ops"=>""
								);  
$emergency_entryForm["FLD"][17]=array(
								"Id"=>"EMRID",     "Name"=>"PCUID",    "Type"=>"hidden",     "Value"=>$_GET["EMRID"],
								"Help"=>"", "Ops"=>""
								);  									
$emergency_entryForm["FLD"][18]=array(
								"Id"=>"HID",     "Name"=>"HID",    "Type"=>"hidden",     "Value"=>$_SESSION["HID"],
								"Help"=>"", "Ops"=>""
								); 
$emergency_entryForm["FLD"][19]=array(
								"Id"=>"Observation",     "Name"=>"Observation",    "Type"=>"hidden",     "Value"=>No,
								"Help"=>"", "Ops"=>""
								); 							
$emergency_entryForm["FLD"][20]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$emergency_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData();",
							"Next"=>""
							);                                            
  
$emergency_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									

?>
