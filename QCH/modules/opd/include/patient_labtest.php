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

function loadPatientLaboratoryTable($PID) {
    $tbl = "";
    $qry = " SELECT  
           lab_order.LAB_ORDER_ID, 
           patient.PID, 
           concat(patient.Personal_Title, ' ',patient.Full_Name_Registered), 
            lab_order.TestGroupName, 
           lab_order.OrderDate, 
           lab_order.OrderBy, 
           lab_order.Collection_Status, 
           lab_order.Status, 
           lab_order.OBJID 
           FROM lab_order, patient 
           WHERE ( lab_order.PID = patient.PID )  AND lab_order.PID=$PID";

    $pager2 = new MDSPager($qry);
    $pager2->setDivId('prefCont'); //important
    $pager2->setDivClass('');
    $pager2->setRowid('LAB_ORDER_ID');
    $pager2->setDivId('tablecont1'); //important
    $pager2->setDivStyle('width:95%;margin:25 auto 0 auto;');
    $pager2->setCaption("OPD Lab order list");
    $pager2->setColOption("OBJID", array("search" => true, "hidden" => true));
    $pager2->setColNames(array("LabID", "Patient-ID", "Name","Test Name", "Date", "By", "Sample Collection", "Status", ""));
    $pager2->setColOption("LAB_ORDER_ID", array("search" => false));
    $pager2->setColOption("OrderDate", array("search" => false));
    $pager2->setColOption("concat(patient.Personal_Title, ' ',patient.Full_Name_Registered)", array("search" => false));
    $pager2->setColOption("PID", array("search" => false));
    $pager2->setColOption("OrderBy", array("search" => false));
    $pager2->setColOption("Collection_Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Done")));
    $pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Done:Done", "Default" => "Pending")));

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
                window.location='home.php?page=opdLabOrder&action=Edit&LABORDID='+rowId+'&RETURN='+encodeURIComponent('home.php?page=laboratory')+'';;
            });
            }";
    return $pager2->render(FALSE);
}

function loadPatientLaboratory($PID) {
    if ((!$PID) || !is_numeric($PID))
        die("ID Error");
    $patient = new MDSPatient();
    $patient->openId($PID);
    echo loadHeader("Laborders");
    echo $patient->patientBannerTiny(30);
    echo loadPatientLaboratoryTable($PID);
}


?>