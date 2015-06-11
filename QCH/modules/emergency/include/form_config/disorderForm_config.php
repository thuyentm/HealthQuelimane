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

$disorderForm = array();
$disorderForm["OBJID"] = "DISORDERID";
$disorderForm["TABLE"] = "disorder";
$disorderForm["LIST"] = array( 'DISORDERID','CONCEPTID', 'TERM','Link_ICD_Code','Link_ICD_Text');
$disorderForm["DISPLAY_LIST"] = array( 'ID','CONCEPTID', 'TERM','ICD CODE','ICD TEXT');
$disorderForm["DISPLAY_WIDTH"] = array( '10%', '10%', '30%','5%','30%');
$disorderForm["SORT"] = '"aaSorting": [[2, "asc"]],';
$disorderForm["OPS"] =' fnShowHide( 0 ); fnShowHide( 1 );';
$disorderForm["AUDIT_INFO"] = true;
$disorderForm["NEXT"]  = "home.php?page=preferences&mod=disorder&=DISORDERID";	
//pager starts
$disorderForm["CAPTION"]  = "Disorder";
$disorderForm["ACTION"]  = "home.php?page=preferences&mod=disorderNew&DISORDERID=";
$disorderForm["ROW_ID"]="DISORDERID";
$disorderForm["COLUMN_MODEL"] = array('DISORDERID'=>array("width"=>"75px"));
$disorderForm["ORIENT"] = "L";

//pager ends
$disorderForm["FLD"][0]=array(
                                    "Id"=>"CONCEPTID", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $disorderForm["FLD"][1]=array(
                                    "Id"=>"TERM",    "Name"=>"Term",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Term",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$disorderForm["FLD"][2]=array(
                                    "Id"=>"DESCRIPTIONSTATUS",    "Name"=>"Status",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Status",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$disorderForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$disorderForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );  
$disorderForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );  					
/////////////////////////DISORDER	
?>