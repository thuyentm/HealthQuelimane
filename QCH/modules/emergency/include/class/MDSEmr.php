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
include_once 'MDSComplaint.php';
include_once 'MDSFinding.php';
include_once 'MDSPermission.php';
include_once 'MDSNotification.php';


class MDSEmr extends MDSPersistent
{
	public $patient = NULL;
	public $isOpened = false;
	private $css_Cont_class =  "opdCont";
	
	public function __construct() {
		parent::__construct("Emergency_Admission");
	}
	public function  openId($pid){
		parent::openId($pid);
		$this->patient = new MDSPatient();
		$this->patient->openId($this->getValue("PID"));
		if ($this->isOneDayOld() >= 1 ) $this->isOpened = false;
		else $this->isOpened = true;
		
		if ($this->isOpened) $this->css_Cont_class =  "opdCont";
		else $this->css_Cont_class =  " opdContClose";
	}	
	private function isOneDayOld(){

		 // First we need to break these dates into their constituent parts:
			$gd_a = getdate(  strtotime($this->getValue("DateTimeOfVisit")));
			$gd_b = getdate(  strtotime(date('Y/m/d')) );

			// Now recreate these timestamps, based upon noon on each day
			// The specific time doesn't matter but it must be the same each day
			$a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
			$b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );

			// Subtract these two numbers and divide by the number of seconds in a
			//  day. Round the result since crossing over a daylight savings time
			//  barrier will cause this time to be off by an hour or two.
				
