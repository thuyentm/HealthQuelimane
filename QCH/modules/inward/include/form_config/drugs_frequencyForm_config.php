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


$drugs_frequencyForm = array();
$drugs_frequencyForm["OBJID"] = "DFQYID";
$drugs_frequencyForm["TABLE"] = "drugs_frequency";
$drugs_frequencyForm["LIST"] = array( 'DFQYID', 'Frequency', 'Factor','Active');
$drugs_frequencyForm["DISPLAY_LIST"] = array( 'ID', 'Frequency','Factor','Active');
$drugs_frequencyForm["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','10%');
$drugs_frequencyForm["NEXT"]  = "home.php?page=preferences&mod=drugs_frequency&DFQYID=";	
$drugs_frequencyForm["AUDIT_INFO"] = true;
//pager starts
$drugs_frequencyForm["CAPTION"]  = "Drugs frequency";
$drugs_frequencyForm["ACTION"]  = "home.php?page=preferences&mod=drugs_frequencyNew&DFQYID=";
$drugs_frequencyForm["ROW_ID"]="DFQYID";
$drugs_frequencyForm["COLUMN_MODEL"] = array( 'DFQYID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$drugs_frequencyForm["ORIENT"] = "P";

//pager ends
$drugs_frequencyForm["FLD"][0]=array(
                                    "Id"=>"Frequency", "Name"=>"Frequency",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Frequency", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$drugs_frequencyForm["FLD"][1]=array(
                                    "Id"=>"Factor",    "Name"=>"Factor",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Multiply factor ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugs_frequencyForm["FLD"][2]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugs_frequencyForm["FLD"][3]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  $drugs_frequencyForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
     $drugs_frequencyForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>