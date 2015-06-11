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
  `NOTIFICATION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EPISODEID` int(11) NOT NULL ,
  `PID` varchar(100) NOT NULL ,
  `FROMID` varchar(100) NOT NULL ,
  `TOID` varchar(100) NOT NULL ,
  
  `Episode_Type` varchar(100) NOT NULL ,
  `Disease` varchar(200) NOT NULL,
  `LabConfirm` tinyint(1) DEFAULT '0',
  `Confirmed` tinyint(1) DEFAULT '0',
  `Remarks` varchar(200),
  `ConfirmedBy` varchar(200) DEFAULT NULL 
  `notificationDate` datetime ;
  
*/


/////////////////////////notification_entryForm//////              


$notification_entryForm = array();
$notification_entryForm["OBJID"] = "NOTIFICATION_ID";
$notification_entryForm["TABLE"] = "notification";
$notification_entryForm["LIST"] = array( 'NOTIFICATION_ID', 'Episode_Type', 'Disease','LabConfirm','Confirmed');
$notification_entryForm["DISPLAY_LIST"] = array( 'ID', 'Deparment', 'Disease','Lab Confirm','Confirmed');
$notification_entryForm["DISPLAY_WIDTH"] = array( '5%', '15%', '50%','15%','2%');
$notification_entryForm["AUDIT_INFO"] = true;
$notification_entryForm["NEXT"]  = "home.php?page=admission&action=View&ADMID=".$_GET["EPISODEID"]."&NOTIFICATION_ID=";	
$notification_entryForm["NEXT1"]  = "home.php?page=notification&action=Edit&NOTIFICATION_ID=";	

$notification_entryForm["FLD"][0]=array(
                                    "Id"=>"notificationDate", "Name"=>"Creation Date",
                                    "Type"=>"timestamp",  "Value"=>"",
                                    "Help"=>"", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$notification_entryForm["FLD"][1]=array(
                                    "Id"=>"Episode_Type",    "Name"=>"Type",  "Type"=>"olable",
                                    "Value"=>$_GET["TYPE"],   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
$notification_entryForm["FLD"][2]=array(
                                    "Id"=>"Disease",    "Name"=>"Disease",  "Type"=>"olable",
                                    "Value"=>$_GET['DISEASE'],   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$notification_entryForm["FLD"][3]=array(
                                    "Id"=>"LabConfirm",    "Name"=>"is Lab Confirmed",  "Type"=>"bool",
                                    "Value"=>"No",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );
$notification_entryForm["FLD"][4]=array(
                                    "Id"=>"Confirmed",    "Name"=>" Notification requested",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );
									
$notification_entryForm["FLD"][5]=array(
                                    "Id"=>"ConfirmedBy",    "Name"=>"Doctor",  "Type"=>"doctor",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>"*"
                                    );

$notification_entryForm["FLD"][6]=array(
                                    "Id"=>"IMMR_text",    "Name"=>"* IMMR Diagnosis",  "Type"=>"hidden",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"",
                                    "valid"=>""
                                    );
 

$notification_entryForm["FLD"][7]=array(
								"Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"",
								"Help"=>"Any remarks (Canned text enabled)", "Ops"=>""
								);    
$notification_entryForm["FLD"][8]=array(
								"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"Diagnosis active or not", "Ops"=>""
								);     								
$notification_entryForm["FLD"][9]=array(
								"Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],
								"Help"=>"", "Ops"=>"" ,"valid"=>""
								);  
$notification_entryForm["FLD"][10]=array(
								"Id"=>"EPISODEID",     "Name"=>"ep",    "Type"=>"hidden",     "Value"=>$_GET["EPISODEID"],
								"Help"=>"", "Ops"=>"","valid"=>"*"
								);  									
$notification_entryForm["FLD"][11]=array(
								"Id"=>"FROMID",     "Name"=>"from",    "Type"=>"hidden",     "Value"=>$_SESSION["HID"],
								"Help"=>"", "Ops"=>"","valid"=>"*"
								);  							
$notification_entryForm["FLD"][12]=array(
								"Id"=>"TOID", "Name"=>"Send Email to",   "Type"=>"textarea",     "Value"=>"",     "Help"=>"Email address ",   "Ops"=>""
								);          
$notification_entryForm["FLD"][13]=array(
								"Id"=>"Status", "Name"=>"",   "Type"=>"hidden",     "Value"=>"Pending",     "Help"=>" ",   "Ops"=>""
								);   
  
$notification_entryForm["BTN"][0]=array(
						   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ",     
							"Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
							"Next"=>""
							);                                            
  
$notification_entryForm["BTN"][1]=array(
						   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
						   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
						   "Next"=>""
							);   									
/////////////////////////notification_entryForm		          
?>