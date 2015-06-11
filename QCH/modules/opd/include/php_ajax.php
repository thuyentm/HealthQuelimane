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
include 'config.php';
$allowedfunctions = array("addLabTest","deleteObject","getBHT","makeItMain");
 
if(in_array($_GET['f'], $allowedfunctions))
{
    $func = $_GET['f'];
	$arg = $_GET['arg'];
	$ocont = $_GET['ocont'];
    $output = $func($arg,$ocont);        
    echo $output;
}
else
{
    echo "Error";
}
function deleteObject(){
	$tbl= $_GET['table'];
	$arg = $_GET['arg'];
	$value = $_GET['value'];
	if ((!$tbl)||(!$arg)) { echo $tbl.$arg; return NULL; }
	
	include_once "class/MDSDataStore.php";
	$ds = new MDSDataStore($tbl);
	$ds->openId($arg);
	if ($value == 1) {
		$ds->setInActive(); 
	}
	else {
		$ds->setActive(); 
	}
	return $ds->save();
}
function makeItMain(){
	$id = $_GET['arg'];
	$admid = $_GET['admid'];
	//return $id;
	if (!$id)  return NULL; 
	if (!$admid)  return NULL; 
	include_once "class/MDSDataStore.php";
	include_once "class/MDSDataBase.php";
	include_once "class/MDSAdmission.php";
	$admission = new MDSAdmission();
	$admission->openId($admid);
	if (!$admission->isOpened) return null;
	$ds = new MDSDataStore("admission_diagnosis");
	$ds->openId($id);
	if ($ds->status(true,false) == false) { return " error=true;"; }
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();	

	$sql=" UPDATE admission_diagnosis SET Main = 0 WHERE ADMID = '".$admid."' ";
	$result=$mdsDB->mysqlQuery($sql); 
	
	if (!$result) { return " error=true;"; }
	$ds = new MDSDataStore("admission_diagnosis");
	$ds->openId($id);
	$ds->setValue("Main",1); 
	$status = $ds->save();
	
	if ($status) { 
		$admission->setValue("Discharge_SNOMED_Code",$ds->getValue("SNOMED_Code"));
		$admission->setValue("Discharge_SNOMED_Text",$ds->getValue("SNOMED_Text"));
		$admission->setValue("Discharge_ICD_Code",$ds->getValue("ICD_Code"));
		$admission->setValue("Discharge_ICD_Text",$ds->getValue("ICD_Text"));
		$admission->setValue("Discharge_IMMR_Code",$ds->getValue("IMMR_Code"));
		$admission->setValue("Discharge_IMMR_Text",$ds->getValue("IMMR_Text"));
		$admission->save();
	}
	return $status;
}

function getBHT(){
	include_once "class/MDSHospital.php";
	$cbht = $_GET["bht"];
	$hospital = new MDSHospital();
	$hospital->openDefaultHospital();
	$bht =$hospital->getCurrentBHT($cbht);
	return $bht;
}
function getLabTests($gName){
	if($gName=='Sugar'){
	$out = "<hr><table border=0 cellspacing=0 cellpadding=0 width=100% style=\'font-size:12;\'>";
    $con = mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql=" SELECT LABID, Name,GroupName,Department FROM lab_tests where Active = 1 AND GroupName ='".$gName."' ORDER BY Name";
	$result = mysql_query($sql);
	if (!$result) return "Error";
	while($row = mysql_fetch_array($result))  {		
		$out.="<tr>";
		$out.="<td><input type=\'checkbox\' id=\'".$row["LABID"]."\' value=\'".$row["LABID"]."\'></td><td>".str_replace('"', '\"', $row["Name"])."</td><td>".str_replace('"', '\"', $row["GroupName"])."</td>";
		$out .="<td>".str_replace('"', '\"', $row["Department"])."</td>";
		$out.="</tr>";
	}
	$out .= "</table><hr>";
	mysql_close($con);
	return $out;
	}
	
	else{	
			$out = "<hr><table border=0 cellspacing=0 cellpadding=0 width=100% style=\'font-size:12;\'>";
    $con = mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql=" SELECT LABID, Name,GroupName,Department FROM lab_tests where Active = 1 AND GroupName ='".$gName."' ORDER BY Name";
	$result = mysql_query($sql);
	if (!$result) return "Error";
	while($row = mysql_fetch_array($result))  {		
		$out.="<tr>";
		$out.="<td><input type=\'checkbox\' id=\'".$row["LABID"]."\' value=\'".$row["LABID"]."\'  checked=true></td><td>".str_replace('"', '\"', $row["Name"])."</td><td>".str_replace('"', '\"', $row["GroupName"])."</td>";
		$out .="<td>".str_replace('"', '\"', $row["Department"])."</td>";
		$out.="</tr>";
	}
	$out .= "</table><hr>";
	mysql_close($con);
	return $out;	
	
	
	}
}

function addLabTest($arg){
	$out ="<script language='javascript'>";
	$ihtml = getLabTests($arg);
	$out .=" $('#lab').html('".$ihtml."');\n";
	$out .=" $('#dcont ,#createBtn').show();\n";
	$out .="</script>\n";
	return $out;
}

?>