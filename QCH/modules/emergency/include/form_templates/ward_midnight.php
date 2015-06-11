<?php
session_start();
if( !session_is_registered(username) ) {  header("location: ../../login.php");}
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



include_once '../class/MDSWard.php';
include_once '../class/MDSDataBase.php';
include_once '../class/MDSHospital.php';
include_once 'mds_reporter/MDSReporter.php';


if (!$_GET["wid"]) {
    echo "Invalid ward ";
    exit();
}

if ( (!$_GET["from"])||(!$_GET["to"])) {
    echo "Invalid Date";
    exit();
}
$ward = new MDSWard();
$ward->openId($_GET["wid"]);

$from_date = new DateTime($_GET['from']);
$to_date = new DateTime($_GET['to']);
if ($to_date->format("Y-m-d") > date("Y-m-d")){
    $to_date = new DateTime(date("Y-m-d"));
}

$startDate = strtotime($_GET['from']);
$endDate = strtotime($_GET['to']);
if ($endDate > strtotime(date("Y-m-d"))){
    $endDate = strtotime(date("Y-m-d"));
}
$diff = intval(abs(($startDate - $endDate) / 86400));

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();

$pdf = new MDSReporter('L', 'mm', 'A5');
$pdf->AddPage();

$from=$from_date->format("Y-m-d");
$to=$to_date->format("Y-m-d");

