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

include_once 'MDSPersistent.php';
include_once 'MDSDataBase.php';
include_once 'MDSOpd.php';
include_once 'MDSPatient.php';
class MDSUser extends MDSPersistent
{
	private static $instance; 
	private $table = "user";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	public function __construct() {
		parent::__construct($this->table);
		$this->openId($_SESSION["UID"]);
	}
	public function getFullName(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return ucwords($this->getValue("Title").$this->getValue("FirstName")." ".$this->getValue("OtherName"));
	}
	public function getName(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		return ucwords($this->getValue("FirstName")." ".$this->getValue("OtherName"));
	}
	public function userGreet(){
		return "Welcome ".$this->getValue("Title")." ".$this->getValue("FirstName")." ".$this->getValue("OtherName");
	}
	public function getPatients(){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$out ="";
		$sql = "SELECT  DISTINCT opd_visits.PID 
		FROM opd_visits,patient 
		where (opd_visits.Doctor ='".$this->getId()."') AND (patient.PID = opd_visits.PID )
		ORDER BY opd_visits.DateTimeOfVisit DESC LIMIT 0,10";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) {
				echo " <script language='javascript'> \n" ;
				echo " jQuery().ready(function(){ \n";
				echo " $('#MDSError').html('List empty!'); \n";
				echo "}); \n";
				echo " </script>\n";
				return "";
		}		
		$out  .= "<div class='pListLeft'><div class='pListHead'>".getPrompt("Your recent patients")."</div>";
		while($row = $mdsDB->mysqlFetchArray($result))  {	
			if (!$row["PID"]) continue;
			$rPat = new MDSPatient();
			$rPat->openId($row["PID"]);
			$out .= "<div  onclick='self.document.location=\"home.php?page=patient&PID=".$rPat->getId()."&action=View#3\"'>";
			$out .= "<table class='recent_patient' border=0 width=100%><tr><td width=250px><b>Patient Name : </b>".$rPat->getFullName()." (".$rPat->getId().")</td>";
			$out .= "<td width:;><b>Gender :</b>".$rPat->getGender()."</td><td><b>Age :</b>".$rPat->getAge('y')."</td>";
			$out .= "<td align='right'>".$this->getLabAlerts($rPat->getId())."</td></tr></table>";
			$out .= "</div>";
		}
		$out  .= "</div>";
		return $out;
	}
	public function getLabAlerts($pid){
	return "";
	}
}

?>