		return  round( abs( $a_new - $b_new ) / 86400 ) ;
	}
	public function getOpdPatient(){
		$this->patient = new MDSPatient();
		$this->patient->openId($this->getValue("PID"));
		return $this->patient;
	}
	public function getOPDDoctor(){
		include_once 'MDSUser.php';
		$doctor = new MDSUser();
		$doctor->openId($this->getValue("Doctor"));
		return $doctor->getFullName();
	}
	public function getEpisodeDoctor(){
		include_once 'MDSUser.php';
		$doctor = new MDSUser();
		$doctor->openId($this->getValue("Doctor"));
		return $doctor->getFullName();
	}	
	public function loadEmr() {
		include_once 'MDSUser.php';
		
		//if (!$this->Fields[$this->ObjField]) return NULL;
		$doctor = new MDSUser();
		
		//$doctor->openId($this->getValue("Doctor"));
		
		//$icd = MDSIcd::GetInstance();
		//$icd->openCode($this->getValue("ICD_Code"));
		//$finding = MDSFinding::GetInstance();
		//$finding->openCode($this->getValue("SNOMED_Code"));
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"admission_Edit"))
				$tools = "<img   src='images/edit-icon.png' width=15 height=15  style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=pcu&PCUID=".$this->getValue("PCUID")."&action=Edit&PID=".$this->getOpdPatient()->getId()."'>";
		//$tools .= "<img   src='images/add_note.jpg' style='cursor:pointer;' title='Add Notes' width=20 height=20  />";
		$alert=$this->getValue("Alert");if($alert=="0")$alert="No";if($alert=="1")$alert="Yes";
		$voice=$this->getValue("Voice");if($voice=="0")$voice="No";if($voice=="1")$voice="Yes";
		$pain=$this->getValue("Pain");if($pain=="0")$pain="No";if($pain=="1")$pain="Yes";
		$unr=$this->getValue("UNR");if($unr=="0")$unr="No";if($unr=="1")$unr="Yes";
		
		$out  = "<div class='".$this->css_Cont_class."' ><div class='opdHead' id='iadh'>".getPrompt("Initial Triage details")."</div>\n";
			$out .= "<div class='opdBody' id ='iadb' >\n";
			$out .= "<table border=0 width=100% cellspacing=0   class='intadmTbl'>\n";
					$out .= "<tr>\n"; 
					$out .= "<td>Triage Category : ".$this->getValue("Status")."</td>\n";
					$out .= "</tr>\n";
					$out .= "<tr>\n"; 
					$out .= "<td style='height:25px'>".getPrompt("Weight")." : </td><td>".$this->getValue("Weight")."</td><td>Height : ".$this->getValue("Height")."</td><td>Sys_BP : ".$this->getValue("sys_BP")."</td><td>Diast_BP : ".$this->getValue("diast_BP")."</td><td>Temprature : ".$this->getValue("Temprature")."</td><td align='right'>".$tools."</td>\n";
					$out .= "</tr>\n";
					$out .= "<tr>\n"; 
					$out .= "<td style='height:25px'>Pulse : ".$this->getValue("Pulse")."</td><td>Saturation : ".$this->getValue("Saturation")."</td><td>Respiratory : ".$this->getValue("Respiratory")."</td><td>Alert : ".$alert."</td><td>Voice : ".$voice."</td><td>Pain : ".$pain."</td><td>UNR : ".$unr."</td>\n";
					$out .= "</tr>\n";
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
			//$out .= $this->checkTab('#iadb');
			$out .= "\n";
		$out .= "</script>\n"; 
		
		return $out;
	}
	
	
	
	public function getLabOrders(){
		include_once 'MDSLabOrder.php';
		include_once 'MDSLabOrderItems.php';
		include_once 'MDSLabTests.php';
		$out = "";
		$count = 0;
		$i = 0;
		$json = array();
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		//$sql=" SELECT LabOrderItems.LABID FROM LabOrder,LabOrderItems WHERE LabOrder.OBJID = '".$this->getId()."' AND LabOrderItems.LAB_ORDER_ID = LabOrder.LAB_ORDER_ID";
		$sql=" SELECT LAB_ORDER_ID FROM lab_order WHERE (OBJID = '".$this->getId()."') AND (Dept = 'OPD') ORDER BY OrderDate DESC";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		
		if ($count == 0) return NULL;	
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["LAB_ORDER_ID"]) {
				$l_order = new MDSLabOrder();
				$l_order->openId($row["LAB_ORDER_ID"]);
					$result1 = NULL;
					$mdsDB1 = MDSDataBase::GetInstance();
					$mdsDB1->connect();		
					$sql1 = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '".$l_order->getId()."'";	
					$result1=$mdsDB1->mysqlQuery($sql1);
					while($row1 = $mdsDB1->mysqlFetchArray($result1))  {
						if ($row1["LAB_ORDER_ITEM_ID"]) {
							$l_test = new MDSLabTests();
							$l_item = new MDSLabOrderItems();
							$l_item->openId($row1["LAB_ORDER_ITEM_ID"]);
							$l_test->openId($row1["LABID"]);
							$json[$i] = array("test"=>$l_test -> getValue("Name"), "value" => $l_item->getValue("TestValue"), "ref" =>$l_test->getValue("RefValue") ); 
							$i++;
						}
					}			
			}
		}	
		$mdsDB1->close();	
		$mdsDB->close();	
		return $json ;
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
		$sql=" SELECT LAB_ORDER_ID FROM lab_order WHERE OBJID = '".$this->getId()."' ORDER BY OrderDate DESC";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		
		if ($count == 0) return NULL;
		$out .= "<div class='".$this->css_Cont_class."'><div class='opdHead' id='oloh'>".getPrompt("Lab Orders")."</div>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["LAB_ORDER_ID"]) {
				$l_order = new MDSLabOrder();
				$l_order->openId($row["LAB_ORDER_ID"]);
				$out .= "<div class='lab_Cont' id='olob'>\n";
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
					$tools = "<img   src='images/print-icon.png' style='cursor:pointer;' title='Print this' width=15 height=15 onclick=printLabTest('".$l_order->getId()."','OPD')>";
					$tools .= "<img   src='images/edit-icon.png' style='cursor:pointer;' title='Edit record' width=15 height=15 onclick=self.document.location='home.php?page=opdLabOrder&action=Edit&LABORDID=".$l_order->getId()."&OPDID=".$this->getId()."'>";
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
		
		$out .= "<script language='javascript'>\n";
		$out .= " $('#oloh').click(function(){ $('#olob').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			$out .= " $('.lab_item').hide(); \n";
			$out .= " $('.lab_head').click(function(e){ \n";
			$out .= " $('#lab_item'+$(this).attr('n')).slideToggle('fast'); }); \n";
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}
	
	public function loadPrescriptionItems(){
		include_once 'MDSPrescription.php';
	
		$prscription = new MDSPrescription();
		$prs = $prscription->getPrescription('OPD',$this->getId());
		if ($prs == "") return null;
		$prscription->openId($prs);
		if ($prscription->getValue("Active") == false) return "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql="
		SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong,prescribe_items.Quantity,prescribe_items.Status,prescribe_items.Frequency FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '".$prs."' ";
		$result=$mdsDB->mysqlQuery($sql); 

		if (!$result) return null;
		

		$out = "";
		$i=0;	
		$tools = "<img   src='images/edit-icon.png'  width=15 height=15  style='cursor:pointer;' title='Edit record'  onclick=self.document.location='home.php?page=opdPrescription&OPDID=".$this->getId()."&action=Edit'>";
		$out .= "<div class='".$this->css_Cont_class."' ><div class='opdHead' id='oph'>".getPrompt("Prescriptions")."</div>\n";
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
	
	public function loadTreatments($ops=''){
		$out = "";
		$count = 0;
		$gotAccess=false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM opd_treatment WHERE OPDID = '".$this->getId()."' ORDER BY CreateDate DESC ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		$mdsPermission = MDSPermission::GetInstance();
		if ($mdsPermission->haveAccess($_SESSION["UGID"],"opd_treatment_Edit")) 	$gotAccess=true;

		if ($count == 0) return NULL;
		$out .= "<div class='".$this->css_Cont_class."'' ><div class='opdHead' id='oth'> ".getPrompt("Treatments")."</div>\n";
		$out .= "<div class='lab_Cont' id='otb'>\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' width=300>Treatment</td>\n";
		$out .= "<td class='td_brd' width=200>Remarks</td>\n";
		$out .= "<td class='td_brd'  colspan=2>Status</td>\n";
		$out .= "</tr>\n";

		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["OPDTREATMENTID"]) {
				$tools ="";
				$treat_dte = date_parse($row["CreateDate"]);
				
				if ($gotAccess) 
						$tools .= "<img   src='images/edit-icon.png'  width=15 height=15  style='cursor:pointer;' title='Edit record' onclick=self.document.location='home.php?page=opd_treatment&OPDID=".$this->getID()."&action=Edit&PID=".$this->getOPDPatient()->getId()."&OPDTREATMENTID=".$row["OPDTREATMENTID"]."'>";

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .=getMDSDate($treat_dte);
				$out .= "</td>\n";
				$out .= "<td>".$row["Treatment"]."</td>\n";
				$out .= "<td>".$row["Remarks"]."</td>\n";
				$out .= "<td>".$row["Status"]."</td>\n";
				$out .= "<td align=right>".$tools."</td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			//$out .= " $('#oth').click(function(){ $('#otb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			//$out .= $this->checkTab('#adb');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}	
  	public function loadQuetionnaire($ops=''){
		$out = "";
		$count = 0;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();	//QUES_ST_ID	
		$sql=" SELECT questionnaire.QUES_ID,questionnaire.Date,questionnaire.Active,quest_struct.Name,quest_struct.Remarks 
                    FROM questionnaire,quest_struct 
                    WHERE ( questionnaire.Type = 'opd_visit' ) 
                    AND (questionnaire.Active=1) 
                    AND (questionnaire.QUES_ST_ID = quest_struct.QUES_ST_ID ) 
                    AND (questionnaire.OBID ='".$this->getId()."') ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$out .= "<div class='".$this->css_Cont_class."'' ><div class='opdHead' id='oqh'> ".getPrompt("Questionnaire")."</div>\n";
		$out .= "<div class='lab_Cont' id='oqb'>\n";
		$out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>";
		$out .= "<tr>\n";
		$out .= "<td class='td_brd' width=80 >Date</td>\n";
		$out .= "<td class='td_brd' width=300>Questionnaire</td>\n";
		$out .= "<td class='td_brd' width=200>Remarks</td>\n";
                $out .= "<td class='td_brd' width=200></td>\n";
		$out .= "</tr>\n";

		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["QUES_ID"]) {

				$out .= "<tr";
				if ($row["Active"] ==0) $out .=" style='text-decoration: line-through;' \n";
				$out .=" >\n";
				$out .= "<td>";
				$out .=getMDSDate(date_parse($row["Date"]));
				$out .= "</td>\n";
				$out .= "<td>".$row["Name"]."</td>\n";
				$out .= "<td>".$row["Remarks"]."</td>\n";
				$out .= "<td align='right'><input type='button' value='View' onclick=qopen('include/questionnaire_view.php?QUES_ID=".$row["QUES_ID"]."') class='formButton'></td>\n";
				$out .= "</tr>\n";
			}
		}
		$out .= "</table>\n";	
		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "<script language='javascript'>\n";
			$out .= " $('#oqh').click(function(){ $('#oqb').toggle('fast'); }).css({'cursor':'pointer'}); \n";
			//$out .= $this->checkTab('#adb');
			$out .= "\n";
		$out .= "</script>\n";
		$mdsDB->close();
		return $out;
	}	      
 	public function getQuestionnaires(){
 		$out = "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT * FROM quest_struct WHERE ( VisitType = '".$this->getValue("VisitType")."' )  AND (Active=1) AND (Type ='opd_visit') ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting questionnaire Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$i = 0;
		while($row = $mdsDB->mysqlFetchArray($result))  {
                    $out .="<input type='button' class='submenuBtn' value='".$row["Name"]."' onclick=self.document.location='home.php?page=questionnaire&mod=datanew&QUES_ST_ID=".$row["QUES_ST_ID"]."&Type=".$row["Type"]."&OBID=".$this->getId()."&PID=".$this->getValue("PID")."&RETURN='+encodeURIComponent(self.document.location)+''  >\n";
                
                }           
                return $out;
        }       
        
	public function getPrescriptionItemsJSON(){
		include_once 'MDSPrescription.php';
	
		$prscription = new MDSPrescription();
		$prs = $prscription->getPrescription('OPD',$this->getId());
		if ($prs == "") return null;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql="
		SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong,prescribe_items.Frequency,prescribe_items.Quantity,prescribe_items.Status FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '".$prs."' ";
		$result=$mdsDB->mysqlQuery($sql); 

		if (!$result) return null;
		$json = array();
		$i=0;	
		while($row = mysql_fetch_array($result))  {
			$json[$i] =  array( "Name" => $row["Name"], "Dosage" => $row["Dosage"],"Frequency" => $row["Frequency"], "HowLong" => $row["HowLong"] );
			$i++;
		}
		$mdsDB->close();
		return $json;
	}
	public function getAlergy(){
		return $this->getOpdPatient()->getAlergy();
	}
        public function checkNotification(){
            $complaint = MDSComplaint::GetInstance();
            $notification = MDSNotification::GetInstance();
            $nid = $notification->check($this->getValue("OPDID"),$this->getValue("Complaint"));
            if ($nid > 0) return;
                if ($complaint->isNotify($this->getValue("Complaint"))== 1)
                {   
                    $msg = "";
                    $msg .= "<table width=100% style='font-size:10px;'><tr><td colspan=2 align=center style='color:#FF0000;'>Alert!<hr></td></tr>";
                    $msg .= "<tr>";
                    $msg .= "<td  width=5%>Complaint:</td>";
                    $msg .= "<td  ><textarea disabled rows=4>".$this->getValue("Complaint")."</textarea></td>";
                    $msg .= "</tr>";
                    $msg .= "<tr><td colspan=2 >Do you want to notify this?</td></tr>";
                    $msg .= "<tr><td colspan=2 align=center><a href='home.php?page=notification&TYPE=opd&EPISODEID=".$this->getValue("OPDID")."&action=New&OPDID=".$this->getValue("OPDID")."&DISEASE=".urlencode($this->getValue("Complaint"))."&RETURN=".urlencode("home.php?page=opd&OPDID=".$this->getValue("OPDID")."&action=View")."'>Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:$(n_pop).remove();'>Cancel</a></td></tr>";
                    $msg .= "</table>";
                        echo "<div id='n_pop' class='nPop' style='padding:10px;border:1px solid #ff0000;background-color:#fff4f4;z-index:9999999;position:absolute;top:0px;left:50%;width:300px;margin-left:-100px;height:150px;max-height:300px;' >$msg</div>";
                }    
        }
	/*
	private function getPrescription($opdid){
		mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
		mysql_select_db(DB) or die("cannot select DB");
		$sql="SELECT PRSID FROM OPDPresciption where OPDID = ".$opdid."";	
		$result = mysql_query($sql);
		if (!$result) return null;
		$count=mysql_num_rows($result);
		if ($count == 1 ) {
				$row = mysql_fetch_array($result) or die(mysql_error());
				return $row["PRSID"];
		}
		else {
			return null;
		}
	}
	*/
}

?>
