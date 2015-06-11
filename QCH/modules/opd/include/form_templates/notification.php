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
include_once '../class/MDSNotification.php';
include_once '../class/MDSAdmission.php';
include_once '../class/MDSOpd.php';
include_once '../class/MDSPatient.php';
include_once '../class/MDSWard.php';
include_once 'print_util.php';

if (!$_GET["NOTIFICATION_ID"]) {
    echo "Invalid Notification  ";
    exit();
}
$notification = new MDSNotification();
$notification->openId($_GET["NOTIFICATION_ID"]);

//echo $notification->displayFields();
if ($notification->getValue("Episode_Type") == 'admission') {
    $admid = $notification->getValue("EPISODEID");
    $admission = new MDSAdmission();
    $admission->openId($admid);
    $patient = $admission->getAdmitPatient();
    $ward = new MDSWard();
    $ward->OpenId($admission->getValue("Ward"));
    $notification->episode_type = "Admission";
    $pat_don_d = $admission->getValue("OnSetDate");
    $pat_dvi_d = mdsGetDate($admission->getValue("AdmissionDate")); //Date of visit (or admission - later)
    $pat_bht_d = $admission->getValue("BHT"); //Bed head ticket number (later)
    $pat_war_d = $ward->getValue("Name");
} else if ($notification->getValue("Episode_Type") == 'opd') {
    $opdid = $notification->getValue("EPISODEID");
    $opd = new MDSOpd();
    $opd->openId($opdid);
    $patient = $opd->getOpdPatient();
    $notification->episode_type = "Opd";
    $pat_don_d = $opd->getValue("OnSetDate");
    $pat_dvi_d=mdsGetDate($opd->getValue("DateTimeOfVisit"));
    $pat_war_d = $opd->getValue("VisitType");
    $pat_bht_d="-";
} else {
    return;
}
// Document variables (to be passed to the script) - defined here for testing
$pat_hos_d = $patient->getHospital(); //Institute
$pat_dis_d = $notification->getValue("Disease"); //Disease to be notified
$pat_nam_d = $patient->getFullName(); //Patient name
$pat_pid_d = $patient->getId(); //Patient record number
//if (!$pat_don_d) {
//    $pat_don_d = "-";
//}

$pat_con_d = '';  //Name of guardian/parent (for children)
//if ($notification->episode_type == 'Admissin') {
//    $pat_dvi_d = $admission->getValue("AdmissionDate"); //Date of visit (or admission - later)
//    $pat_bht_d = $admission->getValue("BHT") . 'BHT'; //Bed head ticket number (later)
//    $pat_bht_d = 'BHT'; //Bed head ticket number (later)
//    $pat_war_d = $ward->getValue("Name"); //Ward (later)
//}

$pat_age_d = $patient->getAge();
$pat_sex_d = $patient->getValue("Gender"); //Gender
if ($notification->getValue("LabConfirm") == 1) {
    $pat_lab_d = "Yes";
} else {
    $pat_lab_d = "No";
}
$pat_add_d = $patient->getAddress("txt");
$pat_tel_d = $patient->getValue("Telephone"); //Home telephone number
$dat_d = date('Y-m-d'); //Date form produced
$pat_moh_d = '';

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
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);  //  light gray
        // Page number - can also use Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C')
        // {nb} will be substituted on document closure by calling AliasNbPages()
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

}

// Create fpdf object
$pdf = new PDF('P', 'mm', 'A4');
// Set base font to start
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 0, 0);
// Add a new page to the document
$pdf->addPage();
$pdf->SetRightMargin(0);
$pdf->Image('06a_notification_form.jpg', 0, 0, 200);

// Constant for adjusting left margin and distance from top
$mar = 30;
$top = 15;
// Write data - field names
$pdf->SetXY($mar + 20, $top + 18);
$pdf->write(13, $pat_hos_d);
$pdf->SetXY($mar + 120, $top + 22);
$pdf->MultiCell(50, 5, $pat_dis_d);
$pdf->SetXY($mar + 10, $top + 29);
$pdf->write(13, $pat_nam_d);
$pdf->SetXY($mar + 125, $top + 29);
$pdf->write(13, $pat_don_d);
$pdf->SetXY($mar - 20, $top + 54);
$pdf->write(13, $pat_con_d);
$pdf->SetXY($mar + 125, $top + 44);
$pdf->write(13, $pat_dvi_d);
$pdf->SetXY($mar + 10, $top + 65);
$pdf->write(13, $pat_bht_d);
$pdf->SetXY($mar + 52, $top + 65);
$pdf->write(13, $pat_war_d);
$pdf->SetXY($mar + 97, $top + 65);
$pdf->write(13, $pat_age_d);
$pdf->SetXY($mar + 148, $top + 65);
$pdf->write(13, $pat_sex_d);
$pdf->SetXY($mar + 52, $top + 79);
$pdf->write(13, $pat_lab_d);
$pdf->SetXY($mar - 20, $top + 104);
$pdf->write(13, $pat_add_d);
$pdf->SetXY($mar + 35, $top + 127);
$pdf->write(13, $pat_tel_d);
$pdf->SetXY($mar + 140, $top + 141);
$pdf->write(13, $dat_d);
$pdf->SetXY($mar - 20, $top + 199);
$pdf->write(13, $pat_moh_d);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('notification_form.pdf', 'I');
?>
