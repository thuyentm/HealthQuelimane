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
include '../class/MDSPatient.php';
include_once '../config.php';

session_start();
$type=$_GET['type'];
$id=$_GET['id'];
$date=date("F j, Y");

//session
session_start();
$hospital="Base Hospital - Avissawella";

//Db
$link = mysql_connect(HOST, USERNAME, PASSWORD) or
die("Could not connect: " . mysql_error());
mysql_select_db(DB);

$title='';
$query='';
$preFix='';
switch ($type) {
    case 'L':
        $title='Lab Order Slip';
        $query="select p.PID as `pid`,concat(p.Full_Name_Registered,' ',p.Personal_Used_Name) as `name`, lo.TestGroupName as 'tgn' from lab_order as lo,patient as p where lo.LAB_ORDER_ID=$id and p.PID=lo.PID";
        //$preFix='L';
        break;

    default:
        $title='Untitled';
        break;
}

$result=mysql_query($query);
$row=mysql_fetch_array($result);
$pid=$row[0];
$name=$row[1];
$tgn=$row[2];


$df=1;

$pdf = new MDSReporter('P', 'mm', array(80,38),false);
$pdf->addPage();
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(0,0);
$pdf->SetXY(0,1+$df);
$pdf->SetFont('Arial','B',8);
//$pdf->MultiCell(0,4,$hospital,0,'C');
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(0,6,$title,0,'C');
$pdf->Line(5, 7,75,7);
$pdf->SetXY(2, 6+$df);
$pdf->MultiCell(0,4,$date,0,'C');
$pdf->SetXY(2, 10+$df);
$pdf->MultiCell(0,2,$name,0,'C');
$pdf->SetXY(2, 13+$df);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0,2,'PID.: '.$pid,0,'C');
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(2, 16+$df);
$pdf->MultiCell(0,2,'Test .: '.$tgn,0,'C');

//$barCode=$preFix.$id;
$barCode=$id;
$bx=$pdf->getBarcodeWidth($barCode);
$bx=40-$bx/2;
$pdf->setBarcode($barCode,$bx,20+$df,false,0);
//sequence number generator

$pdf->Output('opd_slip' . $date, 'I');
//print_file($pdf); 

/*$print = file_get_contents($pdf);

$printer = printer_open("brother HL-2250DN");

printer_write($printer, $print);

printer_close($printer);*/


?>


