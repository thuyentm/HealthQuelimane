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

//canned_text
$CannedTextForm = array();
$CannedTextForm["OBJID"] = "CTEXTID";
$CannedTextForm["TABLE"] = "canned_text";
$CannedTextForm["LIST"] = array( 'CTEXTID','Code', 'Text','Remarks','Active');
$CannedTextForm["DISPLAY_LIST"] = array( 'CTEXTID','Code', 'Text','Remarks','Active');
$CannedTextForm["DISPLAY_WIDTH"] = array( '10%', '10%', '50%','30%','2%');
$CannedTextForm["AUDIT_INFO"] = true;
$CannedTextForm["NEXT"]  = "home.php?page=preferences&mod=CannedText&CTEXTID=";	
//pager starts
$CannedTextForm["CAPTION"]  = "Canned text";
$CannedTextForm["ACTION"]  = "home.php?page=preferences&mod=CannedTextNew&CTEXTID=";
$CannedTextForm["ROW_ID"]="CTEXTID";
$CannedTextForm["COLUMN_MODEL"] = array( 'CTEXTID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$CannedTextForm["ORIENT"] = "P";

//pager ends
$CannedTextForm["FLD"][0]=array(
                                    "Id"=>"Code", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code for the canned text", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $CannedTextForm["FLD"][1]=array(
                                    "Id"=>"Text",    "Name"=>"Text",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Canned text",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$CannedTextForm["FLD"][2]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$CannedTextForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Active or Not ",  "Ops"=>"",
                                    "valid"=>""
                                    );									
	$CannedTextForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  

$CannedTextForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  /*     $CannedTextForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $CannedTextForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>