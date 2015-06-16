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
    header("location: ../login.php");
}
	include 'class/MDSPatient.php';
	include 'class/MDSHospital.php';
    include_once 'class/MDSDataBase.php';

	$hospital = new MDSHospital();
	$hospital->openId($_SESSION["HID"]);
	$code =$hospital->getCode(); 
	
	if ((!$code) || ($code == "") || !isset($code)) {
		echo 'Error=true; res="Hospital Code!";';
		return "";
		
	}

          
	$pid = "";
	$new_patient = new MDSPatient();
	if ($_POST['PID']==""){
        checkDupicate() ;
		$lid = (string)($new_patient->getLastId()+1);
		$lastId = $lid;
		$new_patient->setId("PID",$lastId);
		$new_patient->setValue("LPID",$lid);
	}	
	else {
            $error_msg = "";
            $error = 0;
            $DateOfBirth = $_POST['DateOfBirth'];
            $NIC = $_POST['NIC'];
            $Full_Name_Registered = ucfirst(strtolower(cleanName($_POST['Full_Name_Registered'])));
            if (checkNIC($NIC) == 0){
                $error =1;
                $error_msg .="NIC invalid <br>";
            }
            if (checkDOB($DateOfBirth) == 0){
                $error =1;
                $error_msg .="Date of Birth invalid  <br>";
            }
            if ($Full_Name_Registered ==""){
                $error =1;
                $error_msg .="Name invalid <br>";
            }            
            if ($error){
                die($error_msg);
            }
		$pid = $_POST['PID'];
		$new_patient->openId((String)$pid);
	}
	
	$new_patient->setValue("Personal_Title",(cleanName($_POST['Personal_Title'])));
	$new_patient->setValue("Full_Name_Registered",strtoupper(cleanName($_POST['Full_Name_Registered'])));
	$new_patient->setValue("Personal_Used_Name",strtoupper (cleanName($_POST['Personal_Used_Name'])));
	//Clinic number only used in Sri Lanka 
        //$new_patient->setValue("ClinicNo",(cleanAddress($_POST['ClinicNo'])));
	$new_patient->setValue("Gender",$_POST['Gender']);
	$new_patient->setValue("DateOfBirth",(($_POST['DateOfBirth'])));
	$new_patient->setValue("NIC",(sanitize($_POST['NIC'])));
	$new_patient->setValue("Telephone",(cleanNumber($_POST['Telephone'])));
	$new_patient->setValue("Address_Street",(cleanAddress($_POST['Address_Street'])));
	$new_patient->setValue("Address_Street1",(cleanAddress($_POST['Address_Street1'])));
	$new_patient->setValue("Address_Village",(cleanName($_POST['Address_Village'])));
	$new_patient->setValue("Address_DSDivision",(($_POST['Address_DSDivision'])));
	$new_patient->setValue("Address_District",(($_POST['Address_District'])));
	$new_patient->setValue("Personal_Civil_Status",(($_POST['Personal_Civil_Status'])));
	$new_patient->setValue("Remarks",(cleanNumber($_POST['Remarks'])));
	
	if ($_POST['PID']==""){
		$objId = $new_patient->create();
		echo  '<br>Patient created!<br> Patient number: <b>'.$lastId.'</b><Br>
                    <input class="formButton"  type="button" value="Patient overview" onclick=self.document.location="home.php?page=patient&action=View&PID='.$lastId.'"  autofocus=true >
                    <input class="formButton" type="button" value="Back to Search" onclick=self.document.location="home.php?page=search" >
                    <input class="formButton" style="width:50;" type="button" value="New" onclick=self.document.location="home.php?page=patient&action=New" >
                    ';
	}else {
		$objId = $new_patient->update();
		echo  '<br>Patient updated!<br> Patient number: <b>'.$pid.'</b><Br>
                    <input class="formButton"  type="button" value="Patient overview" onclick=self.document.location="home.php?page=patient&action=View&PID='.$pid.'"  autofocus=true       >
                    <input class="formButton" type="button" value="Back to Search" onclick=self.document.location="home.php?page=search" >
                    ';
	}


    
        function sanitize($data){
            $data=trim($data);
            $data=htmlspecialchars($data);
            $data = mysql_escape_string($data);
            $data = stripslashes($data);
            return $data;
        }
        
        function cleanName($text){
            $text = preg_replace('/[\x00-\x1F\x7F\<\>\,\"\'\(\)\{\}\[\]\/\%\$\#\@\;\:\^\?\/\\\+\-\=\*\&0-9]/', '', $text);
            $possible_injection = array("SCRIPT", "script", "ScRiPt","PHP","php","alert","eval","java","type","hello");
            $replace   = array("", "", "","", "", "","");
            $text = str_replace($possible_injection, $replace, $text);
            return sanitize($text);
        }
        
        function cleanNumber($text){
            $text = preg_replace('/[\x00-\x1F\x7F\<\>\,\"\'\(\)\{\}\[\]\/\%\$\#\@\;\:\^\?\/\\\+\*\&]/', '', $text);
            $possible_injection = array("SCRIPT", "script", "ScRiPt","PHP","php","alert","eval");
            $replace   = array("", "", "","", "", "","");
            $text = str_replace($possible_injection, $replace, $text);
            return sanitize($text);
        }        
        
        function cleanAddress($text){
            $text = preg_replace('/[\x00-\x1F\x7F\<\>\,\"\'\{\}\[\]\%\$\#\@\;\:\^\?\+\*\&]/', '', $text);
            $possible_injection = array("SCRIPT", "script", "ScRiPt","PHP","php","alert","eval");
            $replace   = array("", "", "","", "", "","");
            $text = str_replace($possible_injection, $replace, $text);
            return sanitize($text);
        }           
        function checkNIC($nic){
            if ($nic == "") return 1;
            $reg = '/^(\d\d\d\d\d\d\d\d\d)[xXvV]$/';
            return preg_match($reg,$nic);
        }
        function checkDOB($dob){
            $reg = '/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/';
            return preg_match($reg,$dob);
        }       
        function checkDupicate(){
            $error_msg = "";
            $error = 0;
            $Full_Name_Registered = ucfirst(strtolower(cleanName($_POST['Full_Name_Registered'])));
            $Personal_Used_Name = cleanName($_POST['Personal_Used_Name']);
            $Gender = $_POST['Gender'];
            $Address_Village = cleanName($_POST['Address_Village']);
            $Personal_Civil_Status = $_POST['Personal_Civil_Status'];
            $DateOfBirth = $_POST['DateOfBirth'];
            $NIC = $_POST['NIC'];
            if (checkNIC($NIC) == 0){
                $error =1;
                $error_msg .="NIC invalid <br>";
            }
            if (checkDOB($DateOfBirth) == 0){
                $error =1;
                $error_msg .="Date of Birth  invalid <br>";
            }
            if ($Full_Name_Registered ==""){
                $error =1;
                $error_msg .="Name invalid <br>";
            }
            if ($error){
                die($error_msg);
            }
            $mdsDB = MDSDataBase::GetInstance();
            $mdsDB->connect();	
            $query = " SELECT PID,Full_Name_Registered,Gender,Address_Village,Personal_Civil_Status FROM patient where 
               ( `Full_Name_Registered` = '".$Full_Name_Registered."')
                   AND ( `Gender` = '".$Gender."')
                       AND (`Address_Village` = '".$Address_Village."')
                ";
            $result=$mdsDB->mysqlQuery($query); 
            $count = $mdsDB->getRowsNum($result);
            if ($count > 0) {
				if ($_POST['FS'] !=1){
					die($count." similar patient found! Please  try search<br><input  class='formButton' style='background:#e50b0b;' type='button' onclick='ForceSave()' value='Force Save'><a href='home.php?page=search'>Search a patient</a>");
				}
            }
        }
  ?>