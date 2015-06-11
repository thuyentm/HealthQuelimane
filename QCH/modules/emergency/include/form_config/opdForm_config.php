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


  



/////////////////////////OPD FORM//////              


$opdForm = array();
$opdForm["OBJID"] = "OPDID";
$opdForm["TABLE"] = "opd_visits";
$opdForm["AUDIT_INFO"] = true;
$opdForm["NEXT"]  = "home.php?page=opd&action=View&OPDID=";	
$opdForm["NEXT1"]  = "home.php?page=opd&action=View&OPDID=";
$date=date("Y-m-d H:i:s");
$icd1 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$icd2 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$snomed1 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
$snomed2 = array("Id"=>"_",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
 if ($_SESSION["VISIT_ICD"]==1){
	$icd1 = array("Id"=>"ICD_Code",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
	$icd2 = array("Id"=>"ICD_Text",    "Name"=>"ICD",  "Type"=>"icd_text","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
}
 if ($_SESSION["VISIT_SNOMED"]==1){
	$snomed1 = array("Id"=>"SNOMED_Code",    "Name"=>"",  "Type"=>"hidden","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
	$snomed2 = 	array("Id"=>"SNOMED_Text",    "Name"=>"SNOMED Finding",  "Type"=>"snomed_text","Value"=>"",   "Help"=>" ",  "Ops"=>"","valid"=>"");
 }
$opdForm["FLD"]=array(	
		array("Id"=>"DateTimeOfVisit", "Name"=>"Date and time of visit","Type"=>"timestamp",  "Value"=>"","Help"=>"", "Ops"=>"","valid"=>""),
		array("Id"=>"OnSetDate", "Name"=>"Onset Date",    "Type"=>"date","Value"=>date("Y-m-d"),     "Help"=>"Onset Date",   "Ops"=>"","valid"=>"*"),
		array("Id"=>"Doctor",   "Name"=>"Doctor",    "Type"=>"doctor", "Value"=>"", "Help"=>"Doctor",     "Ops"=>"","valid"=>"*"),
		array("Id"=>"VisitType",   "Name"=>"Visit type",    "Type"=>"visit_type","Value"=>"", "Help"=>"Type of the visit",     "Ops"=>"", "Default"=>"OPD Visit","valid"=>"*"),
		array("Id"=>"Complaint",    "Name"=>"Complaints / Injury",  "Type"=>"complaint","Value"=>"",   "Help"=>"Complaint/Injury ",  "Ops"=>"","valid"=>"*"),
		$icd1,$icd2,
		$snomed1,$snomed2,
		array("Id"=>"sketch",     "Name"=>"Sketch of Injury Points",    "Type"=>"textar","Help"=>"Sketch of Injury Points"),
		array("Id"=>"Severity",   "Name"=>"Severity",    "Type"=>"severity","Value"=>"", "Help"=>"Severity of the Patient",     "Ops"=>"", "Default"=>"Non Urgent","valid"=>""),
		array("Id"=>"Remarks",     "Name"=>"Remarks",    "Type"=>"remarks",     "Value"=>"", "Help"=>"Any remarks (Canned text enabled)", "Ops"=>"" ),
		array("Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],"Help"=>"", "Ops"=>"" ),
		array("Id"=>"OPDID",     "Name"=>"opdid",    "Type"=>"hidden",     "Value"=>$_GET["OPDID"],"Help"=>"", "Ops"=>""),
		array("Id"=>"LastUpDate",     "Name"=>"lastupdate",    "Type"=>"hidden",     "Value"=>$date,"Help"=>"", "Ops"=>"")
	);

$btn1= 	array("Id"=>"PrBtn1",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
$btn2= 	array("Id"=>"PrBtn2",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
$btn3= 	array("Id"=>"PrBtn3",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
$btn4= 	array("Id"=>"PrBtn4",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
$btn5= 	array("Id"=>"PrBtn5",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
$btn6= 	array("Id"=>"PrBtn6",    "Name"=>"Save",   "Type"=>"hidden", "Value"=>"", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
if (!$_GET["OPDID"]){
    $btn1= 	array("Id"=>"PrBtn1",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Labtests", "Help"=>"",   "Ops"=>"",  "onclick"=>"", "Next"=>"");
    $btn2= 	array("Id"=>"PrBtn2",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Prescription", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
    $btn3= 	array("Id"=>"PrBtn3",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Treatment", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
    $btn4= 	array("Id"=>"PrBtn4",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Allergies", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
    $btn5= 	array("Id"=>"PrBtn5",    "Name"=>"Save",   "Type"=>"button", "Value"=>"History", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
    $btn6= 	array("Id"=>"PrBtn6",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Examination", "Help"=>"",   "Ops"=>"",  "onclick"=>"","Next"=>"");
}
$opdForm["BTN"] = array(
        array("Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save ", "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData();canvas_save1(".$_GET["PID"]."," . json_encode($date) .");","Next"=>""),
        array( "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel","Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()", "Next"=>"NL"),
        $btn1,$btn2,$btn3,$btn4,$btn5,$btn6
);                                            
$opdForm["JS"] = "
<script>
	$('#PrBtn1').click(function(){
		saveData(\"\",\"home.php?page=opdLabOrder&action=Edit&OPDID=\");
		$(this).attr('disabled','true');
	});
	$('#PrBtn2').click(function(){
		saveData(\"\",\"home.php?page=opdPrescription&action=Edit&OPDID=\");
		$(this).attr('disabled','true');
	});
	$('#PrBtn3').click(function(){
		saveData(\"\",\"home.php?page=opd_treatment&action=Edit&OPDID=\");
		$(this).attr('disabled','true');
	});
	$('#PrBtn4').click(function(){
		saveData(\"\",\"home.php?page=alergy&action=New&PID=".$_GET["PID"]."&OPDID=\");
		$(this).attr('disabled','true');
	});
		$('#PrBtn5').click(function(){
		saveData(\"\",\"home.php?page=patient_history&action=New&PID=".$_GET["PID"]."&OPDID=\");
		$(this).attr('disabled','true');
	});
	$('#PrBtn6').click(function(){
		saveData(\"\",\"home.php?page=patient_exam&action=New&PID=".$_GET["PID"]."&OPDID=\");
		$(this).attr('disabled','true');
	});	
</script>
";  							
/////////////////////////OPD FORM END			          
?>