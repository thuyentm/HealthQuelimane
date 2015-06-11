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
include_once '../class/MDSUser.php';
include_once 'mds_reporter/MDSReporter.php';
// Document constants
$dat = 'Date: ';
$form_title = 'Prescription';
$pat_nam = 'Patient Name: ';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_rel = 'Religion: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_pid = 'Register No: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
$pat_vist_dat = "Visit Date:";
$pat_onset_dat = "OnSet Date:";
$pat_doctor = "Doctor:";
$pat_complaint = "Complaint:";
$pat_icd = "ICD:";
$pat_snomed = "SNOMED:";
$pat_rem = "Remarks:";
// Document variables (to be passed to the script) - defined here for testing




$patient=new MDSPatient();
$opd = new MDSOpd();
$opd->openId($_GET["OPD"]);
$patient = $opd->getOpdPatient();
$prescription = $opd->getPrescriptionItemsJSON();
if ($patient) {
    $dat_d = date('d/m/Y');
    $pat_nam_d = $patient->getFullName(); //returns the fullname
    $pat_hos_d = $patient->getHospital(); //returns the default hospital
    $pat_sex_d = $patient->getValue("Gender");
    $pat_dob_d = $patient->getValue("DateOfBirth");
    $pat_age_d = $patient->getAge(); //returns in format 23yrs 3mths
    $pat_civ_d = $patient->getValue("Personal_Civil_Status");
    $pat_nic_d = $patient->getValue("NIC");
    $pat_rem_d = $patient->getValue("Remarks");
    $pat_pid_d = $patient->getId(); // returns the ID
    $pat_add_d = $patient->getValue("Address_Street") . " " . $patient->getValue("Address_Village") . " " . $patient->getValue("Address_DSDivision") . " " . $patient->getValue("Address_District");
    $pat_vist_dat_d = $opd->getValue("DateTimeOfVisit");
    $pat_onset_dat_d = $opd->getValue("OnSetDate");
    $pat_doctor_d = $opd->getOPDDoctor();
    $pat_complaint_d = $opd->getValue("Complaint");
    $pat_icd_d = $opd->getValue("ICD_Code") . " " . $opd->getValue("ICD_Text");
    $pat_snomed_d = $opd->getValue("SNOMED_Text");
    $pat_rem_d = $opd->getValue("Remarks");
}

// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A5');
// Add a new page to the document
$pdf->addPage();
// Set the x,y coordinates of the cursor
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_title);

// Reset font, color, and coordinates
$pdf->SetFont('courier', '', 8);
$pdf->SetTextColor(0, 0, 0);

// Write patient details - field names

$pdf->setDy(0);
$pdf->setDx(45);
$pdf->Ln();
$pdf->SetWidths(array(22,40,20,40));
$pdf->colRow(array($pat_nam, $pat_nam_d,$pat_pid, $pat_pid_d),false,8,4);
$pdf->colRow(array($pat_add, $pat_add_d,$pat_age, $pat_age_d),false,8,4);
$pdf->Ln();
$pdf->Image('rx.png',5,$pdf->GetY()-6.5,20,20);
$pdf->Ln();
$rows=10;
if ($prescription) {
//    $pdf->writeSSubTitle('Prescription:');
    $w = array(130);
    $pdf->SetWidths($w);
    $pdf->bottomRow(array('','','',''),true);
//    $pdf->bottomRow(array('Name','Dosage','How Long'),true);
    foreach ($prescription as $row) {
        $row=array($row['Name'].'     '.$row['Dosage'].'     '.$row['Frequency'].'     '.$row['HowLong']);
        $pdf->bottomRow($row ,false, 10, 8);
        $rows-=1;
    }
}

//for($i=0;$i<$rows;$i++){
//    $pdf->horizontalLine(10);
//}
$pdf->addCirtification();
// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d.'prescription', 'i');
?>
