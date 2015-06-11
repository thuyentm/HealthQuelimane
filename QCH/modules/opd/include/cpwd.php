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
if ($_POST["sbtn"]) {
	include_once "class/MDSStaff.php";
	$staff = new MDSStaff();
	$id=0;
	$staff->openId($_POST["uid"]);
	$op = $staff->getValue("Password");
	if ( $op != MD5( $_POST["oldp"] ) ){
		echo "Old password dosent match! <a href='cpwd.php?UID=".$_POST["uid"]."'> Try Again</a> or "
			."<a href='cpwd.php?UID=".$_POST["uid"]."&rs=true'> Reset</a>";
		return "";
	}
	else if (  ($_POST["newp1"] =="")||( $_POST["newp2"]=="")  ){
		echo "Old passwords empty! <a href='cpwd.php?UID=".$_POST["uid"]."'> Try Again</a> or "
			."<a href='cpwd.php?UID=".$_POST["uid"]."&rs=true'> Reset</a>";
		return "";

	}
	else if (  $_POST["newp1"] != $_POST["newp2"]  ){
		echo "Old passwords dosent match! <a href='cpwd.php?UID=".$_POST["uid"]."'> Try Again</a> or "
			."<a href='cpwd.php?UID=".$_POST["uid"]."&rs=true'> Reset</a>";
		return "";
	}
	else {
		$staff->setValue("Password",MD5($_POST["newp2"]));
		$id = $staff->save("rId");
	}
	

	if ( $id > 0 ){
		echo "Password changed! <a href='javascript:self.window.close();'> Close</a>" ;
			return "";
	}
}

if ($_GET["rs"] == "true") {
			include_once "class/MDSStaff.php";
			$staff = new MDSStaff();
			$id=0;
			$staff->openId($_GET["UID"]);
			$staff->setValue("Password",MD5('123'));
			$id = $staff->save("rId");
			echo $id;
			if ( $id > 0 ){
				echo "Password changed! <a href='javascript:self.window.close();'> Close</a>" ;
				return "";
			}	

}

?>
<html>
<head>
<title>Change Password</title>
</head>
<body style='background:#e0edfe;'>
<form method='POST' action='cpwd.php'>
<table border=0>
<tr><td >Old password:</td><td ><input type='password' class='input' id='oldp' name='oldp' value='<?php echo $_POST["oldp"] ?>' ><input type='hidden' class='input' id='uid' name='uid' value='<?php echo $_GET["UID"] ?>'></td></tr>
<tr><td >New password:</td><td ><input type='password' class='input' id='newp1' name='newp1'></td></tr>
<tr><td >New password again:</td><td ><input type='password' class='input' id='newp2' name='newp2'></td></tr>
<tr><td ></td><td ><input type='submit' class='input' id='sbtn' name='sbtn' value='Change'><input type='submit' class='input' id='cbtn' value='Close' onclick=self.window.close()></td></tr>
</table>
</form>
</body>
</html>