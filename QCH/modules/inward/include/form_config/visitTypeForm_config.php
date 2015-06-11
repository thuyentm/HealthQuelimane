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




/////////////////////////visit_type FORM//////              


$visitTypeForm = array();
$visitTypeForm["OBJID"] = "VTYPID";
$visitTypeForm["TABLE"] = "visit_type";
$visitTypeForm["LIST"] = array( 'VTYPID', 'Name', 'Remarks','Stock','Active');
$visitTypeForm["DISPLAY_LIST"] = array( 'ID', 'Name', 'Remarks','Pharmacy stock','Active');
$visitTypeForm["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','5%');
$visitTypeForm["NEXT"]  = "home.php?page=preferences&mod=visitType&VTYPID=";	
$visitTypeForm["AUDIT_INFO"] = true;
//pager starts
$visitTypeForm["CAPTION"]  = "Visit type";	
$visitTypeForm["ACTION"]  = "home.php?page=preferences&mod=visitTypeNew&VTYPID=";	
$visitTypeForm["ROW_ID"]  = "VTYPID";	
$visitTypeForm["COLUMN_MODEL"]=array("VTYPID"=>array("width"=>"75px"),"Active"=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
//pager ends
$visitTypeForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Type", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$visitTypeForm["FLD"][1]=array(
                                    "Id"=>"Stock", "Name"=>"Pharmacy stock",
                                    "Type"=>"select",  "Value"=>array("Stock","ClinicStock"),
                                    "Help"=>"What stock to be used", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$visitTypeForm["FLD"][2]=array(
                                    "Id"=>"Remarks", "Name"=>"Remarks",    "Type"=>"textarea",
                                    "Value"=>"",     "Help"=>"Remarks",   "Ops"=>"",
                                    "valid"=>""
                                    );
$visitTypeForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Active or not",  "Ops"=>"",
                                    "valid"=>""
                                    );									
									
$visitTypeForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$visitTypeForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$visitTypeForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////LABTEST FORM END			
  		
?>