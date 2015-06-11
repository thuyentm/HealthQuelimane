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

$opdid = $_GET["OPD"];
$pid = $_GET["PID"];
$patient = new MDSPatient();
$patient->openId($pid);



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
$form_tit = 'Visit Summary';
$form_tak = 'Take this card when you visit the doctor';
$form_patd = 'Personal details';
$pat_nam = 'Name in full:';
$pat_pid = 'Patient No:';
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
$date = date('d/m/Y');

// for Past history, OPD visits and Diagnostic tests see separate files (array)
//.................................................................................................................................................................
// Create fpdf object
$pdf = new MDSReporter('P', 'mm', 'A5');
$pdf->AddPage();



$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_tit, 12);
//
//// Write patient details - field names . data
//$pdf->SetFont('', 'BU', 8);
$pdf->writeSSubTitle($form_patd);
$dh = 2;
$fsize = 10;
$dy = 3;

$pdf->setDy(0);
$pdf->setDx(32);
$pdf->SetWidths(array(24, 40, 22, 40));
$pdf->SetAligns(array('L', 'L', 'L', 'L'));
$pdf->colRow(array($pat_nam, $pat_nam_d, $pat_pid, $pat_pid_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_age, $pat_age_d, $pat_sex, $pat_sex_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d, $pat_nic, $pat_nic_d), FALSE, $fsize, $dy, $dh);
$pdf->writeField($pat_pho, $pat_pho_d, $fsize);
$pdf->writeField($pat_add, $pat_add_d, $fsize);

//$pdf->horizontalLine();
$pdf->writeSSubTitle('Visit Info');
$opd = new MDSOpd();
$opd->openId($opdid);
$pdf->SetWidths(array(24, 40,22, 40));
$pdf->colRow(array('Type:', $opd->getValue("VisitType"), 'Visit Date:', $opd->getValue("DateTimeOfVisit")), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Onset Date:', $opd->getValue("OnSetDate"), 'Doctor:', $opd->getOPDDoctor()), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('Complaints:', $opd->getValue("Complaint"), 'ICD:', $opd->getValue("ICD_Text")), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array('SNOMED:', $opd->getValue("SNOMED_Text"),'Remarks:', $opd->getValue("Remarks")), FALSE, $fsize, $dy, $dh);


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
$sql = " SELECT * FROM patient_exam WHERE pid = '" . $opd->patient->getId() . "' ORDER BY ExamDate DESC LIMIT 0,10";
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
        $pdf->Row(array($row["ExamDate"], $row["Weight"], $height, $bp, $temp));
    }
}

//lab orders if exists
$sql = " SELECT LAB_ORDER_ID FROM lab_order WHERE OBJID = '" . $opd->getId() . "' ORDER BY OrderDate DESC";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count != 0) {

    while ($row = $mdsDB->mysqlFetchArray($result)) {
        if ($row["LAB_ORDER_ID"]) {
            $l_order = new MDSLabOrder();
            $l_order->openId($row["LAB_ORDER_ID"]);
            if ($l_order->getValue("Status") == 'Done') {
                $pdf->Ln();
                $pdf->SetWidths(array(130));
                $pdf->SetAligns(array('C'));
                $pdf->Row(array('Lab Order:' . $l_order->getValue("TestGroupName") . '(' . $l_order->getValue("OrderDate") . ')'), TRUE);
//                $pdf->SetAligns(array('L'));
//                $pdf->Row(array($l_order->getValue("TestGroupName") . '(' . $l_order->getValue("OrderDate") . ')'), TRUE);
                $pdf->SetAligns(array('L', 'L', 'L'));
                $pdf->SetWidths(array(40, 40, 50));
                $pdf->Row(array('Test', 'Value', 'Referance'), true);
                $mdsDB1 = MDSDataBase::GetInstance();
                $mdsDB1->connect();
                $sql1 = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '" . $l_order->getId() . "'";
                $result1 = $mdsDB1->mysqlQuery($sql1);
                while ($row1 = $mdsDB1->mysqlFetchArray($result1)) {
                    if ($row1["LAB_ORDER_ITEM_ID"]) {
                        $l_test = new MDSLabTests();
                        $l_item = new MDSLabOrderItems();
                        $l_item->openId($row1["LAB_ORDER_ITEM_ID"]);
                        $l_test->openId($row1["LABID"]);
                        $pdf->Row(array($l_test->getValue("Name"), $l_item->getValue("TestValue"), str_replace("<br>", "", $l_test->getValue("RefValue"))));
                    }
                }
            }
        }
    }
}
//write prescription if exists
$prscription = new MDSPrescription();
$prs = $prscription->getPrescription('OPD', $opd->getId());
$prscription->openId($prs);
if ($prs) {
    $mdsDB = MDSDataBase::GetInstance();
    $mdsDB->connect();
    $sql = "SELECT prescribe_items.PRS_ITEM_ID,drugs.Name,prescribe_items.Dosage,prescribe_items.HowLong,prescribe_items.Quantity,prescribe_items.Status,prescribe_items.Frequency FROM prescribe_items,drugs where prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND prescribe_items.PRES_ID = '" . $prs . "' ";
    $result = $mdsDB->mysqlQuery($sql);
    if ($result) {
        $pdf->Ln();
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

//write Questionnaire if exists
$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect(); //QUES_ST_ID	
$sql = " SELECT questionnaire.QUES_ID,questionnaire.Date,questionnaire.Active,quest_struct.Name,quest_struct.Remarks 
                    FROM questionnaire,quest_struct 
                    WHERE ( questionnaire.Type = 'opd_visit' ) 
                    AND (questionnaire.Active=1) 
                    AND (questionnaire.QUES_ST_ID = quest_struct.QUES_ST_ID ) 
                    AND (questionnaire.OBID ='" . $opd->getId() . "') ";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count != 0) {
    $pdf->Ln();
//    $pdf->SetWidths(array(130));
//    $pdf->SetAligns(array('C'));
//    $pdf->Row(array('Questionnaire'), true);

    while ($row = $mdsDB->mysqlFetchArray($result)) {
//        $pdf->Ln();
        $pdf->SetWidths(array(130));
        $pdf->SetAligns(array('C'));
        $pdf->Row(array('Questionnaire'), true);
        $pdf->SetWidths(array(30, 50, 50));
        $pdf->SetAligns(array('L', 'L', 'L'));
        $pdf->Row(array('Date', 'Questionnaire', 'Remarks'), true);
        $pdf->Row(array(getMDSDate(date_parse($row["Date"])), $row["Name"], $row["Remarks"]));
//        $pdf->Ln();
        $mdsDB1 = MDSDataBase::GetInstance();
        $mdsDB1->connect();
        $result1 = $mdsDB1->mysqlQuery("SELECT * FROM questionnaire_data where (QUES_ID ='" . $row["QUES_ID"] . "') ");
        $count1 = $mdsDB1->getRowsNum($result1);
        if ($count1 != 0) {
            $pdf->SetWidths(array(65, 65));
            $pdf->SetAligns(array('L', 'L'));
            $pdf->Row(array('Question', 'Answer'), true);
            while ($row1 = $mdsDB1->mysqlFetchArray($result1)) {
                $pdf->Row(array($row1["Question"], $row1["Answer"]));
            }
            $pdf->Ln();
        }
    }
}

if($mdsDB){
    $mdsDB->close();
}
if($mdsDB1){
    $mdsDB1->close();
}
$pdf->Output($pid.' visit_summery','I');
?>
