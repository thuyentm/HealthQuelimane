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
if (($_POST['FORM'] == "")||!isset($_POST['FORM']))  header("location: ../login.php");

include 'class/MDSDataStore.php';
	$fName = $_POST['FORM']; 
	include 'form_config/'.$fName.'_config.php';
	$frm = ${$fName};
        if ($frm["TABLE"] == "") header("location: ../login.php");
        $unCheckFields = array("UserAccess");
	$mdsDataStore = new MDSDataStore($frm["TABLE"]);
        
	$OBJID = $_POST[$frm["OBJID"]];
	if ($OBJID >=1) {
		$mdsDataStore->openId($OBJID);
	}	
	for ($i = 0; $i < count($frm["FLD"]); ++$i) {
		if ($frm["FLD"][$i]["Id"]!="_") {
		   if ($frm["FLD"][$i]["Id"] == "Password") {
					if ($OBJID >=1) {
						//$mdsDataStore->setValue($frm["FLD"][$i]["Id"],md5($_POST[$frm["FLD"][$i]["Id"]]));
					}
					else{
						if ($_POST[$frm["FLD"][$i]["Id"]] =="" ) {
							echo "Error:true; res='No passowrd'; ";
						}
						else {
							$mdsDataStore->setValue($frm["FLD"][$i]["Id"],md5($_POST[$frm["FLD"][$i]["Id"]]));
						}
					}
					
			}
			else 
			{
					$mdsDataStore->setValue($frm["FLD"][$i]["Id"],sanitize($_POST[$frm["FLD"][$i]["Id"]],$frm["FLD"][$i]["Id"]));
			}
		}
	}		
	$objId = $mdsDataStore->Save();
	echo  $objId;
        
        function sanitize($data,$fld){
                $data=trim($data);
                $possible_injection = array("<SCRIPT>", "<script>", "<ScRiPt>","alert","eval","</SCRIPT>","</script>","</ScRiPt>");
                $replace   = array("", "", "","", "", "","");
                $data =  str_replace($possible_injection, $replace, $data);
                if(($fld == "UserAccess")){
                        return $data;
                }
                $data=htmlspecialchars($data);
                $data = mysql_escape_string($data);
                //$data = stripslashes($data);
                return $data;
        }
  ?>