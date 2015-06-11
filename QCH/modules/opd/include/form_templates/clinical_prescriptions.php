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
date_default_timezone_set('Asia/Colombo');
include_once 'mds_reporter/MDSReporter.php';
include '../config.php';

$from_date = new DateTime($_GET['from']);
$to_date = new DateTime($_GET['to']);

$diff = $from_date->diff($to_date)->format('%a');

if (!$from_date && !$to_date) {
    echo 'please spacify valid date ';
    exit();
}
session_start();
//pdf decleration
$pdf = new MDSReporter('P', 'mm', 'A4');
//$pdf->setFormNum('Health 383A');
$pdf->AddPage();
//setup page title
$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle('OPD Prescriptions From ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"));
$pdf->writeSSubTitle('Limited to patients where drugs were dispensed.', 10, true, 10);

$link = mysql_connect(HOST, USERNAME, PASSWORD) or
        die("Could not connect: " . mysql_error());
mysql_select_db(DB);

for ($index = 0; $index <= $diff; $index++) {

    $date = $from_date->format("Y-m-d");

    $query = "select OPDID,PRSID from opd_presciption as op where op.Status='Dispensed' and op.PrescribeDate and substring(op.PrescribeDate,1,10)='$date' and op.GetFrom='Stock' order by PID";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $pdf->writeSSubTitle('OPD: '.$date, 10, true,0);
        $pdf->Ln();
    }
    
    while ($row = mysql_fetch_array($result)) {
        $pid = $row ? $row['OPDID'] : null;
        $prspid = $row ? $row['PRSID'] : null;
        if ($pid && $prspid) {
            $query2 = "select p.PID as 'pid',p.Personal_Used_Name as 'initials',p.Full_Name_Registered as 'name',p.Gender as 'gender',ov.Complaint as 'complaint' from patient as p,opd_visits as ov where ov.OPDID='$pid' and ov.PID=p.PID ";
            $result2 = mysql_query($query2);
            $row2 = mysql_fetch_array($result2);
            $pid=$row2['pid'];
            mysql_free_result($result2);
            $pdf->MultiCell(0,4,'*' . $pid . ',' . $row2['initials'] . ' ' . $row2['name'] . ',' . substr($row2['gender'],-6,1) . ',' . $row2['complaint'].' :');
            $query3 = "select d.`Name`,pi.Quantity,pi.Frequency from prescribe_items as pi,drugs as d where pi.PRES_ID=$prspid and pi.DRGID=d.DRGID";
            $result3 = mysql_query($query3);
            while ($row3 = mysql_fetch_array($result3)) {
                $pdf->Write(4, $row3['Name'] . '^' . $row3['Quantity'] . ',');
            }
            mysql_free_result($result3);
            $pdf->Ln();
        }
    }
    
//clinic    
    $query = "select PID,PRSID from opd_presciption as op where op.Status='Dispensed' and op.PrescribeDate and substring(op.PrescribeDate,1,10)='$date' and op.GetFrom='ClinicStock'  order by PID";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $pdf->writeSSubTitle('Clinics: '.$date, 10, true,0);
        $pdf->Ln();
    }
    unset ($pid);
    unset ($row);
    unset ($prspid);
    while ($row = mysql_fetch_array($result)) {
        $pid = $row ? $row['PID'] : null;
        $prspid = $row ? $row['PRSID'] : null;
        if ($pid && $prspid) {
            $query2 = "select p.PID as 'pid',p.Personal_Used_Name as 'initials',p.Full_Name_Registered as 'name',p.Gender as 'gender',ov.Complaint as 'complaint' from patient as p,opd_visits as ov where ov.PID='$pid' and ov.PID=p.PID ";
            $result2 = mysql_query($query2);
            $row2 = mysql_fetch_array($result2);
            $pid=$row2['pid'];
            mysql_free_result($result2);
            $pdf->MultiCell(0,4,'*' . $pid . ',' . $row2['initials'] . ' ' . $row2['name'] . ',' . substr($row2['gender'],-6,1) . ',' . $row2['complaint'].' :');
            $query3 = "select d.`Name`,pi.Quantity,pi.Frequency from prescribe_items as pi,drugs as d where pi.PRES_ID=$prspid and pi.DRGID=d.DRGID";
            $result3 = mysql_query($query3);
            while ($row3 = mysql_fetch_array($result3)) {
                $pdf->Write(4, $row3['Name'] . '^' . $row3['Quantity'] . ',');
            }
            mysql_free_result($result3);
            $pdf->Ln();
        }
    }
    
    
//admission
    
    $query = "select PID,PRSID from opd_presciption as op where op.Status='Dispensed' and op.PrescribeDate and substring(op.PrescribeDate,1,10)='$date' and op.GetFrom=''  order by PID";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        $pdf->writeSSubTitle('Admissions: '.$date, 10, true,0);
        $pdf->Ln();
    }
    unset ($pid);
    unset ($row);
    unset ($prspid);
    while ($row = mysql_fetch_array($result)) {
        $pid = $row ? $row['PID'] : null;
        $prspid = $row ? $row['PRSID'] : null;
        if ($pid && $prspid) {
            $query2 = "select p.PID as 'pid',p.Personal_Used_Name as 'initials',p.Full_Name_Registered as 'name',p.Gender as 'gender',ov.Complaint as 'complaint' from patient as p,admission as ov where ov.PID='$pid' and ov.PID=p.PID ";
            $result2 = mysql_query($query2);
            $row2 = mysql_fetch_array($result2);
            $pid=$row2['pid'];
            mysql_free_result($result2);
            $pdf->MultiCell(0,4,'*' . $pid . ',' . $row2['initials'] . ' ' . $row2['name'] . ',' . substr($row2['gender'],-6,1) . ',' . $row2['complaint'].' :');
            $query3 = "select d.`Name`,pi.Quantity,pi.Frequency from prescribe_items as pi,drugs as d where pi.PRES_ID=$prspid and pi.DRGID=d.DRGID";
            $result3 = mysql_query($query3);
            while ($row3 = mysql_fetch_array($result3)) {
                $pdf->Write(4, $row3['Name'] . '^' . $row3['Quantity'] . ',');
            }
            mysql_free_result($result3);
            $pdf->Ln();
        }
    }
    

    date_add($from_date, new DateInterval('P1D'));
}

mysql_close($link);
$pdf->Output('opd_prescriptions'.date('Y-m-d@H:i'), 'i');
?>