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


  			

$proceduresForm = array();
$proceduresForm["OBJID"] = "PROCEDUREID";
$proceduresForm["TABLE"] = "procedures";
$proceduresForm["LIST"] = array( 'PROCEDUREID','CONCEPTID', 'TERM');
$proceduresForm["DISPLAY_LIST"] = array( 'ID','CONCEPTID', 'TERM');
$proceduresForm["DISPLAY_WIDTH"] = array( '10%', '10%', '80%');
$proceduresForm["SORT"] = '"aaSorting": [[2, "asc"]],';
$proceduresForm["OPS"] =' fnShowHide( 0 )';
$proceduresForm["AUDIT_INFO"] = true;
$proceduresForm["NEXT"]  = "home.php?page=preferences&mod=procedures&=PROCEDUREID";
//pager starts
$proceduresForm["CAPTION"]  = "Procedures";
$proceduresForm["ACTION"]  = "home.php?page=preferences&mod=proceduresNew&PROCEDUREID=";
$proceduresForm["ROW_ID"]="PROCEDUREID";
$proceduresForm["COLUMN_MODEL"] = array('PROCEDUREID'=>array("width"=>"75px"));
$proceduresForm["ORIENT"] = "L";

//pager ends
$proceduresForm["FLD"][0]=array(
                                    "Id"=>"CONCEPTID", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $proceduresForm["FLD"][1]=array(
                                    "Id"=>"TERM",    "Name"=>"Term",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Term",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$proceduresForm["FLD"][2]=array(
                                    "Id"=>"DESCRIPTIONSTATUS",    "Name"=>"Status",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Status",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$proceduresForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$proceduresForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );  
$proceduresForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );  					
/////////////////////////PROCEDURE	
?>