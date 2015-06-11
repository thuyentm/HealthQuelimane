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
include_once 'MDSUserGroup.php';

class MDSPermission extends MDSPersistent
{
	private static $instance; 
	private $table = "permission";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
	public function openByGroup($gName) {
	
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("select PRMID,UserAccess from ".$this->table." where UserGroup = '".$gName."' " ); 		
		$count = $mdsDB->getRowsNum($result);
		if ($count!=1) return NULL;
		$row = $mdsDB->mysqlFetchArray($result) or die(mysql_error());
		if ($row["PRMID"]) {
			return  $row["UserAccess"];
			 
		}
		return null;
		
	}
	public function haveAccess($ugid,$access){
	
		$mdsUG = new MDSUserGroup();
		$mdsUG->openId($ugid);
		if (!$mdsUG->getId()) return 0;
		$mdsPermission = $this->openByGroup($mdsUG->getValue("Name"));
		$obj = json_decode($mdsPermission);
		if ($obj->{$access}) {
			return 1;
		}
		else {
			return 0;
		}

	
	}
}

?>