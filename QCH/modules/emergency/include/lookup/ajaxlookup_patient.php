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
        if (!$_POST) die ("POST ERROR");
	$Full_Name_Registered = $_POST["Full_Name_Registered"];
	
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();		
	$sql =" SELECT PID, Personal_Title,DateOfBirth,Personal_Used_Name,Gender,Full_Name_Registered,NIC,Address_Village FROM patient  where  ";
	$sql .=" ( Full_Name_Registered like '$Full_Name_Registered%') ";
	$sql .=" order by Full_Name_Registered limit 0,50";
	$result=$mdsDB->mysqlQuery($sql); 
	$i = 0;
        $out  = "PATdata ={ 'patient':[";
	while($row = $mdsDB->mysqlFetchArray($result))  {
		$pat = new MDSPatient();
		$pat->openId($row["PID"]);
		$out .="{'PID':'".$row["PID"]."', 
                        'Full_Name_Registered':'".$row["Full_Name_Registered"]."',
                        'NIC':'".$row["NIC"]."',
                        'Address_Village':'".$row["Address_Village"]."',
                        'Personal_Title':'".$row["Personal_Title"]."',
                        'Personal_Used_Name':'".$row["Personal_Used_Name"]."',
                        'Gender':'".$row["Gender"]."',
                        'DateOfBirth':'".$row["DateOfBirth"]."'
                        },";
		$i++;
	}
        if ($i>0){
            $out = substr_replace( $out, "", -1 );
        }
	$out  .= "]}";
	$mdsDB->close();	
	echo $out;
?>
