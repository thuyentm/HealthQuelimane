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

include_once 'class/MDSPager.php';
include_once 'class/MDSPatient.php';
include_once 'mdsCore.php';

function loadPatientPrescriptionsTable($PID){
    $out = "";
    $tbl = "";
    $qry = "SELECT opd_presciption.PRSID, 
               patient.PID, 
               concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 

               opd_presciption.PrescribeDate, 
               opd_presciption.PrescribeBy, 
               opd_presciption.Status 
               FROM opd_presciption, patient 
               WHERE ( opd_presciption.PID = patient.PID ) 
               AND (opd_presciption.Active = true ) AND (opd_presciption.PID=$PID)
			   AND (opd_presciption.Status = 'Pending')
			   ORDER BY  opd_presciption.PrescribeDate DESC  
			   ";
			   
			   
	///////////////REMOVE IF THE HOSPITAL DOSENT WANT OPEN PRESRIPTION DIRECTLY		   
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery($qry); 
		if (!$result) return null;
		$count = $mdsDB->getRowsNum($result);
		if ($count == 1) {
			$row = $mdsDB->mysqlFetchArray($result);
			die("<script> self.document.location='home.php?page=dispense&PRSID=".$row["PRSID"]."&RETURN=home.php%3Fpage%3Dpharmacy'</script>");
		}
		else if ($count == 0){
			die("<script> alert('There is no pending prescription.');</script>");
		}
		else{
			$row = $mdsDB->mysqlFetchArray($result);
			//echo "<script> alert('There are ".$count." prescriptions. \\n Please select from the list.');";
			//echo "self.document.location='home.php?page=dispense&PRSID=".$row["PRSID"]."&RETURN=home.php%3Fpage%3Dpharmacy'";
			echo "</script>";
				
	///////////////END:REMOVE IF THE HOSPITAL DOSENT WANT OPEN PRESRIPTION DIRECTLY
	    $qry = "SELECT opd_presciption.PRSID, 
               patient.PID, 
               concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 

               opd_presciption.PrescribeDate, 
               opd_presciption.PrescribeBy, 
               opd_presciption.Status 
               FROM opd_presciption, patient 
               WHERE ( opd_presciption.PID = patient.PID ) 
               AND (opd_presciption.Active = true ) AND (opd_presciption.PID=$PID)
			   ";
    $pager2 = new MDSPager($qry);
    $pager2->setDivId('tablecont1'); //important
    $pager2->setDivStyle('width:95%;margin:25 auto 0 auto;');
    $pager2->setDivClass('');
    $pager2->setRowid('PRSID');

    $pager2->setCaption("OPD Prescription list");
    $pager2->setColNames(array("PRSID", "Patient-ID", "Name", "Date", "By", "Status"));
    $pager2->setColOption("PRSID", array("search" => false));
    $pager2->setColOption("PID", array("search" => false));
    $pager2->setColOption("concat(patient.Personal_Title, ' ',patient.Full_Name_Registered)", array("search" => false));
    $pager2->setColOption("PrescribeDate", array("search" => false));
    $pager2->setColOption("PrescribeBy", array("search" => false));
    $pager2->setColOption("PID", array("table_EL" => "patient"));
    $pager2->setColOption("PrescribeDate", $pager2->getDateSelector());
    $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Dispensed:Dispensed", "defaultValue" => "Pending")));

    $pager2->gridComplete_JS = "function() {
                var c =null;
                $('.jqgrow').mouseover(function(e) {
                    var rowId = $(this).attr('id');
                    c = $(this).css('background');
                    $(this).css({'background':'yellow','cursor':'pointer'});
                }).mouseout(function(e){
                    $(this).css('background',c);
                }).click(function(e){
                    var rowId = $(this).attr('id');
                    window.location='home.php?page=dispense&PRSID='+rowId+'&RETURN=home.php%3Fpage%3Dpharmacy';
                });
                }";
    $pager2->setOrientation_EL("L");
    $out.=$pager2->render(FALSE);
    return $out;
	}
}

function loadPatientPrescriptions($PID){
    if ((!$PID)||!is_numeric($PID))
        die("ID Error");
    $patient = new MDSPatient();
    $patient->openId($PID);
    echo loadHeader("Prescrptions");
    echo $patient->patientBannerTiny(30);
    echo loadPatientPrescriptionsTable($PID);
}
?>