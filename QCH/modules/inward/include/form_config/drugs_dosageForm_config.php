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


$drugs_dosageForm = array();
$drugs_dosageForm["OBJID"] = "DDSGID";
$drugs_dosageForm["TABLE"] = "drugs_dosage";
$drugs_dosageForm["LIST"] = array( 'DDSGID', 'Dosage','Type', 'Factor','Active');
$drugs_dosageForm["DISPLAY_LIST"] = array( 'ID', 'Dosage', 'Type','Factor','Active');
$drugs_dosageForm["DISPLAY_WIDTH"] = array( '10%', '50%','205', '20%','10%');
$drugs_dosageForm["NEXT"]  = "home.php?page=preferences&mod=drugs_dosage&DDSGID=";	
$drugs_dosageForm["AUDIT_INFO"] = true;
//pager starts
$drugs_dosageForm["CAPTION"]  = "Drugs dosage";
$drugs_dosageForm["ACTION"]  = "home.php?page=preferences&mod=drugs_dosageNew&DDSGID=";
$drugs_dosageForm["ROW_ID"]="DDSGID";
$drugs_dosageForm["COLUMN_MODEL"] = array( 'DDSGID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$drugs_dosageForm["ORIENT"] = "P";

//pager ends
$drugs_dosageForm["FLD"][0]=array(
                                    "Id"=>"Dosage", "Name"=>"Dosage",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Dosage", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$drugs_dosageForm["FLD"][1]=array(
                                    "Id"=>"Type", "Name"=>"Type",    "Type"=>"select",
                                    "Value"=>array("Liquid","Tablets","Multidose","Other"),     "Help"=>"Liquid or Tablet",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$drugs_dosageForm["FLD"][2]=array(
                                    "Id"=>"Factor",    "Name"=>"Factor",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Multiply factor ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugs_dosageForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugs_dosageForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  $drugs_dosageForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
     $drugs_dosageForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>