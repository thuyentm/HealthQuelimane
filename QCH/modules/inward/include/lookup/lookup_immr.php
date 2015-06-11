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
	$icd_code = $_GET["ICD"];
	
	if (!$icd_code) return null;
	include_once '../class/MDSDataBase.php';
        include_once '../config.php';
	$immr = checkICD($icd_code);
	if ($immr)	{ 
		echo $immr;
	}
	else {
		echo "0245|||Undiagnosed / uncoded";
	}
	//0049|||Other infectious and parasitic diseases

	function checkICD($code){
		$out  = "";
		$data = array();
		$mdsDB = MDSDataBase::GetInstance();

		if ((!$code) || ($code == "")) return null;
                
		$mdsDB->connect();		
		$sql =" SELECT * FROM immr WHERE ICDCODE LIKE '%".$code."%' ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) return null;
		$i =0;
		while ($row = $mdsDB->mysqlFetchArray($result)) {
			$data[$i]=array("code"=>$row["Code"],"immr"=>$row["Name"]);
			$i++;
		}
		if ($i >0) {
			return $data[0]["code"]."|||".$data[0]["immr"];
		}
		else {
			$icd_array = explode(".", $code);
			if (count($icd_array) == 0 ) return null;
			for ($j = 0 ; $j<count($icd_array)-1 ;$j++) {
					$new_icd_code .= $icd_array[$j].".";

			}
			$new_icd_code = substr_replace( $new_icd_code, "", -1 );;
			return checkICD($new_icd_code);
		}	
	}
	




?>