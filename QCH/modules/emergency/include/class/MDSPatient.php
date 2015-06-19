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
include_once 'MDSPersistent.php';
class MDSPatient extends MDSPersistent
{
	
	public function __construct() {
		parent::__construct("patient");
	}
	
	public function getFullName($ops=""){
		if (!$this->Fields[$this->ObjField]) return NULL;
		$fName = "";
		$fName .= ucwords($this->getValue("Personal_Title")." ".$this->getValue("Personal_Used_Name"));
		if ($this->getValue("Full_Name_Registered") != "") {
			if ($ops== "html") {
				$fName .= "<span > ".$this->getValue("Full_Name_Registered")."</span> " ;
			}
			else {
				$fName .= " ".$this->getValue("Full_Name_Registered")." " ;
			}			
		}	
		return $fName ;
	}
	
	public function getOtherName(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return ucwords($this->getValue("Personal_Used_Name"));
	}
	
	public function getCivilStatus(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return ucwords($this->getValue("Personal_Civil_Status"));
	}
	
	public function getDateOfBirth(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return $this->getValue("DateOfBirth");
	}
	
	public function getNIC(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return $this->getValue("NIC");
	}
	
	public function getGender(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return $this->getValue("Gender");
	}
	
	public function getlastId(){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT MAX(LPID) FROM patient "); 
		if (!$result) return null;
		$row = $mdsDB->mysqlFetchArray($result);
		return $row[0];
	}
	public function getAddress($ops="html"){
		$address = "";
		if ($ops == "html"){
			if ($this->getValue("Address_Street")!="") $address .= $this->getValue("Address_Street").", ";
			if ($this->getValue("Address_Street1")!="") $address .=$this->getValue("Address_Street1").",";
			$address .=$this->getValue("Address_Village").",<br>";
			$address .=$this->getValue("Address_DSDivision").",<br>";
			$address .=$this->getValue("Address_District");
		}
                else {
			if ($this->getValue("Address_Street")!="") $address .= $this->getValue("Address_Street").", ";
			if ($this->getValue("Address_Street1")!="") $address .=$this->getValue("Address_Street1").",";
			$address .=$this->getValue("Address_Village").",";
			$address .=$this->getValue("Address_DSDivision").",";
			$address .=$this->getValue("Address_District");
                
                }
		return $address;
	}
	public function haveAnyOpenedAdmission(){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT ADMID FROM admission where (PID ='".$this->getValue("PID")."') AND (DischargeDate = '' ) "); 	
		$count = $mdsDB->getRowsNum($result);
		$mdsDB->close();		
		if ($count > 0) {
			return true;
		}
		else {
			return false;
		}
	}
        
