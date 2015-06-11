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
$pid=$_GET['PID'];

$patient = new MDSPatient();
$patient->openId($pid);
$date=date("F j, Y, g:i a");
$name = $patient->getFullName(); //returns the fullname
$reg_no=$patient->getId();
$pdf = new MDSReporter('P', 'mm', array(50,50),false);
$pdf->addPage();

//sequence number generator
$link = mysql_connect(HOST, USERNAME, PASSWORD) or
die("Could not connect: " . mysql_error());
mysql_select_db(DB);
$query="select CreatedDate from sequence";
$result = mysql_query($query);
$row=mysql_fetch_array($result);
$seqDate=$row['CreatedDate'];
mysql_free_result($result);
$currDate=date("Y-m-d");
// echo $seqDate.'<br>'.$currDate;
if($seqDate!=$currDate){
// 	echo "IN";
	$query="UPDATE sequence SET ID=0,CreatedDate='$currDate'";
	mysql_query($query);
}
$query="UPDATE sequence SET ID=LAST_INSERT_ID(ID+1)";
mysql_query($query);
$query="SELECT LPAD(LAST_INSERT_ID(),3,'0')";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
$seqNo=$row[0];
mysql_freeresult($result);
mysql_close($link);

// echo $seqNo;
$pdf->SetMargins(0,0);
$pdf->SetXY(0,2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,2,$_SESSION['Hospital'],0,'C');
$pdf->SetFont('Arial','BI',5);
$pdf->MultiCell(0,4,"OPD Appointment Slip",0,'C');
$pdf->MultiCell(0,0,'','B','C');
$pdf->Ln();
$pdf->MultiCell(0,4,$date,0,'C');
// $pdf->Ln();
$pdf->SetFont('Arial','B',25);
$pdf->MultiCell(0,10,$seqNo,0,'C');
// $pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,4,$name,0,'C');
$pdf->MultiCell(0,3.8,"Register No.: ".$reg_no,0,'C');
// $pdf->MultiCell(0,1,'');
$xpos=25-($pdf->getBarcodeWidth($pid)/2);

$pdf->setBarcode($pid,$xpos,$pdf->GetY(),false,0,false);

$pdf->Output('opd_slip' . $date, 'I');
?>
