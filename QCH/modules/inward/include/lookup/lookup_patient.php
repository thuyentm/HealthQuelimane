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
	if(!session_is_registered(username)){
	 header("location:../../login.php");
	}

	include_once '../class/MDSPatient.php';
	include_once '../class/MDSDataBase.php';
	include_once '../config.php';
	$full_name = $_GET["fn"];
	$other_name =$_GET["pun"];
	$village = $_GET["v"];
	$gender = $_GET["g"];
	$nic = $_GET["nic"];
	$out  = "";
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();		
	$sql ="SELECT PID FROM patient  where  ";
	if ($nic) {
		$sql .=" ( NIC LIKE '%$nic%' )  ";
	}
	else {
		if ($village) {
			$sql .="(Address_Village = '$village') and ";
		}
		if ($nic) {
		$sql .="(NIC like '%$nic%' ) and ";
		}
		$sql .="(Full_Name_Registered like '%$full_name%') ";
		if ($other_name) {
		$sql .=" or (Personal_Used_Name like '%$other_name%') ";
		}	
	}
	$sql .=" order by Full_Name_Registered limit 0,50";
	$result=$mdsDB->mysqlQuery($sql); 
	$i = 0;
	while($row = $mdsDB->mysqlFetchArray($result))  {
		$out  .= "<div class='patient_check_row' onmouseover=activeBtn('".$row["PID"]."','".$i."') onmouseout=inactiveBtn('".$i."')>";
		$pat = new MDSPatient();
		$pat->openId($row["PID"]);
		$out .="<span ><table style='font-size:12;' width=100%><tr><td width=300>Full Name: <b> ".$pat->getFullName()."</b></td><td  width=100> Age: <b>".$pat->getAge('y')."</b></td><td  width=200> NIC: <b>".$pat->getValue("NIC")."</b></td><td> Village: <b>".$pat->getValue("Address_Village")."</b></td><td align=right><span id='patient_check_btn".$i."'  class='patient_check_btn'  ></span></td></tr></table>  </span>";
		$out  .= "</div>";
		$i++;
	}
	
	$mdsDB->close();	
	echo $out;
?>
