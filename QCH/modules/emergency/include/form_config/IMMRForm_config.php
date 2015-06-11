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

  			

$IMMRForm = array();
$IMMRForm["OBJID"] = "IMMRID";
$IMMRForm["TABLE"] = "immr";

$IMMRForm["LIST"] = array( 'IMMRID','Code', 'Name','Category','ICDCODE');
$IMMRForm["DISPLAY_LIST"] = array( 'IMMRID','IMMR Code', 'IMMR Name','Category','ICDCODE');
$IMMRForm["AUDIT_INFO"] = true;
$IMMRForm["NEXT"]  = "home.php?page=preferences&mod=Immr&IMMRID=";	
//pager starts
$IMMRForm["CAPTION"]  = "IMMR";
$IMMRForm["ACTION"]  = "home.php?page=preferences&mod=ImmrNew&IMMRID=";
$IMMRForm["ROW_ID"]="IMMRID";
$IMMRForm["COLUMN_MODEL"] = array('IMMRID'=>array("width"=>"75px"));
$IMMRForm["ORIENT"] = "L";

//pager ends
$IMMRForm["FLD"][0]=array(
                                    "Id"=>"Code", "Name"=>"* Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"IMMR Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$IMMRForm["FLD"][1]=array(
                                    "Id"=>"Name",    "Name"=>"Name",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Name",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$IMMRForm["FLD"][2]=array(
                                    "Id"=>"Category", "Name"=>"Category",    "Type"=>"textarea",
                                    "Value"=>"",     "Help"=>"Category",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$IMMRForm["FLD"][3]=array(
                                    "Id"=>"ICDCODE",    "Name"=>"ICDCODE",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"ICDCODE",  "Ops"=>"",
                                    "valid"=>""
                                    );
$IMMRForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
  
  
$IMMRForm["BTN"][0]=array(
                                  "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                   "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                   "Next"=>""
                                   );                                            
  
$IMMRForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>