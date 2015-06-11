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



/////////////////////////labTestGroupForm//////              


$labTestGroupForm = array();
$labTestGroupForm["OBJID"] = "LABGRPTID";
$labTestGroupForm["TABLE"] = "lab_test_group";
$labTestGroupForm["LIST"] = array( 'LABGRPTID', 'Name','Active');
$labTestGroupForm["DISPLAY_LIST"] = array( 'LABGRPTID', 'Name','Active');
$labTestGroupForm["DISPLAY_WIDTH"] = array( '10%', '50%', '10%');
$labTestGroupForm["NEXT"]  = "home.php?page=preferences&mod=labTestGroup&";	
$labTestGroupForm["AUDIT_INFO"] = true;
//pager starts
$labTestGroupForm["CAPTION"]  = "Lab test groups";
$labTestGroupForm["ACTION"]  = "home.php?page=preferences&mod=labTestGroupNew&LABGRPTID=";
$labTestGroupForm["ROW_ID"]="LABGRPTID";
$labTestGroupForm["COLUMN_MODEL"] = array( 'LABGRPTID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$labTestGroupForm["ORIENT"] = "P";

//pager ends
$labTestGroupForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Lab test group name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"User Group name", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$labTestGroupForm["FLD"][1]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Lab test group active or not",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$labTestGroupForm["FLD"][2]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$labTestGroupForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$labTestGroupForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>