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


  
$opd_sample_collectionForm = array();
$opd_sample_collectionForm["OBJID"] = "LAB_ORDER_ID";
$opd_sample_collectionForm["TABLE"] = "lab_order";
$opd_sample_collectionForm["LIST"] = array( 'LAB_ORDER_ID','OBJID','Collection_Status','CollectionDateTime');
$opd_sample_collectionForm["DISPLAY_LIST"] = array( 'LAB_ORDER_ID','OBJID','Collection_Status','CollectionDateTime');
$opd_sample_collectionForm["NEXT"]  = "home.php?page=opdSample&action=Edit&LAB_ORDER_ID=";	
$opd_sample_collectionForm["AUDIT_INFO"] = false;

$opd_sample_collectionForm["FLD"][0]=array(
                                    "Id"=>"TestGroupName", "Name"=>"Lab Test",
                                    "Type"=>"label",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$opd_sample_collectionForm["FLD"][1]=array(
                                    "Id"=>"OrderDate", "Name"=>"Order Date",
                                    "Type"=>"label",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>""
                                    );
$opd_sample_collectionForm["FLD"][2]=array(
                                    "Id"=>"Collection_Status", "Name"=>"Collection Status ",
                                    "Type"=>"select",  "Value"=>array("Pending","Done"),
                                    "Help"=>"Collection Status", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$opd_sample_collectionForm["FLD"][3]=array(
                                    "Id"=>"CollectionDateTime", "Name"=>"Collection DateTime",    "Type"=>"datetime",
                                    "Value"=>"",     "Help"=>"Sample collection date and time",   "Ops"=>"",
                                    "valid"=>"*"
                                    );
$opd_sample_collectionForm["FLD"][4]=array(
                                    "Id"=>"Remarks", "Name"=>"Any remarks",    "Type"=>"remarks",
                                    "Value"=>"",     "Help"=>"Remarks",   "Ops"=>"",
                                    "valid"=>""
                                    );

$opd_sample_collectionForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  

$opd_sample_collectionForm["BTN"][1]=array(
                                   "Id"=>"PrintBtn",    "Name"=>"Print Bar Code", "Type"=>"button",  "Value"=>"Print Bar Code", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"printBarCode(\"L\",\"".$_GET["LAB_ORDER_ID"]."\");",
                                   "Next"=>""
                                    );   			       
$opd_sample_collectionForm["BTN"][2]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Back to list", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   			       
?>