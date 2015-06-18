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

// Document constants
$date = 'Date & Time:';
$title = 'EMERGENCY';
$title1='BASE HOSPITAL - AVISSAWELLA';
$pat_name = 'Patient Name: ';
$pat_sex = '';
//$pat_dob = 'Date of birth: ';
//$pat_age = 'Age: ';
//$pat_status = 'Civil status: ';
$chief_comp= 'Chief Complaint:';
$provi_diag= 'Provisional Diagnosis:';
$triage= 'Triage Category:';
$diagnosis='Provisional Diagnosis';
$pat_rel = 'Religion: ';
$pat_nic = 'NIC number: ';
$pat_rmarks = 'Remarks: ';
$pat_rnum = 'Register No: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
$decision="Died (RED):"." ..........................". "  Home with Instructions:"." .............................". "  Observation:"." ............................ ". "  Referred to:"." ..........................";



// Document variables (to be passed to the script) - defined here for testing

include '../class/MDSPatient.php';
include_once 'print_util.php';

if (!$_GET["PID"]) {
    echo "Invalid Patient ID ";
    exit();
}

$patient = new MDSPatient();
$patient->openId($_GET["PID"]);
if ($patient) {
    $dat_d = date("l jS \of F Y h:i:s A");
    $pat_nam_d = $patient->getFullName(); //returns the fullname
    $pat_hos_d = $patient->getHospital(); //returns the default hospital
    //$pat_sex_d = $patient->getValue("Gender");
   // $pat_dob_d = $patient->getValue("DateOfBirth");
   // $pat_age_d = $patient->getAge(); //returns in format 23yrs 3mths
   // $pat_civ_d = $patient->getValue("Personal_Civil_Status");
    $pat_basic_info="Sex:"." ".$patient->getValue("Gender")."    ". " Date of Birth:" . " " . $patient->getValue("DateOfBirth") ."       ". "Age: " ." ". $patient->getAge()."      " . " Civil Status:" ." ".  $patient->getValue("Personal_Civil_Status");
    $pat_nic_d = $patient->getValue("NIC");
	$pat_rem_d = $patient->getValue("Remarks");
    $pat_pid_d = $patient->getId(); // returns the ID
    $barcode=$pat_pid_d;
//     $pat_pid_d = substr($pat_pid_d, 0, 3) . '  ' . substr($pat_pid_d, 3, 3) . '  ' . substr($pat_pid_d, 6, 3) . '  ' . substr($pat_pid_d, 9, 99);
    $pat_add_d = $patient->getValue("Address_Street") . " " . $patient->getValue("Address_Street1") . " " . $patient->getValue("Address_Village") . " " . $patient->getValue("Address_DSDivision") . " " . $patient->getValue("Address_District");
    $pat_assesment="Temp:"." ..........................". "  Pulse:"." .............................". "  BP:"." ............................ ". "  Weight:"." ..........................";
	$mo_note="Time:"." ........................"."                 MEDICAL OFFICER'S NOTES";
	$decision="Died (RED):"." ............". "   Home with Instructions:"." ............". "   Observation:"." ............ ". "  Referred to:"." ...........................";
    $doc_name="Name of Medical officer: Dr .................................................................. (Please write name)";
    $transfer="Transfer to ward: .................................  Authorized by Dr ................................ Intern/SHO/Registar/Consultant";

}

// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A4');
// Add a new page to the document
$pdf->addPage();

// Print two cards on the left side of the page (A5 landscape)
//$pdf->showData(10,0,$patient,$headings) ;
//$pdf->setDy(0);
$pdf->writeTitle($title1,5,'L');
$pdf->writeSubTitle($title,12,true,'L');
$pdf->setDy(0);
$pdf->Ln();
$pdf->writeField($date, $dat_d);
$pdf->writeField($pat_name, $pat_nam_d);
$pdf->writeField($pat_rnum, $pat_pid_d);
$pdf->writeField($pat_sex, $pat_basic_info);
//$pdf->writeField($pat_dob, $pat_dob_d);
//$pdf->writeField($pat_age, $pat_age_d);
//$pdf->writeField($pat_status, $pat_civ_d);
$pdf->writeField($pat_nic, $pat_nic_d);
$pdf->writeField($pat_add,$pat_add_d);
$pdf->Ln();
$pdf->writeField($chief_comp,'................................................................................................................................................................');
//$pdf->writeField($pat_rem,$pat_rem_d);
$pdf->Ln();
$pdf->writeField($pat_sex, $pat_assesment);
$pdf->horizontalLine(2);
$pdf->Ln();
$pdf->Ln();
$pdf->writeField($pat_sex, $mo_note);
for ($x=0; $x<=26; $x++) {
  $pdf->Ln();
}
$pdf->writeField($triage,' I...............  II...............   III..............  IV...............');
$pdf->Ln();
$pdf->writeField($provi_diag,' ...............................................................................................  Diagnosis: ');
$pdf->Ln();
$pdf->writeField($decision,'');
$pdf->Ln();
$pdf->writeField($doc_name,'');
$pdf->Ln();
$pdf->horizontalLine(2);
$pdf->Ln();
$pdf->Ln();
$pdf->writeField($transfer,'');



//echo "BarcodeX=".$barcodeX;
//$barcode="P215432";
$barcodeX=$pdf->getPageWidth()-$pdf->getBarcodeWidth($barcode);
//$pdf->setBarcode($barcode,$barcodeX+5,2);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . ' pcu_slip', 'i');
?>