//$pdf->writeTitle($_SESSION["Hospital"]);
//$pdf->writeSubTitle('Midnight Census from '.$from_date->format("Y-m-d").' to '.$to_date->format("Y-m-d"), 12);
//$pdf->writeSSubTitle('Ward:'.$ward->getValue("Name"));
//
//$pdf->SetWidths(array(25,22,22,24,26,22,45));
//$pdf->SetAligns(array('L', 'L', 'L', 'L','L','L','L'));
//$pdf->Row(array("Date","Admissions","Discharges","Transfers In","Transfers Out","Balance","Remarks"),TRUE);
//$pdf->SetAligns(array('L', 'R', 'R', 'R','R','R','R'));
echo "<html>";
echo "<head>";
echo "<style type='text/css'>
	.t_head {font-weight: bold; font-size:16px;font-family:Georgia;border:2px solid #000000;}
	.r_head {font-weight: bold; font-size:12px;border-top:1px solid #000000;text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;}
	.r_data {font-size:12px;border-top:1px solid #000000;border-right:1px solid #000000;}
	.r_right {text-align:right;}
	.r_left_border {border-left:1px solid #000000;}
	.r_total { text-align:right; font-size:14px;border-right:1px solid #000000;font-weight: bold;border-top:2px solid #000000;border-bottom:2px solid #000000;}
</style>";
echo "</head>";
echo "<body>";
echo "<table border=0 cellspacing=0 cellpadding=5 align=center style='font-family:Arial;font-size:10px;'>";
echo "<tr>";
echo "<td colspan=8 class='t_head' align=center ><b>".$_SESSION["Hospital"]."<br>Midnight Census from ".$from_date->format("Y-m-d")." to ".$to_date->format("Y-m-d")."<br>Ward:".$ward->getValue("Name")."</b></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='r_head r_left_border'>Date</td><td class='r_head'>Admissions</td><td class='r_head'>Transfers In</td><td class='r_head'>Death &lt; 48Hrs</td><td class='r_head'>Death &gt; 48Hrs</td><td class='r_head'>Discharges</td><td class='r_head'>Transfers Out</td><td class='r_head'>Balance</td>";
echo "</tr>";
for ($index = 0; $index <= $diff; $index++) {
    
    $date = $from_date->format("Y-m-d");
    
    $sql_adm = " SELECT count(admission.ADMID) from admission  WHERE  (admission.AdmitTo ='".sanitize($_GET["wid"])."' ) AND ( substring(admission.AdmissionDate,1,10) = '".$date."')";
    $result_adm = $mdsDB->mysqlQuery($sql_adm);
    $row_adm = $mdsDB->mysqlFetchArray($result_adm);

    $sql_dis = " SELECT count(admission.ADMID) from admission  WHERE  (admission.Ward ='".sanitize($_GET["wid"])."' ) AND (admission.OutCome !='Died' ) AND ( substring(admission.DischargeDate,1,10) = '".$date."')";
    $result_dis = $mdsDB->mysqlQuery($sql_dis);
    $row_dis = $mdsDB->mysqlFetchArray($result_dis);
    
    $sql_dis_less_48 = " SELECT count(admission.ADMID) from admission  WHERE  (admission.Ward ='".sanitize($_GET["wid"])."' )AND (admission.OutCome ='Died' ) and (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))<2 ) AND ( substring(admission.DischargeDate,1,10) = '".$date."')";
    $result_dis_less_48 = $mdsDB->mysqlQuery($sql_dis_less_48);
    $row_dis_less_48 = $mdsDB->mysqlFetchArray($result_dis_less_48);    

    $sql_dis_greater_48 = " SELECT count(admission.ADMID) from admission  WHERE  (admission.Ward ='".sanitize($_GET["wid"])."' )AND (admission.OutCome ='Died' ) and (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))>=2 ) AND ( substring(admission.DischargeDate,1,10) = '".$date."')";
    $result_dis_greater_48 = $mdsDB->mysqlQuery($sql_dis_greater_48);
    $row_dis_greater_48 = $mdsDB->mysqlFetchArray($result_dis_greater_48);     
    
    $sql_in = " SELECT count(ADTR) from admission_transfer  WHERE  (TransferTo ='".sanitize($_GET["wid"])."' ) AND ( substring(TransferDate,1,10) = '".$date."')";
    $result_in = $mdsDB->mysqlQuery($sql_in);
    $row_in = $mdsDB->mysqlFetchArray($result_in);

    $sql_out = " SELECT count(ADTR) from admission_transfer  WHERE  (TransferFrom ='".sanitize($_GET["wid"])."' ) AND ( substring(TransferDate,1,10) = '".$date."')";
    $result_out = $mdsDB->mysqlQuery($sql_out);
    $row_out = $mdsDB->mysqlFetchArray($result_out);
    
    $bln = "";
    if( $index == $diff ){
        $sql_bln = " SELECT count(admission.ADMID) from admission  WHERE  (admission.Ward ='".sanitize($_GET["wid"])."' ) 
            AND ( admission.DischargeDate = '' ) 
            AND ( substring(admission.AdmissionDate,1,10) < '".$date."')
                ";
        $result_bln = $mdsDB->mysqlQuery($sql_bln);
        $row_bln = $mdsDB->mysqlFetchArray($result_bln);
        $bln = $row_bln[0];
    }
    
     echo "<tr>";
//    $pdf->Row(array($date,$row_adm[0],$row_dis[0],$row_in[0],$row_out[0],$bln,''));
     echo "<td  class='r_data r_left_border'>".$date."</td>
            <td class='r_data r_right' style='cursor:pointer;' onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=admission') >".$row_adm[0]."</td>
            <td  class='r_data r_right' style='cursor:pointer;'  onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=transfer_in')>".$row_in[0]."</td>    
                
            <td  class='r_data r_right' style='cursor:pointer;'  onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=death_within_48')>".$row_dis_less_48[0] ."</td>
                <td  class='r_data r_right' style='cursor:pointer;'  onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=death_after_48')>".$row_dis_greater_48[0] ."</td>
            <td  class='r_data r_right' style='cursor:pointer;'  onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=discharge')>".$row_dis[0]."</td>
            
            <td class='r_data r_right' style='cursor:pointer;'  onclick=popup('../mc_drill_down.php?dte=".$date."&wrd=".$_GET["wid"]."&tbl=transfer_out')>".$row_out[0]."</td>
            <td  class='r_data r_right'>".$bln."</td>";
    date_add($from_date, new DateInterval('P1D'));
    //-$row_out[0]-$row_dis[0]+$row_in[0]+$row_adm[0]
     echo "</tr>";
}
 echo "</table>";
 echo "</body>";
 echo "</html>";

 echo "\n
    <script>
        function popup(link) {
            var params = 'menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=500,height=200'
            var url = link;
            var pwdW = window.open(url, 'pwdW1', params);
        }
    </script>";
//$pdf->Output('midnight_census_'.$from.'_to_'.$to,'I');
function sanitize($data){
    $data=trim($data);
    $data=htmlspecialchars($data);
    $data = mysql_escape_string($data);
    $data = stripslashes($data);
    return $data;
}

?>
