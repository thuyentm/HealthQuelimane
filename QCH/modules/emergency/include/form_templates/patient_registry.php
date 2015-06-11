<?php

//  ------------------------------------------------------------------------ //
//                   MDSFoss - Free Patient Record System                    //
//            Copyright (c) 2011 Net Com Technologies (Sri Lanka)            //
//                        <http://www.mdsfoss.org/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation.                                            //									     									 //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even an implied warranty of            //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to:                               //
//  Free Software  MDSFoss                                                   //
//  C/- Net Com Technologies,                                                //
//  15B Fullerton Estate II,                                                 //
//  Gamagoda, Kalutara, Sri Lanka                                            //
//  ------------------------------------------------------------------------ //
//  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org       //
//  Consultant: Dr. Denham Pole          	DrPole[AT]gmail.com          //
//  URL: http://www.mdsfoss.org                                              //
// ------------------------------------------------------------------------- //
date_default_timezone_set('Asia/Colombo');
include_once 'mds_reporter/MDSReporter.php';
include_once '../class/MDSDataBase.php';
include_once '../config.php';

$from_date = new DateTime($_GET['from']);
$to_date = new DateTime($_GET['to']);


// TSR: commented
//$diff = $from_date->diff($to_date)->format('%a');
//TSR:Added
$startDate = strtotime($_GET['from']);
$endDate = strtotime($_GET['to']);
$diff = intval(abs(($startDate - $endDate) / 86400));
//TSR

if (!$from_date && !$to_date) {
    echo 'please spacify valid date ';
    exit();
}
//pdf decleration
$pdf = new MDSReporter('P', 'mm', 'A5');
//$pdf->setFormNum('Health 383A');
$pdf->AddPage();
//setup page title
if(!session_start()) session_start ();
$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle('Visit Statistics From ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"));
$pdf->Ln(3);
//$pdf->SetWidths(array(15,30,10,30));
//$pdf->SetAligns(array('L','L','L','L'));
//$pdf->colRow(array('From:', $from_date->format('Y-m-d'),'To:',$to_date->format('Y-m-d')));

$pdf->SetWidths(array(30, 30, 30, 30));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Row(array('Date', 'OPD Visits', 'Admissions', 'Clinics'), true);

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();

for ($index = 0; $index <= $diff; $index++) {

    $date = $from_date->format("Y-m-d");

    $sql_opd = "select count(PID) as 'count' from opd_visits as ov where ov.DateTimeOfVisit like '{$date}%' and ov.VisitType='OPD Visit' group by substring(ov.DateTimeOfVisit,1,10)";
    $result_opd = $mdsDB->mysqlQuery($sql_opd);
    $row_opd = $mdsDB->mysqlFetchArray($result_opd);

    $sql_adm = "select count(PID) as 'count' from admission as ad where ad.AdmissionDate like '$date%' group by substring(ad.AdmissionDate,1,10);";
    $result_adm = $mdsDB->mysqlQuery($sql_adm);
    $row_adm = $mdsDB->mysqlFetchArray($result_adm);

    $sql_cli = "select count(PID) as 'count' from opd_visits as ov where ov.DateTimeOfVisit like '{$date}%' and ov.VisitType!='OPD Visit' group by substring(ov.DateTimeOfVisit,1,10);";
    $result_cli = $mdsDB->mysqlQuery($sql_cli);
    $row_cli = $mdsDB->mysqlFetchArray($result_cli);

    $opd_count = $row_opd ? $row_opd['count'] : 0;
    $adm_count = $row_adm ? $row_adm['count'] : 0;
    $cli_count = $row_cli ? $row_cli['count'] : 0;

    $pdf->Row(array($date, $opd_count, $adm_count, $cli_count));
    date_add($from_date, new DateInterval('P1D'));
}

$pdf->Output('visit_statistics_from ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"), 'i');
?>