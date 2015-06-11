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


  
/*
  `TREATMENTID` int(11) NOT NULL AUTO_INCREMENT,
  `Treatment` varchar(500),
  `Remarks` varchar(1000),
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`TREATMENTID`)
*/

/////////////////////////treatment//////              


$treatmentForm = array();
$treatmentForm["OBJID"] = "TREATMENTID";
$treatmentForm["TABLE"] = "treatment";
$treatmentForm["LIST"] = array( 'TREATMENTID','Treatment', 'Type','Remarks','Active');
$treatmentForm["DISPLAY_LIST"] = array( 'ID','Treatment', 'Type','Remarks','Active');
$treatmentForm["AUDIT_INFO"] = true;
$treatmentForm["NEXT"]  = "home.php?page=preferences&mod=treatment&&TREATMENTID=";	
//pager starts
$treatmentForm["CAPTION"]  = "Treatments";
$treatmentForm["ACTION"]  = "home.php?page=preferences&mod=treatmentNew&TREATMENTID=";
$treatmentForm["ROW_ID"]="TREATMENTID";
$treatmentForm["COLUMN_MODEL"] = array( 'TREATMENTID'=>array("width"=>"75px"),'Active'=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$treatmentForm["ORIENT"] = "P";

//pager ends
$treatmentForm["FLD"][0]=array(
                                    "Id"=>"Treatment", "Name"=>"Treatment name",
                                    "Type"=>"textarea",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$treatmentForm["FLD"][1]=array(
								"Id"=>"Type",     "Name"=>"Treatment type",    "Type"=>"select",     "Value"=>array('OPD','Admission'),
								"Help"=>"Type of the treatment", "Ops"=>"","valid"=>"*"
								);  
$treatmentForm["FLD"][2]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);    
$treatmentForm["FLD"][3]=array(
								"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"Treatment active or not", "Ops"=>""
								);     								
							
$treatmentForm["FLD"][4]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$treatmentForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$treatmentForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////opd_treatment_entryForm		          
?>