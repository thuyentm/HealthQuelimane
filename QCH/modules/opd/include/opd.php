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


include_once 'class/MDSOpd.php';
include_once 'class/MDSLeftMenu.php';






function loadOpdLabTestInfo($opdid){
	$out = "";
	$tools= "<input type='button'  title='Add/Edit this prescription' class='patBtn'  value='Edit' onclick=self.document.location='home.php?page=opdPrescription&OPDID=".$opdid."'>";
	$out .= "<div class='opdCont' style='width:900px;padding:5px;'>\n";
	$out .= "<table class='PrescriptionInfo' width=100% border=0 cellpadding=0>";
		$out .= "<tr><td class='td_brd'>#</td>\n";
		$out .= "<td class='td_brd'>Test Orderd</td>\n";
		$out .= "<td class='td_brd'>Value</td>\n";
		$out .= "<td class='td_brd'>Range</td>\n";
		$out .= "<td align=right></td><tr>";
	$out .= "</table>";
	$out .= "</div>";
	return $out;
}

function loadOPDSummary() {
  
	$opdid = $_GET['OPDID'];
	$out = $lbar = $opdInfo = $patInfo = $head = $opdPrescription = $opdLabOrder =  "";
	if (!$opdid) {
		echo " <script language='javascript'> \n" ;
		echo " jQuery().ready(function(){ \n";
		echo " $('#MDSError').html('Patient not found!'); \n";
		echo "}); \n";
		echo " </script>\n";
		return ""; 
	}
	$opd		= new MDSOpd();
	$l_menu		= new MDSLeftMenu();
	$opd->openId($opdid);
        echo loadHeader("Patient Visit Information");
	 echo $l_menu->renderLeftMenu("Opd",$opd);
        
        echo  $opd->patient->patientBannerTiny();
	echo  $opd->loadOPD($opd->isOpened);
	echo  $opd->loadPrescriptionItems($opd->isOpened);
	echo  $opd->loadLabOrders($opd->isOpened);
	
	echo  $opd->patient->loadExams($opd->isOpened);
	echo  $opd->patient->loadHistory($opd->isOpened);
	echo  $opd->patient->loadPatientAllergy($opd->isOpened);	
	echo  $opd->loadTreatments($opd->isOpened);
        echo  $opd->loadQuetionnaire($opd->isOpened);
        echo  $opd->checkNotification();

}

?>