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
include_once 'MDSLabOrderItems.php';
include_once 'MDSLabTests.php';


class MDSLabOrder extends MDSPersistent
{
	public $LabItem = array();
	
	public function __construct() {
		parent::__construct("lab_order");
	}
	
	public function addItem($lid){
		array_push($this->LabItem,$lid);
	}
	public function createOrder(){
		$id = NULL;
		$id = $this->Save("rId");
		if (!$id) return -1;
		for ( $i = 0 ; $i < count($this->LabItem); ++$i) {
			if ($this->LabItem[$i]) { 
				$test = new MDSLabTests();
				$test->openId($this->LabItem[$i]);
				$l_item = new MDSLabOrderItems();
				$l_item->setValue("LAB_ORDER_ID", $id);
				$l_item->setValue("LABID", $test->getId());
				$l_item->setValue("TestValue","");
				$l_item->setValue("Active",1);
				$l_item->setValue("Status","Pending");
				$l_item->Save();
			}
		}
		
		return $id;
	}
	
	public function prepair($episode,$pat,$type){
		if (!$this->Fields[$this->ObjField]) return NULL;
		$this->setValue("Dept",$type);
		$this->setValue("OBJID",$episode->getId());
		$this->setValue("PID",$pat->getId());
		$this->setValue("OrderDate",date("Y-m-d H:i:s"));
		$this->setValue("OrderBy",$_SESSION["FirstName"]." ".$_SESSION["OtherName"]);
		$this->setValue("Status","Pending");
		$this->setValue("CreateDate",date("Y-m-d H:i:s"));
		$this->setValue("Active",1);
		$this->setValue("CreateUser",$_SESSION["FirstName"]." ".$_SESSION["OtherName"]);	
	}
	
	public function getEpisode(){
		if ($this->getValue("Dept") == "OPD") {
			if ( $this->getValue("OBJID") ) {
				include_once "MDSOpd.php";
				$opd = new MDSOpd();
				$opd->openId($this->getValue("OBJID")); 
				return $opd;
			}
		}
		else if ($this->getValue("Dept") == "ADM") {
			if ( $this->getValue("OBJID") ) {
				include_once "MDSAdmission.php";
				$admission = new MDSAdmission();
				$admission->openId($this->getValue("OBJID")); 
				return $admission;
			}
		}
		return NULL;
	}
	
	public function getLabDataJSON(){
		include_once 'MDSLabTests.php';
		include_once 'MDSLabOrderItems.php';
		include_once 'MDSDatabase.php';
		$json = array();
		$i = 0;
		$result1 = NULL;
		$mdsDB1 = MDSDataBase::GetInstance();
		$mdsDB1->connect();		
		$sql1 = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '".$this->getId()."'";	
		$result1=$mdsDB1->mysqlQuery($sql1);

		while($row1 = $mdsDB1->mysqlFetchArray($result1))  {
			if ($row1["LAB_ORDER_ITEM_ID"]) {
				$l_test = new MDSLabTests();
				$l_item = new MDSLabOrderItems();
				$l_item->openId($row1["LAB_ORDER_ITEM_ID"]);
				$l_test->openId($row1["LABID"]);
				$json[$i] = array("test"=>$l_test -> getValue("Name"), "value" => $l_item->getValue("TestValue"), "ref" => htmlspecialchars_decode($l_test->getValue("RefValue"))); 
				$i++;
			}
		}
		$mdsDB1->close();	
		return $json;	
	}
	
