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
//include_once 'fpdf/fpdf.php';
include '../class/MDSPatient.php';
include '../class/MDSOpd.php';
include_once 'print_util.php';

if (!$_GET["PID"]) {
    echo "Invalid Patient ID ";
    exit();
}

$patient = new MDSPatient();
$patient->openId($_GET["PID"]);



$histry_JSON = $patient->getHistoryJSON();
$alergy_JSON = $patient->getAllergyJSON();
$visit_JSON = $patient->getVisitJSON();
//$prescription = $opd->getPrescriptionItemsJSON();
//$json[$i] = array(
//"Date"=>$row["HistoryDate"], 
//"Type" => $row["History_Type"], 
//"Snomed" =>$row["SNOMED_Text"],
//"Remarks" =>$row["Remarks"]
//);
//
$admission_JSON = $patient->getAdmissionJSON();
//$json[$i] = array(
//"Date"=>$row["AdmissionDate"] ,
//"Complaint" => $row["Complaint"],
//"Diagnosis" =>$row["Discharge_ICD_Text"],
//"Remarks" =>$row["Remarks"],
//"DischargeDate" =>$row["DischargeDate"]);
// Document constants
$form_tit = 'Patient Summary';
$form_tak = 'Take this card when you visit the doctor';
$form_patd = 'Personal details';
$pat_nam = 'Name in full:';
$pat_pid = 'Register No:';
$pat_pidl = ' (';
$pat_pidr = ')';
$pat_age = 'Age:';
$pat_sex = 'Gender:';
$pat_civ = 'Civil status:';
$pat_nic = 'NIC:';
$pat_pho = 'Telephone:';
$pat_add = 'Address:';
$form_phis = 'Past history';
$form_dat = 'Date';
$form_scon = 'Snomed concept';
$form_rem = 'Remarks';
$form_ovc = 'OPD Visits and Clinics';
$form_com = 'Complaint';
$form_dru = 'Drugs/treatments: ';
$form_con = 'Consultant name:';
$form_padm = 'Previous admissions';
$form_adm = 'Last admission';
$pat_dad = 'Date of admission:';
$pat_ddi = 'Date of discharge:';
$pat_bht = 'BHT no.: ';
$pat_adr = 'Admission reason: ';
$pat_pcom = 'Presenting complaint: ';
$pat_wdi = 'Working diagnosis (ICD): ';
$pat_sdi = 'Working diagnosis (Snomed): ';
$pat_spr = 'Surgical procedures: ';
$pat_tre = 'Treatments given: ';
$pat_ddic = 'Discharge diagnosis (ICD): ';
$pat_ddim = 'Discharge diagnosis (IMMR): ';
$pat_out = 'Outcome: ';
$pat_ref = 'Referred to: ';
$form_dia = 'Diagnostic tests: ';
$form_sdo = 'Signature & designation: .......................................................';
$form_alerg = 'Allergies';
$form_visit = 'Visits';
$form_admission = 'Admissions';


// Document variables (to be passed to the script) - defined here for testing
$pat_hos_d = $patient->getHospital(); //returns the default hospital
$pat_nam_d = $patient->getFullName();
$pat_pil_d = $patient->getId();
$pat_age_d = $patient->getAge();
$pat_sex_d = $patient->getValue("Gender");
$pat_civ_d = $patient->getValue("Personal_Civil_Status");
$pat_nic_d = $patient->getValue("NIC");
$pat_pho_d = $patient->getValue("Telephone");
$pat_add_d = $patient->getValue("Address_Street") . " " . $patient->getValue("Address_Village") . " " . $patient->getValue("Address_DSDivision") . " " . $patient->getValue("Address_District");
$pat_pid_d = $patient->getId();
$pat_dad_d = '02/01/2011';
$pat_ddi_d = '07/01/2011';
$pat_bht_d = '124/124';
$pat_adr_d = 'Coughing blood';
$pat_pcom_d = 'Pale, emaciated, febrile';
$pat_wdi_d = 'A91 Dengue haemorrhagic fever';
$pat_sdi_d = 'DHF - Dengue';
$pat_spr_d = 'Diagnostic lumbar puncture';
$pat_tre_d = 'Intravenous fluids, Platelet transfusion';
$pat_ddic_d = 'A91 Dengue haemorrhagic fever';
$pat_ddim_d = '032 Dengue haemorrhagic fever';
$pat_out_d = 'Recovered, to be followed up';
$pat_ref_d = 'Dengue follow-up unit, Kurunegala';
$date = date('d/m/Y');

// for Past history, OPD visits and Diagnostic tests see separate files (array)
//.................................................................................................................................................................
// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A5');
$pdf->AddPage();



