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

/////////////////////////institutionForm FORM//////              


$institutionForm = array();
$institutionForm["OBJID"] = "INSTID";
$institutionForm["TABLE"] = "institution";
$institutionForm["LIST"] = array( 'INSTID', 'Name', 'Type','Email1','Telephone1','Address_Village','Active');
$institutionForm["DISPLAY_LIST"] = array( 'Id', 'Name', 'Type','E mail',' Telephone','Village','Active');
$institutionForm["DISPLAY_WIDTH"] = array( '5%', '20%', '5%','10%','10%','10%','20%','5%');
$institutionForm["NEXT"]  = "home.php?page=preferences&mod=institution&INSTID=";	
$institutionForm["AUDIT_INFO"] = true;
//pager starts
$institutionForm["CAPTION"]  = "Institutes";	
$institutionForm["ACTION"]  = "home.php?page=preferences&mod=institutionNew&INSTID=";	
$institutionForm["ROW_ID"]  = "INSTID";	
$institutionForm["COLUMN_MODEL"]=array("INSTID"=>array("width"=>"75px"),"Active"=>  array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),"searchoptions" => array("defaultValue"=>'')));
$institutionForm["ORIENT"] = "L";
//pager ends
$institutionForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Institution name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the Institution", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$institutionForm["FLD"][1]=array(
                                    "Id"=>"Code", "Name"=>"Code",    "Type"=>"text",
                                    "Value"=>"0",     "Help"=>"institution Code if any",   "Ops"=>"",
                                    "valid"=>""
                                    );
$institutionForm["FLD"][2]=array(
                                    "Id"=>"Type", "Name"=>"Type", "Type"=>"select",  "Value"=>array("Hospital","MOH","RDHS","DPDHS","Other"),
                                       "Help"=>"Institution type",   "Ops"=>"",
                                    "valid"=>"*"
                                    );	
$institutionForm["FLD"][3]=array(
                                    "Id"=>"Email1", "Name"=>"Primary Email",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"Primary Email address",   "Ops"=>"",
                                    "valid"=>""
                                    );
$institutionForm["FLD"][4]=array(
                                    "Id"=>"Email2", "Name"=>"Other Email",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"Other contact Email address",   "Ops"=>"",
                                    "valid"=>""
                                    );
$institutionForm["FLD"][5]=array(
                                    "Id"=>"Telephone1", "Name"=>"Telephone",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"Contact telephone number",   "Ops"=>"",
                                    "valid"=>""
                                    );

$institutionForm["FLD"][6]=array(
                                    "Id"=>"Address_Village", "Name"=>"Address :Village",  "Type"=>"lookup",
                                    "Value"=>"",   "Help"=>"eg. Navatkudah", "Ops"=>"Village",
                                    "valid"=>"*"
                                    );  									
$institutionForm["FLD"][7]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"1",   "Help"=>"",  "Ops"=>"",
                                    "valid"=>""
                                    );
									
$institutionForm["FLD"][8]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );      
    $institutionForm["FLD"][9]=array(
                                    "Id"=>"Address_DSDivision", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );    
      $institutionForm["FLD"][10]=array(
                                    "Id"=>"Address_District", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );   									
$institutionForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
$institutionForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   		
  		
?>