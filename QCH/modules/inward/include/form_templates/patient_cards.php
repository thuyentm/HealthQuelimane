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

//
// patient_cards - two cards on the left, patient slip on the right
//
include_once 'mds_reporter/MDSReporter.php';
// Document constants
$pat_nam = 'Name in full: ';
$pat_pid = 'Register number: ';
$pat_cno = 'Clinic number: ';
//$bring = 'Bring this card with you on your next visit';
$bring = 'Bring this card with you on every visit to the hospital';
$dat = 'Date: ';
$form_title = 'Patient Slip';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
// Document variables (from the mds6 database)
include '../class/MDSPatient.php';

if (!$_GET["PID"]) {
    echo "Invalid Patient ID ";
    exit();
}

$patient = new MDSPatient();
$patient->openId($_GET["PID"]);
if ($patient) {
    $pat_nam_d = $patient->getFullName(); //returns the fullname
    $pat_hos_d = "BANGLADESH-KOREA FRIENDSHIP HOSPITAL"; //returns the default hospital
    $pat_sex_d = $patient->getValue("Gender");
    //Clinic number only used in Sri Lanka
    //$pat_cno_d = $patient->getValue("ClinicNo");
    $pat_dob_d = $patient->getValue("DateOfBirth");
    $pat_age_d = $patient->getAge(); //returns in format 23yrs 3mths
    $pat_civ_d = $patient->getValue("Personal_Civil_Status");
    $pat_nic_d = $patient->getValue("NIC");
    $pat_rem_d = $patient->getValue("Remarks");
    $pat_pid_d = $patient->getId(); // returns the ID
    $barcode = $pat_pid_d;
//     $barcode = 'P1234567';
//     $pat_pid_d = substr($pat_pid_d, 0, 3) . '  ' . substr($pat_pid_d, 3, 3) . '  ' . substr($pat_pid_d, 6, 3) . '  ' . substr($pat_pid_d, 9, 99);
    $pat_add_d = $patient->getValue("Address_Street") . "," . $patient->getValue("Address_Street1") . '.' . $patient->getValue("Address_Village") . "," . $patient->getValue("Address_DSDivision") . "," . $patient->getValue("Address_District");
}

class PDF extends MDSReporter {

    //Current column
    var $col = 0;
    //Ordinate of column start
    var $y0;

    function showData($x1, $y1, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring, $barcode) {
        $this->SetAutoPagebreak(0);
        $this->SetFont('arial', 'BU', 10);
        $dy = 7;

        $this->SetXY($x1, $y1 + 1 * $dy);
        $this->MultiCell(0, 4, $pat_hos_d, 0, 1, 0);
        $this->SetFont('arial', 'B', 10);

        $this->SetXY($x1, $y1 + 2 * $dy);
        $this->write(8, $pat_nam);

        /* $this->SetXY($x1, $y1 + 3*$dy);
          $this->write(8, $pat_cno); */

        $this->SetXY($x1, $y1 + 3 * $dy);
        $this->write(8, $pat_pid);

        $this->SetFont('arial', '', 10);
        $x2 = $x1 + 25;
        $this->SetXY($x2 + 10, $y1 + 2 * $dy);
//        $pat_nam_d=strlen($pat_nam_d)>25?substr($pat_nam_d,0,25).'...':$pat_nam_d;
        $this->write(6, $pat_nam_d);

        /* $this->SetXY($x2 + 10, $y1 + 3*$dy);
          $this->write(8, $pat_cno_d); */

        $this->SetXY($x2 + 10, $y1 + 3 * $dy);
        $this->write(8, $pat_pid_d);

        $this->setBarcode($barcode, $x1 + 15, $y1 + 4 * $dy);

        $this->SetXY($x1, $y1 + 6 * $dy);
        $this->write(8, $bring);
        $this->SetXY($x1, $y1 + 6 * $dy);
    }

}

#.......................................................................................................................................
// Create fpdf object
$pdf = new PDF('P', 'mm', 'A5', false);
$pdf->addPage();

$dx = $pdf->getPageWidth() - $pdf->GetStringWidth($pat_nam_d);
$dx-=20;
$dx/=2;
// Print two cards on the left side of the page (A5 landscape)
$pdf->showData($dx, 50, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring, $barcode);
//$pdf->showData(10, 70, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring,$barcode);
//// Print two cards on the right side of the page (A5 landscape)
//$pdf->showData(110, 0, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring,$barcode);
//$pdf->showData(110, 70, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring,$barcode);
//add line separetors
//for ($i = 1; $i <= 130; $i++) {
//    $pdf->SetXY(100, $i);
//    $pdf->write(13, '.');
//}
//for ($i = 10; $i <= 195; $i++) {
//    $pdf->SetXY($i, 65);
//    $pdf->write(13, '.');
//}
// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . ' patient_cards.pdf', 'I');
?>
