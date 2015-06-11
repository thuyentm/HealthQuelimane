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
/////////////////////////Attachment//////              

$attachForm = array();
$attachForm["OBJID"] = "ATTCHID";
$attachForm["TABLE"] = "attachment";
$attachForm["SAVE"] = "attachment_save.php";
$attachForm["LIST"] = array( 'ATTCHID','VDate','VTime', 'Token','Type');
$attachForm["DISPLAY_LIST"] = array( 'ID','Date','Time', 'Token Number','Type');
$attachForm["AUDIT_INFO"] = true;
$attachForm["NEXT"]  = "home.php?page=".$_GET["TYPE"]."&action=View&PID=".$_GET["PID"]."&ATTCHID=";
if ($_GET["TYPE"] == "patient"){
	$continue = array("Id"=>"Continue","Name"=>"","Type"=>"hidden","Value"=>"home.php?page=patient&action=View&PID=".$_GET["PID"]."&ATTCHID=","Help"=>"","Ops"=>"");
}
$attachForm["FLD"]=array ( 
	array("Id"=>"fileToUpload","Name"=>"File to attach","Type"=>"file","Value"=>"","Help"=>"Select the file to be attached","Ops"=>"","valid"=>"*"),
	array("Id"=>"Attach_Type", "Name"=>"Attachment type","Type"=>"select","Value"=>array("PDF","Scan Image","ECG","X-Ray","Document","Other"), "Help"=>"Attachment type","Ops"=>" ","valid"=>"*"),
	array("Id"=>"Attach_To","Name"=>"File will be attached to","Type"=>"label","Value"=>$_GET["TYPE"],"Help"=>"","Ops"=>""),
	array("Id"=>"Attached_By","Name"=>"Attached By","Type"=>"staff","Value"=>"","Help"=>"File attached staff","Ops"=>""),
	array("Id"=>"Attach_Description", "Name"=>"Description / remarks","Type"=>"remarks","Value"=>"","Help"=>"Description / remarks","Ops"=>"","valid"=>""),
	array("Id"=>"PID","Name"=>"","Type"=>"hidden","Value"=>$_GET["PID"],"Help"=>"","Ops"=>""),
	array("Id"=>"EPISODE","Name"=>"","Type"=>"hidden","Value"=>$_GET["EPISODE"],"Help"=>"","Ops"=>""),
	array("Id"=>"Active","Name"=>"Active","Type"=>"bool","Value"=>"","Help"=>"Record active or not", "Ops"=>"" ,"valid"=>""), 
	$continue
);
$btn1=array("Id"=>"SaveBtn",    "Name"=>"SaveBtn", "Type"=>"button",  "Value"=>"Attach", "Help"=>"", "Ops"=>"", "onclick"=>"fileUpLoad();","Next"=>"");   
$btn2 = array("Id"=>"CancelBtn",    "Name"=>"CancelBtn",   "Type"=>"button", "Value"=>"Cancel","Help"=>"",   "Ops"=>"",  "onclick"=>"window.history.back();","Next"=>"");
$attachForm["BTN"]=array($btn1,$btn2);  

/////////////////////////Attachment		          
?>