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



/////////////////////////VillageForm FORM//////              


$VillageForm = array();
$VillageForm["OBJID"] = "VGEID";
$VillageForm["TABLE"] = "village";
$VillageForm["LIST"] = array( 'VGEID', 'District','DSDivision', 'GNDivision','Code','Active');
$VillageForm["DISPLAY_LIST"] = array( 'VGEID', 'District','DSDivision', 'GNDivision','Code','Active');
$VillageForm["DISPLAY_WIDTH"] = array( '5%', '15%', '20%','20%','5%','5%');
$VillageForm["SORT"] = '"aaSorting": [[3, "asc"]],';
$VillageForm["OPS"] =' fnShowHide( 0 )';
$VillageForm["NEXT"]  = "home.php?page=preferences&mod=Village&VGEID=";	
//pager starts
$VillageForm["CAPTION"]  = "Villages";
$VillageForm["ACTION"]  = "home.php?page=preferences&mod=VillageNew&VGEID=";
$VillageForm["ROW_ID"]="VGEID";
$VillageForm["COLUMN_MODEL"] = array('VGEID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$VillageForm["ORIENT"] = "L";

//pager ends
$VillageForm["AUDIT_INFO"] = true;
$VillageForm["FLD"][0]=array(
                                    "Id"=>"District", "Name"=>"District","Type"=>"place",  "Value"=>"",
                                    "Help"=>"District", "Ops"=>"", "d"=>"", "ds"=>"", "Place"=>"District",
                                    "valid"=>"*"
                                    );
$VillageForm["FLD"][1]=array(
                                    "Id"=>"DSDivision", "Name"=>"DSDivision",    "Type"=>"place",
                                    "Value"=>"",     "Help"=>"DSDivision",   "Ops"=>"","d"=>"0", "ds"=>"", "Place"=>"DSDivision",
                                    "valid"=>"*"
                                    );
$VillageForm["FLD"][2]=array(
                                    "Id"=>"GNDivision", "Name"=>"GNDivision / Village",    "Type"=>"place",
                                    "Value"=>"",     "Help"=>"GNDivision / Village",   "Ops"=>"","d"=>"0", "ds"=>"1", "Place"=>"GNDivision",
                                    "valid"=>"*"
                                    );									
$VillageForm["FLD"][3]=array(
                                    "Id"=>"Code", "Name"=>"Code",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"9 letter Code", "Ops"=>"Village",
                                    "valid"=>""
                                    );  									
$VillageForm["FLD"][4]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"",  "Ops"=>"",
                                    "valid"=>""
                                    );
									
$VillageForm["FLD"][5]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$VillageForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
$VillageForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>