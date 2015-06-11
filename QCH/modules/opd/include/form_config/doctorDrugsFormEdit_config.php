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

$UID=$_SESSION["UID"];
$doctorDrugsFormEdit = array();
$doctorDrugsFormEdit["OBJID"] = "DDID";
$doctorDrugsFormEdit["TABLE"] = "Doctor_Drug";
$doctorDrugsFormEdit["LIST"] = array( 'DDID', 'Name', 'Type','dDosage','dFrequency','Stock','ClinicStock','Active');
$doctorDrugsFormEdit["DISPLAY_LIST"] = array( 'DDID', 'Drug Name', 'Type','Dosage','Frequency','Stock','Clinic Stock','Active');
$doctorDrugsFormEdit["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','10%');
$doctorDrugsFormEdit["NEXT"]  = "home.php?page=preferences&mydrugs&DDID=";	
$doctorDrugsFormEdit["AUDIT_INFO"] = true;
//pager starts
$doctorDrugsFormEdit["CAPTION"]  = "Doctor_Drug";
$doctorDrugsFormEdit["ACTION"]  = "home.php?page=preferences&mod=mydrugsNew&DRGID=";
$doctorDrugsFormEdit["ROW_ID"]="DDID";
$doctorDrugsFormEdit["COLUMN_MODEL"] = array( 'DDID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$doctorDrugsFormEdit["ORIENT"] = "L";
$ddid=$_GET['DDID'];

//echo $ddid;
//pager ends


$doctorDrugsFormEdit["FLD"][0]=array(
                                    "Id"=>"PRIORITY", "Name"=>"Add to Favourite",
                                    "Type"=>"selectdrugposition",  "Value"=>"",
                                    "Help"=>"Add to your favourite drug list", "Ops"=>"",
									"valid"=>"*"    
                                    
                                    );
									
$doctorDrugsFormEdit["FLD"][1]=array(
                                    "Id"=>"USRID",     "Name"=>"uid",    "Type"=>"hidden",     "Value"=>$UID,
                                    "Help"=>"", "Ops"=>""
                                    );								

         
$doctorDrugsFormEdit["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Update",   "Type"=>"button", "Value"=>"Update",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    ); 
$doctorDrugsFormEdit["BTN"][1]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Remove From List",   "Type"=>"button", "Value"=>"Remove From List",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"removedrug($ddid);",
                                    "Next"=>""
                                    ); 								
  
$doctorDrugsFormEdit["BTN"][2]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>