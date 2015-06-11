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
include_once 'print_util.php';
include '../class/MDSAdmission.php';
if (!$_GET["ADMID"]) {
    echo "Invalid Admission ";
    exit();
}




//remove from the original
$patient = new MDSPatient();
$admission = new MDSAdmission();
$admission->openId($_GET["ADMID"]);
$patient = $admission->getAdmitPatient();
//echo $admission->displayFields();
//field values
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
$pat_pid_d = substr($pat_pid_d, 0, 3) . '  ' . substr($pat_pid_d, 3, 3) . '  ' . substr($pat_pid_d, 6, 3) . '  ' . substr($pat_pid_d, 9, 99);
$pat_add_d = $patient->getValue("Address_Street") . "," . $patient->getValue("Address_Street1") . "," . $patient->getValue("Address_Village") . "," . $patient->getValue("Address_DSDivision") . "," . $patient->getValue("Address_District");

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


//pdf decleration
$pdf = new MDSReporter('P', 'mm', 'A5');
$pdf->setFormNum('Health 383A');
$pdf->AddPage();

//setup page title
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle('Diagnosis Ticket');


//horizontal & vertical space
$pdf->setDx(50);
$pdf->setDy(0);


//write field names/values
$dy=4;
$dh=3;
$fontSize=10;
$pdf->Ln();
$pdf->SetWidths(array(40, 85));
$pdf->bottomRowOdd(array('Name of the Patient:', $pat_nam_d . '(' . $pat_pid_d . ')'),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(20,40));
$pdf->bottomRowOdd(array('Age:', $pat_age_d),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(15, 50, 30, 30));
$pdf->bottomRowOdd(array('Ward:', $admin_ward_d, 'Bed Head No:', $admin_bht_d),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(35, 27, 35, 28));
$pdf->bottomRowOdd(array('Date of Admission:', mdsGetDate($admin_date_d), 'Date of Discharge:', mdsGetDate($admin_discharge_date_d)),FALSE,$fontSize,$dy,$dh);

$pdf->writeSSubTitle('Investigation and Treatment');
$pdf->Ln(2);
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Admission Reason:', $admission->getValue('Complaint')),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Admission Remarks:', $admission->getValue("Remarks")),FALSE,$fontSize,$dy,$dh);
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
$diag=1;
if ($count != 0) {
    $row = $mdsDB->mysqlFetchArray($result);
    $pdf->colRow(array('Diagnosis:', $diag.'.'.$row["ICD_Text"]),FALSE,$fontSize,$dy,$dh);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
    	$diag++;
        $pdf->colRow(array('' ,$diag.'.'.$row["ICD_Text"]),FALSE,$fontSize,$dy,$dh);
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
    $pdf->colRow(array('Surgical Procedure:', $row["SNOMED_Text"]),FALSE,$fontSize,$dy,$dh);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $pdf->colRow(array('', $row["SNOMED_Text"]),FALSE,$fontSize,$dy,$dh);
    }
    
//     $pdf->MultiCell(0, 1, '','B');
}
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Discharge Diagnosis:', $admin_discharge_diag_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Discharge IMMR:', $admin_discharge_immr_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Outcome:', $admin_discharge_outcome_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Referred To:', $admission->getValue('ReferTo')),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Discharge Remarks:', trim($admin_discharge_rem_d)),FALSE,$fontSize,$dy,$dh);

$pdf->addCirtification();

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('discharge_ticket ADMID=' . $_GET["ADMID"], 'i');
?>
