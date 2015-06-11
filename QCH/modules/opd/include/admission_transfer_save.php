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
	include_once 'class/MDSDataStore.php';
	include_once 'class/MDSAdmission.php';
	
	
	$admission = new MDSAdmission();
	if ($_POST['ADMID'] > 0){
		$admid = $_POST['ADMID'];
		$admission->openId($admid);
	}
	$from = $admission->getValue("Ward");
	$admission->setValue("Ward",(($_POST['Ward'])));
	$id= $admission->save('rId');
	if ($id > 0) {
		//$patient->save();
		$admission_transfer= new MDSDataStore("admission_transfer");
		$admission_transfer->setValue("ADMID",$admid);
		$admission_transfer->setValue("TransferDate",date("Y-m-d h:i:s"));
		$admission_transfer->setValue("TransferFrom",$from );
		$admission_transfer->setValue("TransferTo",$_POST['Ward'] );
		$sid = $admission_transfer->Save();
		echo 'Error=false; res="'.$id.'"; ';
	}
	else{
		echo 'Error=true; res="BHT Already exisit"; ';
	}
	

  ?>