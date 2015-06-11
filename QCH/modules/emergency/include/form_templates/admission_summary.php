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
include_once '../class/MDSPatient.php';
include_once '../class/MDSOpd.php';
include_once '../class/MDSDataBase.php';
include_once '../class/MDSLabOrder.php';
include_once '../class/MDSLabTests.php';
include_once '../class/MDSLabOrderItems.php';
include_once '../class/MDSPrescription.php';
include_once 'print_util.php';

if (!$_GET["PID"]) {
    echo "Invalid Patient ID ";
    exit();
}

$admid = $_GET["ADMID"];
$pid = $_GET["PID"];

$patient = new MDSPatient();
$patient->openId($pid);

$admission = new MDSAdmission();
$admission->openId($admid);



$histry_JSON = $patient->getHistoryJSON();
$alergy_JSON = $patient->getAllergyJSON();
$visit_JSON = $patient->getVisitJSON();
//$json[$i] = array(
//"Date"=>$row["HistoryDate"],
//"Type" => $row["History_Type"],
//"Snomed" =>$row["SNOMED_Text"],
//"Remarks" =>$row["Remarks"]
//);

$admission_JSON = $patient->getAdmissionJSON();
//$json[$i] = array(
//"Date"=>$row["AdmissionDate"] ,
//"Complaint" => $row["Complaint"],
//"Diagnosis" =>$row["Discharge_ICD_Text"],
//"Remarks" =>$row["Remarks"],
//"DischargeDate" =>$row["DischargeDate"]);
// Document constants
$form_tit = 'Admission Summary';
$form_tak = 'Take this card when you visit the doctor';
$form_patd = 'Personal details';
$pat_nam = 'Patient Name:';
$pat_pid = 'Register No:';
$pat_pidl = ' (';
$pat_pidr = ')';
$pat_age = 'Age:';
$pat_sex = 'Sex:';
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

$admin_date_d = $admission->getValue('AdmissionDate');
$admin_onsetdate_d = $admission->getValue('OnSetDate');
$admin_bht_d = $admission->getValue('BHT');
$admin_doctor_d = $admission->getEpisodeDoctor();
$admin_ward_d = $admission->getWard();
$admin_complaint_d = $admission->getValue('Complaint');
$admin_discharge_date_d = $admission->getValue('DischargeDate');
$admin_discharge_outcome_d = $admission->getValue('OutCome');
$admin_discharge_diag_d = $admission->getValue('Discharge_ICD_Text');
$admin_discharge_immr_d = $admission->getValue('Discharge_IMMR_Text');
$admin_discharge_rem_d = $admission->getValue('Discharge_Remarks');
$date = date('d/m/Y');

// for Past history, OPD visits and Diagnostic tests see separate files (array)
//.................................................................................................................................................................
// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A5');
$pdf->AddPage();
$dh = 2;
$fsize = 10;
$dy = 3;


$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_tit, 12);
//
//// Write patient details - field names . data
//$pdf->SetFont('', 'BU', 8);
$pdf->writeSSubTitle($form_patd);

$pdf->setDy(0);
$pdf->setDx(32);
$pdf->SetWidths(array(30, 40, 25, 40));
$pdf->SetAligns(array('L', 'L', 'L', 'L'));
$pdf->colRow(array($pat_nam, $pat_nam_d, $pat_pid, $pat_pid_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_age, $pat_age_d, $pat_sex, $pat_sex_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d, $pat_nic, $pat_nic_d), FALSE, $fsize, $dy, $dh);
$pdf->SetWidths(array(30, 110));
$pdf->colRow(array($pat_pho, $pat_pho_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_add, $pat_add_d), FALSE, $fsize, $dy, $dh);


//$pdf->horizontalLine();
$pdf->writeSSubTitle('Admission Info');

