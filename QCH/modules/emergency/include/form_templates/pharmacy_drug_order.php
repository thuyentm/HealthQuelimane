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
include_once '../class/MDSHospital.php';
$pdf = new MDSReporter('P', 'mm', 'A5');
// Add a new page to the document
$pdf->addPage();
$ops = $_GET['ops'];

// Print two cards on the left side of the page (A5 landscape)
//$pdf->showData(10,0,$patient,$headings) ;
//$pdf->setDy(0);
$pdf->writeTitle($_SESSION['Hospital']);
$pdf->writeSubTitle('Drug Order List');
$pdf->writeSSubTitle('Stock less than '.$ops, 10, true, 0);

$rsql = "SELECT drugs.Name as 'name', Stock as 'stock',''  FROM `drugs` where 
                                 Active = 1 
                                 and (drugs.Stock < '$ops' )                                 
                             ORDER BY Name";
;
$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();
$result = $mdsDB->mysqlQuery($rsql);
if (!$result) {
    echo "ERROR getting Exam Items";
    exit();
}
$count = $mdsDB->getRowsNum($result);
$pdf->SetWidths(array(10,60,30,30));
$pdf->Ln();
if ($count) {
    $x=0;
    $pdf->Row(array('','Drug Name', 'Current Stock', 'Order Required'), true);
    while ($row = $mdsDB->mysqlFetchArray($result)) {
        $x+=1;
        $pdf->Row(array($x,$row['name'], $row['stock'],''));
    }
} else {
    //
}

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('drug_order'.date('Y-m-d@H:i'), 'i');
?>
