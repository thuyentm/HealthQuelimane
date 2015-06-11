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
  `ADMNOTEID` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) NOT NULL,
  `Note` varchar(500),
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ADMNOTEID`)
*/


/////////////////////////admission_discharge_entry//////              


$admission_notes_entryForm = array();
$admission_notes_entryForm["OBJID"] = "ADMNOTEID";
$admission_notes_entryForm["TABLE"] = "admission_notes";
$admission_notes_entryForm["AUDIT_INFO"] = true;
$admission_notes_entryForm["NEXT"]  = "home.php?page=admission&action=View&PID=".$_GET["PID"]."&ADMID=".$_GET["ADMID"]."ADMNOTEID=";	
$admission_notes_entryForm["NEXT1"]  = "home.php?page=admission&action=View&ADMNOTEID=";	

$admission_notes_entryForm["FLD"][0]=array(
                                    "Id"=>"Note", "Name"=>"Notes",
                                    "Type"=>"remarks",  "Value"=>"",
                                    "Help"=>"Admission notes", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$admission_notes_entryForm["FLD"][1]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Active or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );							
$admission_notes_entryForm["FLD"][2]=array(
								"Id"=>"ADMID",     "Name"=>"HID",    "Type"=>"hidden",     "Value"=>$_GET["ADMID"],
								"Help"=>"", "Ops"=>""
								);  								
$admission_notes_entryForm["FLD"][3]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$admission_notes_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$admission_notes_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
///////////////////////// admission_notes_entryFormEND			          
?>