$pdf->SetWidths(array(40, 27, 35, 28));
$pdf->colRow(array('Date of Admission:', mdsGetDate($admin_date_d), 'Date of Discharge:', mdsGetDate($admin_discharge_date_d)), FALSE, $fsize, $dy, $dh);
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Admission Reason:', $admission->getValue('Complaint')), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Admission Remarks:', $admission->getValue("Remarks")), FALSE, $fsize, $dy, $dh);
// $pdf->MultiCell(0, 2, '','B');
// $pdf->Ln(3);

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = " SELECT * FROM admission_diagnosis WHERE ADMID = '" . $admission->getId() . "' ORDER BY DiagnosisDate DESC ";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if (!$result) {
    echo "ERROR getting Lab Items";
    return null;
}
$diag = 1;
if ($count != 0) {
    $row = $mdsDB->mysqlFetchArray($result);
    $pdf->colRow(array('Diagnosis:', $diag . '.' . $row["ICD_Text"]), FALSE, $fsize, 4, $dh);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $diag++;
        $pdf->colRow(array('', $diag . '.' . $row["ICD_Text"]), FALSE, $fsize, 4, $dh);
    }
}


$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = " SELECT * FROM admission_procedures WHERE ADMID = '" . $admission->getId() . "' ORDER BY ProcedureDate DESC ";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if (!$result) {
    echo "ERROR getting Lab Items";
    return null;
}
if ($count != 0) {
//     $pdf->MultiCell(0, 1, '','B');
    $row = $mdsDB->mysqlFetchArray($result);
//     $pdf->SetWidths(array(38, 87));
    $pdf->colRow(array('Surgical Procedure:', $row["SNOMED_Text"]), FALSE, $fsize, 4, $dh);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $pdf->colRow(array('', $row["SNOMED_Text"]), FALSE, $fsize, 4, $dh);
    }

//     $pdf->MultiCell(0, 1, '','B');
}
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Discharge Diagnosis:', $admin_discharge_diag_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Discharge IMMR:', $admin_discharge_immr_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Outcome:', $admin_discharge_outcome_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Referred To:', $admission->getValue('ReferTo')), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Discharge Remarks:', trim($admin_discharge_rem_d)), FALSE, $fsize, $dy, $dh);


//write allergies if exists
if ($alergy_JSON) {
    $pdf->Ln();
    $pdf->SetWidths(array(130));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_alerg), TRUE);
    //    $pdf->writeSSubTitle($form_alerg);
    $pdf->SetWidths(array(30, 20, 40, 40));
    $pdf->Row(array('First Recorded', 'Status', 'Allergy', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($alergy_JSON as $row) {
        $row = array(mdsGetDate($row['Date']), $row['Snomed'], $row['Type'], $row['Remarks']);
        $pdf->Row($row);
    }
}

//write histroy if exists
if ($histry_JSON) {
    $pdf->Ln();
    $pdf->SetWidths(array(130));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_phis), TRUE);
    $pdf->SetWidths(array(25, 65, 40));
    $pdf->Row(array('Period', 'Snomed concept', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($histry_JSON as $row) {
        $row = array($row['Date'], $row['Snomed'], $row['Remarks']);
        //        $row = array($row['Date'], $row['Type'][0], $row['Snomed'], $row['Remarks']);
        $pdf->Row($row);
    }
}

//write examinations if exists
$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = " SELECT * FROM patient_exam WHERE pid = '" . $admission->patient->getId() . "' ORDER BY ExamDate DESC LIMIT 0,10";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count != 0) {
    $pdf->Ln();
    $pdf->SetWidths(array(130));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array('Examinations'), TRUE);
    $pdf->SetWidths(array(25, 25, 25, 25, 30));
    $pdf->Row(array('Date', 'Weight(Kg)', 'Height(m)', 'BP', 'Temperature(C)'), TRUE);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        if (($row["sys_BP"] > 0) && ($row["diast_BP"] > 0))
            $bp = $row["sys_BP"] . "/" . $row["diast_BP"];
        else
            $bp = "-";
        if ($row["Temprature"] == 0) {
            $temp = "-";
        } else {
            $temp = $row["Temprature"];
        }
        if ($row["Height"] == 0) {
            $height = "-";
        } else {
            $height = $row["Height"];
        }
        if ($row["Weight"] == 0) {
            $weight = '-';
        } else {
            $weight = $row["Weight"];
        }
        $pdf->Row(array(mdsGetDate($row["ExamDate"]), $weight, $height, $bp, $temp));
    }
}




