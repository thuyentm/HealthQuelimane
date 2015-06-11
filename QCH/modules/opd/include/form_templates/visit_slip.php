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
// Document constants
$dat = 'Date';
$form_title = 'Hospital Visit Slip';
$pat_nam = 'Name in full: '; 
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_pid = 'Register number: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
$vis_dat = 'Date/time of visit: ';
$vis_con = 'Consultant name:';
$vis_com = 'Main complaint: ';
$vis_pre = 'Other complaints: ';
$vis_dru = 'Drugs/treatments: ';
$vis_dia = 'Diagnostic tests: ';
$vis_rem = 'OPD remarks: ';

// Document variables (to be passed to the script) - defined here for testing
$dat_d = date('d/m/Y');
$pat_hos_d = 'Rideegama Base Hospital';
$pat_nam_d = 'M. M. Hussein'; 
$pat_pid_d = 'RBH17892';
$pat_age_d = '22yrs 4 mths';
$pat_civ_d = 'Single';
$pat_add_d = "23 Kurunegala Road, Rideegama Town and Gravets, Rideegama, Sri Lanka";
$vis_dat_d = '02 Oct 2010 / 10:07';
$vis_con_d = 'Dr J.B. Haldane';
$vis_com_d = 'Suspected influenza';
$vis_pre_d = 'Fever, sore throat';
$vis_dru_d = 'Calcium lactate tabs 2x/day; Dulcolax as needed; Rohypnol 1 at night';
$vis_rem_d = 'Allergic to penicillin. Previously treated at the Kurunegala General Hospital for dysmenorrhoea and inter-menstrual spotting. Given conjugated estrogens for 6 months.';
// for Diagnostic tests see separate file (array)

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
//Load data
function LoadData($file) {
    //Read file lines
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode('|',chop($line));
    return $data;
}
//Table
function Table($header,$data) {
    //Column widths
    $w=array(20,45, 65);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],4,$row[0],0);
        $this->Cell($w[1],4,$row[1],0);
        //$row23 = $row[2] . '  ';
        //$row23 = $row23 . $row[3];
        $this->MultiCell($w[2],4,$row[2],0,'L',0);
        //$this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}
}
//..............................................................................................................................................
// Create fpdf object
$pdf = new PDF('P', 'mm', 'A5');

// Set base font to start
$pdf->SetFont('Times', 'B', 12);

// Add a new page to the document
$pdf->addPage();

// Set the x,y coordinates of the cursor
$x1 = 10;
$pdf->SetXY($x1,0);
$pdf->Cell(0,10, $form_title, 0, 2, 'C', false);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetXY($x1,10);
$pdf->Cell(0,5, $pat_hos_d, 'B', 2, 'C', false);

// Reset font and color
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

// Write patient details - field names
$pdf->SetXY($x1, 15);
$pdf->write(13, $pat_nam);
$pdf->SetXY($x1, 20);
$pdf->write(13, $pat_age);
$pdf->SetXY($x1, 25);
$pdf->write(13, $pat_civ);
$pdf->SetXY($x1, 30);
$pdf->write(13, $pat_add);
$pdf->SetXY($x1, 35);
$pdf->write(13, $vis_dat);
$pdf->SetXY($x1, 40);
$pdf->write(13, $vis_con);
$pdf->SetXY($x1, 45);
$pdf->write(13, $vis_com);
$pdf->SetXY($x1, 50);
$pdf->write(13, $vis_pre);
$pdf->SetXY($x1, 55);
$pdf->write(13, $vis_dru);
$pdf->SetXY($x1, 60);
$pdf->write(13, $vis_rem);

// write constants
$pdf->SetXY($x1, 70);
$pdf->write(13, 'Additional notes: ');
$pdf->SetXY($x1, 95);
$pdf->write(13, '..........................................');
$pdf->SetXY($x1, 100);
$pdf->write(13, 'Date/signature/stamp');
$pdf->SetXY($x1, 110);
$pdf->write(13, $vis_dia);

//Write patient details - information
$x2 = 35;
$pdf->SetXY($x2, 15);
$pat_nampid = $pat_nam_d . ' (';
$pat_nampid = $pat_nampid . $pat_pid_d;
$pat_nampid = $pat_nampid . ')';
$pdf->write(13, $pat_nampid);
$pdf->SetXY($x2, 20);
$pdf->write(13, $pat_age_d);
$pdf->SetXY($x2, 25);
$pdf->write(13, $pat_civ_d);
$pdf->SetXY($x2, 30);
$pdf->write(13, $pat_add_d);
$pdf->SetXY($x2, 35);
$pdf->write(13, $vis_dat_d);
$pdf->SetXY($x2, 40);
$pdf->write(13, $vis_con_d);
$pdf->SetXY($x2, 45);
$pdf->write(13, $vis_com_d);
$pdf->SetXY($x2, 50);
$pdf->write(13, $vis_pre_d);
$pdf->SetXY($x2, 55);
$pdf->write(13, $vis_dru_d);
$pdf->SetXY($x2, 65);
$pdf->MultiCell(0,4, $vis_rem_d,0,1,0);

//Column titles
$header=array('Date','Test','Result','');

//Data loading
$data=$pdf->LoadData('visit_slip_diagtests.txt');
$pdf->SetFont('Arial','',9);
$pdf->SetXY(10,120);
$pdf->Table($header,$data);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('visit_slip.pdf','D');
?>
