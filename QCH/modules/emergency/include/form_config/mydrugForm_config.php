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



/////////////////////////DRUGS FORM//////////////////////////////////////////////              


$mydrugForm = array();
$mydrugForm["OBJID"] = "DDID";
//$mydrugForm["TABLE"] = "drugs";
//$mydrugForm["LIST"] = array( 'DRGID', 'Name', 'Type','dDosage','dFrequency','Stock','ClinicStock','Active');
$mydrugForm["DISPLAY_LIST"] = array( 'DDID','DRGID', 'Drug Name','Default Frequency','Default Dosage','Stock');
$mydrugForm["DISPLAY_WIDTH"] = array( '10%', '50%', '20%','10%');
$mydrugForm["NEXT"]  = "home.php?page=preferences&mod=Drugs&DDID=";	
$mydrugForm["AUDIT_INFO"] = true;
//pager starts
$mydrugForm["CAPTION"]  = "My Drugs List";
//$mydrugForm["ACTION"]  = "home.php?page=preferences&mod=mydrugsNew&DRGID=";
$mydrugForm["ROW_ID"]="DDID";
//$mydrugForm["COLUMN_MODEL"] = array( 'DRGID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$mydrugForm["ORIENT"] = "L";

//pager ends
$doctorDrugsForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Drug name",
                                    "Type"=>"selectdrug",  "Value"=>"",
                                    "Help"=>"Drug name", "Ops"=>"",
                                    "valid"=>"*"
                                    );

         
$doctorDrugsForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$doctorDrugsForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>