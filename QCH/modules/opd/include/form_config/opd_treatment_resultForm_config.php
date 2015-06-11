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
CREATE TABLE IF NOT EXISTS `opd_treatment` (
  `OPDTREATMENTID` int(11) NOT NULL AUTO_INCREMENT,
  `Treatment` varchar(500),
  `Status` varchar(1000),
  `Remarks` varchar(1000),
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`OPDTREATMENTID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
*/

/////////////////////////opd_treatment//////              


$opd_treatment_resultForm = array();
$opd_treatment_resultForm["OBJID"] = "OPDTREATMENTID";
$opd_treatment_resultForm["TABLE"] = "opd_treatment";
$opd_treatment_resultForm["LIST"] = array( 'OPDTREATMENTID','CreateDate','Treatment', 'Status');
$opd_treatment_resultForm["DISPLAY_LIST"] = array( 'ID','Date','Treatment', 'Status');
$opd_treatment_resultForm["AUDIT_INFO"] = true;
$opd_treatment_resultForm["NEXT"]  = "home.php?page=opd&action=View&PID=".$_GET["PID"]."&OPDID=".$_GET["OPDID"]."&OPDTREATMENTID=";	

$opd_treatment_resultForm["FLD"][0]=array(
                                    "Id"=>"Treatment", "Name"=>"Treatment",
                                    "Type"=>"opd_treatment",  "Value"=>"",
                                    "Help"=>"", "Ops"=>" disabled ",
                                    "valid"=>"*"
                                    );
$opd_treatment_resultForm["FLD"][1]=array(
                                    "Id"=>"Status",    "Name"=>"Status",  "Type"=>"select",
                                    "Value"=>array('Done','Pending'),   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );

$opd_treatment_resultForm["FLD"][2]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);    
   								
$opd_treatment_resultForm["FLD"][3]=array(
								"Id"=>"OPDID",     "Name"=>"OPDID",    "Type"=>"hidden",     "Value"=>$_GET["OPDID"],
								"Help"=>"", "Ops"=>"","valid"=>"*"
								);  									
							
$opd_treatment_resultForm["FLD"][4]=array(
								"Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
								);          

  
$opd_treatment_resultForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$opd_treatment_resultForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////opd_treatment_entryForm		          
?>