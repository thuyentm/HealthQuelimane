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
$dat = date('d/m/Y');
$form_title = 'OPD Pharmacy Order List ' . ' ' . $dat;

// Document variables (to be passed to the script) - defined here for testing
$pat_hos_d = 'Rideegama Base Hospital, Kurunegala District';
$file_name_d = 'drug_list.txt';  // 3 columns, "|" as delimiter

class PDF extends FPDF {
function Footer() {
    // Page footer
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8 (If there is no Arial stored, Helvetica will be substituted)
    $this->SetFont('Arial','I',10);
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
    $w=array(80,30,30,50);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],10,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Ln();
        $this->Cell($w[0],6,$row[0],0);
        $this->Cell($w[1],6,$row[1],0,'','R');
        $this->Cell($w[2],6,$row[2],0,'','R');
        $this->Cell($w[3],6,'............................................',0,'','R');
    }
    //Closure line
        $this->Ln();    
        $this->Cell(array_sum($w),0,'','T');
}
}
//..............................................................................................................................................
// Create fpdf object
$pdf = new PDF('P', 'mm', 'A4');
// Set base font to start
$pdf->SetFont('Times', 'B', 12);
// Add a new page to the document
$pdf->addPage();

// Set the x,y coordinates of the cursor
$x1 = 10;
$pdf->SetXY($x1,0);
$pdf->Cell(0,10,$pat_hos_d, 0, 2, 'C', false);
$pdf->SetFont('Times', 'B', 11);
$pdf->SetXY($x1,10);
$pdf->Cell(0,5,$form_title, 'B', 2, 'C', false);

// Reset font and color
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);

//Column titles
$header=array('Drugs','Curr. stock','Clinic stock','Order req');

//Data loading
$data=$pdf->LoadData($file_name_d);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,20);
$pdf->Table($header,$data);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('drug_list.pdf','D');
?>
