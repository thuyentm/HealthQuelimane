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
	

$eventForm = array();
$eventForm["OBJID"] = "EVENTID";
$eventForm["TABLE"] = "event";
$eventForm["LIST"] = array( 'EVENTID','CONCEPTID', 'TERM');
$eventForm["DISPLAY_LIST"] = array( 'ID','CONCEPTID', 'TERM');
$eventForm["DISPLAY_WIDTH"] = array( '10%', '10%', '80%');
$eventForm["SORT"] = '"aaSorting": [[2, "asc"]],';
$eventForm["OPS"] =' fnShowHide( 0 )';
$eventForm["AUDIT_INFO"] = true;
$eventForm["NEXT"]  = "home.php?page=preferences&mod=event&=EVENTID=";	
//pager starts
$eventForm["CAPTION"]  = "Events";
$eventForm["ACTION"]  = "home.php?page=preferences&mod=eventNew&EVENTID=";
$eventForm["ROW_ID"]="EVENTID";
$eventForm["COLUMN_MODEL"] = array('EVENTID'=>array("width"=>"75px"));
$eventForm["ORIENT"] = "L";

//pager ends
$eventForm["FLD"][0]=array(
                                    "Id"=>"CONCEPTID", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $eventForm["FLD"][1]=array(
                                    "Id"=>"TERM",    "Name"=>"Term",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Term",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$eventForm["FLD"][2]=array(
                                    "Id"=>"DESCRIPTIONSTATUS",    "Name"=>"Status",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Status",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$eventForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$eventForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );  
$eventForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );  					
/////////////////////////EVENT	
?>