       	public function haveAnyOpenedEmergencyAdmission(){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT EMRID FROM emergency_admission where (PID ='".$this->getValue("PID")."') AND (DischargeDate = '' ) "); 	
		$count = $mdsDB->getRowsNum($result);
		$mdsDB->close();		
		if ($count > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function patientBanner(){
		if (!$this->Fields[$this->ObjField]) {
                    die(diplayMessage('<br>Patient not found <br><input  class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,100));
                    return NULL;
                }
		$patInfo ="";
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_Edit"))
			$tools= "<img  src='images/patient_edit.png' style='cursor:pointer;' title='Edit record'    onmousedown=self.document.location='home.php?page=patient&action=Edit&PID=".$this->getValue("PID")."'>";
                $tools .= "&nbsp;<img   src='images/patient_screen.png' style='cursor:pointer;' title='Open' onclick=openPatient('".$this->getValue("PID")."')><br>";
		$patInfo .= "<div id ='patientBanner' class='patientBanner'>\n";
		$patInfo .= "<table width=100% border=0 class='tblPatientBanner'>\n";
		$patInfo .= "<tr><td>".getPrompt("Full Name").":</td><td><b>".$this->getFullName('html')."</b></td><td>".getPrompt("Registration No").":</td><td><b>".$this->getId()."</b></td><td  rowspan=5 valign=top align=right>".$tools."</td></tr>\n";
		$patInfo .= "<tr><td>".getPrompt("Gender").":</td><td>".$this->getGender()."</td><td>".getPrompt("NIC").":</td><td>".$this->getNIC()."</td></tr>\n";
		$patInfo .= "<tr><td>".getPrompt("Date of birth").":</td><td>~".$this->getDateOfBirth()."</td><td >".getPrompt("Address").":</td><td rowspan=3 valign=top>".$this->getAddress("html")."</td></tr>\n";

		$patInfo .= "<tr><td>".getPrompt("Age").":</td><td>~<b>".$this->getAge()."</b></td><td></td></tr>\n";
		$patInfo .= "<tr><td>".getPrompt("Civil Status").":</td><td>".$this->getCivilStatus()."</td><td></td></tr>\n";
		$patInfo .= "</table></div>\n";
		$this->addRecentPatient();		
		
		return $patInfo;
	}
	
	public function patientBannerTiny($left=""){
		if (!$this->Fields[$this->ObjField]) {
                    die(diplayMessage('<br>Patient not found <br><input  class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,100));
                    return NULL;
                }
		$patInfo ="";
		//$tools= "<input type='button' class='patBtn'  value='Edit' onclick=self.document.location='home.php?page=patientedit&PID=".$row["PID"]."'>";
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_Edit"))
		$tools= "<img   src='images/edit-icon.png'  style='cursor:pointer;' title='Edit record'   onmousedown=self.document.location='home.php?page=patient&action=Edit&PID=".$this->getValue("PID")."'>";
		// $tools .="<input type='button' class='patBtn'  value='Print' onclick=\"printPatientSlip(".$aRow[0].");\">";
		$patInfo .= "<div id ='patientBanner' class='patientTinny Tinny' ";
                if ($left !="")
                        $patInfo .= " style='left:".$left.";'\n";
                $patInfo .= " >\n";
		$patInfo .= "<table width=100% border=0 class='tblPatientBannerTinny'>\n";
		$patInfo .= "<tr><td><span style='font-size:18px;cursor:pointer;' onclick=reDirect('patient&PID=".$this->getId()."&action=View') ><b>".$this->getFullName('html')." / ".$this->getGender()." / ~".$this->getAge()." / ".$this->getCivilStatus()."</b></span></td>";
		$patInfo .= "<td>".getPrompt("PID").":&nbsp".$this->getId()."</td>";
		//$patInfo .= "<td>".getPrompt("Sex").":&nbsp;".."</td>";
		//$patInfo .= "<td>".getPrompt("Civil Status").":&nbsp;".$this->getCivilStatus()."</td>";
		$patInfo .= "<td>".getPrompt("DOB").":&nbsp;~".$this->getDateOfBirth()."</td>";
		//$patInfo .= "<td>".getPrompt("Age").":&nbsp;".$this->getAge()."</td>";
		$patInfo .= "<td>".getPrompt("Village").":&nbsp;".$this->getValue("Address_Village")."</td>";
		$patInfo .= "<td align='right'>".$tools."</td>";
		$patInfo .= "</tr>";
		$patInfo .= "</table></div>\n";
		//$allergis = $this->loadPatientAllergy(); 
		return $patInfo;
	}
	
	public function addRecentPatient(){
		include_once 'MDSRecentPatient.php';
		$loged_user_id = $_SESSION["UID"];
		$recent_patient = new MDSRecentPatient();
		$recent_patient->addRecentPatient($this->getId(),$loged_user_id,"patient");
	}
	
	public function getRecentPatientList(){
		include_once 'MDSRecentPatient.php';
		$loged_user_id = $_SESSION["UID"];
		$recent_patient = new MDSRecentPatient();
		return $recent_patient->getRecentPatientList($loged_user_id);
	}
	
	public function loadPatientAllergy($ops=""){
		$out = "";
		$out .= "<div class='opdCont ";
		if ( !$ops ){ $out .= " opdContClose' "; } else { $out .= " ' ";} 

		$out .= $this->getAlergy();

		return $out;
	}
	
	public function getAlergy(){
		$out = "";
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_exam_Edit")) 	$gotAccess=true;		
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM patient_alergy where ( PID ='".$this->getValue("PID")."' )  ORDER BY Name"); 
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$out .="><div class='opdHead' id='palh'> ".getPrompt("Allergies")."</div>\n";
		$out .= "<div class='opdBody' id='palb'>\n";
		$out .= "<table border=0 width=100% cellspacing=0   class='opdTbl' >\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if (!$row["ALERGYID"]) continue;
			if ($gotAccess) 
				$tools = "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onmousedown=self.document.location='home.php?page=alergy&ALERGYID=".$row["ALERGYID"]."&action=Edit&PID=".$this->getValue("PID")."&RETURN='+encodeURIComponent(self.document.location)+'#4'>";

				$out .= "<tr";
			if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
			$out .=" >\n";
			$out .= "<td width=150>".$row["CreateDate"]."</td><td width=300>".$row["Name"]."</td><td>".$row["Status"]."</td><td align='right'>By: ".$row["CreateUser"]."</td><td align=right width='20'>".$tools."</td>";
			
			$out .= "</tr>";
		}
		$out .= "</table>"; 
		$out .= "</div>\n";
		$out .= "</div>";
		$out .= "<script language='javascript'>\n";
			$out .= " $('#palh').click(function(){ $('#palb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();		
		return $out;
	}
	public function loadOpdInfo()
	{	
		include_once 'MDSUser.php';
		if (!$this->Fields[$this->ObjField]) return NULL;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM opd_visits where PID ='".$this->getValue("PID")."' ORDER BY DateTimeOfVisit DESC"); 
		if (!$result) {
				echo " <script language='javascript'> \n" ;
				echo " jQuery().ready(function(){ \n";
				echo " $('#MDSError').html('Patient not found!'); \n";
				echo "}); \n";
				echo " </script>\n";
				return "";
		}		
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$out  = "<div class='opdCont'>\n";
			$out .= "<div class='opdHead' id='popdh'>".getPrompt("Visits")."</div>\n";
			$out .= "<div class='opdBody' id='popdb'>\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='opdTbl'>\n";
			$i = 0;

				while($row = $mdsDB->mysqlFetchArray($result))  {
					$i++;
					$doctor = new MDSUser();
					$doctor->openId($row["Doctor"]);
					$vst_dte = date_parse($row["DateTimeOfVisit"]);
					$btn = " onmousedown = reDirect('opd','OPDID=".$row["OPDID"]."&action=View') ";
					$out .= "<tr title='Open this entry' onmouseover=changeOver(this); onmouseout=changeOut(this); ".$btn.">\n"; 
					$out .= "<td width=100>".getMDSDate($vst_dte)."</td><td>".$row["VisitType"]."</td><td>".$row["Complaint"]."</td><td>".$row["ICD_Text"]."</td><td align='right'>".$doctor->getFullName()."</td>\n";
					$out .= "</tr>\n";					
				}
			$out .= "</table>\n";	
			$out .= "</div>\n";
		$out .= "</div>\n";
		$out .= "<script language='javascript'>\n";
			$out .= " $('#popdh').click(function(){ $('#popdb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";		
		$mdsDB->close();
		return $out;
	}
	public function loadAdmissionInfo()
	{
		include_once 'MDSUser.php';
		if (!$this->Fields[$this->ObjField]) return NULL;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM admission where PID ='".$this->getValue("PID")."' ORDER BY AdmissionDate DESC"); 
		if (!$result) {
				echo " <script language='javascript'> \n" ;
				echo " jQuery().ready(function(){ \n";
				echo " $('#MDSError').html('Patient not found!'); \n";
				echo "}); \n";
				echo " </script>\n";
				return "";
		}		
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$out  = "<div class='opdCont'>\n";
			$out .= "<div class='opdHead' id='pah'>".getPrompt("Admissions")."</div>\n";
			$out .= "<div class='opdBody' id='pab'>\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='opdTbl'>\n";
			$i = 0;

				while($row = $mdsDB->mysqlFetchArray($result))  {
					$i++;
					$doctor = new MDSUser();
					$doctor->openId($row["Doctor"]);
					$adm_dte = date_parse($row["AdmissionDate"]);
					$btn = " onmousedown = reDirect('admission','ADMID=".$row["ADMID"]."&action=View') ";
					$out .= "<tr title='Open this entry' ";
					$out .= " onmouseover=changeOver(this); onmouseout=changeOut(this); ".$btn.">\n"; 
					$out .= "<td width=100>";
					if (!$row["DischargeDate"])
						$out .="<b style='color:#FF0000;font-size:14px;'>&raquo;</b>&nbsp;";
					$out .=getMDSDate($adm_dte)."</td><td>".$row["BHT"]."</td><td>".$row["Complaint"]."</td><td>".$row["Discharge_ICD_Text"]."</td><td align='right'>".$doctor->getFullName()."</td>\n";
					$out .= "</tr>\n";					
				}
			$out .= "</table>\n";	
			$out .= "</div>\n";
		$out .= "</div>\n";
		$out .= "<script language='javascript'>\n";
			$out .= " $('#pah').click(function(){ $('#pab').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";		
		$mdsDB->close();
		return $out;
	}
	public function loadExams($ops=""){
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM patient_exam WHERE pid = '".$this->getId()."' ORDER BY ExamDate DESC LIMIT 0,10";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_exam_Edit")) 	$gotAccess=true;

		
		$out .= "<div class='opdCont ";
		if ( !$ops ){ $out .= " opdContClose' "; } else { $out .= " ' ";} 
		$out .="><div class='opdHead' id='peh'> ".getPrompt("Examinations")."</div>\n";
		$out .= "<div class='lab_Cont' id='peb' >\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' align=right>Weight (Kg)</td>\n";
		$out .= "<td class='td_brd' align=right>Height (M)</td>\n";
		$out .= "<td class='td_brd' align=right>BP</td>\n";
		$out .= "<td class='td_brd' align=right>Temperature ('c)</td>\n";
		$out .= "<td class='td_brd' align='right'></td>\n";
		$out .= "</tr>\n";

		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["PATEXAMID"]) {
				$tools ="";
				if ($gotAccess) 
						$tools .= "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onmousedown=self.document.location='home.php?page=patient_exam&PATEXAMID=".$row["PATEXAMID"]."&action=New&PID=".$this->getId()."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .= $row["ExamDate"];
				$out .= "</td>\n";
				$out .= "<td align=right>";
				if($row["Weight"] == 0){ $out .= "-"; } else {$out .= $row["Weight"];} $out .="</td>\n";
				$out .= "<td align=right>";
				if($row["Height"] == 0){ $out .= "-"; } else {$out .= $row["Height"];} $out .="</td>\n";
				$out .= "<td align=right>";
				if (($row["sys_BP"] > 0)&& ($row["diast_BP"]>0))
					$out .= $row["sys_BP"]."/".$row["diast_BP"];
				else 
					$out .= "-"; 
				$out .= "</td>\n";
				$out .= "<td align=right>";
					if($row["Temprature"] == 0){ $out .= "-"; } else {$out .= $row["Temprature"];} $out .="</td>\n";
				$out .= "<td align='right'>By: ".$row["CreateUser"]."</td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= " $('#peh').click(function(){ $('#peb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			//$out .= " $('#peb').toggle();\n";
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}		
	
	public function loadTriage($ops=""){
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM pcu_visits WHERE PID = '".$this->getId()."' ORDER BY DateTimeOfVisit DESC LIMIT 0,1";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Triage Details"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_exam_Edit")) 	$gotAccess=true;

		
		$out .= "<div class='opdCont ";
		if ( !$ops ){ $out .= " opdContClose' "; } else { $out .= " ' ";} 
		$out .="><div class='opdHead' id='peh'> ".getPrompt("Initial Triage Details")."</div>\n";
		$out .= "<div class='lab_Cont' id='peb' >\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
	
		/*$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Pulse</td>\n";
		$out .= "<td class='td_brd' width=80 >Saturation</td>\n";
		$out .= "<td class='td_brd' align=right>Respiratory</td>\n";
		$out .= "<td class='td_brd' align=right>Alert</td>\n";
		$out .= "<td class='td_brd' align=right>Voice</td>\n";
		$out .= "<td class='td_brd' align=right>Pain</td>\n";
		$out .= "<td class='td_brd' align=right>UNR</td>\n";
		$out .= "<td class='td_brd' align='right'></td>\n";
		$out .= "</tr>\n";
		
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' align=right>Remarks</td>\n";
		$out .= "<td class='td_brd' align='right'></td>\n";
		$out .= "</tr>\n";*/

		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["PCUID"]) {
				$tools ="";
				if ($gotAccess) 
						//$tools .= "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onmousedown=self.document.location='home.php?page=patient_exam&PATEXAMID=".$row["PATEXAMID"]."&action=New&PID=".$this->getId()."'>";
                        $tools = "<img   src='images/edit-icon.png' width=15 height=15  style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=emergency&EMRID=".$row["EMRID"]."&action=Edit&PID=".$row["PID"]."'>";
				$out .= "<tr";
				//if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td class='td_brd' width=80 >Date:</td>\n";
				$out .= "<td>";
				$out .= $row["OnSetDate"];
				$out .= "</td>\n";
				$out .= "<td class='td_brd' width=80 >Category :</td>\n";
				$out .= "<td>";
				$out .= $row["Status"];
				$out .= "</td>\n";
				$out .= "<td class='td_brd' align=right>Weight (Kg):</td>\n";
				$out .= "<td align=right>";
				if($row["Weight"] == 0){ $out .= "-"; } else {$out .= $row["Weight"];} $out .="</td>\n";
				$out .= "<td class='td_brd' align=right>Height (M):</td>\n";
				$out .= "<td align=right>";
				if($row["Height"] == 0){ $out .= "-"; } else {$out .= $row["Height"];} $out .="</td>\n";
				$out .= "<td class='td_brd' align=right>BP :</td>\n";
				$out .= "<td align=right>";
				if (($row["sys_BP"] > 0)&& ($row["diast_BP"]>0))
					$out .= $row["sys_BP"]."/".$row["diast_BP"];
				else 
					$out .= "-"; 
				$out .= "</td>\n";
				$out .= "<td class='td_brd' align=right>Temperature ('c) :</td>\n";
				$out .= "<td align=right>";
					if($row["Temprature"] == 0){ $out .= "-"; } else {$out .= $row["Temprature"];} $out .="</td>\n";
				//$out .= "<td align='right'>By: ".$row["CreateUser"]."</td>\n";
					$out .= "<td class='td_brd' align='right'></td>\n";
				$out .= "<td align=right> </td>\n";
				$out .= "<td class='td_brd' align='right'></td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
				
				$out .= "<tr>\n";
				$out .= "<td class='td_brd' width=80 >Pulse:</td>\n";
				$out .= "<td>";
				if(!$row["Pulse"]){ $out .= "-"; } else {$out .= $row["Pulse"];} $out .="</td>\n";
				$out .= "</td>\n";
				$out .= "<td class='td_brd' width=80 >Saturation:</td>\n";
				$out .= "<td>";
				if(!$row["Saturation"]){ $out .= "-"; } else {$out .= $row["Saturation"];} $out .="</td>\n";
				$out .= "</td>\n";
				$out .= "<td class='td_brd' width=80 >Respiratory:</td>\n";
				$out .= "<td>";
				if(!$row["Respiratory"]){ $out .= "-"; } else {$out .= $row["Respiratory"];} $out .="</td>\n";
				$out .= "</td>\n";
				$out .= "<td class='td_brd' align=right>Alert:</td>\n";
				$out .= "<td align=right>";
				if($row["Alert"] == 0){ $out .= "No"; } else {$out .= "Yes";} $out .="</td>\n";
				$out .="</td>\n";
				$out .= "<td class='td_brd' align=right>Voice:</td>\n";
				$out .= "<td align=right>";
				if($row["Voice"] == 0){ $out .= "No"; } else {$out .= "Yes";} $out .="</td>\n";
				$out .="</td>\n";
				$out .= "<td class='td_brd' align=right>Pain:</td>\n";
				$out .= "<td align=right>";
				if($row["Pain"] == 0){ $out .= "No"; } else {$out .= "Yes";} $out .="</td>\n";
				$out .= "</td>\n";
				$out .= "<td class='td_brd' align=right>UNR:</td>\n";
				$out .= "<td align=right>";
				if($row["UNR"] == 0){ $out .= "No"; } else {$out .= "Yes";} $out .="</td>\n";
				$out .= "</td>\n";
				//$out .= "<td align=right>";
					//if($row["Temprature"] == 0){ $out .= "-"; } else {$out .= $row["Temprature"];} $out .="</td>\n";
				$out .= "<td align='right'>By: ".$row["CreateUser"]."</td>\n";
				//$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
				
				
			}
		}
		
		
		
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= " $('#peh').click(function(){ $('#peb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			//$out .= " $('#peb').toggle();\n";
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}	
	
	public function loadHistory($ops = ""){
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM medical_history WHERE PID = '".$this->getId()."' ORDER BY CreateDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_history_Edit")) 	$gotAccess=true;

		if ($count == 0) return NULL;
		$out .= "<div class='opdCont ";
		if ( !$ops ){ $out .= " opdContClose' "; } else { $out .= " ' ";} 
		$out .="><div class='opdHead' id='phh'> ".getPrompt("Past history")."</div>\n";
		$out .= "<div class='lab_Cont' id='phb' >\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		/*
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' >Type</td>\n";
		$out .= "<td class='td_brd' >Snomed</td>\n";
		$out .= "<td class='td_brd' ></td>\n";
		$out .= "</tr>\n";
*/
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["HID"]) {
				$tools ="";
				if ($gotAccess) 
						$tools .= "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onmousedown=self.document.location='home.php?page=patient_history&HID=".$row["HID"]."&action=Edit&PID=".$this->getId()."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .= $row["HistoryOfComplaint"];
				$out .= "</td>\n";
				$out .= "<td >";
				$out .= $row["SystemicReview"]; $out .="</td>\n";
				$out .= "<td >";
				$out .= $row["PastMedicalHistory"]; $out .="</td>\n";
				$out .= "<td align='right'>By: ".$row["CreateUser"]."</td>\n";
				$out .= "<td align=right width=20>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= " $('#phh').click(function(){ $('#phb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			//$out .= " $('#phb').toggle(); \n";
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}		
	public function loadOpdPrescriptionInfo()
	{ 
		if (!$this->Fields[$this->ObjField]) return NULL;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT opd_presciption.OPDID,opd_presciption.PRSID,opd_presciption.Status,opd_presciption.PrescribeDate,opd_presciption.Dept,opd_presciption.PrescribeBy FROM opd_presciption,opd_visits where opd_visits.PID ='".$this->getValue("PID")."' AND opd_presciption.OPDID=opd_visits.OPDID ORDER BY PrescribeDate DESC"); 
		if (!$result) {
				echo " <script language='javascript'> \n" ;
				echo " jQuery().ready(function(){ \n";
				echo " $('#MDSError').html('Patient not found!'); \n";
				echo "}); \n";
				echo " </script>\n";
				return "";
		}	
		$out  = "<div class='opdCont'>\n";
			$out .= "<div class='opdHead' id='podh'>".getPrompt("Prescriptions")." </div>\n";
			$out .= "<div class='opdBody' id='podb'>\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='opdTbl'>\n";
			$i = 0;
				while($row = $mdsDB->mysqlFetchArray($result))  {
					$i++; //?page=opdPrescription&OPDID=4 view=1bda80f2be4d3658e0baa43fbe7ae8c1 edit=de95b43bceeb4b998aed4aed5cef1ae7
					$sqlp ="SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '".$row["PRSID"]."' ";
					$resultp=mysql_query($sqlp);  
					$drugs ="";
					while($rowp = mysql_fetch_array($resultp))  {
						$drugs.=$rowp["Name"].", ";
					}					
					$out .= "<tr  title='Open this entry'  onmouseover=changeOver(this); onmouseout=changeOut(this); onclick=reDirect('opdPrescription','OPDID=".$row["OPDID"]."&action=View')>\n"; 
					$out .= "<td width=150>".$row["PrescribeDate"]."</td><td>".$drugs."</td><td align='right'>By:".$row["PrescribeBy"]." (".$row["Dept"].")</td>\n";
					$out .= "</tr>\n";					
				}
			$out .= "</table>\n";	
			$out .= "</div>\n";
		$out .= "</div>\n";
		$out .= "<script language='javascript'>\n";
			$out .= " $('#podh').click(function(){ $('#podb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";		
		$mdsDB->close();
		return $out;
	}
	
 	public function loadOpdLabOrderInfo()
	{ 
		include_once 'MDSLabOrder.php';
		include_once 'MDSLabOrderItems.php';
		include_once 'MDSLabTests.php';
		$out = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		//$sql=" SELECT LabOrderItems.LABID FROM LabOrder,LabOrderItems WHERE LabOrder.OBJID = '".$this->getId()."' AND LabOrderItems.LAB_ORDER_ID = LabOrder.LAB_ORDER_ID";
		$sql=" SELECT LAB_ORDER_ID FROM lab_order WHERE PID = '".$this->getId()."' ORDER BY OrderDate DESC";
		$result=$mdsDB->mysqlQuery($sql); 
		if ( !$result ) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		
		if ( $count == 0 ) return NULL;
        		$out  = "<div class='opdCont'>\n";
			$out .= "<div class='opdHead' id='polh'>".getPrompt("Lab orders")." </div>\n";
			$out .= "<div class='opdBody' id='polb'>\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='opdTbl'>\n";
			$i = 0;
        while($row = $mdsDB->mysqlFetchArray($result))  {
            $l_order = new MDSLabOrder();
				$l_order->openId($row["LAB_ORDER_ID"]);
            					$i++; //?page=opdPrescription&OPDID=4 view=1bda80f2be4d3658e0baa43fbe7ae8c1 edit=de95b43bceeb4b998aed4aed5cef1ae7
					$out .= "<tr  title='Open this entry'  onmouseover=changeOver(this); onmouseout=changeOut(this); onclick=reDirect('opdLabOrder','action=View&LABORDID=".$l_order->getId()."')>\n"; 
					$out .= "<td width=150>".$l_order->getValue("OrderDate")."</td><td>".$l_order->getValue("TestGroupName")."</td><td align='right'>By:".$l_order->getValue("OrderBy")." (".$l_order->getValue("Dept").")</td>\n";
					$out .= "</tr>\n";	
            }
        $out .= "</table>\n";	
		$out .= "</div>\n";
		$out .= "</div>\n";  
		$out .= "<script language='javascript'>\n";
			$out .= " $('#polh').click(function(){ $('#polb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";
  		return $out;
	}   
    
	public function getAge($ops=''){
		list ($yrs,$mths,$dys)= $this->dateDifference($this->getValue("DateOfBirth"),date('Y/m/d'));
		if ($ops == 'y') {
			return $yrs.'yrs';
		}
                elseif ($ops == 'ym') {
			return $yrs.'yrs'.$mths."mths ";                    
                }
                elseif ($ops == 'ymd') {
			return $yrs.'yrs'.$mths."mths ".$dys."dys";
                }
		else {
                    $age = "";
                    if ($yrs != 0 )  
                        $age .= $yrs."yrs ";
                    if ($mths != 0 ) 
                        $age .= $mths."mths ";
                    if ($dys != 0 )  
                        $age .= $dys."dys ";
                    return $age;
    		}
	}

	public function loadSummaryBar()
	{
		$out ="";
		$out .="<div class='summaryCont'><input type='button' class='summaryBtE' value='".getPrompt("Summary")."'>&nbsp;</div>\n";
		$out .="\n";
		return $out;
	}
	public function getHistoryJSON(){
		$json = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM patient_history WHERE ( PID = '".$this->getId()."' )  AND (Active=1) ORDER BY HistoryDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["PATHISTORYID"]) {
				$json[$i] = array("Date"=>$row["HistoryDate"], "Type" => $row["History_Type"], "Snomed" =>$row["SNOMED_Text"],"Remarks" =>$row["Remarks"]); 
				$i++;
			}
		}

		$mdsDB->close();	
		return $json;	
	}	
	public function getAllergyJSON(){
		$json = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM patient_alergy where ( PID ='".$this->getValue("PID")."' ) AND (Active=1)  ORDER BY Name"); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["ALERGYID"]) {
				$json[$i] = array("Date"=>$row["CreateDate"], "Type" => $row["Name"], "Snomed" =>$row["Status"],"Remarks" =>$row["Remarks"]); 
				$i++;
			}
		}

		$mdsDB->close();	
		return $json;	
	}	
	
	public function getVisitJSON(){
		$json = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM opd_visits where PID ='".$this->getValue("PID")."' ORDER BY DateTimeOfVisit DESC"); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["OPDID"]) {

				$json[$i] = array("Date"=>$row["DateTimeOfVisit"] , "Type" => $row["VisitType"], "Complaint" =>$row["Complaint"],"Remarks" =>$row["Remarks"],"OPDID"=>$row["OPDID"]); 
				$i++;
			}
		}

		$mdsDB->close();	
		return $json;	
	}		
	public function getAdmissionJSON(){
		$json = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT * FROM admission where PID ='".$this->getValue("PID")."' ORDER BY AdmissionDate DESC"); 
		if (!$result) { echo "ERROR getting Exam Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["ADMID"]) {

				$json[$i] = array("Date"=>$row["AdmissionDate"] , "Complaint" => $row["Complaint"], "Diagnosis" =>$row["Discharge_ICD_Text"],"Remarks" =>$row["Remarks"],"DischargeDate" =>$row["DischargeDate"]); 
				$i++;
			}
		}

		$mdsDB->close();	
		return $json;	
	}	
        
