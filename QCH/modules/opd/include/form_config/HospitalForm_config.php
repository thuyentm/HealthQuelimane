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

/////////////////////////HospitalForm FORM//////              


$HospitalForm = array();
$HospitalForm["OBJID"] = "HID";
$HospitalForm["TABLE"] = "hospital";
$HospitalForm["LIST"] = array( 'HID', 'Name','Code', 'Type','Address_Village','Active');
$HospitalForm["DISPLAY_LIST"] = array( 'HID', 'Name','Code', 'Type','Village','Active');
$HospitalForm["DISPLAY_WIDTH"] = array( '5%', '30%', '5%','10%','20%','5%');
$HospitalForm["NEXT"]  = "home.php?page=preferences&mod=Hospital&HID=";	
$HospitalForm["AUDIT_INFO"] = true;
$HospitalForm["LEFT"] = 200;
//pager starts
$HospitalForm["CAPTION"]  = "Hospital settings";	
$HospitalForm["ACTION"]  = "home.php?page=preferences&mod=HospitalNew&HID=";	
$HospitalForm["ROW_ID"]  = "HID";	
$HospitalForm["COLUMN_MODEL"]=array("HID"=>array("width"=>"75px"),"Active"=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$HospitalForm["ORIENT"] = "L";
//pager ends
$HospitalForm["FLD"]=array(	
	array("Id"=>"Name", "Name"=>"Hospital name","Type"=>"text",  "Value"=>"","Help"=>"Name of the Hospital", "Ops"=>"","valid"=>"*"),
	array("Id"=>"Code", "Name"=>"Code",    "Type"=>"text","Value"=>"0",     "Help"=>"Hospital Code BTTKTTMOH",   "Ops"=>"","valid"=>"*"),
	array("Id"=>"Current_BHT", "Name"=>"Running BHT No",    "Type"=>"text","Value"=>"0",     "Help"=>"Current running BHT No [YYYY]/[NNNN]/NNNN",   "Ops"=>"","valid"=>"*"),
	array("Id"=>"Type", "Name"=>"Type",    "Type"=>"text","Value"=>"0",     "Help"=>"Hospital type",   "Ops"=>"","valid"=>"*"),
	array("Id"=>"Type", "Name"=>"Type",    "Type"=>"text", "Value"=>"0",     "Help"=>"Hospital type",   "Ops"=>"","valid"=>"*"),
	array("Id"=>"Address_Village", "Name"=>"Address :Village",  "Type"=>"lookup","Value"=>"",   "Help"=>"eg. Navatkudah", "Ops"=>"Village","valid"=>"*"),
	array("Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool","Value"=>"",   "Help"=>"",  "Ops"=>"","valid"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"Address_DSDivision", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"Address_District", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"section",     "Value"=>"Prescription settings <i style='color:#b4c5cd;'>&nbsp;&nbsp;&nbsp;&nbsp;Please Log out and log in to see the effect!</i>",     "Help"=>"",   "Ops"=>""),       
	array( "Id"=>"Display_Drug_Count", "Name"=>"Display drug stock in prescription ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"", "valid"=>""),
	array("Id"=>"Display_Zero_Drug_Count", "Name"=>"Display drugs with zero stock in prescription ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"Dispense_Drug_Count", "Name"=>"Count drugs to be dispensed automatically ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"Display_Previous_Drug", "Name"=>"Display previous prescriptions ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"section",     "Value"=>"Patient registration settings <i style='color:#b4c5cd;'>&nbsp;&nbsp;&nbsp;&nbsp;Please Log out and log in to see the effect!</i>",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"Use_One_Field_Name", "Name"=>"Use only one field for 'Name' ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),	
	array("Id"=>"Use_Calendar_DOB", "Name"=>"Use calendar for 'Date of Birth' ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"Instant_Validation", "Name"=>"Enable instant validation ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"Number_NIC_Validation", "Name"=>"Use only number validation for NIC ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"section",     "Value"=>"Visit settings <i style='color:#b4c5cd;'>&nbsp;&nbsp;&nbsp;&nbsp;Please Log out and log in to see the effect!</i>",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"Visit_ICD_Field", "Name"=>"Add ICD field in visit ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"Visit_SNOMED_Field", "Name"=>"Add SNOMED field in visit ? ",  "Type"=>"bool","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"section",     "Value"=>"Report Settings <i style='color:#b4c5cd;'>&nbsp;&nbsp;&nbsp;&nbsp;Please Log out and log in to see the effect!</i>",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"Token_Footer_Text", "Name"=>"Token footer text ",  "Type"=>"text","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>""),
	array("Id"=>"_", "Name"=>"",   "Type"=>"section",     "Value"=>"License Information",     "Help"=>"",   "Ops"=>""),
	array("Id"=>"LIC_Info", "Name"=>"License Information",  "Type"=>"license","Value"=>"",   "Help"=>" ", "Ops"=>"","valid"=>"" )
	
							
);

//--------------
$HospitalForm["BTN"]=array(
						array(
                           "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                            "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                            "Next"=>""
                            ),
						array(
                           "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                           "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                           "Next"=>""
                            )
					);                                            
	
  		
?>