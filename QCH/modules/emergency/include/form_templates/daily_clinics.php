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
$pdf = new MDSReporter('L', 'mm', 'A5');
$pdf->addPage();
$date = $_GET['date'];
$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Clinic Attendances ' . $date);

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$sql = "select `Name` from visit_type where `Name`!='OPD Visit'";
$result = $mdsDB->mysqlQuery($sql);
$count = $mdsDB->getRowsNum($result);
if ($count != 0) {


    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $clinic = $row['Name'];
        $mdsDB2 = MDSDataBase::GetInstance();
        $mdsDB2->connect();
        $sql2 = "select p.PID as pid,p.Full_Name_Registered as patient,p.Personal_Used_Name as patient2,u.FirstName as doctor,u.OtherName as doctor2,p.Gender as gender,ov.Complaint as complaint,ov.isNotify as notify  from patient as p,`user` as u,opd_visits as ov where ov.DateTimeOfVisit LIKE '$date%' and ov.PID=p.PID and ov.Doctor=u.UID and ov.VisitType='$clinic' order by p.LPID";
        $result2 = $mdsDB->mysqlQuery($sql2);
        $count2 = $mdsDB->getRowsNum($result2);
        if ($count2 != 0) {
            $pdf->Ln();
            $pdf->SetWidths(array(190));
            $pdf->SetAligns(array('C'));
            $pdf->Row(array($clinic), true);
            $pdf->SetWidths(array(20,60,50,60));
            $pdf->Row(array('PID', 'Name', 'Complaint', 'Doctor'), TRUE);
            while ($row2 = $mdsDB2->mysqlFetchArray($result2)) {
                $notify2 = $row2['notify'] == 0 ? 'no' : 'yes';
                $pdf->Row(array($row2['pid'], $row2['patient2'].' '.$row2["patient"], $row2['complaint'], $row2['doctor'].' '.$row['doctor2']));
            }
            $pdf->MultiCell(0, 6, "Total : $count2");
        }
        
    }
}
$pdf->Output('clinics' . $date, 'I');
?>
