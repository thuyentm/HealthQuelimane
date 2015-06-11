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


  			
//quest_structForm
$quest_structForm = array();
$quest_structForm["OBJID"] = "QUES_ST_ID";
$quest_structForm["TABLE"] = "quest_struct";
$quest_structForm["LIST"] = array( 'QUES_ST_ID','Name', 'Type','Remarks','Active');
$quest_structForm["DISPLAY_LIST"] = array( 'ID','Name', 'Type','Remarks','Active');
$quest_structForm["AUDIT_INFO"] = true;
$quest_structForm["NEXT"]  = "home.php?page=preferences&mod=quest_struct&A=";
//pager starts
$quest_structForm["CAPTION"]  = "Questionnaires";
$quest_structForm["ACTION"]  = "home.php?page=preferences&mod=quest_structNew&QUES_ST_ID=";
$quest_structForm["ROW_ID"]="QUES_ST_ID";
$quest_structForm["COLUMN_MODEL"] = array( 'QUES_ST_ID'=>array("width"=>"75px"));
$quest_structForm["ORIENT"] = "L";

//pager ends

$quest_structForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the questionnaire", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$quest_structForm["FLD"][1]=array(
                                    "Id"=>"VisitType",    "Name"=>"Related to",  "Type"=>"visit_type",
                                    "Value"=>"",   "Help"=>"Questionnaire related to",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$quest_structForm["FLD"][2]=array(
                                    "Id"=>"Type",    "Name"=>"Type",  "Type"=>"select",
                                    "Value"=>array("patient","opd_visit","admission"),   "Help"=>"Type of the Questionnaire",  "Ops"=>"",
                                    "valid"=>"*"
                                    );

$quest_structForm["FLD"][3]=array(
                                    "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"textarea",
                                    "Value"=>"",   "Help"=>"Any remarks",  "Ops"=>"",
                                    "valid"=>""
                                    );

$quest_structForm["FLD"][4]=array(
				"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
				"Help"=>"Questionnaire active or not", "Ops"=>""
				);     		
	$quest_structForm["FLD"][5]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $quest_structForm["FLD"][6]=array(
                                    "Id"=>"QUES_ST_ID",     "Name"=>"QUES_ST_ID",    "Type"=>"hidden",     "Value"=>$_GET["QUES_ST_ID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
  
$quest_structForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
/*     $patient_historyForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $quest_structForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
     $quest_structForm["BTN"][2]=array(
                                   "Id"=>"AddBtn",    "Name"=>"Add Question", "Type"=>"button",  "Value"=>"Add Question", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"addFields(".$_GET["QUES_ST_ID"].") ",
                                   "Next"=>""
                                    );   
          $quest_structForm["BTN"][3]=array(
                                   "Id"=>"AddBtn",    "Name"=>"Add Question", "Type"=>"button",  "Value"=>"Preview", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"previewQuestionnaire(".$_GET["QUES_ST_ID"].") ",
                                   "Next"=>""
                                    );   
/////////////////////////ICD FORM END		
?>