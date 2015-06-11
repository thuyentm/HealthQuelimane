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
	

$findingForm = array();
$findingForm["OBJID"] = "FINDID";
$findingForm["TABLE"] = "finding";
$findingForm["LIST"] = array( 'FINDID','CONCEPTID', 'TERM');
$findingForm["DISPLAY_LIST"] = array( 'ID','CONCEPTID', 'TERM');
$findingForm["SORT"] = '"aaSorting": [[2, "asc"]],';
$findingForm["OPS"] =' fnShowHide( 0 )';
                    
$findingForm["DISPLAY_WIDTH"] = array( '0%', '10%', '80%');
$findingForm["AUDIT_INFO"] = true;
$findingForm["NEXT"]  = "home.php?page=preferences&mod=Finding#3";
//pager starts
$findingForm["CAPTION"]  = "Findings";
$findingForm["ACTION"]  = "home.php?page=preferences&mod=findingNew&FINDID=";
$findingForm["ROW_ID"]="FINDID";
$findingForm["COLUMN_MODEL"] = array('FINDID'=>array("width"=>"75px"));
$findingForm["ORIENT"] = "L";

//pager ends
$findingForm["FLD"][0]=array(
                                    "Id"=>"CONCEPTID", "Name"=>"Code",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Code", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $findingForm["FLD"][1]=array(
                                    "Id"=>"TERM",    "Name"=>"Term",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Term",  "Ops"=>"",
                                    "valid"=>"*"
                                    );                                   
$findingForm["FLD"][2]=array(
                                    "Id"=>"DESCRIPTIONSTATUS",    "Name"=>"Status",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Status",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$findingForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Drug avtive or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$findingForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );  
$findingForm["BTN"][0]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   
/////////////////////////FINDID FORM END		
?>