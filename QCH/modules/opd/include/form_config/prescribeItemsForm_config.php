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




/////////////////////////PRESCRIPTION ITEM FORM//////              


$prescribeItemsForm = array();
$prescribeItemsForm["OBJID"] = "PRS_ITEM_ID";
$prescribeItemsForm["TABLE"] = "prescribe_items";
$prescribeItemsForm["LIST"] = array( 'PRS_ITEM_ID','DRGID','Dosage','Frequency','HowLong','Remarks');
$prescribeItemsForm["DISPLAY_LIST"] = array( 'PRS_ITEM_ID','DRGID','Dosage','Frequency','Period','Remarks');
$prescribeItemsForm["NEXT"]  = "home.php?page=opdPrescription&OPDID=";	
$prescribeItemsForm["AUDIT_INFO"] = false;
$prescribeItemsForm["FLD"][0]=array(
                                    "Id"=>"PDRGID", "Name"=>"Drug name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$prescribeItemsForm["FLD"][1]=array(
                                    "Id"=>"DRGID", "Name"=>"Drug name",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
								
$prescribeItemsForm["FLD"][2]=array(
                                    "Id"=>"Dosage", "Name"=>"Dosage",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"Dosage",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$prescribeItemsForm["FLD"][3]=array(
                                    "Id"=>"Frequency", "Name"=>"Frequency",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"Dosage",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$prescribeItemsForm["FLD"][4]=array(
                                    "Id"=>"HowLong", "Name"=>"HowLong",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$prescribeItemsForm["FLD"][5]=array(
                                    "Id"=>"PRES_ID", "Name"=>"PRES_ID",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"",   "Ops"=>"",
                                    "valid"=>""
                                    );                                   

$prescribeItemsForm["FLD"][6]=array(
                                    "Id"=>"Active", "Name"=>"Active",    "Type"=>"hidden",
                                    "Value"=>"1",     "Help"=>"",   "Ops"=>"",
                                    "valid"=>""
                                    );                                   
									
//$prescribeItems["FLD"][3]=array(
                                  //  "Id"=>"Remarks",    "Name"=>"Remarks",  "Type"=>"text",
                                  //  "Value"=>"",   "Help"=>"",  "Ops"=>"",
                                   // "valid"=>""
                                   // );
$prescribeItemsForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
$prescribeItemsForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////PRESCRIPTION ITEM FORM//////       END	
  		
?>