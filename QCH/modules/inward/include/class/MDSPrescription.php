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
include_once 'config_drug.php';
include_once 'MDSOpd.php';
class MDSPrescription extends MDSPersistent
{
	private $isOpened = false;
        private $patient = null;
        private $opd = null;
        
	public function __construct($type,$objId,$pid) {
		parent::__construct("opd_presciption");
		if ((!$objId)||(!$pid)) return ;
		$pr_id = $this->getPrescription($type,$objId);
		if ($pr_id) {
			return $this;
		}
		else {
			$this->setValue("Dept",$type);
			$this->setValue("OPDID",$objId);
			$this->setValue("PID",$pid);
			$this->setValue("PrescribeDate",date("Y-m-d H:i:s"));
			$this->setValue("PrescribeBy",$_SESSION["FirstName"]." ".$_SESSION["OtherName"]);
			$this->setValue("Status","Pending");
			$this->setValue("CreateDate",date("Y-m-d H:i:s"));
			$this->setValue("Active",1);
			$this->setValue("CreateUser",$_SESSION["FirstName"]." ".$_SESSION["OtherName"]);
			return  $this->openId($this->Save("rId"));
		}
	}
	public function ifNotCreate(){
	}

	public function getPrescription($type,$objId)
	{
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT PRSID FROM opd_presciption where OPDID = ".$objId." AND Dept = '".$type."'"); 
		if (!$result) return null;
		$count=mysql_num_rows($result);
		if ($count == 1) {
			$row = mysql_fetch_array($result) or die(mysql_error());
			return  $this->openId($row["PRSID"]);
		}
		else {
			return  NULL;
		}
		$mdsDB->close();
	}
        public function getADMItems($prId,$type){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT prescribe_items.PRS_ITEM_ID,
                    drugs.Name,
                    drugs.DRGID,
                    prescribe_items.Dosage,
                    prescribe_items.Frequency,
                    prescribe_items.HowLong,
                    prescribe_items.Status,
                    prescribe_items.Quantity 
                    FROM prescribe_items,drugs 
                    where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '".$prId."' ";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "Error getting Items"; return null; };

		$count=mysql_num_rows($result);
		if (!$result) return null;
		$out = "";
		if ($count == 0) {
			//return "<script language='javascript'>$(document).ready(function(){ $('#okBtn').hide();}) </script>";
		}
		$i=0;	
		while($row = mysql_fetch_array($result))  {
			$out .= "<tr><td>".++$i."</td>\n";
			$out .= "<td>".$row["Name"]."</td>\n";
			$out .= "<td>".$row["Name"]."</td>\n";
			$out .= "<td>".$row["Dosage"]."</td>\n";
                        $out .= "<td>".$row["Frequency"]."</td>\n";
			$out .= "<td>".$row["HowLong"]."</td>\n";
                        //if ($row["Status"]=="Dispensed"){
                          //  $out .= "<td nowrap>".$row["Status"]." ".$row["Quantity"]."</td>\n";
                            
                        //} 
                        //else {
                            if ($type == "new" ){
                                $out .= "<td nowrap><span class='cancel' onclick=deleteObjectAjax('prescribe_items','".$row["PRS_ITEM_ID"]."','".$this->getValue("Active")."','')>Delete</span></td>";
                            }
                            else {
                                $out .= "<td nowrap><span class='continue' >Continue this</span></td>";                            
                            }
                        //}
                        $out .= "<tr>";
			//<input type='button' value='Remove'  onclick=removeItem(".$PRS_ITEM_ID."); />
		}
		$mdsDB->close();
		return $out."<script language='javascript'>$(document).ready(function(){ $('#okBtn').show();}) </script>";	
	}
	public function getItems($prId,$type){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,drugs.DRGID,prescribe_items.Dosage,prescribe_items.Frequency,prescribe_items.HowLong,prescribe_items.Status,prescribe_items.Quantity FROM prescribe_items,drugs where prescribe_items.Active = 1 AND (prescribe_items.DRGID = drugs.DRGID OR prescribe_items.PDRGID = drugs.DRGID) AND prescribe_items.PRES_ID = '".$prId."' ";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "Error getting Items"; return null; };

		$count=mysql_num_rows($result);
		if (!$result) return null;
                $out .= "";
		if ($count ==0){
                    if ($type == "new" ){
                        $out .="<script language='javascript'>$(document).ready(function(){ $('#okBtn').hide();}) </script>";	;
                    }
                }

		$c=0;	
		while($row = mysql_fetch_array($result))  {
                        $c=$c+1;
			$out .= "<tr><td>".$c."</td>\n";
			$out .= "<td>".$row["Name"]."</td>\n";
			$out .= "<td>".$row["Name"]."</td>\n";
			$out .= "<td>".$row["Dosage"]."</td>\n";
                        $out .= "<td>".$row["Frequency"]."</td>\n";
			$out .= "<td>".$row["HowLong"]."</td>\n";
                            if ($type == "new" ){
                                $out .= "<td nowrap><span class='cancel' onclick=deleteObjectAjax('prescribe_items','".$row["PRS_ITEM_ID"]."','".$this->getValue("Active")."','')>Delete</span></td>";
                                $out .=  "<script language='javascript'>$(document).ready(function(){ $('#okBtn').show();}) </script>";
                            }
                            else {
                                $out .= "<td nowrap><span class='continue'  onmouseover=\"drugSelect('".$row["DRGID"]."','".$row["DRGID"]."',String('".$row["Dosage"]."'),'".$row["Frequency"]."','".$row["HowLong"]."')\"   onclick=\"saveData()\" >Continue this</span></td>";                            
                                
                            }
                        $out .= "<tr>";
			//<input type='button' value='Remove'  onclick=removeItem(".$PRS_ITEM_ID."); />
		}
                

		$mdsDB->close();
		return $out;
	}
	public function getBlankItem($c_stock=""){
		$out  = "";	
		if ($_GET["action"] == "View") return;
		$out .= "<tr><td><input type='hidden' id='PRES_ID' value='".$this->getId()."'/></td>\n";
		$out .= "<td>".$this->getPriorityDrugs($c_stock)."</td>\n";
		$out .= "<td>".$this->getDrugs($c_stock)."</td>\n";
		$out .= "<td>".$this->getDosage()."</td>\n";
                $out .= "<td>".$this->getFrequency()."</td>\n";
		$out .= "<td>".$this->getPeriod()."<input type='hidden' id='Active' name='Active' value=1></td>\n";
		$out .= "<td><input type='button' value='+ Add'   class='formButton'  onclick=saveData(); style='height:50;width:50;' ".$this->isOpened." /></td><tr>";
		//$out .= "<td><span class='ui-icon ui-icon-circle-check' ></span></td></tr>";
		return $out;
	}	
	public function renderADMForm($opd,$pat,$mode){
		$out ="";
		$this->setValue("Active",true);
		$this->save();
                include_once 'MDSAdmission.php';
                $opd = new MDSAdmission();
                $opd->openId($this->getValue("OPDID"));
                if ($opd){
                    $this->opd = $opd;
                    $this->patient = $opd->getAdmitPatient();
                }
		$out .= "<div id='formCont' class='formCont' style='left:20;'>\n";
                $out .=$this->patient->patientBannerTiny('10px');
		$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("Admission Prescription")."</div>";
		$out .= "<div class='prescriptionInfo'>\n";
		$out .= "<table border=0 width=80% class='PrescriptionInfo'>\n";
	
			$out .= $this->getADMItems($this->getId("PRSID"),'new'); 
			if ($mode== "de95b43bceeb4b998aed4aed5cef1ae7") {
                            $out .= $this->getBlankItem(); 
                        //$out .= $this->getPreviousPrescirption();
			}

		$out .= "</table>\n";
		$out .= "<div align=center><input  id='okBtn' ".$this->isOpened."   class='formButton' type='button' value='Send to pharmacy' onclick=self.document.location='home.php?page=admission&action=View&ADMID=".$opd->getId()."' >\n ";
		$out .= "<input  ".$this->isOpened." type='button' value='Discard'  class='formButton' onclick=deleteObjectAjax('opd_presciption','".$this->getId()."','1','home.php?page=opd&action=View&OPDID=".$opd->getId()."')>\n ";
                $out .= "<input type='button' value='Back'  class='formButton' onclick=self.window.history.back();><div>\n ";
		$out .= "</div>\n";
		$out .= "</div>\n ";	
		return $out;
	}
	public function renderForm($opd,$pat,$mode){
		$out ="";
		$this->setValue("Active",true);
		
                $opd = new MDSOpd();
                $opd->openId($this->getValue("OPDID"));
                if ($opd){
                    $this->opd = $opd;
                    $this->patient = $opd->getOpdPatient();
                    if ($opd->isOpened == 1) 
                                $this->isOpened  = '';
                    else    $this->isOpened  = 'disabled';
                }
                $cur_stock = $this->getStock($opd->getValue("VisitType"));
                $this->setValue("GetFrom",$cur_stock);
                $this->save();
		$out .= "<div id='formCont' class='formCont' style='left:20;'>\n";
		$out .= "<div class='prescriptionHead' style='font-size:23px;'>".getPrompt("OPD Prescription")."</div>";
		$out .= "<div class='prescriptionInfo'>\n";
		$out .= "<table border=0 width=90% class='PrescriptionInfo'>\n";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Hospital")." : </td><td>".$_SESSION["Hospital"]."</td>"; 
		$out .= "<td nowrap>".getPrompt("Prescription ID")." : </td><td nowrap>".$this->getId("PRSID")."</td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Prescribed By").": </td><td >".$this->getValue("PrescribeBy")."</td>"; 
		$out .= "<td nowrap>".getPrompt("Prescribed On")." : </td><td nowrap>".$this->getValue("PrescribeDate")."</td>"; 
		$out .= "</tr>";
		
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Patient").": </td><td><a href='home.php?page=patient&action=View&PID=".$pat->getId()."'>".$pat->getFullName()." (".$pat->getId().") </a></td>"; 
		list ($yrs,$mths)= $pat->dateDifference($pat->getValue("DateOfBirth"),date('Y/m/d'));
		$out .= "<td nowrap>".getPrompt("Gender")."/".getPrompt("Age")." : </td><td nowrap>".$pat->getValue("Gender")."&nbsp;/&nbsp;".$yrs."yrs&nbsp;".$mths."mths</td>"; 
		$out .= "</tr>";	
		
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Complaints / Injuries").": </td><td>".$opd->getValue("Complaint")."</td>"; 
		$out .= "<td nowrap>".getPrompt("Doctor")." : </td><td nowrap>".$opd->getOPDDoctor()."</td>"; 
		$out .= "</tr>";
		$out .= "<tr>";
		$out .= "<td>".getPrompt("Visit Type").": </td><td>".$opd->getValue("VisitType")."</td>"; 
                
