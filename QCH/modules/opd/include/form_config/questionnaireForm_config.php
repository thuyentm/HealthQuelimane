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

 */
  			
//quest_structForm
$questionnaireForm = array();
$questionnaireForm["OBJID"] = "QUES_ID";
$questionnaireForm["TABLE"] = "questionnaire";
$questionnaireForm["LIST"] = array( 'QUES_ID','QUES_ST_ID', 'Type','OBID','Date','Active');
$questionnaireForm["AUDIT_INFO"] = true;
$questionnaireForm["NEXT"]  = "home.php?page=preferences&mod=quest_struct&A=";
//pager starts
$questionnaireForm["CAPTION"]  = "Questionnaires";
$questionnaireForm["ACTION"]  = "home.php?page=preferences&mod=quest_structNew&QUES_ST_ID=";
$questionnaireForm["ROW_ID"]="QUES_ID";
$questionnaireForm["COLUMN_MODEL"] = array( 'QUES_ID'=>array("width"=>"75px"));
$questionnaireForm["ORIENT"] = "L";

//pager ends

$questionnaireForm["FLD"][0]=array(
                                    "Id"=>"QUES_ST_ID", "Name"=>"Field Name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the field", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$questionnaireForm["FLD"][1]=array(
                                    "Id"=>"Type",    "Name"=>"Type of the Field",  "Type"=>"select",
                                    "Value"=>array("text","number","select","remarks","date","yes-no"),   "Help"=>"Type of the field",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$questionnaireForm["FLD"][2]=array(
                                    "Id"=>"OBID",    "Name"=>"Possible values",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Possible Values",  "Ops"=>"",
                                    "valid"=>""
                                    );
$questionnaireForm["FLD"][3]=array(
                                    "Id"=>"Date",    "Name"=>"Default value",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Default value",  "Ops"=>"",
                                    "valid"=>""
                                    );

$questionnaireForm["FLD"][4]=array(
				"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
				"Help"=>"Questionnaire active or not", "Ops"=>""
				);     		
	$questionnaireForm["FLD"][5]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $questionnaireForm["FLD"][6]=array(
                                    "Id"=>"QUES_ST_ID",     "Name"=>"",    "Type"=>"hidden",     "Value"=>$_GET["QUES_ST_ID"],
                                    "Help"=>"", "Ops"=>"",valid=>"*"
                                    );  
  ///////ICD FORM END		
?>