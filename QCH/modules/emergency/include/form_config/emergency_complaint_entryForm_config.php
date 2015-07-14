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


  



///////////////////////// FORM//////              


$emergency_complaint_entryForm = array();
$emergency_complaint_entryForm["OBJID"] = "EMRID";
$emergency_complaint_entryForm["TABLE"] = "emergency_admission";
$emergency_complaint_entryForm["AUDIT_INFO"] = true;
$emergency_complaint_entryForm["NEXT"]  = "home.php?page=emergency&action=View&EMRID=";	
$emergency_complaint_entryForm["NEXT1"]  = "home.php?page=emergency&action=View&EMRID=";
$date=date("Y-m-d H:i:s");
$icd1 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$icd2 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$snomed1 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$snomed2 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");

$emergency_complaint_entryForm["FLD"]=array(	
		array("Id"=>"DateTimeOfVisit", "Name"=>"Date and time of observe","Type"=>"timestamp",  "Value"=>"","Help"=>"", "Ops"=>"","valid"=>""),
		array("Id"=>"OnSetDate", "Name"=>"Onset Date",    "Type"=>"date","Value"=>date("Y-m-d"),     "Help"=>"Onset Date",   "Ops"=>"","valid"=>"*"),
		array("Id"=>"ODoctor",   "Name"=>"Observation Doctor",    "Type"=>"doctor", "Value"=>"", "Help"=>"Doctor",     "Ops"=>"","valid"=>"*"),
		array("Id"=>"Complaint",    "Name"=>"Complaints / Injury",  "Type"=>"complaint","Value"=>"",   "Help"=>"Complaint/Injury ",  "Ops"=>"","valid"=>"*"),$icd1,$icd2,
		$snomed1,$snomed2,
		array("Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"", "Help"=>"Any remarks (Canned text enabled)", "Ops"=>"" ),
		array("Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],"Help"=>"", "Ops"=>"" ),
		array("Id"=>"EMRID",     "Name"=>"opdid",    "Type"=>"hidden",     "Value"=>$_GET["EMRID"],"Help"=>"", "Ops"=>""),
		array("Id"=>"LastUpDate",     "Name"=>"lastupdate",    "Type"=>"hidden",     "Value"=>$date,"Help"=>"", "Ops"=>"")
	);


$emergency_complaint_entryForm["BTN"] = array(
        array("Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ", "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()","Next"=>""),
        array( "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel","Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()", "Next"=>"NL")
        
);                                            
 							
///////////////////////// FORM END			          
?>
