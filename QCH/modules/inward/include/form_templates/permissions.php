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
include_once '../class/MDSDataBase.php';
include_once '../mdsCore.php';
include_once '../class/MDSHospital.php';

$hospital = getHospital();
$pdf = new MDSReporter('P', 'mm', 'A5');
$pdf->addPage();
$group = $_GET['gid'];
$date = date('Y-m-d');

$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Permissions for ' . $group .' Group');

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = "select UserGroup,UserAccess from `permission` where UserGroup='".$group."'";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count != 0) {
    $pdf->Ln();
    $pdf->SetWidths(array(50, 20,20, 20, 20));
    $pdf->SetAligns(array('L','C','C','C','C'));
    $pdf->Row(array('Module', 'Print', 'View', 'Edit', 'Create'), TRUE);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $json = $row[1];
        //"systems_table_Print":,"systems_table_View":,"systems_table_Edit":X,"systems_table_New":X,"test":}
        $obj = json_decode($json);
//        print_r($obj);
        $pdf->Row(array('Patient',$obj->{'patient_Print'}?'X':'',$obj->{'patient_View'}?'X':'',$obj->{'patient_Edit'}?'X':'',$obj->{'patient_New'}?'X':''));
        $pdf->Row(array('Patient Alergy',$obj->{'patient_alergy_Print'}?'X':'',$obj->{'patient_alergy_View'}?'X':'',$obj->{'patient_alergy_Edit'}?'X':'',$obj->{'patient_alergy_New'}?'X':''));
        $pdf->Row(array('Patient history',$obj->{'patient_history_Print'}?'X':'',$obj->{'patient_history_View'}?'X':'',$obj->{'patient_history_Edit'}?'X':'',$obj->{'patient_history_New'}?'X':''));
        $pdf->Row(array('Patient exam',$obj->{'patient_exam_Print'}?'X':'',$obj->{'patient_exam_View'}?'X':'',$obj->{'patient_exam_Edit'}?'X':'',$obj->{'patient_exam_New'}?'X':''));
        $pdf->Row(array('Visit',$obj->{'opd_visit_Print'}?'X':'',$obj->{'opd_visit_View'}?'X':'',$obj->{'opd_visit_Edit'}?'X':'',$obj->{'opd_visit_New'}?'X':''));
        $pdf->Row(array('OPD Treatment',$obj->{'opd_treatment_Print'}?'X':'',$obj->{'opd_treatment_View'}?'X':'',$obj->{'opd_treatment_Edit'}?'X':'',$obj->{'opd_treatment_New'}?'X':''));
        $pdf->Row(array('Admission',$obj->{'admission_Print'}?'X':'',$obj->{'admission_View'}?'X':'',$obj->{'admission_Edit'}?'X':'',$obj->{'admission_New'}?'X':''));
        $pdf->Row(array('Admission diagnosis',$obj->{'admission_diagnosis_Print'}?'X':'',$obj->{'admission_diagnosis_View'}?'X':'',$obj->{'admission_diagnosis_Edit'}?'X':'',$obj->{'admission_diagnosis_New'}?'X':''));
        $pdf->Row(array('Admission surgical procedure',$obj->{'admission_procedures_Print'}?'X':'',$obj->{'admission_procedures_View'}?'X':'',$obj->{'admission_procedures_Edit'}?'X':'',$obj->{'admission_procedures_New'}?'X':''));
        $pdf->Row(array('Admission notes',$obj->{'admission_notes_Print'}?'X':'',$obj->{'admission_notes_View'}?'X':'',$obj->{'admission_notes_Edit'}?'X':'',$obj->{'admission_notes_New'}?'X':''));
        $pdf->Ln();
        $pdf->Row(array('Lab Order',$obj->{'lab_order_Print'}?'X':'',$obj->{'lab_order_View'}?'X':'',$obj->{'lab_order_Edit'}?'X':'',$obj->{'lab_order_New'}?'X':''));
        $pdf->Row(array('Prescription Order',$obj->{'opd_presciption_Print'}?'X':'',$obj->{'opd_presciption_View'}?'X':'',$obj->{'opd_presciption_Edit'}?'X':'',$obj->{'opd_presciption_New'}?'X':''));
        $pdf->Row(array('Drugs',$obj->{'drugs_Print'}?'X':'',$obj->{'drugs_View'}?'X':'',$obj->{'drugs_Edit'}?'X':'',$obj->{'drugs_New'}?'X':''));
        $pdf->Row(array('Lab Tests',$obj->{'lab_tests_Print'}?'X':'',$obj->{'lab_tests_View'}?'X':'',$obj->{'lab_tests_Edit'}?'X':'',$obj->{'lab_tests_New'}?'X':''));
        $pdf->Row(array('Lab Tests Groups',$obj->{'lab_test_group_Print'}?'X':'',$obj->{'lab_test_group_View'}?'X':'',$obj->{'lab_test_group_Edit'}?'X':'',$obj->{'lab_test_group_New'}?'X':''));
        $pdf->Row(array('Lab Department',$obj->{'lab_test_department_Print'}?'X':'',$obj->{'lab_test_department_View'}?'X':'',$obj->{'lab_test_department_Edit'}?'X':'',$obj->{'lab_test_department_New'}?'X':''));
        $pdf->Row(array('Canned Text',$obj->{'canned_text_Print'}?'X':'',$obj->{'canned_text_View'}?'X':'',$obj->{'canned_text_Edit'}?'X':'',$obj->{'canned_text_New'}?'X':''));
        $pdf->Row(array('Notification',$obj->{'notification_Print'}?'X':'',$obj->{'notification_View'}?'X':'',$obj->{'notification_Edit'}?'X':'',$obj->{'notification_New'}?'X':''));
        $pdf->Row(array('Wards',$obj->{'ward_Print'}?'X':'',$obj->{'ward_View'}?'X':'',$obj->{'ward_Edit'}?'X':'',$obj->{'ward_New'}?'X':''));
        $pdf->Ln();
        $pdf->Row(array('Systems table',$obj->{'systems_table_Print'}?'X':'',$obj->{'systems_table_View'}?'X':'',$obj->{'systems_table_Edit'}?'X':'',$obj->{'systems_table_New'}?'X':''));
    }
}
				

$pdf->Output('permissions' . $date, 'I');
?>
