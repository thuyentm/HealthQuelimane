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


$SNOMEDForm = array();
$SNOMEDForm["OBJID"] = "SNOMEDID";
$SNOMEDForm["TABLE"] = "snomed";

$SNOMEDForm["LIST"] = array( 'SNOMEDID','CONCEPTID', 'TERM');
$SNOMEDForm["DISPLAY_LIST"] = array( 'SNOMEDID','CONCEPTID', 'TERM');
$SNOMEDForm["DISPLAY_WIDTH"] = array( '10%', '10%', '80%');
$SNOMEDForm["AUDIT_INFO"] = true;
$SNOMEDForm["NEXT"]  = "home.php?page=preferences&mod=Snomed&=SNOMEDID";	
$SNOMEDForm["FLD"][0]=array(
                                    "Id"=>"CONCEPTID", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $SNOMEDForm["FLD"][1]=array(
                                    "Id"=>"TERM",    "Name"=>"Term",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Term",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$SNOMEDForm["FLD"][2]=array(
                                    "Id"=>"DESCRIPTIONSTATUS",    "Name"=>"Status",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Status",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$SNOMEDForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$SNOMEDForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );  
$SNOMEDForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );  					
/////////////////////////SNOMED FORM END		
?>