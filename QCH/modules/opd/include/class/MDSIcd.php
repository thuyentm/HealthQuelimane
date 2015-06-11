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
class MDSIcd extends MDSPersistent
{
	private static $instance; 
	private $table = "icd10";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
	
	public function displayICD() {
		if (!$this->Fields[$this->ObjField]) return NULL;
		if ($this->getValue("isNotify") == 1) {
			$out = "<span style='color:#FF0000;'>".$this->getValue("Code").": ".$this->getValue("Name")."</span>";
		}
		else {
			$out = "<span >".$this->getValue("Code").": ".$this->getValue("Name")."</span>";
		}
		return $out;
	}
	public function openCode($code){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('select ICDID from '.$this->TableName.' where Code = "'.$code.'"'); 
		$count = $mdsDB->getRowsNum($result);
		if ($count!=1) return NULL;
		$row = $mdsDB->mysqlFetchArray($result) or die(mysql_error());
		if (!$row["ICDID"])return NULL;
		$this->openId($row["ICDID"]);
	}
	public function isNotify(){
		if (!$this->Fields[$this->ObjField]) return NULL;
		if ($this->getValue("isNotify") == 1) {
			return true;
		}
		else {
			return false;
		}
	}
}

?>