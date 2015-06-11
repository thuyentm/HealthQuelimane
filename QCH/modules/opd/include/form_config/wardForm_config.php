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


  			
//ward
$wardForm = array();
$wardForm["OBJID"] = "WID";
$wardForm["TABLE"] = "ward";
$wardForm["LIST"] = array( 'WID','Name', 'Type','Telephone','BedCount','Remarks','Active');
$wardForm["DISPLAY_LIST"] = array( 'ID','Name', 'Type','Telephone','BedCount','Remarks','Active');
$wardForm["DISPLAY_WIDTH"] = array( '10%', '30%', '20%','10%','10%','15%','2%');
$wardForm["AUDIT_INFO"] = true;
$wardForm["NEXT"]  = "home.php?page=preferences&mod=ward&WID=";	
//pager starts
$wardForm["CAPTION"]  = "Wards";
$wardForm["ACTION"]  = "home.php?page=preferences&mod=wardNew&WID=";
$wardForm["ROW_ID"]="WID";
$wardForm["COLUMN_MODEL"] = array( 'WID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$wardForm["ORIENT"] = "L";

//pager ends
$wardForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Ward name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the ward", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $wardForm["FLD"][1]=array(
                                    "Id"=>"Type",    "Name"=>"Type of the ward",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Name",  "Ops"=>"",
                                    "valid"=>""
                                    );                                   
$wardForm["FLD"][2]=array(
                                    "Id"=>"Telephone",    "Name"=>"Telephone",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Telephone number ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$wardForm["FLD"][3]=array(
                                    "Id"=>"BedCount",    "Name"=>"Number of beds",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Number of beds in the ward ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$wardForm["FLD"][4]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Remarks",  "Ops"=>"",
                                    "valid"=>""
                                    );	
$wardForm["FLD"][5]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Ward active or not",  "Ops"=>"",
                                    "valid"=>""
                                    );										
$wardForm["FLD"][6]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  

$wardForm["BTN"][0]=array(
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
     $wardForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>