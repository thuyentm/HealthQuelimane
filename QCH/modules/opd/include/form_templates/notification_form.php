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


require('fpdf/fpdf.php');

// Document variables (to be passed to the script) - defined here for testing
$pat_hos_d = 'Rideegama Base Hospital, Kurunegala'; //Institute
$pat_dis_d = 'Chickenpox'; //Disease to be notified
$pat_nam_d = 'M. M. Hussein'; //Patient name
$pat_don_d = '12/01/2011'; //Date of onset
$pat_con_d = 'Mrs G. W. Hussein';  //Name of guardian/parent (for children)
$pat_dvi_d = '12/01/2011'; //Date of visit (or admission - later)
$pat_bht_d = '1234/123'; //Bed head ticket number (later)
$pat_war_d = 'Ward 5'; //Ward (later)
$pat_age_d = '2 yrs';
$pat_sex_d = 'Female'; //Gender
$pat_lab_d = 'Not carried out'; //Laboratory Results (if available) (to be added as a user input field)
$pat_add_d = '23 Matale Road, Rideegama Town and Gravets, Rideegama, Sri Lanka';
$pat_tel_d = '064 222 3123'; //Home telephone number
$dat_d = date('d/m/Y'); //Date form produced
$pat_moh_d = 'The Medical Officer of Health, Rideegama Division, 234 Dambulla Road, Post Office Box 222, Kurunegala.';

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
$pdf = new PDF('P', 'mm', 'A4');
// Set base font to start
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255,0,0);
// Add a new page to the document
$pdf->addPage();
$pdf->SetRightMargin(0);
$pdf->Image('notification_form.jpg',0,0,200);

// Constant for adjusting left margin and distance from top
$mar = 30;
$top = 15;
// Write data - field names
$pdf->SetXY($mar + 20, $top + 18);
$pdf->write(13, $pat_hos_d);
$pdf->SetXY($mar + 125, $top + 18);
$pdf->write(13, $pat_dis_d);
$pdf->SetXY($mar + 10, $top + 30);
$pdf->write(13, $pat_nam_d);
$pdf->SetXY($mar + 125, $top + 30);
$pdf->write(13, $pat_don_d);
$pdf->SetXY($mar - 20, $top + 56);
$pdf->write(13, $pat_con_d);
$pdf->SetXY($mar + 125, $top + 45);
$pdf->write(13, $pat_dvi_d);
$pdf->SetXY($mar + 7, $top + 68);
$pdf->write(13, $pat_bht_d);
$pdf->SetXY($mar + 52, $top + 68);
$pdf->write(13, $pat_war_d);
$pdf->SetXY($mar + 97, $top + 68);
$pdf->write(13, $pat_age_d);
$pdf->SetXY($mar + 148, $top + 68);
$pdf->write(13, $pat_sex_d);
$pdf->SetXY($mar + 52, $top + 83);
$pdf->write(13, $pat_lab_d);
$pdf->SetXY($mar - 20, $top + 110);
$pdf->write(13, $pat_add_d);
$pdf->SetXY($mar + 35, $top + 135);
$pdf->write(13, $pat_tel_d);
$pdf->SetXY($mar + 140, $top + 150);
$pdf->write(13, $dat_d);
$pdf->SetXY($mar - 20, $top + 210);
$pdf->write(13, $pat_moh_d);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('notification_form.pdf','D');
?>