//lab orders if exists
$sql = "SELECT DISTINCT lt.`Name`,loi.TestValue,lt.RefValue FROM lab_tests as lt,lab_order_items as loi,lab_order as lo WHERE lo.Dept='ADM' and lo.OBJID='$admid' and lo.LAB_ORDER_ID=loi.LAB_ORDER_ID and loi.LABID=lt.LABID ORDER BY lo.LAB_ORDER_ID";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count > 0) {
    $pdf->Ln();
    $pdf->CheckPageBreak(20);
    $header = array('Test', 'Result', 'Ref. Value');
    $pdf->SetWidths(array(130));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array("Laborders"), TRUE);
    $pdf->SetWidths(array(41, 41, 48));
    $pdf->SetAligns(array('L', 'L', 'L'));
    $pdf->Row($header, true);
    $pdf->SetFont('courier', '', 8);
    while ($row = mysql_fetch_array($result)) {
        $pdf->Row(array($row[0],$row[1],$row[2]));
    }
    //SELECT lt.`Name`,loi.TestValue,lt.RefValue FROM lab_order_items as loi,lab_tests as lt WHERE loi.LAB_ORDER_ID=20 and loi.LABID=lt.LABID
}

//procedures if exists
$sql = "SELECT ap.CreateDate,ap.SNOMED_Text,ap.Remarks FROM admission_procedures as ap WHERE ap.ADMID=$admid";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count > 0) {
    $pdf->Ln();
    $pdf->CheckPageBreak(20);
    $header = array('Date', 'Procedure', 'Remarks');
    $pdf->SetWidths(array(130));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array("Procedures"), TRUE);
    $pdf->SetWidths(array(30,50,50));
    $pdf->SetAligns(array('L', 'L', 'L'));
    $pdf->Row($header, true);
    $pdf->SetFont('courier', '', 8);
    while ($row = mysql_fetch_array($result)) {
        $pdf->Row(array(mdsGetDate($row[0]),$row[1],$row[2]));
    }
    //SELECT lt.`Name`,loi.TestValue,lt.RefValue FROM lab_order_items as loi,lab_tests as lt WHERE loi.LAB_ORDER_ID=20 and loi.LABID=lt.LABID
}





//write prescription if exists
$prscription = new MDSPrescription();
$prs = $prscription->getPrescription('ADM', $admission->getId());
$prscription->openId($prs);
if ($prs) {
    $mdsDB = MDSDataBase::GetInstance();
    $mdsDB->connect();
    $sql = "SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong,prescribe_items.Quantity,prescribe_items.Status,prescribe_items.Frequency FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '" . $prs . "' ";
    $result = $mdsDB->mysqlQuery($sql);
    if ($result) {
        $pdf->Ln();
        $pdf->CheckPageBreak(20);
        $pdf->SetWidths(array(130));
        $pdf->SetAligns(array('C'));
        $pdf->Row(array('Prescription'), true);
        $pdf->SetWidths(array(60, 20, 30, 20));
        $pdf->SetAligns(array('L', 'L', 'L', 'L'));
        $pdf->Row(array('Drugs Prescribed', 'Dosage', 'Frequency', 'Period'), true);
        while ($row = mysql_fetch_array($result)) {
            $pdf->Row(array($row["Name"], $row["Dosage"], $row["Frequency"], $row["HowLong"]));
        }
    }
}


if ($mdsDB) {
    $mdsDB->close();
}
if ($mdsDB1) {
    $mdsDB1->close();
}
$pdf->Output($admid . ' admission_summery', 'I');
?>