	public function renderForm($episode,$pat,$type){
		$out = "";
		$out .= "<div id='formCont' class='formCont'>\n";
		$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("Lab Order")."</div>";
		$out .= "<div class='prescriptionInfo'>\n";
		$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Hospital")." : </td><td>Base Hospital - Avissawella</td>"; 
		$out .= "<td nowrap>".getPrompt("Order ID")." : </td><td nowrap></td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Ordering By").": </td><td >".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]."</td>"; 
		$out .= "<td>".getPrompt("Test Date")." : </td><td nowrap><input id='OrderDate' value='".date("Y-m-d")."'></td>"; 
                
		$out .= "</tr>";
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Patient").": </td><td>".$pat->getFullName()." (".$pat->getId().") </td>"; 
		$out .= "<td nowrap>".getPrompt("Sex")."/".getPrompt("Age")." : </td><td nowrap>".$pat->getValue("Gender")."&nbsp;/&nbsp;".$pat->getAge()."</td>"; 
		$out .= "</tr>";
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Complaints")." / ".getPrompt("Injuries").": </td><td>".$episode->getValue("Complaint")."</td>"; 
		$out .= "<td nowrap>".getPrompt("Doctor")." : </td><td nowrap>".$episode->getEpisodeDoctor()."</td>"; 
		$out .= "</tr>";
		if ($type == "ADM") {
			$out .= "<tr>";
			$out .= "<td>".getPrompt("BHT")." : </td><td>".$episode->getValue("BHT")."</td>"; 
			$out .= "<td nowrap>".getPrompt("Ward")." : </td><td nowrap>".$episode->getWard()."</td>"; 
			$out .= "</tr>";
		}
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Priority").": </td><td><select id='Priority' name='Priority' class='input'><option value='Normal'>Normal</option><option value='Urgent'>Urgent</option></select></td>"; 
		$out .= "<td nowrap>".getPrompt("Test")." : </td><td nowrap>".$this->loadLabTest()."</td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td colspan=4 ><div id='lab' style='background:#FFFFFF;'></div></td>"; 
		$out .= "</tr>";
		$out .= "<tr id='dcont'>";
		$out .= "<td >".getPrompt("Sample collection Date")." : </td><td><input type=text readonly id='dd' class='input' style='width:100;' />".$this->timePicker("CollectionDateTime","00","00")."</td>"; 
		$out .= "<td nowrap><input type=hidden  id='CollectionDateTime' class='input' style='width:100;' /></td><td nowrap></td>"; 
		$out .= "</tr>";	
		$out .= "</table>\n";
		$out .= "<div align=center><input id='okBtn' type='button'  class='formButton' value='Create Order' onclick='saveData();'>\n ";
		if ($type == "OPD") {
			$out .= "<input id='okBtn' type='button' value='Cancel'  class='formButton' onclick=self.document.location='home.php?page=opd&action=View&OPDID=".$episode->getId()."'>\n ";
		}
		else if ($type == "ADM") {
			$out .= "<input id='okBtn' type='button' value='Cancel'  class='formButton' onclick=self.document.location='home.php?page=admission&action=View&ADMID=".$episode->getId()."'>\n ";
		}
		//$out .= "<input type='button' value='Cancel'  onclick=self.document.location='home.php?page=patient&PID=".$pat["PID"]."'><div>\n ";
		$out .= "</div>\n";
		$out .= "</div>\n ";	
		return $out;
	}
	private function loadLabTest(){
		$out = "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT DISTINCT GroupName FROM lab_tests where Active = true ORDER BY GroupName";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) return "Error";
		$out .= "<select id='labTest' name='labTest' class='input' onchange=callAjax('addLabTest',this.value,'lab');><div id='ljs'></div>\n";
		$out .="<option value=''>Select</option>\n";
		while($row = mysql_fetch_array($result))  {		
			$out .="<option value='".$row["GroupName"]."'>".$row["GroupName"]."</option>\n";
		}
		$out .= "</select>";
		$mdsDB->close();
		return $out;
	}
	private function timePicker($cont,$h,$m){
		$out = "";
		$HH = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		$MM = array('00','05','10','15','20','25','30','35','40','45','50','55');
		$out .= "&nbsp;Time : <select id='hh' name='hh' class='input' style='width:60;' onchange=updateDateTime('".$cont."');>\n";
		$out .="<option value=''></option>\n";
		for ( $hh=0 ; $hh <count($HH) ; ++$hh ) {
			if ($h == $HH[$hh]) {
				$out .="<option value='".$HH[$hh]."' selected>".$HH[$hh]."</option>\n";
			}
			else {
				$out .="<option value='".$HH[$hh]."'>".$HH[$hh]."</option>\n";
			}
		}
		$out .= "</select> HH : ";
		$out .= "<select id='mm' name='mm' class='input' style='width:60;' onchange=updateDateTime('".$cont."');>\n";	
		$out .="<option value=''></option>\n";
		for ( $mm=0 ; $mm <count($MM) ; ++$mm ) {
			if ($m == $MM[$mm]) {
				$out .="<option value='".$MM[$mm]."' selected>".$MM[$mm]."</option>\n";
			}
			else {
			$out .="<option value='".$MM[$mm]."'>".$MM[$mm]."</option>\n";
			}
		}
		$out .= "</select> MM ";
		return $out;
	}
	public function renderFormEdit($episode,$pat,$type){
		$out = "";
		$out .= "<div id='formCont' class='formCont' style='left:5px;' >\n";
		$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("Lab Order")."</div>";
		$out .= "<div class='prescriptionInfo'>\n";
		$out .= "<table border=0 width=100% class='PrescriptionInfo'>\n";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Hospital").": </td><td>".$_SESSION["Hospital"]."</td>"; 
		$out .= "<td nowrap>".getPrompt("Order ID")." : </td><td nowrap>".$this->getId()."</td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Ordering By").": </td><td >".$this->getValue("OrderBy")."</td>"; 
		$out .= "<td>".getPrompt("Test date")." : </td><td nowrap>".$this->getValue("OrderDate")."</td>"; 
		$out .= "</tr>";
		//$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Patient").": </td><td>".$pat->getFullName()." (".$pat->getId().") </td>"; 
		$out .= "<td nowrap>".getPrompt("Sex")."/".getPrompt("Age")." : </td><td nowrap>".$pat->getAge()."</td>"; 
		$out .= "</tr>";
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		if ($type == "ADM") {
			$out .= "<tr>";
			$out .= "<td>".getPrompt("BHT")." : </td><td>".$episode->getValue("BHT")."</td>"; 
			$out .= "<td nowrap>".getPrompt("Ward")." : </td><td nowrap>".$episode->getWard()."</td>"; 
			$out .= "</tr>";
		}
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Complaints")." / ".getPrompt("Injuries").": </td><td>".$episode->getValue("Complaint")."</td>"; 
		$out .= "<td nowrap>".getPrompt("Doctor")." : </td><td nowrap>".$episode->getEpisodeDoctor()."</td>"; 
		$out .= "</tr>";
		//$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Priority").": </td><td>".$this->getValue("Priority")."</td>"; 
		$out .= "<td nowrap>".getPrompt("Test")." : </td><td nowrap>".$this->getValue("TestGroupName")."</td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
		$out .= "<td colspan=4 ><div id='lab' >".$this->getLabItems()."</div></td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		if ($this->getValue("CollectionDateTime") != "0000-00-00 00:00:00") {
			$out .= "<td ><input type=hidden  id='CollectionDateTime' value='".$this->getValue("CollectionDateTime")."' />".getPrompt("Sample collection Date")." : </td><td>".$this->getValue("CollectionDateTime")."</td>"; 
			$out .= "<td nowrap></td><td nowrap></td>"; 
		}
		else {
			$out .= "<tr >";
			$out .= "<td >".getPrompt("Sample collection Date")." : </td><td><input type=text readonly id='dd' class='input' style='width:100;' />".$this->timePicker("CollectionDateTime","00","00")."</td>"; 
			$out .= "<td nowrap><input type=hidden  id='CollectionDateTime' class='input' style='width:100;' /></td>";
			$out .= "<td nowrap ></td>"; 
			$out .= "</tr>";			
		}
		$out .= "</tr>";
		if ($_GET["action"] != "View") {
			$out .= "<tr >";
			$out .= "<td colspan=3><input class='input' style='width:15' id='confirm' type='checkbox'> Result confirmed by ".getLoggedUser()."</td>"; 
			$out .= "</tr>";		
		}
		$out .= "<td colspan=3 align=right><i>".getPrompt("Last Accessed By").":".$this->getValue("LastUpDateUser")."  on  ".$this->getValue("LastUpDate")."</i></td>"; 
		$out .= "<tr><td colspan=4><hr style='border:0;color: #000000;background-color: #000000;height:1px;'></td></tr>";
			$out .= "<tr >";
			$out .= "<td ></td>"; 
			$out .= "<td nowrap>";
			if ($_GET["action"] != "View") {
				$out .= "<input id='saveBtn' type='button'  class='formButton' value='Save' onclick='saveData();'>";
			}
			$out .= "<input id='okBtn' type='button' value='Back'  class='formButton' onclick='history.back(1);'></td>";
			$out .= "<td nowrap align=right>";
			if ($_GET["action"] != "View") {
				$out .= "<span class='cancel' onclick=deleteObjectAjax('lab_order','".$this->getId()."','".$this->getValue("Active")."')>".$this->status("Delete","Restore")."</span></td>"; 
			}
			$out .= "</tr>";		
		$out .= "</table>\n";
		$out .= "</div>\n ";	
		return $out;
	}
	private function getLabItems(){
		include_once 'MDSLabTests.php';
		include_once 'MDSLabOrderItems.php';
		include_once 'MDSDatabase.php';
		$result1 = NULL;
		$mdsDB1 = MDSDataBase::GetInstance();
		$mdsDB1->connect();		
		$sql1 = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '".$this->getId()."'";	
		$result1=$mdsDB1->mysqlQuery($sql1);
		$out .= "<table class='PrescriptionInfo' border=0 cellspacing=0 cellpading=0 width=100%>\n";	
		$out .= "<tr><td class='td_brd'>".getPrompt("Test")."</td><td class='td_brd'>".getPrompt("Result")."</td><td class='td_brd'>".getPrompt("Reference")."</td></tr>";
		$i=0;
                while($row1 = $mdsDB1->mysqlFetchArray($result1))  {
			if ($row1["LAB_ORDER_ITEM_ID"]) {
                                ++$i;
				$l_test = new MDSLabTests();
				$l_item = new MDSLabOrderItems();
				$l_item->openId($row1["LAB_ORDER_ITEM_ID"]);
				$l_test->openId($row1["LABID"]);
				$out .= "<tr>";
				$out .= "<td valign=middle class='lab_td' >".$l_test->getValue("Name")."</td>";
				$out .= "<td valign=middle class='lab_td' >";
				$out .= "<input type='text' typ='result' class='input' ";
				if ($_GET["action"] == "View") {
					$out .=" readonly ";
				}
				$out .= " id ='".$l_item->getId()."' ";
					if ($l_item->getValue("TestValue")) {
						$out .= " value ='".$l_item->getValue("TestValue")."'" ;	
					}
				$out .= "/>";	
				"</td>";
                                if ($l_test->getValue("RefValue")){
                                    $out .= "<td valign=top class='lab_td' width=200 ><span style='cursor:pointer;color:green;' onclick=$('#ref".$i."').toggle()>&raquo;</span><div id='ref".$i."' style='display:none;font-size:10px;'>".$l_test->getValue("RefValue")."</div>&nbsp;</td>";
                                }
				$out .= "</tr>";
				$out .= "<tr><td colspan=4><hr style='border:2;color: #eeeeee;background-color: #eeeeee;height:1px;'></td></tr>";
			}
		}
		$mdsDB1->close();	
		return $out;

	}
}

?>