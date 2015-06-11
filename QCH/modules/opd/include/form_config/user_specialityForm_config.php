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


$user_specialityForm = array();
$user_specialityForm["OBJID"] = "SPEC_ID";
$user_specialityForm["TABLE"] = "user_speciality";
$user_specialityForm["LIST"] = array( 'SPEC_ID', 'Name', 'Remarks','Active');
$user_specialityForm["DISPLAY_LIST"] = array( 'Id', 'Name', 'Remarks','Active');
$user_specialityForm["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','10%');
$user_specialityForm["NEXT"]  = "home.php?page=preferences&mod=user_speciality&SPEC_ID=";	
$user_specialityForm["AUDIT_INFO"] = true;
//pager starts
$user_specialityForm["CAPTION"]  = "Drugs";
$user_specialityForm["ACTION"]  = "home.php?page=preferences&mod=user_postNew&POST_ID=";
$user_specialityForm["ROW_ID"]="SPEC_ID";
$user_specialityForm["COLUMN_MODEL"] = array( 'SPEC_ID'=>array("width"=>"15px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$user_specialityForm["ORIENT"] = "L";

//pager ends
$user_specialityForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Speciality",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Speciality eg. Cardiologist,Gynecologist", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$user_specialityForm["FLD"][1]=array(
                                    "Id"=>"Remarks", "Name"=>"Remarks",    "Type"=>"remarks",
                                    "Value"=>"",     "Help"=>"Remarks",   "Ops"=>"OPD",
                                    "valid"=>""
                                    );
$user_specialityForm["FLD"][2]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"post avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );									
$user_specialityForm["FLD"][3]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$user_specialityForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$user_specialityForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>