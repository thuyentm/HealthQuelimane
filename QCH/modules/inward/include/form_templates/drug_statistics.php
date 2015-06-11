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

include_once 'mds_reporter/MDSReporter.php';
include '../config.php';

$from_date = $_GET['from'];
$to_date = $_GET['to'];




if (!$from_date && !$to_date) {
    echo 'please spacify valid date ';
    exit();
}
//pdf decleration
$pdf = new MDSReporter('P', 'mm', 'A4');
//$pdf->setFormNum('Health 383A');
$pdf->AddPage();
//setup page title

session_start();
$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle('Prescription by Drug From ' . $from_date . ' to ' . $to_date);
$pdf->Ln(3);
$pdf->MultiCell(0, 4, 'Format \'Patient Reg.No.->Quantity\'', 0, 'C');
//$pdf->Ln();

$link = mysql_connect(HOST, USERNAME, PASSWORD) or
        die("Could not connect: " . mysql_error());
mysql_select_db(DB);

$query = "select p.LPID as pid,d.`Name` as drug,pi.Quantity as quentity,SUBSTR(pi.CreateDate from 1 for 10) as cdate from prescribe_items as pi,opd_presciption as op,patient as p,drugs as d where pi.Status='Dispensed' and pi.CreateDate >= '" . mysql_real_escape_string($from_date) . "' and pi.CreateDate <= date_add('" . mysql_real_escape_string($to_date) . "',interval 1 day) and pi.PRES_ID=op.PRSID and op.PID=p.PID and pi.DRGID=d.DRGID and pi.Quantity>0 and op.GetFrom='Stock' order by pi.CreateDate,d.`Name`,p.LPID";
$result = mysql_query($query);
$count = mysql_num_rows($result);
if ($count != 0) {
    $pdf->writeSSubTitle("OPD:");
    $data = array();
    while ($row = mysql_fetch_array($result)) {
        if ($data[$row['drug']]) {
            array_push($data[$row['drug']], $row['pid'] . '->' . $row['quentity']);
        } else {
            $data[$row['drug']] = array($row['pid'] . '->' . $row['quentity']);
        }
    }
    mysql_free_result($result);
//    mysql_close($link);
    $pdf->SetFont("arial", "B");
    foreach ($data as $key => $value) {
        $pdf->MultiCell(0, 6, $key, 1);
        foreach ($value as $text) {
            $texts.=$text . ',';
        }
        $texts = substr($texts, 0, -1);
        $pdf->SetFont('arial', '');
        $pdf->MultiCell(0, 6, $texts, 1);
        $pdf->SetFont('arial', 'B');
        $texts = '';
    }
}
mysql_free_result($result);

$query = "select p.LPID as pid,d.`Name` as drug,pi.Quantity as quentity,SUBSTR(pi.CreateDate from 1 for 10) as cdate from prescribe_items as pi,opd_presciption as op,patient as p,drugs as d where pi.Status='Dispensed' and pi.CreateDate >= '" . mysql_real_escape_string($from_date) . "' and pi.CreateDate <= date_add('" . mysql_real_escape_string($to_date) . "',interval 1 day) and pi.PRES_ID=op.PRSID and op.PID=p.PID and pi.DRGID=d.DRGID and pi.Quantity>0 and op.GetFrom='ClinicStock' order by pi.CreateDate,d.`Name`,p.LPID";
$result = mysql_query($query);
$count = mysql_num_rows($result);
if ($count != 0) {
    $pdf->writeSSubTitle("Clinic:");
    $data = array();
    while ($row = mysql_fetch_array($result)) {
        if ($data[$row['drug']]) {
            array_push($data[$row['drug']], $row['pid'] . '->' . $row['quentity']);
        } else {
            $data[$row['drug']] = array($row['pid'] . '->' . $row['quentity']);
        }
    }
    mysql_free_result($result);
    mysql_close($link);
    $pdf->SetFont("arial", "B");
    foreach ($data as $key => $value) {
        $pdf->MultiCell(0, 6, $key, 1);
        foreach ($value as $text) {
            $texts.=$text . ',';
        }
        $texts = substr($texts, 0, -1);
        $pdf->SetFont('arial', '');
        $pdf->MultiCell(0, 6, $texts, 1);
        $pdf->SetFont('arial', 'B');
        $texts = '';
    }
}


$pdf->Output('prescription_by_drug_from ' . $from_date . ' to ' . $to_date, 'I');
?>
