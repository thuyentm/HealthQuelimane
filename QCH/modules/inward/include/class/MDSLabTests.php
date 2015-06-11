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
include_once '../config.php';

class MDSLabTests extends MDSPersistent
{	
	
	public function __construct() {
		parent::__construct("lab_tests");
	}
	
	function getTests($id){
	
	    $mdsDB1 = MDSDataBase::GetInstance();
		$mdsDB1->connect();		
		$sql1 = "SELECT Name FROM lab_tests WHERE LABID = '".$id."'";
		$result1=$mdsDB1->mysqlQuery($sql1);
	    $row = mysql_fetch_assoc($result1);
				
			return $row["Name"];
			
		
	
	}
	
}

?>