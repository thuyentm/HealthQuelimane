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
include_once 'MDSPatient.php';
include_once 'MDSIcd.php';
include_once 'MDSFinding.php';
include_once 'MDSPermission.php';
include_once 'MDSNotification.php';

class MDSAdmission extends MDSPersistent
{
	public $patient = NULL;
	public $isOpened = false;
	private $css_Cont_class =  " opdCont ";
	public function __construct() {
		parent::__construct("admission");
	}
	public function  openId($aid){
		parent::openId($aid);
                if (!$this->getId()){
                    die(diplayMessage('<br>Admission not found <br><input  class=\'formButton\' type=\'button\' value=\'Ok\' onclick=history.back();>','Error',300,100));
                    return NULL;
                }
		$this->patient = new MDSPatient();
		$this->patient->openId($this->getValue("PID"));
		//$this->isOpened = $this->patient->haveAnyOpenedAdmission();
		if ($this->getValue("DischargeDate") == "") $this->isOpened = true;
		else$this->isOpened = false;
		if ($this->isOpened) $this->css_Cont_class =  " opdCont ";
		else $this->css_Cont_class =  " opdContClose ";
	}

	public function getAdmitPatient(){
		return $this->patient;
	}
	public function getEpisodeDoctor(){
		include_once 'MDSUser.php';
		$doctor = new MDSUser();
		$doctor->openId($this->getValue("Doctor"));
		return $doctor->getFullName();
	}	
	public function getWard(){
		include_once 'MDSWard.php';
		$ward = new MDSWard();
		$ward->openId($this->getValue("Ward"));
		return $ward->getName();
	}
	public function opened(){
		if ($this->getValue("DischargeDate")==""){
			return true;
		}
		else {
			return false;
		}
	}
	private function checkTab($tag){
	 //if (!$this->isOpened) 
		//return " $('".$tag."').toggle('fast'); \n";
	}
	public function loadAdmission() {
		include_once 'MDSUser.php';
		
		if (!$this->Fields[$this->ObjField]) return NULL;
		$doctor = new MDSUser();
		
		$doctor->openId($this->getValue("Doctor"));
		
		//$icd = MDSIcd::GetInstance();
		//$icd->openCode($this->getValue("ICD_Code"));
		//$finding = MDSFinding::GetInstance();
		//$finding->openCode($this->getValue("SNOMED_Code"));
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_Edit"))
				$tools = "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=admission&ADMID=".$this->getValue("ADMID")."&action=Edit&PID=".$this->getAdmitPatient()->getId()."'>";
		//$tools .= "<img   src='images/add_note.jpg' style='cursor:pointer;' title='Add Notes' width=20 height=20  />";
		//$alert=$this->getValue("Alert");if($alert=="0")$alert="No";if($alert=="1")$alert="Yes";
		//$voice=$this->getValue("Voice");if($voice=="0")$voice="No";if($voice=="1")$voice="Yes";
		//$pain=$this->getValue("Pain");if($pain=="0")$pain="No";if($pain=="1")$pain="Yes";
		//$unr=$this->getValue("UNR");if($unr=="0")$unr="No";if($unr=="1")$unr="Yes";
		
		$out  = "<div class='".$this->css_Cont_class."' ><div class='opdHead' id='iadh'>".getPrompt("Initial admission details")."</div>\n";
			$out .= "<div class='opdBody' id ='iadb' >\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='intadmTbl'>\n";
					$out .= "<tr>\n"; 
					$out .= "<td style='height:25px'>".getPrompt("BHT")." : </td><td>".$this->getValue("BHT")."</td><td align=center>Date &amp; Time of Admission : ".$this->getValue("AdmissionDate")."</td><td>".getPrompt("Ward")." : <a target='_self' href='home.php?page=wardpatient&action=View&WID=".$this->getValue("Ward")."'>".$this->getWard()."</a></td><td align='right'>".$tools."</td>\n";
					$out .= "</tr>\n";					
					$out .= "<tr>\n"; 
					$out .= "<td style='height:25px'>".getPrompt("Complaints").": </td><td colspan=3>".$this->getValue("Complaint")."</td>\n";
					$out .= "</tr>\n";
					//$out .= "<tr>\n"; 
					//$out .= "<td style='height:25px'>".getPrompt("Weight")." : </td><td>".$this->getValue("Weight")."</td><td>Height : ".$this->getValue("Height")."</td><td>Sys_BP : ".$this->getValue("sys_BP")."</td><td>Diast_BP : ".$this->getValue("diast_BP")."</td><td>Temprature : ".$this->getValue("Temprature")."</td>\n";
					//$out .= "</tr>\n";
					//$out .= "<tr>\n"; 
					//$out .= "<td style='height:25px'>Pulse : ".$this->getValue("pulse")."</td><td>Saturation : ".$this->getValue("saturation")."</td><td>Respiratory : ".$this->getValue("respiratory")."</td><td>Alert : ".$alert."</td><td>Voice : ".$voice."</td><td>Pain : ".$pain."</td><td>UNR : ".$unr."</td>\n";
					//$out .= "</tr>\n";
					$out .= "<tr>\n"; 
					$out .= "<td colspan=2 style='height:25px'>".getPrompt("Remarks").": </td><td>".$this->getValue("Remarks")."</td><td colspan=2 align=right>";
					if ($this->getValue("LastUpDateUser")) {
						$out .= "<i>Last Access By : ".$this->getValue("LastUpDateUser")."(".$this->getValue("LastUpDate").")</i>";
					}
					else {
						$out .= "&nbsp;";
					}
					$out .= "</td>\n";
					$out .= "</tr>\n";	
			$out .= "</table>\n";	
			$out .= "</div>\n";
		$out .= "</div>\n"; 
		$out .= "<div class='notesCont'>\n"; 
		$out .= "</div>\n"; 	
		$out .= "<script language='javascript'>\n";
			$out .= " $('#iadh').click(function(){ $('#iadb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= $this->checkTab('#iadb');
			$out .= "\n";
		$out .= "</script>\n";
		
		return $out;
	}	
	public function loadDischarge() {
		include_once 'MDSUser.php';
		
		if (!$this->Fields[$this->ObjField]) return NULL;
		if ($this->opened()) return null;
		$doctor = new MDSUser();
		
		$doctor->openId($this->getValue("Doctor_Discharge"));
		
		//$icd = MDSIcd::GetInstance();
		//$icd->openCode($this->getValue("ICD_Code"));
		//$finding = MDSFinding::GetInstance();
		//$finding->openCode($this->getValue("SNOMED_Code"));
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_Edit"))
				$tools = "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=discharge&ADMID=".$this->getValue("ADMID")."&action=Edit&PID=".$this->getAdmitPatient()->getId()."'>";
		//$tools .= "<img   src='images/add_note.jpg' style='cursor:pointer;' title='Add Notes' width=20 height=20  />";
		
		$out  = "<div class='".$this->css_Cont_class."' ><div class='opdHead' id='addh'>".getPrompt("Discharge details")."</div>\n";
			$out .= "<div class='opdBody' id ='addb' >\n";
			$out .= "<table border=0  width=100% cellspacing=2   class='opdTbl'>\n";
					$out .= "<tr>\n"; 
					$out .= "<td  width=150>".getPrompt("Date of Discharge")." : </td><td colspan=4   >".$this->getValue("DischargeDate")."</td><td align=center></td><td></td><td></td><td align='right'>".$tools."</td>\n";
					$out .= "</tr>\n";					
					$out .= "<tr>\n"; 
					$out .= "<td >".getPrompt("Discharged By")." : </td><td colspan=4  >".$doctor->getFullName()."</td><td align='right'></td>\n";
					$out .= "</tr>\n";
					$out .= "<tr>\n"; 
					$out .= "<td valign=top  >".getPrompt("Discharge ICD10").": </td><td colspan=4  >".$this->getValue("Discharge_ICD_Text")."</td>\n";
					$out .= "</tr>\n";			
					$out .= "<tr>\n"; 
					$out .= "<td valign=top  >".getPrompt("Discharge SNOMED").": </td><td colspan=4  >".$this->getValue("Discharge_SNOMED_Text")."</td>\n";
					$out .= "</tr>\n";
					$out .= "<tr>\n"; 
					$out .= "<td valign=top  >".getPrompt("Discharge IMMR").": </td><td colspan=4  >".$this->getValue("Discharge_IMMR_Text")."</td>\n";
					$out .= "</tr>\n";					
					$out .= "<tr>\n"; 
					$out .= "<td valign=top  >".getPrompt("Out come").": </td><td colspan=4  >".$this->getValue("OutCome")."</td>\n";
					$out .= "</tr>\n";	
					$out .= "<tr>\n"; 
					$out .= "<td colspan=1  >".getPrompt("Remarks").": </td><td   >".$this->getValue("Discharge_Remarks")."</td><td colspan=2 align=right   >";
					if ($this->getValue("LastUpDateUser")) {
						$out .= "<i>Last Access By : ".$this->getValue("LastUpDateUser")."(".$this->getValue("LastUpDate").")</i>";
					}
					else {
						$out .= "&nbsp;";
					}
					$out .= "</td>\n";
					$out .= "</tr>\n";	
			$out .= "</table>\n";	
			$out .= "</div>\n";
		$out .= "</div>\n"; 
		$out .= "<div class='notesCont'>\n"; 
		$out .= "</div>\n"; 	
		$out .= "<script language='javascript'>\n";
			$out .= " $('#addh').click(function(){ $('#addb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= "\n";
		$out .= "</script>\n";
		
		return $out;
	}		
	public function loadLabOrders(){
		include_once 'MDSLabOrder.php';
		include_once 'MDSLabOrderItems.php';
		include_once 'MDSLabTests.php';
		$out = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		//$sql=" SELECT LabOrderItems.LABID FROM LabOrder,LabOrderItems WHERE LabOrder.OBJID = '".$this->getId()."' AND LabOrderItems.LAB_ORDER_ID = LabOrder.LAB_ORDER_ID";
		$sql=" SELECT LAB_ORDER_ID FROM lab_order WHERE (OBJID = '".$this->getId()."') AND (Dept = 'ADM') ORDER BY OrderDate DESC";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		
		if ($count == 0) return NULL;
		$out .= "<div class='".$this->css_Cont_class."'' ><div class='opdHead' id='aloh'> ".getPrompt("Lab Orders")."</div>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["LAB_ORDER_ID"]) {
				$l_order = new MDSLabOrder();
				$l_order->openId($row["LAB_ORDER_ID"]);
				$out .= "<div class='lab_Cont' id='alob'>\n";
					$out .= "<div class='lab_head_cont' title='Click to open or hide' id='lab_head' >";
					$out .= "<table class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%><tr>";
					$out .= "<td width=400 class='lab_head' n=".$l_order->getId()." >&nbsp;&nbsp;&nbsp;".$l_order->getValue("TestGroupName")."&nbsp;&nbsp;&nbsp;";
					$out .= "<span style='color:#7f7f7f;'>(".$l_order->getValue("OrderDate").")</span></td><td  class='lab_head' n=".$l_order->getId()." >&nbsp;&nbsp;&nbsp;";
					if ($l_order->getValue("Active") == 0) {
						$out .= "<span style='color:#f96b6b;'>Order Deleted by:".$l_order->getValue("LastUpDateUser")." on ".$l_order->getValue("LastUpDate")."</span> ";
						$out .="&nbsp;</td><td align=right>";
					}
					else {
						$out .= "<span style='color:#246c46;'>".$l_order->getValue("Status");
						$out .="&nbsp;&raquo;</span></td><td align=right width=10% >";
					}
					$tools = "<img   src='images/print-icon.png' style='cursor:pointer;' title='Print this' width=15 height=15 onclick=printLabTest('".$l_order->getId()."','ADMIN')>";
					$tools .= "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onclick=self.document.location='home.php?page=admLabOrder&action=Edit&LABORDID=".$l_order->getId()."&ADM=".$this->getId()."'>";
					$out .= $tools;
					$out .= "</td></tr></table></div>";
					if ($l_order->getValue("Active") == 0) continue;
					$out .= "<div class='lab_item' id='lab_item".$l_order->getId()."' >\n";
					$result1 = NULL;
					$mdsDB1 = MDSDataBase::GetInstance();
					$mdsDB1->connect();		
					$sql1 = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '".$l_order->getId()."'";	
					$result1=$mdsDB1->mysqlQuery($sql1);
					$out .= "<table class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>\n";	
					$out .= "<tr><td class='td_brd'>".getPrompt("Test")."</td><td class='td_brd'>".getPrompt("Value")."</td><td class='td_brd'>".getPrompt("Referance")."</td></tr>";
					while($row1 = $mdsDB1->mysqlFetchArray($result1))  {
						if ($row1["LAB_ORDER_ITEM_ID"]) {
							$l_test = new MDSLabTests();
							$l_item = new MDSLabOrderItems();
							$l_item->openId($row1["LAB_ORDER_ITEM_ID"]);
							$l_test->openId($row1["LABID"]);
							$out .= "<tr>";
							$out .= "<td valign=top class='lab_td'>".$l_test->getValue("Name")."</td>";
							$out .= "<td valign=top class='lab_td'>";
								if ($l_item->getValue("TestValue")) {
									$out .=$l_item->getValue("TestValue");	
								}
								else {
									$out .= getPrompt("Pending...");	
								}
							"</td>";
							$out .= "<td valign=top class='lab_td'>".$l_test->getValue("RefValue")."</td>";
							$out .= "</tr>";
						}
					}
					$out .= "</table>\n";	
					$out .= "</div>";
				$out .= "</div>";
				$mdsDB1->close();
			}
		}
		$out .= "</div>";
		$out .= "</div>";
		$out .= "<script language='javascript'>\n";
			$out .= " $('#aloh').click(function(){ $('#alob').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= " $('.lab_item').hide(); \n";
			$out .= " $('.lab_head').click(function(e){ \n";
			$out .= " $('#lab_item'+$(this).attr('n')).slideToggle('fast'); }); \n";
			$out .= $this->checkTab('#alob');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}
	public function loadDiagnosis(){
		//include_once 'MDSDiagnosis.php';
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM admission_diagnosis WHERE ADMID = '".$this->getId()."' ORDER BY DiagnosisDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_diagnosis_Edit")) 	$gotAccess=true;

		if ($count == 0) return NULL;
		$out  = "<div class='".$this->css_Cont_class."' > <div class='opdHead' id='adh1' > ".getPrompt("Diagnosis")." </div>\n";
		$out .= "<div class='lab_Cont' id='adb'>\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' >SNOMED</td>\n";
		$out .= "<td class='td_brd' width=450 colspan=2>ICD</td>\n";
		$out .= "</tr>\n";
                
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["ADMDIAGNOSISID"]) {
				$tools ="";
                                $nid = 0;
				$dis_dte = date_parse($row["DiagnosisDate"]);
				$icd = MDSIcd::GetInstance();
				$icd->openCode($row["ICD_Code"]);
				if ($icd->isNotify()) {
                                        $notification = MDSNotification::GetInstance();
                                        $nid = $notification->check($this->getValue("ADMID"),$icd->getValue("Name"));
                                        if ($nid == 0 ){
        					$tools .= "<img src='images/notification.png' style='cursor:pointer;' title='Create a notification' width=15 height=15 onclick=self.document.location='home.php?page=notification&TYPE=admission&EPISODEID=".$this->getValue("ADMID")."&action=New&ADMDIAGNOSISID=".$row["ADMDIAGNOSISID"]."&DISEASE=".urlencode($icd->getValue("Name"))."'>&nbsp;&nbsp;\n";
                                        }
                                        else{
                                                $tools .= "<img src='images/notification.png' style='cursor:pointer;' title='Create a notification' width=15 height=15 onclick=self.document.location='home.php?page=notification&action=Edit&NOTIFICATION_ID=".$nid."&EPISODEID=".$this->getValue("ADMID")."'>&nbsp;&nbsp;\n";
                                        }
				}
				if ($row["Main"]==1) {
					$tools .="<img   src='images/main.png'  title='Main diagnosis' >&nbsp;&nbsp;";
				}
				else {
					if ($row["Active"] ==1)
					$tools .="<img   src='images/notmain.png'  title='Set as main diagnosis'  style='cursor:pointer;' onclick=makeItMainAjax('".$row["ADMDIAGNOSISID"]."','".$this->getId()."')>&nbsp;&nbsp;";
				}
				
				if ($gotAccess) 
						$tools .= "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record' onclick=self.document.location='home.php?page=admission_diagnosis&ADMID=".$this->getValue("ADMID")."&action=Edit&PID=".$this->getAdmitPatient()->getId()."&ADMDIAGNOSISID=".$row["ADMDIAGNOSISID"]."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .=getMDSDate($dis_dte);
				if ($row["Main"]==1) $out .="<b style='color:#FF0000;font-size:14px;'>&raquo;&nbsp;";
				$out .= "</td>\n";
				$out .= "<td>".$row["SNOMED_Text"]."</td>\n";
				$out .= "<td>".$icd->displayICD()."</td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= " $('#adh1').click(function(){ $('#adb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= $this->checkTab('#adb');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}	
	public function loadProcedures(){
		//include_once 'MDSDiagnosis.php';
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM admission_procedures WHERE ADMID = '".$this->getId()."' ORDER BY ProcedureDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Procedure Items"; return null; }

		$count = $mdsDB->getRowsNum($result);
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_procedures_Edit")) 	$gotAccess=true;

		if ($count == 0) return NULL;
		$out .= "<div class='".$this->css_Cont_class."'' ><div class='opdHead' id='adph'>".$this->getIcon()."".getPrompt("Procedures")."</div>\n";
		$out .= "<div class='lab_Cont' id='adpb'>\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' >Procedure</td>\n";
		$out .= "<td class='td_brd' width=450 colspan=2>Remarks</td>\n";
		$out .= "</tr>\n";

		while($row = $mdsDB->mysqlFetchArray($result))  {

			if ($row["ADMDPROCEDUREID"]) {	
				$tools ="";
				$dis_dte = date_parse($row["ProcedureDate"]);

				if ($gotAccess) 
						$tools = "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=admission_procedures&ADMID=".$this->getValue("ADMID")."&action=Edit&ADMDPROCEDUREID=".$row["ADMDPROCEDUREID"]."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .=getMDSDate($dis_dte);
				$out .= "</td>\n";
				$out .= "<td>".$row["SNOMED_Text"]."</td>\n";
				$out .= "<td>".$row["Remarks"]."</td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= "  $('#adph').click(function(){ $('#adpb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= $this->checkTab('#adpb');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}	
	public function loadNotes(){
		//include_once 'MDSDiagnosis.php';
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM admission_notes WHERE ADMID = '".$this->getId()."' ORDER BY CreateDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Procedure Items"; return null; }

		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_notes_Edit")) 	$gotAccess=true;

		
		$out .= "<div class='".$this->css_Cont_class."'' ><div class='opdHead' id='adnh'>".$this->getIcon()."".getPrompt("Notes")."</div>\n";
		$out .= "<div class='lab_Cont' id='adnb'>\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd'  colspan=2>Note</td>\n";
		$out .= "</tr>\n";

		while($row = $mdsDB->mysqlFetchArray($result))  {

			if ($row["ADMNOTEID"]) {	
				$tools ="";
				$note_dte = date_parse($row["CreateDate"]);

				if ($gotAccess) 
						$tools = "<img   src='images/edit-icon.png' width=15 height=15 style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=admission_notes&ADMID=".$this->getValue("ADMID")."&action=Edit&ADMNOTEID=".$row["ADMNOTEID"]."&PID=".$this->getAdmitPatient()->getId()."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .=getMDSDate($note_dte);
				$out .= "</td>\n";
				$out .= "<td>".$row["Note"]."</td>\n";
                                $out .= "<td align=right>".$row["CreateUser"]."</td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= "  $('#adnh').click(function(){ $('#adnb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= $this->checkTab('#adpb');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}		
	public function loadPrescriptionItems(){
		include_once 'MDSPrescription.php';
	
		$prscription = new MDSPrescription();
		$prs = $prscription->getPrescription('ADM',$this->getId());
		if ($prs == "") return null;
		$prscription->openId($prs);
		if ($prscription->getValue("Active") == false) return "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql="
		SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong,prescribe_items.Quantity,prescribe_items.Status,prescribe_items.Frequency FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '".$prs."'  ";
		$result=$mdsDB->mysqlQuery($sql); 

		if (!$result) return null;
		

		$out = "";
		$i=0;	
		$tools = "<img   src='images/edit-icon.png'  width=15 height=15 style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=admPrescription&ADMID=".$this->getId()."&action=Edit'>";
		$out .= "<div class='".$this->css_Cont_class."' ><div class='opdHead' id='oph'>".getPrompt("Prescription")."</div>\n";//page=admPrescription&ADMID=7987&action=Edit
		$out .= "<table class='PrescriptionInfo' width=100% border=0 cellpadding=0>";
			$out .= "<tr><td class='td_brd'>#</td>\n";
			$out .= "<td class='td_brd'>".getPrompt("Drugs Prescribed")."</td>\n";
			$out .= "<td class='td_brd'>".getPrompt("Dosage")."</td>\n";
                        $out .= "<td class='td_brd'>".getPrompt("Frequency")."</td>\n";
			$out .= "<td class='td_brd'>".getPrompt("Period")."</td>\n";
			$out .= "<td class='td_brd'></td>\n";
			$out .= "<td  class='td_brd' align=right>".$tools."</td><tr>";
		while($row = mysql_fetch_array($result))  {
			$out .= "<tr><td>".++$i."</td>\n";
			$out .= "<td>".$row["Name"]."</td>\n";
			$out .= "<td>".$row["Dosage"]."</td>\n";
                        $out .= "<td>".$row["Frequency"]."</td>\n";
			$out .= "<td>".$row["HowLong"]."</td>\n";
			if ($row["Quantity"] > 0) {
				$out .= "<td  class='td_brd' align=right>".$row["Quantity"]."</td>\n";
			}		
			$out .= "<td></td><tr>";
			//<input type='button' value='Remove'  onclick=removeItem(".$PRS_ITEM_ID."); />
		}
		$out .= "</table>";
		$out .= "</div>";

		return $out;

	}        
	private function getIcon($cont){
		//return "<img id='".$cont."img' src='images/expanded.gif' >";
	}
}

?>