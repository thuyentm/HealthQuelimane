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


$drugsForm = array();
$drugsForm["OBJID"] = "DRGID";
$drugsForm["TABLE"] = "drugs";
$drugsForm["LIST"] = array( 'DRGID', 'Name', 'Type','dDosage','dFrequency','Stock','ClinicStock','Active');
$drugsForm["DISPLAY_LIST"] = array( 'DRGID', 'Drug Name', 'Type','Dosage','Frequency','Stock','Clinic Stock','Active');
$drugsForm["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','10%');
$drugsForm["NEXT"]  = "home.php?page=preferences&mod=Drugs&DRGID=";	
$drugsForm["AUDIT_INFO"] = true;
//pager starts
$drugsForm["CAPTION"]  = "Drugs";
$drugsForm["ACTION"]  = "home.php?page=preferences&mod=drugsNew&DRGID=";
$drugsForm["ROW_ID"]="DRGID";
$drugsForm["COLUMN_MODEL"] = array( 'DRGID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$drugsForm["ORIENT"] = "L";

//pager ends
$drugsForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Drug name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Drug name", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$drugsForm["FLD"][1]=array(
                                    "Id"=>"Stock", "Name"=>"OPD Stock",    "Type"=>"stock",
                                    "Value"=>"0",     "Help"=>"Stock",   "Ops"=>"OPD",
                                    "valid"=>"*"
                                    );
$drugsForm["FLD"][2]=array(
                                    "Id"=>"ClinicStock", "Name"=>"Clinic Stock",    "Type"=>"stock",
                                    "Value"=>"0",     "Help"=>"Stock",   "Ops"=>"Clinic",
                                    "valid"=>"*"
                                    );
$drugsForm["FLD"][3]=array(
                                    "Id"=>"Type", "Name"=>"Drug type",    "Type"=>"select",
                                    "Value"=>array("Tablet","Liquid","Multidose","Other"),     "Help"=>"Stock",   "Ops"=>"",
                                    "valid"=>""
                                    );
$drugsForm["FLD"][4]=array(
                                    "Id"=>"dDosage", "Name"=>"Defailt dosage",    "Type"=>"dosage",
                                    "Value"=>"",     "Help"=>"Stock",   "Ops"=>"",
                                    "valid"=>""
                                    );
$drugsForm["FLD"][5]=array(
                                    "Id"=>"dFrequency", "Name"=>"Default frequency",    "Type"=>"frequency",
                                    "Value"=>"",     "Help"=>"Stock",   "Ops"=>"",
                                    "valid"=>""
                                    );

$drugsForm["FLD"][6]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugsForm["FLD"][7]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$drugsForm["FLD"][8]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$drugsForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$drugsForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>