        public function dateDifference($startDate, $endDate) 
        { 
            
            $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
            
            $years = $months = $days = 0;
            /*
            //if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
              //  return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
            
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months <= 0)  { 
                $months += 12; 
                $years--; 
            } 
            if ( $years  < 0 ) $years = 0; 
            if ( $months < 0 ) $months = 0;
            if ( $months == 12 ) $months = 0;
            // Calculate the days 
                        $offsets = array(); 
                        if ($years > 0) 
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                        if ($months > 0) 
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDate - strtotime($offsets, $startDate); 
                        $days = date('z', $days);    
            if ( $days <  0 ) $days = 0;            
            if ( $days > 30 ) $days = 30;           
            $days ="";
            */
            $two = $startDate; $one = $endDate;
            $invert = false;
            if ($one > $two) {
                list($one, $two) = array($two, $one);
                $invert = true;
            }

            $key = array("y", "m", "d", "h", "i", "s");
            $a = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $one))));
            $b = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $two))));

            $result = array();
            $result["y"] = $b["y"] - $a["y"];
            $result["m"] = $b["m"] - $a["m"];
            $result["d"] = $b["d"] - $a["d"];
            $result["h"] = $b["h"] - $a["h"];
            $result["i"] = $b["i"] - $a["i"];
            $result["s"] = $b["s"] - $a["s"];
            $result["invert"] = $invert ? 1 : 0;
            $result["days"] = intval(abs(($one - $two)/86400));

            if ($invert) {
                _date_normalize(&$a, &$result);
            } else {
                _date_normalize(&$b, &$result);
            }

           
            return array($result["y"], $result["m"], $result["d"]); 
        } 
  
  
}
	
 function _date_range_limit($start, $end, $adj, $a, $b, $result)
{
    if ($result[$a] < $start) {
        $result[$b] -= intval(($start - $result[$a] - 1) / $adj) + 1;
        $result[$a] += $adj * intval(($start - $result[$a] - 1) / $adj + 1);
    }

    if ($result[$a] >= $end) {
        $result[$b] += intval($result[$a] / $adj);
        $result[$a] -= $adj * intval($result[$a] / $adj);
    }

    return $result;
}

function _date_range_limit_days($base, $result)
{
    $days_in_month_leap = array(31, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $days_in_month = array(31, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    _date_range_limit(1, 13, 12, "m", "y", &$base);

    $year = $base["y"];
    $month = $base["m"];

    if (!$result["invert"]) {
        while ($result["d"] < 0) {
            $month--;
            if ($month < 1) {
                $month += 12;
                $year--;
            }

            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;
        }
    } else {
        while ($result["d"] < 0) {
            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;

            $month++;
            if ($month > 12) {
                $month -= 12;
                $year++;
            }
        }
    }

    return $result;
}

function _date_normalize($base, $result)
{
    $result = _date_range_limit(0, 60, 60, "s", "i", $result);
    $result = _date_range_limit(0, 60, 60, "i", "h", $result);
    $result = _date_range_limit(0, 24, 24, "h", "d", $result);
    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    $result = _date_range_limit_days(&$base, &$result);

    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    return $result;
}     	
?>
