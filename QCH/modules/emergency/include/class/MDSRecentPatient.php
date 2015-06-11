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
class MDSRecentPatient extends MDSPersistent
{
	
	public function __construct() {
		parent::__construct("recent_patient");
	}
	public function getRecentPatientList($uid){
	include_once 'MDSPatient.php';
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT  PID,Page FROM recent_patient where UID ='".$uid."' ORDER BY CreateDate DESC LIMIT 0,5"); 
		if (!$result) {
				echo " <script language='javascript'> \n" ;
				echo " jQuery().ready(function(){ \n";
				echo " $('#MDSError').html('List empty!'); \n";
				echo "}); \n";
				echo " </script>\n";
				return "";
		}		
		$out  = "<div class='recent_patient_cont'>";
		while($row = $mdsDB->mysqlFetchArray($result))  {	
			if (!$row["PID"]) continue;
			$out .= "<div class='recent_patient' onclick='self.document.location=\"home.php?page=".$row["Page"]."&PID=".$row["PID"]."&action=View#3\"'>";
			
			$rPat = new MDSPatient();
			$rPat->openId($row["PID"]);
			$out .= $rPat->getFullName()." (".$rPat->getId().")";
			$out .= "<br>".$rPat->getGender()." / ".$rPat->getAge('y');
			$out .= "</div>";
		}
		
		$out .= "</div>";
		return $out;
	}
	public function addRecentPatient($pid,$uid,$page){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("SELECT PID FROM recent_patient where (UID ='".$uid."') AND (PID ='".$pid."') "); 
		$count = $mdsDB->getRowsNum($result);
		if ($count >= 1) return;

		$this->setValue("PID",$pid);
		$this->setValue("UID",$uid);
		$this->setValue("Page",$page);
		$this->setValue("CreateDate",date("Y-m-d"));
		$this->save();
	}
}

?>