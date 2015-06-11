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


if ( !$_GET["OPD"] ) { echo "Invalid Order ";  exit(); }
require('fpdf/fpdf.php');
include_once '../class/MDSOpd.php';

// Document constants
$dat = 'Date: ';
$form_title = 'OPD clinical information';
$pat_nam = 'Name in full: '; 
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_rel = 'Religion: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_pid = 'Register number: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';

// Document variables (to be passed to the script) - defined here for testing





$opd = new MDSOpd();
$opd->openId($_GET["OPD"]);
$patient = $opd->getOpdPatient();

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
    $pat_add_d = $patient->getValue("Address_Street").",".$patient->getValue("Address_Village").",".$patient->getValue("Address_DSDivision").",".    $patient->getValue("Address_District");
}

class PDF extends FPDF {
//Current column
var $col = 0;
//Ordinate of column start
var $y0;
function Footer() {
    // Page footer
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8 (If there is no Arial stored, Helvetica will be substituted)
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);  //  light gray
    // Page number - can also use Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C')
    // {nb} will be substituted on document closure by calling AliasNbPages()
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}

// Create fpdf object
$pdf = new PDF('P', 'mm', 'A5');
// Set base font to start
$pdf->SetFont('Times', 'B', 18);
// Add a new page to the document
$pdf->addPage();
// Set the x,y coordinates of the cursor
$x1 = 10;
$pdf->SetXY($x1,0);
$pdf->Cell(0,10, $form_title, 'B', 2, 'C', false);

// Reset font, color, and coordinates
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

// Write patient details - field names
$pdf->SetXY($x1, 15);
$pdf->write(13, $pat_nam);
$pdf->SetXY($x1, 20);
$pdf->write(13, $pat_sex);
$pdf->SetXY($x1, 25);
$pdf->write(13, $pat_dob);
$pdf->SetXY($x1, 30);
$pdf->write(13, $pat_age);
$pdf->SetXY($x1, 35);
$pdf->write(13, $pat_civ);
$pdf->SetXY($x1, 40);
$pdf->write(13, $pat_rel);
$pdf->SetXY($x1, 45);
$pdf->write(13, $pat_nic);
$pdf->SetXY($x1, 50);
$pdf->write(13, $pat_rem);

// Write patient details - information
$x2 = 35;
$pdf->SetXY($x2, 15);
$pdf->write(13, $pat_nam_d);
$pdf->SetXY($x2, 20);
$pdf->write(13, $pat_sex_d);
$pdf->SetXY($x2, 25);
$pdf->write(13, $pat_dob_d);
$pdf->SetXY($x2, 30);
$pdf->write(13, $pat_age_d);
$pdf->SetXY($x2, 35);
$pdf->write(13, $pat_civ_d);
$pdf->SetXY($x2, 40);
$pdf->write(13, $pat_rel_d);
$pdf->SetXY($x2, 45);
$pdf->write(13, $pat_nic_d);
$pdf->SetXY($x2, 55);
$pdf->MultiCell(0,4, $pat_rem_d,0,1,0);
$yi=$pdf->GetY();
// Write patient details - field names
$x3=75;
$pdf->SetXY($x3, 15);
$pdf->write(13, $pat_pid);
$pdf->SetXY($x3, 20);
$pdf->write(13, $pat_hos);
$pdf->SetXY($x3, 30);
$pdf->write(13, $dat);
$pdf->SetXY($x3, 35);
$pdf->write(13, $pat_add);

// Write patient details - information
$x4 = 100;
$pdf->SetXY($x4, 15);
$pdf->write(13, $pat_pid_d);
$pdf->SetXY($x4, 25);
$pdf->MultiCell(0,4, $pat_hos_d,0,1,0);
$pdf->SetXY($x4, 30);
$pdf->write(13, $dat_d);
$pdf->SetXY($x4, 40);
$pdf->MultiCell(0, 4, $pat_add_d,0,1,0);

for ($i = 10; $i <= 130; $i++) {
    $pdf->SetXY($i,$yi);
    $pdf->write(13,'.');
}

$dy=5;

$pdf->SetXY($x1, $yi+$dy); $pdf->write(13, "Visit Date:");
$pdf->SetXY($x2, $yi+$dy); $pdf->write(13, $opd->getValue("DateTimeOfVisit"));
$pdf->SetXY($x3, $yi+$dy); $pdf->write(13, "OnSet Date:");
$pdf->SetXY($x4, $yi+$dy); $pdf->write(13, $opd->getValue("OnSetDate"));
$pdf->SetXY($x1, $yi+2*$dy); $pdf->write(13, "Doctor:");
$pdf->SetXY($x2, $yi+2*$dy); $pdf->write(13, $opd->getOPDDoctor());
$pdf->SetXY($x1, $yi+3*$dy); $pdf->write(13, "Complaint:");
$pdf->SetXY($x2, $yi+3*$dy); $pdf->write(13, $opd->getValue("Complaint"));
$pdf->SetXY($x1, $yi+4*$dy); $pdf->write(13, "ICD:");
$pdf->SetXY($x2, $yi+4*$dy); $pdf->write(13, $opd->getValue("ICD_Code")." ".$opd->getValue("ICD_Text"));
$pdf->SetXY($x1, $yi+5*$dy); $pdf->write(13, "SNOMED:");
$pdf->SetXY($x2, $yi+5*$dy); $pdf->write(13, $opd->getValue("SNOMED_Text"));
$pdf->SetXY($x1, $yi+6*$dy); $pdf->write(13, "Remarks:");
$pdf->SetXY($x2, $yi+6*$dy+5); $pdf->MultiCell(0, 4, $opd->getValue("Remarks"),0,1,0);
$yi=$pdf->GetY()+7*$dy;

for ($i = 10; $i <= 130; $i++) {
    $pdf->SetXY($i,$yi);
    $pdf->write(13,'.');
}
/*
$pdf->SetXY($x1, 100); $pdf->write(13, "Prescription:");
$prescription = $opd->getPrescriptionItemsJSON();

$w=array(80,20,20);
$pdf->SetXY(10,110);
	$pdf->Cell($w[0],4,"Name",1,0,'L');
	$pdf->Cell($w[1],4,"Dosage",1,0,'R');
	$pdf->Cell($w[2],4,"HowLong",1,0,'C');
	
for($i=0;$i<count($prescription);$i++){
	$pdf->SetXY(10,115+5*$i);
	$pdf->Cell($w[0],4,$prescription[$i]["Name"],1,0,'L');
	$pdf->Cell($w[1],4,$prescription[$i]["Dosage"],1,0,'R');
	$pdf->Cell($w[2],4,$prescription[$i]["HowLong"],1,0,'C');

}
*/
// Close the document and offer to show or save to ~/Downloads
$pdf->Output('','i');
?>
