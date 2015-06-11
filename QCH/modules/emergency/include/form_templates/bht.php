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
require('fpdf/fpdf.php');
// Document constants

$form_title = 'BED HEAD TICKET';
$pat_hos = 'Hospital : ';
$pat_pid = 'Register number : ';
$pat_bht = 'BHT No : ';
$pat_nam = 'Name in full : '; 
$pat_nic = 'NIC Number : ';
$pat_sex = 'Sex  ';
$pat_age = 'Age : ';
$pat_civ = 'Civil status : ';
$pat_add = 'Address : ';
$adm_war = 'Ward : ';
$adm_dat = 'Date of admission : ';
$adm_tim = 'Time of admission : ';
$adm_ons = 'Date of onset dis/inj. : ';
$adm_con = "Consultant's name : ";
$adm_did = 'Date of discharge/death : ';
$adm_art = 'Articles in possession : ';
$adm_pag = 'Name & address parent/guardian : ';
$adm_tel = 'Telephone : ';
$adm_com = 'Disease or injury: ';
$dat = 'Date';
$pre = 'History, symptoms, diagnosis, treatment';
$rem = 'Remarks: ';

// Document variables (to be passed to the script) - defined here for testing
$dat_d = date('d/m/Y');

$pat_hos_d = 'Rideegama Base Hospital';
$pat_pid_d = 'KEG MWE PBH 7892';
$pat_bht_d = '1093/230';
$pat_nam_d = 'Mohammed Hussein M.M.'; 
$pat_nic_d = '684567321v';
$pat_sex_d = 'Male';
$pat_age_d = '52yrs 4 mths';
$pat_civ_d = 'Married';
$pat_add_d = "23 Kurunegala Road, Rideegama Town and Gravets, Rideegama, Sri Lanka";
$adm_war_d = 'Ward 1';
$adm_dat_d = '12/07/2011';
$adm_tim_d = '11:45 AM';
$adm_ons_d = '10/07/2011';
$adm_con_d = "Dr Ronald McDonald";
$adm_did_d = '';
$adm_art_d = 'Koran; 5000 Rs';
$adm_pag_d = 'Father, Mohamed Amila, Rideegama';
$adm_tel_d = '035 222 2222';
$adm_com_d = 'Dog bite';

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

// Create fpdf object
$pdf = new PDF('P', 'mm', 'A5');

// Set base font to start
$pdf->SetFont('Times', 'B', 12);

// Add a new page to the document
$pdf->addPage();

// Set the x,y coordinates of the cursor
$x1 = 10;
//$pdf->SetXY($x1,0);
//$pdf->Cell(0,10, $form_title, 0, 2, 'C', false);
//$pdf->SetFont('Times', 'B', 12);
$pdf->SetXY($x1,10);
$pdf->Cell(0,5, $form_title, 'B', 2, 'C', false);

// Reset font and color
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

// Write patient details - field names

$pdf->SetXY($x1, 16);
$pdf->Cell(25,4,$pat_hos,0,0,R);
$pdf->Cell(35,4,$pat_hos_d,0,1,L);
$pdf->Cell(25,4, $pat_pid,0,0,R);
$pdf->Cell(35,4,$pat_pid_d,0,1,L);
$pdf->Cell(25,4,$pat_bht,0,0,R);
$pdf->Cell(35,4,$pat_bht_d,0,1,L);
$pdf->Cell(25,4,'',0,0,R);
$pdf->Cell(35,4,'',0,1,L);
$pdf->Cell(25,4,$pat_nam,0,0,R);
$pdf->Cell(35,4,$pat_nam_d,0,1,L);
$pdf->Cell(25,4, $pat_nic,0,0,R);
$pdf->Cell(35,4,$pat_nic_d,0,1,L);
$pdf->Cell(25,4,$pat_sex,0,0,R);
$pdf->Cell(35,4,$pat_sex_d,0,1,L);
$pdf->Cell(25,4, $pat_age,0,0,R);
$pdf->Cell(35,4,$pat_age_d,0,1,L);
$pdf->Cell(25,4,$pat_civ,0,0,R);
$pdf->Cell(35,4,$pat_civ_d,0,1,L);
$pdf->Cell(25,4,$pat_add,0,0,R);
$pdf->MultiCell(35,4,$pat_add_d,0,L);
$pdf->Cell(60,4,$adm_com,LTB,0,R);
$pdf->Cell(68,4,$adm_com_d,RTB,1,L);
$pdf->Cell(15,4,$dat,LB,0,C);
$pdf->Cell(55,4,$pre,LBR,0,C);
$pdf->Cell(58,4,$rem,RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);
$pdf->Cell(15,6,'',LB,0,C);
$pdf->Cell(55,6,'',LBR,0,C);
$pdf->Cell(58,6,'',RB,1,C);

$pdf->SetXY(80, 16);
$pdf->Cell(25,4,$adm_war,0,2,R);
$pdf->Cell(25,4, $adm_dat,0,2,R);
$pdf->Cell(25,4,$adm_tim,0,2,R);
$pdf->Cell(25,4,$adm_ons,0,2,R);
$pdf->Cell(25,4,$adm_con,0,2,R);
$pdf->Cell(25,4,$adm_did,0,2,R);
$pdf->Cell(25,4,$adm_art,0,2,R);
$pdf->Cell(25,4,$adm_tel,0,2,R);
$pdf->Cell(25,4, $adm_pag,0,2,R);

$pdf->SetXY(105, 16);
$pdf->Cell(35,4,$adm_war_d,0,2,L);
$pdf->Cell(35,4,$adm_dat_d,0,2,L);
$pdf->Cell(35,4,$adm_tim_d,0,2,L);
$pdf->Cell(35,4,$adm_ons_d,0,2,L);
$pdf->Cell(35,4,$adm_con_d,0,2,L);
$pdf->Cell(35,4,$adm_did_d,0,2,L);
$pdf->Cell(35,4,$adm_art_d,0,2,L);
$pdf->Cell(35,4,$adm_tel_d,0,2,L);
$pdf->MultiCell(35,4,$adm_pag_d,0,L);


// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . 'bht.pdf','I');
?>
