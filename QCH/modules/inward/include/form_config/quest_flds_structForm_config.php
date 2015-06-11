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
 *   `QUES_FLD_ST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUES_ST_ID` int(11),
  `Field` varchar(200),
  `Type` varchar(100),
  `PValue` varchar(1000),
  `DValue` varchar(100),
  `Help` varchar(2000),
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QUES_FLD_ST_ID`)
 */
  			
//quest_structForm
$quest_flds_structForm = array();
$quest_flds_structForm["OBJID"] = "QUES_FLD_ST_ID";
$quest_flds_structForm["TABLE"] = "quest_flds_struct";
$quest_flds_structForm["LIST"] = array( 'QUES_FLD_ST_ID','Name', 'Type','PValue','DValue','Active');
$quest_flds_structForm["DISPLAY_LIST"] = array( 'ID','Name', 'Type','Possible Value','Default Value','Active');
$quest_flds_structForm["AUDIT_INFO"] = true;
$quest_flds_structForm["NEXT"]  = "home.php?page=preferences&mod=quest_struct&A=";	

$quest_flds_structForm["FLD"][0]=array(
                                    "Id"=>"Field", "Name"=>"Field Name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the field", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$quest_flds_structForm["FLD"][1]=array(
                                    "Id"=>"Type",    "Name"=>"Type of the Field",  "Type"=>"select",
                                    "Value"=>array("text","number","select","remarks","date","yes-no"),   "Help"=>"Type of the field",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$quest_flds_structForm["FLD"][2]=array(
                                    "Id"=>"PValue",    "Name"=>"Possible values",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Possible Values",  "Ops"=>"",
                                    "valid"=>""
                                    );
$quest_flds_structForm["FLD"][3]=array(
                                    "Id"=>"DValue",    "Name"=>"Default value",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Default value",  "Ops"=>"",
                                    "valid"=>""
                                    );

$quest_flds_structForm["FLD"][4]=array(
				"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
				"Help"=>"Questionnaire active or not", "Ops"=>""
				);     		
	$quest_flds_structForm["FLD"][5]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $quest_flds_structForm["FLD"][6]=array(
                                    "Id"=>"QUES_ST_ID",     "Name"=>"",    "Type"=>"hidden",     "Value"=>$_GET["QUES_ST_ID"],
                                    "Help"=>"", "Ops"=>"",valid=>"*"
                                    );  
  
$quest_flds_structForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
									
     $quest_flds_structForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
      
/////////////////////////ICD FORM END		
?>