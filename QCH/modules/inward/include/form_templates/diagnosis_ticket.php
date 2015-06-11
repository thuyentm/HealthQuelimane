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
$pat_add_d = $patient->getValue("Address_Street") . " " . $patient->getValue("Address_Street1") . " " . $patient->getValue("Address_Village") . " " . $patient->getValue("Address_DSDivision") . " " . $patient->getValue("Address_District");
$pat_rem_d = $patient->getValue("Remarks");

$admin_date_d = $admission->getValue('AdmissionDate');
$admin_onsetdate_d = $admission->getValue('OnSetDate');
$admin_bht_d = $admission->getValue('BHT');
$admin_doctor_d = $admission->getEpisodeDoctor();
$admin_ward_d = $admission->getWard();
$admin_complaint_d = $admission->getValue('Complaint');
$admin_discharge_date_d = $admission->getValue('DischargeDate');
$admin_discharge_outcome_d = $admission->getValue('OutCome');
$admin_discharge_diag_d = $admission->getValue('Discharge_ICD_Text');
$admin_pag_d = $patient->getValue('ContactPerson'); // 'Father, Mohamed Amila, Rideegama';
$admin_tel_d = $patient->getValue('Telephone');
$admin_discharge_diag_d = $admission->getValue('Discharge_ICD_Text');

$pdf=new MDSReporter('P', 'mm', 'A5');
$pdf->setFormNum('Health 383A');
$pdf->AddPage();
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle('Diagnosis Ticket');
$pdf->writeField($pat_nam, $pat_nam_d);
$pdf->Output($pat_pid_d.'diagnosis_ticket', 'I');
?>
