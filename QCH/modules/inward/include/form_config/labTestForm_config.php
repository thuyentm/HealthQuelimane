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




/////////////////////////LABTEST FORM//////              


$labTestForm = array();
$labTestForm["OBJID"] = "LABID";
$labTestForm["TABLE"] = "lab_tests";
$labTestForm["LIST"] = array( 'LABID', 'Department', 'GroupName','Name', 'RefValue');
$labTestForm["DISPLAY_LIST"] = array( 'LABID', 'Department', 'Group Name','Test Name', 'Ref. Value');
$labTestForm["NEXT"]  = "home.php?page=preferences&mod=LabTest&LABID=";	
$labTestForm["AUDIT_INFO"] = true;
//pager starts
$labTestForm["CAPTION"]  = "Lab tests";
$labTestForm["ACTION"]  = "home.php?page=preferences&mod=LabTestNew&LABID=";
$labTestForm["ROW_ID"]="LABID";
$labTestForm["COLUMN_MODEL"] = array( 'LABID'=>array("width"=>"75px"));
$labTestForm["ORIENT"] = "L";

//pager ends
$labTestForm["FLD"][0]=array(
                                    "Id"=>"Department", "Name"=>"Department",
                                    "Type"=>"lab_dpt",  "Value"=>"",
                                    "Help"=>"Department", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$labTestForm["FLD"][1]=array(
                                    "Id"=>"GroupName", "Name"=>"Group Name",    "Type"=>"lab_grp",
                                    "Value"=>"",     "Help"=>"Group Name",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$labTestForm["FLD"][2]=array(
                                    "Id"=>"Name",    "Name"=>"Name",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Test Name ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$labTestForm["FLD"][3]=array(
                                    "Id"=>"RefValue",    "Name"=>"RefValue",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Referance value ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$labTestForm["FLD"][4]=array(
                                    "Id"=>"DefValue",    "Name"=>"Default Value",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Default value ",  "Ops"=>"",
                                    "valid"=>""
                                    );								
$labTestForm["FLD"][5]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Active or not",  "Ops"=>"",
                                    "valid"=>""
                                    );									
									
$labTestForm["FLD"][6]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$labTestForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$labTestForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////LABTEST FORM END			
  		
?>