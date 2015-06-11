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

CREATE TABLE IF NOT EXISTS `appointment` (
  `APPID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11),
  `VDate` date NOT NULL,
  `VTime` time,
  `Token` int(5),
  `Type` varchar(30),
  `Mode` varchar(30),
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`APPID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
*/

/////////////////////////Appointment//////              


$appointmentForm = array();
$appointmentForm["OBJID"] = "APPID";
$appointmentForm["TABLE"] = "appointment";
$appointmentForm["SAVE"] = "appointment_save.php";
$appointmentForm["LIST"] = array( 'APPID','VDate','VTime', 'Token','Type');
$appointmentForm["DISPLAY_LIST"] = array( 'ID','Date','Time', 'Token Number','Type');
$appointmentForm["AUDIT_INFO"] = true;
$appointmentForm["NEXT"]  = "home.php?page=appointment&action=Edit&PID=".$_GET["PID"]."&APPID=";


if ($_GET["APPID"]){
    $token =array("Id"=>"Token",     "Name"=>"Token Number",    "Type"=>"label",     "Value"=>"","Help"=>"", "Ops"=>"","valid"=>"" );  									
}
else{
    $token =array("Id"=>"Token",     "Name"=>"Token Number",    "Type"=>"hidden",     "Value"=>"","Help"=>"", "Ops"=>"","valid"=>"" );     
}

if ($_GET["APPID"]){
	$appointmentForm["FLD"]=array ( array("Id"=>"VDate",    "Name"=>"Appointment date",  "Type"=>"label","Value"=>date('Y-m-d'),   "Help"=>"Date",  "Ops"=>"disabled","valid"=>""),
									array("Id"=>"Type", "Name"=>"Token type","Type"=>"label",  "Value"=>"","Help"=>"OPD or Clinic", "Ops"=>" ","valid"=>"*"),
									array("Id"=>"Consultant",   "Name"=>"Consultant",    "Type"=>"doctor", "Value"=>"", "Help"=>"Doctor",     "Ops"=>"","valid"=>""),
									array("Id"=>"VTime",     "Name"=>"Appointment Time",    "Type"=>"Date",     "Value"=>"","Help"=>"Appointment Time", "Ops"=>""),
									$token,
									array("Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],"Help"=>"", "Ops"=>"")   
	);
}
else{
	$appointmentForm["FLD"]=array ( array("Id"=>"VDate",    "Name"=>"Appointment date",  "Type"=>"date","Value"=>date('Y-m-d'),   "Help"=>"Date",  "Ops"=>"","valid"=>""),
									array("Id"=>"Type", "Name"=>"Token type","Type"=>"visit_type",  "Value"=>"","Help"=>"OPD or Clinic", "Ops"=>" ","valid"=>"*"),
									array("Id"=>"Consultant",   "Name"=>"Consultant",    "Type"=>"doctor", "Value"=>"", "Help"=>"Doctor",     "Ops"=>"","valid"=>""),
									array("Id"=>"VTime",     "Name"=>"Appointment Time",    "Type"=>"Date",     "Value"=>"","Help"=>"Appointment Time", "Ops"=>""),
									$token,
									array("Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],"Help"=>"", "Ops"=>"")   
	);
}
if ($_GET["APPID"]){
    $btn1=array("Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"PRINT TOKEN", "Help"=>"", "Ops"=>"", "onclick"=>"printToken(".$_GET["APPID"].");","Next"=>"");   
	$btn2 = array("Id"=>"SaveBtn",    "Name"=>"Give another",   "Type"=>"button", "Value"=>"Over View","Help"=>"",   "Ops"=>"",  "onclick"=>"reDirect(\"patient\",\"PID=".$_GET["PID"]."&action=View\")","Next"=>"");
}
else{
    $btn2= array("Id"=>"SaveBtn",    "Name"=>"Give another",   "Type"=>"button", "Value"=>"Over View","Help"=>"",   "Ops"=>"",  "onclick"=>"reDirect(\"patient\",\"PID=".$_GET["PID"]."&action=View\")","Next"=>"");
	$btn1 = array("Id"=>"SaveBtn",    "Name"=>"Save Appointment",   "Type"=>"button", "Value"=>"Save Appointment ","Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()","Next"=>"");
}
$appointmentForm["BTN"]=array($btn1,$btn2);   

$appointmentForm["JS"] = " ";
$js = "";
$js .= "<script>\n";
    $js .= " function printToken(appid) {\n";
        $js .= " var params = 'menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700'
				var url = 'token.php?APPID='+appid; 
				 var lookUpW = window.open('include/form_templates/' + url + '', 'lookUpW',	params)
		\n";
   $js .= " }\n";        
$js .= "</script>\n";
$appointmentForm["JS"] = $js;
/////////////////////////opd_treatment_entryForm		          
?>