$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_tit, 12);
//$pdf->writeSubTitle($form_tak, 10);
//
//// Write patient details - field names . data
//$pdf->SetFont('', 'BU', 8);
$pdf->writeSSubTitle($form_patd);
$dh = 2;
$fsize = 10;
$dy = 3;

$pdf->setDy(0);
$pdf->setDx(32);
$pdf->SetWidths(array(24, 40, 24, 40));
$pdf->SetAligns(array('L', 'L', 'L', 'L'));
$pdf->colRow(array($pat_nam, $pat_nam_d, $pat_pid, $pat_pid_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_age, $pat_age_d, $pat_sex, $pat_sex_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d, $pat_nic, $pat_nic_d), FALSE, $fsize, $dy, $dh);
$pdf->writeField($pat_pho, $pat_pho_d, $fsize);
$pdf->writeField($pat_add, $pat_add_d, $fsize);
//$pdf->horizontalLine();
//write admition if exists



//write allergies if exists
if ($alergy_JSON) {
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_alerg), true);
    $pdf->SetWidths(array(28, 20, 40, 40));
    $pdf->Row(array('First Recorded', 'Status', 'Allergy', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($alergy_JSON as $row) {
        $row = array(mdsGetDate($row['Date']), $row['Snomed'] ? $row['Snomed'] : '-', $row['Type'] ? $row['Type'] : '-', $row['Remarks'] ? $row['Remarks'] : '-');
        $pdf->Row($row);
    }
}

//write histroy if exists
if ($histry_JSON) {

    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_phis), true);

    $pdf->SetWidths(array(24, 52, 52));
    $pdf->Row(array('Period', 'Snomed concept', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($histry_JSON as $row) {
        $row = array($row['Date'], $row['Snomed'] ? $row['Snomed'] : '-', $row['Remarks'] ? $row['Remarks'] : '-');
        $pdf->Row($row);
    }
}





//write visit if exists
if ($visit_JSON) {
    $count=0;
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_visit."(Shows only last 5 visits)"), true);

    $pdf->SetWidths(array(24, 24, 40, 40));
    $pdf->Row(array('Visit Date', 'Type of Visit', 'Complaint', 'Remarks'), true, 8);
    $pdf->SetFont('', '', 8);
    foreach ($visit_JSON as $row) {
        $count++;
        if($count>5){
            break;
        }
        $pdf->SetWidths(array(24, 24, 40, 40));
        $pdf->Row(array(mdsGetDate($row['Date']), $row['Type'], $row['Complaint'], $row['Remarks'] ? $row['Remarks'] : '-'), FALSE, 8);
        $opdid = $row["OPDID"];
        
//         $opd = new MDSOpd();
//         $opd->openId($opdid);
//         $prescription = $opd->getPrescriptionItemsJSON();

        
//         if($prescription){
//             $pdf->SetWidths(array(128));
//             $pdf->SetAligns(array('L'));
//             $pdf->Row(array("Prescription:"),true);
// //            $pdf->SetWidths(array(53,15,30, 30));
//             $pdf->SetWidths(array(128));
// //            $pdf->SetAligns(array('L','L','L','L'));
//             $pdf->SetAligns(array('L'));
//             foreach ($prescription as $row2) {
//                 $pdf->Row(array($row2['Name']." ".$row2['Dosage']." ".$row2['Frequency']."  ".$row2['HowLong']));
//             }
            
//         }
    }
}

if ($admission_JSON) {
    $count=0;
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_admission."(Shows only last 5 admissions)"), true);
    $pdf->SetWidths(array(20, 25, 33, 25, 25));
    $pdf->Row(array('Date', 'Complaint', 'Discharge Diagnosis', 'Remarks', 'Discharge Date'), TRUE, 8);
//    $pdf->SetFont('', '', 8);
    foreach ($admission_JSON as $row) {
        $count++;
        if($count>5){
            break;
        }
        $row = array(mdsGetDate($row['Date']), $row['Complaint'], $row['Diagnosis'] ? $row['Diagnosis'] : '-', $row['Remarks'] ? $row['Remarks'] : '-', mdsGetDate($row['DischargeDate']) ? mdsGetDate($row['DischargeDate']) : '-');
        $pdf->Row($row, FALSE, 8);
    }
}

$pat_pid_d = substr($pat_pid_d, 0, 3) . '_' . substr($pat_pid_d, 3, 3) . '_' . substr($pat_pid_d, 6, 3) . '_' . substr($pat_pid_d, 9, 99);

$pdf->Output($pat_pid_d . ' patient_summery', 'I');
?>
