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


  			


/////////////////////////COMPLAINT FORM//////              


$complaintForm = array();
$complaintForm["OBJID"] = "COMPID";
$complaintForm["TABLE"] = "complaints";
$complaintForm["LIST"] = array( 'COMPID', 'Name', 'Type','isNotify','ICDLink','Remarks');
$complaintForm["DISPLAY_LIST"] = array( 'COMPID', 'Name', 'Type','isNotify','ICDLink','Remarks');
$complaintForm["AUDIT_INFO"] = true;
$complaintForm["NEXT"]  = "home.php?page=preferences&mod=Complaints&COMPID=";	
//pager starts
$complaintForm["CAPTION"]  = "Complaints";
$complaintForm["ACTION"]  = "home.php?page=preferences&mod=ComplaintsNew&COMPID=";
$complaintForm["ROW_ID"]="COMPID";
$complaintForm["COLUMN_MODEL"] = array('COMPID'=>array("width"=>"75px"),'isNotify'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$complaintForm["ORIENT"] = "L";

//pager ends
$complaintForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Complaint",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Complaint name", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$complaintForm["FLD"][1]=array(
                                    "Id"=>"Type",    "Name"=>"Type",  "Type"=>"select",
                                    "Value"=>array("Cause","Diagnosis","Findings","Procedure","Symptom","Vague"),   "Help"=>"Complaint type",  "Ops"=>"",
                                    "valid"=>""
                               );                                   
$complaintForm["FLD"][2]=array(
                                    "Id"=>"ICDLink", "Name"=>"ICD Link",    "Type"=>"icd_text",
                                    "Value"=>"",     "Help"=>"ICD link",   "Ops"=>"",
                                    "valid"=>""
                                    );
									
									
$complaintForm["FLD"][3]=array(
                                    "Id"=>"isNotify", "Name"=>"is Notifiable",    "Type"=>"bool",
                                    "Value"=>"",     "Help"=>"is this complaint notifiable",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$complaintForm["FLD"][4]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$complaintForm["FLD"][5]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Record active or not",  "Ops"=>"",
                                    "valid"=>""
                                    );
									
$complaintForm["FLD"][6]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  
  
$complaintForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
$complaintForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );      
$complaintForm["BTN"][2]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   	


/////////////////////////////
?>