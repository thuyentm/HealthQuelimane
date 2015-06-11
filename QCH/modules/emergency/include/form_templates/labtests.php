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
date_default_timezone_set('Asia/Colombo');
include_once 'mds_reporter/MDSReporter.php';
include '../config.php';

$from_date = new DateTime($_GET['from']);
$to_date = new DateTime($_GET['to']);

$diff = $from_date->diff($to_date)->format('%a');

if (!$from_date && !$to_date) {
    echo 'please spacify valid date ';
    exit();
}
session_start();
//pdf decleration
$pdf = new MDSReporter('P', 'mm', 'A4');
//$pdf->setFormNum('Health 383A');
$pdf->AddPage();
//setup page title
$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle('Labtests From ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"));
//$pdf->Ln();
$link = mysql_connect(HOST, USERNAME, PASSWORD) or
        die("Could not connect: " . mysql_error());
mysql_select_db(DB);

for ($index = 0; $index <= $diff; $index++) {

    $date = $from_date->format("Y-m-d");
    $query = " SELECT  
           patient.PID,lab_order.LAB_ORDER_ID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
           lab_order.TestGroupName,
           lab_order.OrderBy,
           lab_order.LastUpDateUser
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND lab_order.Status='Done'
and lab_order.CreateDate LIKE '$date%' order by lab_order.PID asc
";
    $result = mysql_query($query);
    $count=mysql_num_rows($result);
//    $pdf->write(6,$count);
    if ($count>0) {
        $pdf->writeSSubTitle($date);
        $pdf->SetWidths(array($pdf->getAsPercentage(12),$pdf->getAsPercentage(22),
                    $pdf->getAsPercentage(22),$pdf->getAsPercentage(22),$pdf->getAsPercentage(22)));
        $pdf->Row(array("PID/LID","Patient","Test","Doctor","Labtech"),true);
//        $pdf->writeSSubTitle('OPD: ' . $date, 10, true, 0);
        while ($row = mysql_fetch_array($result)) {
            
            $data=array($row[0].'/'.$row[1],$row[2],$row[3],$row[4],$row[5]);
            $pdf->Row($data);
        }
        
        //statistics
        
        $query2="SELECT  
           lab_order.TestGroupName,
count(lab_order.TestGroupName)
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID ) AND lab_order.Status='Done'
and lab_order.CreateDate LIKE '$date%' GROUP BY lab_order.TestGroupName 
order by lab_order.TestGroupName asc";
        $result2=mysql_query($query2);
        $pdf->Ln(2);
        $pdf->SetWidths(array($pdf->getAsPercentage(50),$pdf->getAsPercentage(25)));
        while ($row2 = mysql_fetch_array($result2)) {
//            $pdf->ColRRow(array($row2[0],$row2[1]));
            $pdf->MultiCell(0,4,$row2[0]." : ".$row2[1]);
        }
        $pdf->SetFont("","B");
        $pdf->MultiCell(0, 4, "Total : $count");
        
    }


    date_add($from_date, new DateInterval('P1D'));
}


$pdf->Output('opd_prescriptions' . date('Y-m-d@H:i'), 'i');
?>