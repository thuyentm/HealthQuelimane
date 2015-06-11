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
//include 'checksession.php';
//include 'config.php';
//include 'mdsCore.php';

session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}
include_once 'class/MDSDataBase.php';
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>HHIMS Drill Down</title>
</head>           
<body>
    <?php            
        $mdsDB = MDSDataBase::GetInstance();
        $mdsDB->connect();
        if ($_GET["tbl"] == 'admission'){
            $sql = " SELECT admission.ADMID from admission  WHERE  (admission.AdmitTo ='".$_GET["wrd"]."' ) AND ( substring(admission.AdmissionDate,1,10) = '".$_GET["dte"]."')";
        }
        else if ($_GET["tbl"] == 'discharge'){
            $sql = " SELECT admission.ADMID from admission  WHERE  (admission.AdmitTo ='".$_GET["wrd"]."' ) AND (admission.OutCome !='Died' ) AND ( substring(admission.DischargeDate,1,10) = '".$_GET["dte"]."')";
        }
        else if ($_GET["tbl"] == 'death_within_48'){
            $sql = " SELECT admission.ADMID from admission  WHERE  (admission.Ward ='".$_GET["wrd"]."' )AND (admission.OutCome ='Died' ) AND ( substring(admission.DischargeDate,1,10) = '".$_GET["dte"]."') AND (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))<2 )";
        }
        else if ($_GET["tbl"] == 'death_after_48'){
            $sql = " SELECT admission.ADMID from admission  WHERE  (admission.Ward ='".$_GET["wrd"]."' )AND (admission.OutCome ='Died' ) AND ( substring(admission.DischargeDate,1,10) = '".$_GET["dte"]."') AND (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))>=2 )";
        }        
        else if ($_GET["tbl"] == 'transfer_in'){
            $sql = " SELECT ADMID,TransferTo,TransferFrom from admission_transfer  WHERE  (TransferTo ='".$_GET["wrd"]."' ) AND ( substring(TransferDate,1,10) = '".$_GET["dte"]."')";
        }        
        else if ($_GET["tbl"] == 'transfer_out'){
            $sql = " SELECT ADMID,TransferTo,TransferFrom from admission_transfer  WHERE  (TransferFrom ='".$_GET["wrd"]."' ) AND ( substring(TransferDate,1,10) = '".$_GET["dte"]."')";
        }        

        
        else{
            die("ERROR");
        }
        $result_adm = $mdsDB->mysqlQuery($sql);
        echo "<table border=1 cellspacing=0 cellpadding=2 style='background:#fcfcfc;font-size:12px;font-family:Arial;'>";
        echo "<tr>";
        echo "<td colspan=5>".strtoupper($_GET["tbl"])."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Date</td><td>Admissions ID</td><td>ward</td>";
        if (($_GET["tbl"] == 'transfer_in') ||($_GET["tbl"] == 'transfer_out')){
             echo "<td>From</td><td>To</td>";
        }
        echo "</tr>";
        while($row1 = $mdsDB->mysqlFetchArray($result_adm))  {
        echo "<tr>";
        echo "<td>".$_GET["dte"]."</td><td><a target='_blank' href='../home.php?page=admission&ADMID=".$row1[0]."&action=View'>".$row1[0]."</a></td><td>".$_GET["wrd"]."</td>";
        if (($_GET["tbl"] == 'transfer_in') ||($_GET["tbl"] == 'transfer_out')){
            echo "<td>".$row1["TransferFrom"]."</td><td>".$row1["TransferTo"]."</td>";
        }
        echo "</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>
