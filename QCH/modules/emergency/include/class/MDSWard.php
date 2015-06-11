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


include_once 'MDSPersistent.php';
include_once 'MDSDataBase.php';
include_once 'MDSAdmission.php';
include_once 'MDSPatient.php';
include_once 'MDSPager.php';

class MDSWard extends MDSPersistent {

    private static $instance;
    private $table = "ward";

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        parent::__construct($this->table);
    }

    public function getName() {
        return $this->getValue("Name");
    }

    public function loadWardList() {
		$qry = "SELECT w.`WID`,
				w.`Name`,
				w.`Type`,
				w.Telephone,
				w.BedCount,count(ad.ADMID) as pcount 
				FROM ward as w 
				LEFT JOIN (admission as ad) ON (w.WID=ad.Ward and ad.DischargeDate='') 
				where w.Active =1 GROUP BY w.`Name`";
        $pager = new MDSPager($qry);
        $pager->setDivId('ward_cont');
        $pager->setDivClass('ward_cont');
        $pager->setRowid('WID');
        $pager->setSortorder('asc');
        $pager->setCaption("Ward List");
        $pager->setColOption("WID",array("width"=>75,"search"=>false));
        $pager->setColOption("pcount",array("width"=>75,"search"=>false));
        $pager->setColNames(array("ID","Ward Name","Type","Telephone","Nos.Bed","Patients"));
        $pager->gridComplete_JS = "function() {
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                $(this).css({'cursor':'pointer'});
            }).mouseout(function(e){
            }).click(function(e){
                var rowId = $(this).attr('id');
                reDirect('wardpatient','WID='+rowId);
            });
            }";
        

        $out = $pager->render(false);

        return $out;
    }

    private function getPatientCount($wid) {
        $count = 0;
        $mdsDB = MDSDataBase::GetInstance();
        $mdsDB->connect();
        $result = $mdsDB->mysqlQuery("SELECT COUNT(ADMID) FROM admission where (Ward = '" . $wid . "') and (DischargeDate = '')  ");
        $row = $mdsDB->mysqlFetchArray($result);
        $mdsDB->close();
        return $row[0];
    }

    public function renderWardPlan() {
        $out = "";
        $out .="<div class='floor_cont'> \n";
        $out .=$this->renderBedLayout();
        $out .=$this->renderActiveBed();
        $out .="</div>\n";
        return $out;
    }

    private function renderBedLayout() {
        $seq = 0;
        $x = 10;
        $y = 10;
        $w = 300;
        $h = 140;
        $nrow = 3;
        for ($i = 0; $i < $this->getValue("BedCount"); $i++) {
            if ($seq == $nrow) {
                $y+=$h + 10;
                $x = 10;
                $seq = 0;
            }
            $out .="<div class='bed_cont' style='top:" . $y . "px;left:" . ($x + $w * $seq) . "px;' ><div style='color:#666666;font-size:18;'>" . ($i + 1) . "</div></div>";
            $seq++;
        }
        return $out;
    }

    public function renderActiveBed() {
        $out = "";
        $mdsDB = MDSDataBase::GetInstance();
        $mdsDB->connect();
        $sql = " SELECT admission.ADMID,admission.BHT,admission.Complaint,admission.AdmissionDate,admission.Remarks,
                patient.PID                
                FROM admission,patient 
                where (admission.Ward ='" . $this->getValue("WID") . "') 
                    and (admission.DischargeDate = '') 
                    AND (admission.PID =patient.PID) ORDER BY AdmissionDate DESC ";
        $result = $mdsDB->mysqlQuery($sql);
        if (!$result) {
            echo "ERROR getting Exam Items";
            return null;
        }
        $count = $mdsDB->getRowsNum($result);
        if ($count == 0)
            return NULL;
        $seq = 0;
        $x = 10;
        $y = 10;
        $w = 300;
        $h = 140;
        $nrow = 3;
        while ($row = $mdsDB->mysqlFetchArray($result)) {
            //if (!$row["ADMID"])continue;
            if ($seq == $nrow) {
                $y+=$h + 10;
                $x = 10;
                $seq = 0;
            }
            $out .="<div class='bed_active' style='top:" . $y . "px;left:" . ($x + $w * $seq) . "px;overflow:auto;' >";
            $patient = new MDSPatient();
            $patient->openId($row["PID"]);
            $out .= "<div class='pat_info' >" . $patient->getFullName() . " / " . $patient->getId() . "<br>" . $patient->getValue("Gender") . "/" . $patient->getAge("yrs") . "<hr></div>";
            $out .= "<div class='ad_info'>BHT: " . $row["BHT"] . "&nbsp;&nbsp;&nbsp;Date:" . $row["AdmissionDate"] . "<br>Complaint: " . $row["Complaint"] . "<br>";
            $out .= "Diagnosis: " . $row["Remarks"] . "</div>";
            $btns = "<input type='button' value='Open admission' class='formButton' style='font-weight:normal;height:20;'  onmousedown=reDirect('admission','action=View&ADMID=" . $row['ADMID'] . "&WID=" . $this->getId() . "') >";
            //$btns .= "<input type='button' value='Open Patient' class='formbutton'  onmousedown=reDirect('patient','action=View&PID=".$row['PID']."')>";
            $out .=$btns;
            $out .="</div>";
            $seq++;
        }
        $mdsDB->close();
        return $out;
    }

    public function renderWardPatient() {
        $out = "";
        /*
          $mdsDB = MDSDataBase::GetInstance();
          $mdsDB->connect();
          $sql =" SELECT admission.ADMID,admission.BHT,admission.Complaint,admission.AdmissionDate,admission.Remarks,
          patient.PID
          FROM admission,patient
          where (admission.Ward ='".$this->getValue("WID")."')
          and (admission.DischargeDate = '')
          AND (admission.PID =patient.PID) ORDER BY AdmissionDate DESC ";
          $result=$mdsDB->mysqlQuery($sql);
          if (!$result) { echo "ERROR getting Exam Items"; return null; }
          $count = $mdsDB->getRowsNum($result);
          if ($count == 0) return NULL;
          $seq = 1;
          $out .="<div class='ward_cont'  > \n";
          $out .="<TABLE border=0 cellspacing=0 cellpadding=5 width=100% > \n";
          $out .="<tr  class='ward_head'><td  class='ward_th'>"
          .getPrompt("#")."</td><td class='ward_th'>"
          .getPrompt("Date")."</td><td class='ward_th'>"
          .getPrompt("BHT")."</td><td class='ward_th'>"
          .getPrompt("Patient")."</td><td class='ward_th'>"
          .getPrompt("Complaint")."</td><td class='ward_th'>"
          ."</td></tr>\n";
          while($row = $mdsDB->mysqlFetchArray($result))  {
          $patient = new MDSPatient();
          $patient->openId($row["PID"]);
          $btns = "<input type='button' value='Open admission' class='formbutton' onmousedown=reDirect('admission','action=View&ADMID=".$row['ADMID']."&WID=".$this->getId()."') >";
          //$btns .= "<input type='button' value='Open Patient' class='formbutton'  onmousedown=reDirect('patient','action=View&PID=".$row['PID']."')>";

          $out .="<tr class='ward_row'><td>".$seq++."</td>";
          $out .="<td>".$row["AdmissionDate"]."</td>";
          $out .="<td>".$row["BHT"]."</td>";
          $out .="<td>".$patient->getFullName()." / ".$patient->getId()." / ".$patient->getValue("Gender")."/".$patient->getAge("yrs")."</td>";
          $out .="<td>".$row["Complaint"]."</td>";
          $out .="<td align='right'>".$btns."</td></tr>\n";
          }
          $out .="</TABLE  > \n";
          $out .="</div> \n";
          $mdsDB->close();
          return $out;

         */
        $qry = " SELECT admission.ADMID,
                patient.PID,
                patient.Full_Name_Registered,
                admission.AdmissionDate,
                admission.BHT,
                
                admission.Complaint
                FROM admission,patient 
                where (admission.Ward =" . $this->getValue("WID") . ") 
                    and (admission.DischargeDate = '') 
                    AND (admission.PID =patient.PID) ";
        $pager2 = new MDSPager($qry);
        $pager2->setDivId('ward_cont'); //important
        $pager2->setDivClass('ward_cont');
        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('ADMID');
        $pager2->setHeight(400);
        $pager2->setCaption("Patient list");
        //$pager->setSortname("AdmissionDate");
        $pager2->setColOption("ADMID", array("search"=>true,"hidden" => true,"height"=>100));
        $pager2->setColNames(array("","PID", "Patient","Date", "BHT",  "Complaint"));
        $pager2->setColOption("ADMID", array("search" => false, "width" => 50));
        $pager2->setColOption("AdmissionDate", $pager2->getDateSelector(''));
        //$pager2->setColOption("PrescribeDate", array("stype" => "text", "searchoptions" => array("dataInit_JS" => "datePicker_REFID","defaultValue"=>date("Y-m-d"))));
        //$pager2->setColOption("Status", array("stype" => "select", "searchoptions" => array("value" => ":All;Pending:Pending;Dispensed:Dispensed","defaultValue"=>"Pending")));

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
                window.location='home.php?page=admission&action=View&ADMID='+rowId;
            });
            }";
        $pager2->setOrientation_EL("L");
        return $pager2->render();
        //echo $qry ;
    }

}

?>