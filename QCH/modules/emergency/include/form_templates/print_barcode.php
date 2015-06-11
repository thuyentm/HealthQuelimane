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
$date=date("F j, Y, g:i a");

//session
session_start();
$hospital=$_SESSION['Hospital'];

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
        $query="select p.PID as `pid`,concat(p.Personal_Title,' ',p.Full_Name_Registered,' ',p.Personal_Used_Name) as `name` from lab_order as lo,patient as p where lo.LAB_ORDER_ID=$id and p.PID=lo.PID";
        $preFix='L';
        break;

    default:
        $title='Untitled';
        break;
}

$result=mysql_query($query);
$row=mysql_fetch_array($result);
$pid=$row[0];
$name=$row[1];

$df=2;

$pdf = new MDSReporter('P', 'mm', array(80,44),false);
$pdf->addPage();
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(0,0);
$pdf->SetXY(0,1+$df);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,4,$hospital,0,'C');
$pdf->SetFont('Arial','B',6);
$pdf->MultiCell(0,2,$title,0,'C');
$pdf->Line(5, 10,75,10);
$pdf->SetXY(2, 10+$df);
$pdf->MultiCell(0,2,$date,0,'C');
$pdf->SetXY(2, 14+$df);
$pdf->MultiCell(0,2,$name,0,'C');
$pdf->SetXY(2, 18+$df);
$pdf->MultiCell(0,2,'Registration No.: '.$pid,0,'C');

$barCode=$preFix.$id;
$bx=$pdf->getBarcodeWidth($barCode);
$bx=40-$bx/2;
$pdf->setBarcode($barCode,$bx,22+$df,false,0);
//sequence number generator

$pdf->Output('opd_slip' . $date, 'I');
?>
