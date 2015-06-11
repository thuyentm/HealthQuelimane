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
class MDSHospital extends MDSPersistent
{
	private static $instance; 
	private $table = "hospital";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}

	public function openCode($code){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select HID from '.$this->TableName.' where Code = "'.$code.'"'); 
		$count = $mdsDB->getRowsNum($result);
		if ($count!=1) return NULL;
		$row = $mdsDB->mysqlFetchArray($result) or die("mysql_error()");
		if (!$row["HID"])return NULL;
		$this->openId($row["HID"]);
	}
	public function openDefaultHospital(){
		if (!$_SESSION["HID"])
			return null;
		$this->openId($_SESSION["HID"]);
	}
	public function getCode(){
		return $this->getvalue("Code");
	}
	public function getDistrictDSDivision(){
		$this->openDefaultHospital();
		return array ($this->getValue("Address_District"),$this->getValue("Address_DSDivision"));
	}
	public function getCurrentBHT($cbht){
		
		$hbht = $this->getValue("Current_BHT");
		if ($cbht) {
			$hbht =$cbht;
		}
		$data = explode('/',$hbht);
		if (count($data) != 3) $bht = "Error";
		$year = date('Y');
		$day = date('d');
		$y = $data[0];
		$y_count = $data[1];
		$m_count = $data[2];
		if ( $day == 1) $m_count = 1;
		if ($y == $year-1) { $y_count = 0;  $m_count = 0; };
		$bht = $year."/".++$y_count."/".++$m_count;
		return $bht;
	}
        public function getBedCount(){
            	$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select sum(BedCount) from ward where Active = 1 '); 
		$count = $mdsDB->getRowsNum($result);
		$row = $mdsDB->mysqlFetchArray($result) or die("mysql_error()");
		return $row[0];

        }
        public function getPatientCountBeforeQuarter($sdate,$fdate){
            	$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select count(ADMID) from admission  where (OutCome="") AND (AdmissionDate  <= "'.$sdate.'") '); 
		$count = $mdsDB->getRowsNum($result);
		$row = $mdsDB->mysqlFetchArray($result) or die("mysql_error()");
		return $row[0];            
        }
        public function getPatientCountRemainQuarter($sdate,$fdate){
            	$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select count(ADMID) from admission  where (OutCome="")  AND (AdmissionDate  <= "'.$fdate.'") '); 
		$count = $mdsDB->getRowsNum($result);
		$row = $mdsDB->mysqlFetchArray($result) or die("mysql_error()");
		return $row[0];            
        }        
        public function getPatientCountAdmisttedQuarter($sdate,$fdate){
            	$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select count(ADMID) from admission  where  (AdmissionDate  < "'.$fdate.'")  AND  (AdmissionDate  >="'.$sdate.'") '); 
		$count = $mdsDB->getRowsNum($result);
		$row = $mdsDB->mysqlFetchArray($result) or die("mysql_error()");
		return $row[0];            
        }           
}

?>