		$out .= "<td nowrap>Use:</td><td nowrap><b>";
                if ($cur_stock == "ClinicStock")
                    $out .= "Clinic Stock";
                else 
                    $out .= "OPD Stock";
                $out .="</b></td>"; 
		$out .= "</tr>";
		
		$out .= "</table>\n";
		$out .= "<table border=0 width=90% class='PrescriptionInfo' style='background:#FFFFFF'>\n";
		$out .= "<tr>";
		$out .= "<td class='pTd'></td><td class='pTd'>My Favourite</td><td class='pTd'>".getPrompt("Drug List")."</td><td nowrap class='pTd'>".getPrompt("Dosage")."</td><td nowrap class='pTd'>".getPrompt("Frequency")."</td><td nowrap class='pTd'>".getPrompt("Period")."</td><td  class='pTd'></td>"; 
		$out .= "</tr>";
			$out .= $this->getItems($this->getId("PRSID"),'new'); 
			if ($mode== "de95b43bceeb4b998aed4aed5cef1ae7") {
                            $out .= $this->getBlankItem($cur_stock ); 
                            if ($_SESSION["DISPLAY_PREVIOUS_DRUG"])$out .= $this->getPreviousPrescirption();
			}

		$out .= "</table>\n";
		$out .= "<div align=center><input  id='okBtn' ".$this->isOpened."   class='formButton' type='button' value='Send to pharmacy' onclick=self.document.location='home.php?page=opd&action=View&OPDID=".$opd->getId()."' >\n ";
		$out .= "<input  ".$this->isOpened." type='button' value='Discard'  class='formButton' onclick=deleteObjectAjax('opd_presciption','".$this->getId()."','1','home.php?page=opd&action=View&OPDID=".$opd->getId()."')>\n ";
                $out .= "<input type='button' value='Back'  class='formButton' onclick=self.window.history.back();><div>\n ";
		$out .= "</div>\n";
		$out .= "</div>\n ";	
		return $out;
	}
        private function getStock($type){
                $mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT Stock FROM visit_type where (Name = '".$type."') and (Active = 1) ORDER BY Stock";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) return null;  
                while($row = mysql_fetch_array($result))  {
                    return $row["Stock"];
                }            
        }
        private function getPreviousPrescirption(){
            if ($this->isOpened == 'disabled') return "";
            $opdId = $this->getLastOPDId();
            if (!$opdId ) return "";
            $prId = $this->getPrescription('OPD',$opdId);
            $out ="";
            $out .= "<tr>";
		$out .= "<td  colspan=6><b>Previous prescription<b></td>"; 
            $out .= "</tr>";
            $out .= "<tr>";
		$out .= "<td class='pTd'>#</td><td class='pTd'>".getPrompt("Drug")."</td><td class='pTd'>".getPrompt("Drug")."</td><td nowrap class='pTd'>".getPrompt("Dosage")."</td><td nowrap class='pTd'>".getPrompt("Frequency")."</td><td nowrap class='pTd'>".getPrompt("Period")."</td><td  class='pTd'></td>"; 
            $out .= "</tr>";
            $out .= $this->getItems($prId,'old'); 
            return $out;
                
        }
        private function getLastOPDId(){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT OPDID FROM opd_visits where (OPDID != '".$this->getValue("OPDID")."') and (PID = '".$this->patient->getId()."') ORDER BY OPDID DESC";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) return null;  
                while($row = mysql_fetch_array($result))  {
                    return $row["OPDID"];
                }
        }
		
		private function getPriorityDrugs($c_stock){
		$mdsDB = MDSDataBase::GetInstance();
		$UID=$_SESSION["UID"];
		$mdsDB->connect();
                $sql = "";
                if ($c_stock == "ClinicStock"){
                    $sql.=" SELECT drugs.DRGID,drugs.Name,drugs.Stock as Stock,drugs.dDosage,drugs.dFrequency FROM drugs,Doctor_Drug where (Doctor_Drug.DRGID = drugs.DRGID ) AND (Doctor_Drug.USRID = '$UID') AND (Doctor_Drug.PRIORITY = 'Yes') ";
                        if ($_SESSION["DISPLAY_ZERO_DRUG_COUNT"]==0) $sql.=" and (ClinicStock > 0) ";
                    $sql.=   " ORDER BY drugs.Name ";
                }
                else{
                     $sql.=" SELECT drugs.DRGID,drugs.Name,drugs.Stock as Stock,drugs.dDosage,drugs.dFrequency FROM drugs,Doctor_Drug where (Doctor_Drug.DRGID = drugs.DRGID ) AND (Doctor_Drug.USRID = '$UID') AND (Doctor_Drug.PRIORITY = 'Yes') ";
                    if ($_SESSION["DISPLAY_ZERO_DRUG_COUNT"]==0) $sql.=" and (Stock > 0) ";
                    $sql.=" ORDER BY drugs.Name ";
                }
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) return null;
		$out = "";
		$out .= "<select class='inputfavdruglist' id='PDRGID' size='10' style='width:300;' autofocus  onchange=setDefault('PDRGID') onclick=DisableDrugList() ".$this->isOpened." >\n";
		$out .= "<option value='' ></option>\n";
		while($row = mysql_fetch_array($result))  {
			if ( $row["Stock"] <= 0 ) {
				$out .= "<option value='".$row["DRGID"]."' style='color:red;' dosage='".$row["dDosage"]."'  fre='".$row["dFrequency"]."' >".$row["Name"]."&nbsp;&nbsp;&nbsp;";
                                if ($_SESSION["DISPLAY_DRUG_COUNT"]) $out .= "(Stock:".$row["Stock"].")";
                                $out .= "</option>\n";
			}
			else {
				$out .= "<option value='".$row["DRGID"]."' dosage='".$row["dDosage"]."'  fre='".$row["dFrequency"]."' >".$row["Name"]."&nbsp;&nbsp;&nbsp;";
                                if ($_SESSION["DISPLAY_DRUG_COUNT"]) $out .= "(Stock:".$row["Stock"].")";
                                $out .= "</option>\n";
			}
		}
		$out .= "</select>\n";
		$mdsDB->close();
		return $out;
	}
	private function getDrugs($c_stock){
		$mdsDB = MDSDataBase::GetInstance();
		$UID=$_SESSION["UID"];
		$mdsDB->connect();
                $sql = "";
                if ($c_stock == "ClinicStock"){
                    $sql.=" SELECT drugs.DRGID,drugs.Name,drugs.Stock as Stock,drugs.dDosage,drugs.dFrequency FROM drugs,Doctor_Drug where (Doctor_Drug.DRGID = drugs.DRGID ) AND (Doctor_Drug.USRID = '$UID') AND (Doctor_Drug.PRIORITY = 'No') ";
                        if ($_SESSION["DISPLAY_ZERO_DRUG_COUNT"]==0) $sql.=" and (ClinicStock > 0) ";
                    $sql.=   " ORDER BY drugs.Name ";
                }
                else{
                     $sql.=" SELECT drugs.DRGID,drugs.Name,drugs.Stock as Stock,drugs.dDosage,drugs.dFrequency FROM drugs,Doctor_Drug where (Doctor_Drug.DRGID = drugs.DRGID ) AND (Doctor_Drug.USRID = '$UID') AND (Doctor_Drug.PRIORITY = 'No') ";
                    if ($_SESSION["DISPLAY_ZERO_DRUG_COUNT"]==0) $sql.=" and (Stock > 0) ";
                    $sql.=" ORDER BY drugs.Name ";
                }
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) return null;
		$out = "";
		$out .= "<select class='inputdruglist' id='DRGID' size='10' style='width:300;' autofocus  onchange=setDefault('DRGID') onclick=DisableFavDrugList() ".$this->isOpened." >\n";
		$out .= "<option value='' ></option>\n";
		while($row = mysql_fetch_array($result))  {
			if ( $row["Stock"] <= 0 ) {
				$out .= "<option value='".$row["DRGID"]."' style='color:red;' dosage='".$row["dDosage"]."'  fre='".$row["dFrequency"]."' >".$row["Name"]."&nbsp;&nbsp;&nbsp;";
                                if ($_SESSION["DISPLAY_DRUG_COUNT"]) $out .= "(Stock:".$row["Stock"].")";
                                $out .= "</option>\n";
			}
			else {
				$out .= "<option value='".$row["DRGID"]."' dosage='".$row["dDosage"]."'  fre='".$row["dFrequency"]."' >".$row["Name"]."&nbsp;&nbsp;&nbsp;";
                                if ($_SESSION["DISPLAY_DRUG_COUNT"]) $out .= "(Stock:".$row["Stock"].")";
                                $out .= "</option>\n";
			}
		}
		$out .= "</select>\n";
		$mdsDB->close();
		return $out;
	}
	
	
	private function getDosage(){
		include "include/config_drug.php";
		$out = "";
		$out .= "<select class='input' id='Dosage' size='10' style='width:80px;'  ".$this->isOpened.">\n";
		$out .= "<option value='' selected></option>\n";
		$i=0;
                /*
		for ($i=0 ; $i < count($dosage["TEXT"]) ; ++$i){
			$out .= "<option value='".$dosage["TEXT"][$i]."'>".$dosage["TEXT"][$i]."</option>\n";
		}
                 */
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT Dosage FROM drugs_dosage where Active = 1 order by Dosage ";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "Error getting Items"; return null; };

		$count=mysql_num_rows($result);
		if (!$result) return null;
		while($row = mysql_fetch_array($result))  {
                    $out .= "<option value='".$row["Dosage"]."'>".$row["Dosage"]."</option>\n";
                }
                                
		$out .= "</select>\n";
		return $out;
	}
	private function getFrequency(){
		include "include/config_drug.php";
		$out = "";
		$out .= "<select class='input' id='Frequency' size='10' style='width:150px;'  ".$this->isOpened.">\n";
		$out .= "<option value='' selected></option>\n";
		$i=0;
                /*
		for ($i=0 ; $i < count($dosage["TEXT"]) ; ++$i){
			$out .= "<option value='".$dosage["TEXT"][$i]."'>".$dosage["TEXT"][$i]."</option>\n";
		}
                 */
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();
		$sql=" SELECT Frequency FROM drugs_frequency where Active = 1 order by Frequency ";
		$result = $mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "Error getting Items"; return null; };

		$count=mysql_num_rows($result);
		if (!$result) return null;
		while($row = mysql_fetch_array($result))  {
                    $out .= "<option value='".$row["Frequency"]."'>".$row["Frequency"]."</option>\n";
                }
                                
		$out .= "</select>\n";
		return $out;
	}        
	private function getPeriod(){
		include "include/config_drug.php";

		$out = "";
		$out .= "<select class='input' id='HowLong' size='10'  ".$this->isOpened.">\n";
		$out .= "<option value=''></option>\n";
		$i=0;
		for ($i=0 ; $i < count($period["TEXT"]) ; ++$i){
			$out .= "<option value='".$period["TEXT"][$i]."' ";
                        if ($period["TEXT"][$i] =="For 3 days") 
                            $out .= "selected";
                        $out .= " >".$period["TEXT"][$i]."</option>\n";
		}
		$out .= "</select>\n";
		return $out;
	}
	
}

?>