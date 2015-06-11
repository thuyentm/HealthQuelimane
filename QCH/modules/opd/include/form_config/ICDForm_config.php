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


$ICDForm = array();
$ICDForm["OBJID"] = "ICDID";
$ICDForm["TABLE"] = "icd10";
$ICDForm["LIST"] = array( 'ICDID','Code', 'Name','isNotify','Remarks');
$ICDForm["DISPLAY_LIST"] = array( 'ICDID','ICD Code', 'ICD Name','isNotify','Remarks');
$ICDForm["AUDIT_INFO"] = true;
$ICDForm["NEXT"]  = "home.php?page=preferences&mod=Icd&ICDID=";	
//pager starts
$ICDForm["CAPTION"]  = "ICD 10";
$ICDForm["ACTION"]  = "home.php?page=preferences&mod=IcdNew&ICDID=";
$ICDForm["ROW_ID"]="ICDID";
$ICDForm["COLUMN_MODEL"] = array('ICDID'=>array("width"=>"75px"),'isNotify'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$ICDForm["ORIENT"] = "L";

//pager ends
$ICDForm["FLD"][0]=array(
                                    "Id"=>"Code", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"ICD Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $ICDForm["FLD"][1]=array(
                                    "Id"=>"Name",    "Name"=>"Name",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Name",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$ICDForm["FLD"][2]=array(
                                    "Id"=>"isNotify", "Name"=>"is Notifiable",    "Type"=>"bool",
                                    "Value"=>"",     "Help"=>"is this ICD notifiable",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$ICDForm["FLD"][3]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks ",  "Ops"=>"",
                                    "valid"=>""
                                    );
	$ICDForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  
  /*
$ICDForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
     $ICDForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $ICDForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>