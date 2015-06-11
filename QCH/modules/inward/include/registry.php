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

include_once 'MDSDataBase.php';

function loadLeftMenu() {
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";
		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>Books</a>\n";
			$menu .="<div>\n";
					$menu .="<input type='button' class='submenuBtn' value='Admission Registry'  onclick=self.document.location='home.php?page=registry&book=admission'>\n";
					$menu .="<input type='button' class='submenuBtn' value='OPD Registry'  onclick=self.document.location='home.php?page=registry&book=opd'>\n";
			$menu .="</div>\n";
	$menu .=" </div>\n";
	$menu .="</div>\n";
	$menu .="<script language='javascript'>\n";
		$menu .="$('#list1a').accordion();\n";
	$menu .="</script>\n";
	echo $menu ;
}
function loadOPDRegistryBook($dte){
   $tbl = "";
   $OBJID = "PID";
   $clmns= array();
   $caption = "";
   $dte_field = "";
   $link = "";
   
	$qry = "SELECT  opd_visits.DateTimeOfVisit,
		opd_visits.OPDID ,
		concat('(', patient.PID,') ',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  as Name  , 
		concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs') as age,
		patient.Gender,
		patient.Personal_Civil_Status,
		concat(patient.Address_Street,', ',patient.Address_Village,', ',Address_DSDivision,', ',Address_District) as address,
		opd_visits.VisitType 
		FROM opd_visits, patient
		where (patient.PID = opd_visits.PID ) AND (opd_visits.DateTimeOfVisit LIKE '$dte%') order by opd_visits.OPDID desc";
	$OBJID = "OPDID";
	$caption1 = "HOSPITAL : ".strtoupper($_SESSION["Hospital"])."<br>DATE : ".getRegistryDate();	
	$caption2 = "OPD PATIENT REGISTRY BOOK" ;		
	$clmns = array("Visit Date","","Complaint","Name","Details");
	$dte_field = "DateTimeOfVisit";
	$link ="'home.php?page=opd&action=View&OPDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=opdpatient')";
	
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();		
	$result=$mdsDB->mysqlQuery($qry); 
	if (!$result) {
			echo " <script language='javascript'> \n" ;
			echo " jQuery().ready(function(){ \n";
			echo " $('#MDSError').html('List empty!'); \n";
			echo "}); \n";
			echo " </script>\n";
			return "";
	}		
	
	echo "<div style='position:absolute;left:200px'  id='registry_cont'><table border=0 cellpadding=0 cellspacing=0 class='registry_book' width=95% >";
	echo "<tr>";
	
	echo "<td class='ttll' colspan=5  ><img src='images/sl_logo_black_white.png' valign=middle>&nbsp;&nbsp;&nbsp;&nbsp;$caption2</td>";
	echo "<td class='ttlr' colspan=4 >$caption1</td>";
	echo "</tr>";
		echo "<tr>";
		echo "<th style='border-left:1px solid #000000;'>OPDID</th><th>NAME</th><th>AGE</th><th>GENDER</th><th>CIVIL STATUS</th><th>DATE OF VISIT</th>";
		echo "<th>CONTACT PERSON</th>";
		echo "<th>ADDRESS</th>";
		
	echo "</tr>";
	while($row = $mdsDB->mysqlFetchArray($result))  {	
		echo "<tr>";
			echo "<td class='tdl'>".$row["OPDID"]."</td>";
			echo "<td class='tdc'>".strtoupper($row["Name"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["age"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["Gender"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["Personal_Civil_Status"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["DateTimeOfVisit"])."</td>";
			echo "<td class='tdc'></td>";
			echo "<td class='tdc'>".strtoupper($row["address"])."</td>";
			
		echo "</tr>";
	}
	echo "</table ><div>";
	$mdsDB->close();	
}
function isDateValid($str) 
{ 
  $stamp = strtotime($str); 
  if (!is_numeric($stamp)) 
     return FALSE; 
   if ( checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp)) ) 
  { 
     return TRUE; 
  } 
  return FALSE; 
} 
function getRegistryDate(){
	$out = "";
	$dte= date('Y-m-d');
	if (isDateValid($_GET["dte"])){
		$dte= $_GET["dte"];
	}
	else{
		$dte= date('Y-m-d');
	}
	$out .= "<input type='text' name='dte' id='dte' value='$dte' style='border:0px;cursor:pointer;'>";
	
	$out .= "<script>
			$('#dte').datepicker({
				changeMonth: true,changeYear: true,yearRange: 'c-100:c+100',dateFormat: 'yy-mm-dd',maxDate: '+0D',
				onSelect: function(dateText, inst) { 
					$(this).val(dateText); ";
					$out .= "self.document.location='home.php?page=registry&book=".$_GET["book"]."&dte='+dateText";
				$out .= "}
			});
		</script>";
	return $out;
}
function loadAdmissionRegistryBook($dte){
   $tbl = "";
   $OBJID = "PID";
   $clmns= array();
   $caption = "";
   $dte_field = "";
   $link = "";


	$qry = "SELECT  admission.AdmissionDate,
		admission.ADMID,
		admission.BHT,
		admission.OutCome,
		concat('(', patient.PID,') ',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  as Name  , 
		concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs') as age,
		patient.Gender,
		patient.Personal_Civil_Status,
		concat(patient.Address_Street,', ',patient.Address_Village,', ',Address_DSDivision,', ',Address_District) as address,
		ward.Name as wardname
		FROM admission, patient,ward  
		where  (patient.PID = admission.PID ) AND(ward.WID = admission.Ward )  AND (admission.AdmissionDate LIKE '$dte%')order by ADMID desc";
		$OBJID = "OPDID";
		$caption1 = "HOSPITAL : ".strtoupper($_SESSION["Hospital"])."<br>DATE : ".getRegistryDate();	
		$caption2 = "ADMISSION AND DISCHARGE BOOK " ;	
		$clmns = array("Visit Date","V","Complaint","Name","Details","Visit Type");
		$dte_field = "DateTimeOfVisit";
		$link ="'home.php?page=opd&action=View&OPDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=patientlist&show=clinicpatient')";

	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();		
	$result=$mdsDB->mysqlQuery($qry); 
	if (!$result) {
			echo " <script language='javascript'> \n" ;
			echo " jQuery().ready(function(){ \n";
			echo " $('#MDSError').html('List empty!'); \n";
			echo "}); \n";
			echo " </script>\n";
			return "";
	}		
	
	echo "<div style='position:absolute;left:200px' id='registry_cont'><table border=0 cellpadding=0 cellspacing=0 class='registry_book' width=95% >";
	echo "<tr>";
	
	echo "<td class='ttll' colspan=7  ><img src='images/sl_logo_black_white.png' valign=middle>&nbsp;&nbsp;&nbsp;&nbsp;$caption2</td>";
	echo "<td class='ttlr' colspan=2 >$caption1</td>";
	echo "</tr>";
		echo "<tr>";
		echo "<th style='border-left:1px solid #000000;'>BHT</th><th>NAME</th><th>AGE</th><th>GENDER</th><th>CIVIL STATUS</th><th>DATE OF ADMISSION</th>";
		echo "<th>STATUS</th>";
		echo "<th>ADDRESS</th>";
		echo "<th>Ward</th>";
		
	echo "</tr>";
	while($row = $mdsDB->mysqlFetchArray($result))  {	
		echo "<tr>";
			echo "<td class='tdl'>".$row["BHT"]."</td>";
			echo "<td class='tdc'>".strtoupper($row["Name"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["age"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["Gender"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["Personal_Civil_Status"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["AdmissionDate"])."</td>";
			echo "<td class='tdc'>";
			if ($row["OutCome"] == "") 	{echo "IN";}
			else  { echo strtoupper($row["OutCome"]);}
			echo"</td>";
			echo "<td class='tdc'>".strtoupper($row["address"])."</td>";
			echo "<td class='tdc'>".strtoupper($row["wardname"])."</td>";
			
		echo "</tr>";
	}
	echo "</table ><div>";
	$mdsDB->close();	
}


function loadRegistry(){
	loadLeftMenu();
	$dte= date('Y-m-d');
	if (isDateValid($_GET["dte"])){
		$dte= $_GET["dte"];
	}
	if($_GET["book"] == "opd"){
		echo loadHeader('OPD registry book');
		echo loadOPDRegistryBook($dte);
	}
	else {
		echo loadHeader('Admission registry book');
		echo loadAdmissionRegistryBook($dte);
	}
	
}

?>