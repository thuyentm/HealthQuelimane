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


  			
//permission
$permissionForm = array();
$permissionForm["OBJID"] = "PRMID";
$permissionForm["TABLE"] = "permission";
$permissionForm["LIST"] = array( 'PRMID','UserGroup', 'Remarks');
$permissionForm["DISPLAY_LIST"] = array( 'ID','UserGroup', 'Remarks');
$permissionForm["DISPLAY_WIDTH"] = array( '10%', '50%', '25%');
$permissionForm["AUDIT_INFO"] = true;
$permissionForm["NEXT"]  = "home.php?page=preferences&mod=Permission&PRMID=";
//pager starts
$permissionForm["CAPTION"]  = "Group Permissions";	
$permissionForm["ACTION"]  = "home.php?page=preferences&mod=permissionNew&PRMID=";	
$permissionForm["ROW_ID"]  = "PRMID";	
$permissionForm["COLUMN_MODEL"]=array("PRMID"=>array("width"=>"15px"));
//pager ends

if ($_GET["PRMID"] > 0){
	$permissionForm["FLD"][0]=array(
										"Id"=>"UserGroup", "Name"=>"User Group",
										"Type"=>"label",  "Value"=>"",
										"Help"=>"User Group", "Ops"=>"",
										"valid"=>"*"
										);

}
else{
	$permissionForm["FLD"][0]=array(
										"Id"=>"UserGroup", "Name"=>"User Group",
										"Type"=>"select_usergroup",  "Value"=>"",
										"Help"=>"User Group", "Ops"=>"",
										"valid"=>"*"
										);
}									
 $permissionForm["FLD"][1]=array(
                                    "Id"=>"UserAccess",    "Name"=>"Permission",  "Type"=>"permission",
                                    "Value"=>"",   "Help"=>"Modules and permission",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$permissionForm["FLD"][2]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks ",  "Ops"=>"",
                                    "valid"=>""
                                    );
	$permissionForm["FLD"][3]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  

$permissionForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  /*     $permissionForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $permissionForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>