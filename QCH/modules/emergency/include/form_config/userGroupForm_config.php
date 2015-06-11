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



/////////////////////////DRUGS FORM//////              


$userGroupForm = array();
$userGroupForm["OBJID"] = "UGID";
$userGroupForm["TABLE"] = "user_group";
$userGroupForm["LIST"] = array( 'UGID', 'Name','MainMenu','Scan_Redirect','Active');
$userGroupForm["DISPLAY_LIST"] = array( 'ID', 'Name','Home page','Redirect page','Active');
$userGroupForm["DISPLAY_WIDTH"] = array( '10%', '50%','20%','20%', '10%');
$userGroupForm["NEXT"]  = "home.php?page=preferences&mod=userGroup&UGID=";	
$userGroupForm["AUDIT_INFO"] = true;
//pager starts
$userGroupForm["CAPTION"]  = "User Group";	
$userGroupForm["ACTION"]  = "home.php?page=preferences&mod=userGroupNew&UGID=";	
$userGroupForm["ROW_ID"]  = "UGID";	
$userGroupForm["COLUMN_MODEL"]=array("UGID"=>array("width"=>"75px"),"Active"=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
//pager ends
$userGroupForm["FLD"]=array(array(
                                    "Id"=>"Name", "Name"=>"User group",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"User Group name", "Ops"=>"",
                                    "valid"=>"*"
                                    ),
                            array(
                                    "Id"=>"MainMenu",    "Name"=>"Home Page",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Default page when login",  "Ops"=>"",
                                    "valid"=>"*"
                                    ),
                            array(
                                    "Id"=>"Scan_Redirect",    "Name"=>"Scan redirect page",  "Type"=>"select",
                                   "Value"=>array("Patient Overview","Labtests","Prescriptions","Treatments"),  "Help"=>"Redirect page when patient slip scanned",  "Ops"=>"",
                                    "valid"=>"*"
                                    ),    
                           array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Menu active or not",  "Ops"=>"",
                                    "valid"=>""
                                    ),
                            array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"User group active or not",  "Ops"=>"",
                                    "valid"=>"*"
                                    ),
                           
        );

$userGroupForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$userGroupForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>