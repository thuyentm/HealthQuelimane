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


$userMenuForm = array();
$userMenuForm["OBJID"] = "UMID";
$userMenuForm["TABLE"] = "user_menu";
$userMenuForm["LIST"] = array( 'UMID', 'Name', 'UserGroup','Link','MenuOrder','Active');
$userMenuForm["DISPLAY_LIST"] = array( 'UMID', 'Name', 'UserGroup','Link','MenuOrder','Active');
$userMenuForm["DISPLAY_WIDTH"] = array( '10%', '20%', '20%','10%','5%','5%');
$userMenuForm["NEXT"]  = "home.php?page=preferences&mod=Menu&UMID=";	
$userMenuForm["AUDIT_INFO"] = true;
//pager starts
$userMenuForm["CAPTION"]  = "User Menus";	
$userMenuForm["ACTION"]  = "home.php?page=preferences&mod=MenuNew&UMID=";	
$userMenuForm["ROW_ID"]  = "UMID";	
$userMenuForm["COLUMN_MODEL"]=array("UMID"=>array("width"=>"75px"),"MenuOrder"=>array("width"=>"75px"),"Active"=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$userMenuForm["ORIENT"] = "L";
//pager ends
$userMenuForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Menu name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Menu display  name", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$userMenuForm["FLD"][1]=array(
                                    "Id"=>"UserGroup", "Name"=>"User group",    "Type"=>"usergroup",
                                    "Value"=>"0",     "Help"=>"User group",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$userMenuForm["FLD"][2]=array(
                                    "Id"=>"Link",    "Name"=>"Link",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Link to follow when clicking ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$userMenuForm["FLD"][3]=array(
                                    "Id"=>"MenuOrder",    "Name"=>"Menu order",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Link to follow when clicking ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$userMenuForm["FLD"][4]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Menu active or not",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$userMenuForm["FLD"][5]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$userMenuForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$userMenuForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>