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
$txt = array();
$txt=explode('|',chop($_POST["txt"]));

$val = array();
$val=explode('|',chop($_POST["val"]));
$stock =$_POST["Stock"];

    mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
    mysql_select_db(DB) or die("cannot select DB");
	$sql = "";
	for ( $i = 0 ; $i < count($txt); ++$i) {
		if ( $txt[$i] >= 1) {
			$sql="UPDATE prescribe_items SET Quantity = '" .$val[$i]. "' , LastUpDateUser = '".$_POST["LastUpDateUser"]."' , LastUpDate = '".$_POST["LastUpDate"]."' ";
			if ( $val[$i] > 0  ) {
				$sql .= " , Status = 'Dispensed' ";
			}
			else {
				$sql .= " , Status = '' ";
			}
			$sql .= "  WHERE PRS_ITEM_ID = ".$txt[$i]." ";  	
			$result = mysql_query($sql);
			if (!$result) 
				echo $sql.mysql_error();;
				
			$sql1="SELECT DRGID FROM prescribe_items  WHERE PRS_ITEM_ID = ".$txt[$i]." "; 
			$result1 = mysql_query($sql1);
			if ($result1) {
				$row = mysql_fetch_array($result1);
				if ($row["DRGID"] > 0) {
					$sql2="UPDATE drugs SET  ";
                                        if ($stock == "ClinicStock"){
                                            $sql2 .= " ClinicStock = ( ClinicStock - ".$val[$i]." ) ";
                                        }
                                        else{
                                            $sql2.= " Stock = ( Stock - ".$val[$i]." ) ";
                                        }
                                        $sql2.= " where DRGID = '".$row["DRGID"]."' "; 
					$result2 = mysql_query($sql2);
				}
			}			
		}
	}
	
    $sql="UPDATE opd_presciption SET Status = 'Dispensed'  where PRSID =  '".$_POST["PRSID"]."' ";
	$result = mysql_query($sql);
	if (!$result) 
		echo 'Error=true; res="'.$sql.mysql_error()."'";
		
	echo 'Error=false; res=1';	
  ?>