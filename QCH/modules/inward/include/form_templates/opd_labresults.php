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

if (!$_GET["OPD"]) {
    echo "Invalid Order ";
    exit();
}

include_once 'mds_reporter/MDSReporter.php';
include_once '../class/MDSLabOrder.php';
include_once '../class/MDSOpd.php';
include_once 'print_util.php';
session_start();
$lid=$_GET["OPD"];


$link = mysql_connect(HOST, USERNAME, PASSWORD) or
        die("Could not connect: " . mysql_error());
mysql_select_db(DB);

$query="select concat(p.Personal_Title,' ',p.Full_Name_Registered) as `name`,p.PID,p.DateOfBirth,p.Age,p.Personal_Civil_Status,p.Gender,p.NIC,concat(p.Address_Street,' ',p.Address_Village,' ',p.Address_DSDivision,' ',p.Address_District) as address,ov.DateTimeOfVisit,ov.OnSetDate,ov.Complaint,concat(u.Title,u.FirstName,' ',u.OtherName) as doctor,ov.ICD_Text,ov.SNOMED_Text,ov.Remarks from patient as p,lab_order as lo,opd_visits as ov,`user` as u where lo.LAB_ORDER_ID=$lid and p.PID=lo.PID and ov.OPDID=lo.OBJID and ov.Doctor=u.UID";
$result=mysql_query($query);
$row=mysql_fetch_array($result);



$dat_d = date('d/m/Y');

$dat = 'Date';
$form_title = 'Diagnostic Test Results';
$pat_nam = 'Name in full: ';
$pat_age = 'Age: ';
$pat_pid = 'Register number: ';
$pat_hos = 'Hospital: ';
$orderdate = 'Order date :';
$complaint = 'Complaints / Injuries:';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_civ = 'Civil status: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_pid = 'Patient No: ';
$pat_add = 'Address: ';
$pat_rel = 'Religion: ';
$pat_visit_dat = "Visit Date:";
$pat_onset_dat = "OnSet Date:";
$pat_doctor = "Doctor:";
$pat_complaint = "Complaint:";
$pat_icd = "ICD:";
$pat_snomed = "SNOMED:";
$pat_rem = "Remarks:";

$pdf = new MDSReporter('P', 'mm', 'A5');
// Add a new page to the document
$pdf->addPage();

$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle("Diagnostic Test Results");
// Write patient details - field names
$dh = 2;
$fsize = 10;
$dy = 3;

$pdf->setDy(0);
$pdf->setDx(45);
$pdf->Ln();
$pdf->SetWidths(array(25,40,18,45));
$pdf->colRow(array($pat_nam, $row[0],$pat_pid, $row[1]), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_dob, $row[2],$pat_age, $row[3]), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $row[4],$pat_sex, $row[5]), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_nic, $row[6],$pat_add,$row[7]), FALSE, $fsize, $dy, $dh);
$pdf->MultiCell(0,4,'','B');
$pdf->Ln();
$pdf->SetWidths(array(25,45,24,40));
$pdf->colRow(array($pat_visit_dat, $row[8],$pat_onset_dat, $row[9]),FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_complaint, $row[10],$pat_doctor, $row[11]),FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_icd, $row[12],$pat_snomed, $row[13]), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_rem, $row[14],'',''), FALSE, $fsize, $dy, $dh);
$pdf->horizontalLine();

$query="select lt.`Name`,loi.TestValue,lt.RefValue from lab_order_items as loi,lab_tests as lt where loi.LAB_ORDER_ID=$lid and loi.LABID=lt.LABID";
$result=mysql_query($query);
$count=mysql_num_rows($result);
if($count>0){
    $header = array('Test', 'Result', 'Ref. Value');
    $pdf->SetWidths(array(40, 40, 48));
    $pdf->Ln();
    $pdf->Row($header,true);
    $pdf->SetFont('courier', '', 8);
    while ($row = mysql_fetch_array($result)) {
        $pdf->Row(array($row[0], $row[1], str_replace('<br>', ',', $row[2])));
    }
}

mysql_close($link);
// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . '_diagnostic_tests.pdf', 'I');
?>