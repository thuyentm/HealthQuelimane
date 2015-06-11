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

$opd = new MDSOpd();
$pat = new MDSPatient();
$opd->openId($_GET["OPD"]);
$pat = $opd->getOpdPatient();
$lab_data = $opd->getLabOrders();
//$pat->displayFields();
//echo print_r($lab_data);

$dat_d = date('d/m/Y');
$pat_hos_d = $pat->getHospital();
$pat_nam_d = $pat->getFullName();
$pat_pid_d = $pat->getId();
$pat_age_d = $pat->getAge();
$pat_nic_d = $pat->getValue("NIC");
$complaint_d = $opd->getValue("Complaint");
$pat_sex_d = $pat->getValue("Gender");
$pat_dob_d = $pat->getValue("DateOfBirth");
$pat_civ_d = $pat->getValue("Personal_Civil_Status");
$pat_rem_d = $pat->getValue("Remarks");
$pat_add_d = $pat->getValue("Address_Street") . "," . $pat->getValue("Address_Village") . "," . $pat->getValue("Address_DSDivision") . "," . $pat->getValue("Address_District");
$pat_visit_dat_d = $opd->getValue("DateTimeOfVisit");
$pat_onset_dat_d = $opd->getValue("OnSetDate");
$pat_doctor_d = $opd->getOPDDoctor();
$pat_complaint_d = $opd->getValue("Complaint");
$pat_icd_d = $opd->getValue("ICD_Code") . " " . $opd->getValue("ICD_Text");
$pat_snomed_d = $opd->getValue("SNOMED_Text");
$pat_rem_d = $opd->getValue("Remarks");
// $barcode=$lab_data->getId();
//$lab_data = $labOrder->getLabDataJSON(); //returns the lab data in the folowing format
/*
  $lab_data[i] = array( "test" => "test_name", "value" => "test_value",  ref => "ref_value");
  eg :
  $lab_data[0] = array( "test" => "Urine pH", "value" => "5",  ref => "5-8");
  $lab_data[1] = array( "test" => "Urine Bile", "value" => "+",  ref => "Negative");
  .........................................
 */

// Document constants
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


//..............................................................................................................................................
// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A5');
// Add a new page to the document
$pdf->addPage();

$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_title);


// Write patient details - field names
$dh = 2;
$fsize = 10;
$dy = 3;

$pdf->setDy(0);
$pdf->setDx(45);
$pdf->Ln();
$pdf->SetWidths(array(24,40,24,40));
$pdf->colRow(array($pat_nam, $pat_nam_d,$pat_pid, $pat_pid_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_dob, $pat_dob_d,$pat_age, $pat_age_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d,$pat_sex, $pat_sex_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_nic, $pat_nic_d,$pat_add, $pat_add_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_visit_dat, $pat_visit_dat_d,$pat_onset_dat, $pat_onset_dat_d),FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_complaint, $pat_complaint_d,$pat_doctor, $pat_doctor_d),FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_icd, $pat_icd_d,$pat_snomed, $pat_snomed_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_rem, $pat_rem_d,'',''), FALSE, $fsize, $dy, $dh);
$pdf->horizontalLine();
if ($lab_data) {
//Column titles
    $header = array('Test', 'Result', 'Ref. Value');
    $pdf->SetWidths(array(40, 40, 48));
    $pdf->Ln();
    $pdf->Row($header,true);
    $pdf->SetFont('courier', '', 8);
    foreach ($lab_data as $row) {
        $row = array($row['test'], $row['value'], str_replace('<br>', ',', $row['ref']));
        $pdf->Row($row);
    }
}

// $pdf->setBarcode($barcode);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . '_diagnostic_tests.pdf', 'I');
?>