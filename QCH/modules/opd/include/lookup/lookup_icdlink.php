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

session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}
	$snomed_code = $_GET["SNOMEDCODE"];
	if (!$snomed_code) return "";
	include_once '../class/MDSDataBase.php';
        include_once '../config.php';
	$icd = getICDCode($snomed_code);
	if ($icd)	echo $icd;

	function getICDCode($code){
		$icd_code= "";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql =" SELECT * FROM snomed_map WHERE  CONCEPTID  = '".$code."' ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) return null;
		while ($row = $mdsDB->mysqlFetchArray($result)) {
			$icd_code = substr($row["ICDMAP"],0,3);
		}
		return $icd_code;
	}
	




?>