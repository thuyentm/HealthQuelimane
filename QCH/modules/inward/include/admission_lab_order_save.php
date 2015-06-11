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

include 'config.php';
include_once 'class/MDSLabOrder.php';
	$action = $_POST["Action"];
	
	if ($action == "Update") {
		$ORDID = $_POST["ORDID"];
		if (!$ORDID) { echo -1; exit ; }
		include_once 'class/MDSLabOrderItems.php';
		$labResults = array();
		$labTests = array();
		$labResults = explode('|',chop($_POST["LabResults"]));
		$labTests = explode('|',chop($_POST["LabTests"]));
		$labOrder  = new MDSLabOrder();
		$labOrder->openId($ORDID);
		$labOrder->setValue("Status",$_POST["Status"]);
		$labOrder->setValue("CollectionDateTime",$_POST["CollectionDateTime"]);
		for ( $i = 0 ; $i < count($labTests); ++$i) {
			$tests = new MDSLabOrderItems();
			$tests->openId($labTests[$i]);
			if ( $labResults[$i] == "") {
				$tests->setValue("TestValue","---");
			}
			else {
				$tests->setValue("TestValue",$labResults[$i]);
			}
			$tests->setValue("Status","Available");
			$tests->save("rId");
		}
		echo $labOrder->save();
	}
	else {
		$labItems = array();
		$labItems = explode('|',chop($_POST["LabItems"]));
		$labOrder  = new MDSLabOrder();
		$labOrder->setValue("Dept",$_POST["Dept"]);
		$labOrder->setValue("OBJID",$_POST["OPDID"]);
		$labOrder->setValue("PID",$_POST["PID"]);
		$labOrder->setValue("OrderDate",$_POST["OrderDate"]);
		$labOrder->setValue("OrderBy",$_POST["OrderBy"]);
		$labOrder->setValue("Status",$_POST["Status"]);
		$labOrder->setValue("Priority",$_POST["Priority"]);
		$labOrder->setValue("CollectionDateTime",$_POST["CollectionDateTime"]);
		$labOrder->setValue("TestGroupName",$_POST["TestGroupName"]);
		$labOrder->setValue("CreateDate",$_POST["CreateDate"]);
		$labOrder->setValue("Active",$_POST["Active"]);
		$labOrder->setValue("CreateUser",$_POST["CreateUser"]);
		if (count($labItems) == 0 )  { echo "No tests selected"; return NULL ; }
		
		for ( $i = 0 ; $i < count($labItems); ++$i) {
			$labOrder->addItem($labItems[$i]);
		}
		$res = $labOrder->createOrder();
		echo "Error=false; res='".$res."';";
	}
  ?>