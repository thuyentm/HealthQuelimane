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


include_once 'class/MDSReport.php';

function loadReport() {
    $report_type = $_GET['report'];
    if (!$report_type) {
        $report_type = "list";
    }
    if ($report_type == "pharmacy_balance") {
        $report = loadPharmacyBalanceReport();
    } else if ($report_type == "pharmacy_stock") {
        $report = loadPharmacyStockReport();
    } else if ($report_type == "drug_list") {
        $report = loadDrugListReport();
    }else if ($report_type == "immr") {
        $report = loadIMMRReport();
    }
    else {
        $reports = loadReportItems();
    }
    $out = "";
    $out .= $report;
    echo $out;
}
function loadIMMRReport(){
    $out = "";
    $year = $_GET['year'];
    $quater = $_GET['quarter'];
    $report = new MDSReport();
    $report->rdate = date("Y-m-d");
    $report->rtype = "immr";
    $filter = $report->loadSideFilter();
    $out .= $filter;
    $url = "include/form_templates/immr.php?year=".$year."&quarter=".$quater;
    if (($year =="") || ($quater == "")) {
    echo $out."Selct the year and the quarter";
    return;
    }
    else {
        $out.="<iframe src=$url height='85%' width='100%' >";
        echo $out;
    }
    
    
}
function loadPharmacyBalanceReport() {
    $out = "";
    $from_date = $_GET['fdate'];
    $to_date = $_GET['tdate'];
    $lines = $_GET['lines'];
    if ($from_date == "")
        $from_date = date("Y-m-d");
    if ($to_date == "")
        $to_date = date("Y-m-d");
    if ($lines == "")
        $lines = 30;
    $report = new MDSReport();
    $report->rdate = date("Y-m-d");
    $report->rtype = "pharmacy_balance";
    $report->rtitle = "Pharmacy drug balance";
    $report->rheaders = array('Drug Name', 'Quantity');
    $report->rheaders_width = array('300', '200');
    $report->rtext_align = array('left', 'right');

    $report->fdate = $from_date;
    $report->lines = $lines;
    $report->rsql = "SELECT drugs.Name, SUM( prescribe_items.Quantity)  FROM `prescribe_items` ,`opd_presciption`,`drugs` where 
                            (opd_presciption.PrescribeDate LIKE '$from_date%') 
                            AND (opd_presciption.PRSID =  prescribe_items.PRES_ID)
                            AND(drugs.DRGID=prescribe_items.DRGID)
                            AND(prescribe_items.Status = 'Dispensed') 
                            AND(prescribe_items.Active = 1) 
                            GROUP BY prescribe_items.DRGID ORDER BY drugs.Name";
    $filter = $report->loadSideFilter();
//    $rcont = $report->loadReport();
//    $out .=$filter.$rcont;
    $out .=$filter;
    //added gihan
    $url = "include/form_templates/pharmacy_balance.php?fdate=$from_date";
    $out.="<iframe src=$url height='85%' width='100%' >";
    return $out;
}

function loadDrugListReport() {

    $out = "";
    $from_date = $_GET['fdate'];
    $to_date = $_GET['tdate'];
    $lines = $_GET['lines'];

    if ($from_date == "")
        $from_date = date("Y-m-d");
    if ($to_date == "")
        $to_date = date("Y-m-d");
    if ($lines == "")
        $lines = 30;

    $report = new MDSReport();
    $report->rdate = date("Y-m-d");
    $report->rtype = "drug_list";
    $report->rtitle = "Current stock";
    $report->rheaders = array('Drug Name', 'Current stock');
    $report->rheaders_width = array('300', '100');
    $report->rtext_align = array('left', 'right');

    $report->fdate = $from_date;
    $report->lines = $lines;
    $report->rsql = "SELECT drugs.Name, Stock  FROM `drugs` where 
                                 (drugs.Active = 1) 
                             ORDER BY Name";

    $filter = $report->loadSideFilter();
//    $rcont = $report->loadReport();
//    $out .=$filter . $rcont;
    $out .=$filter;
    $url = "include/form_templates/pharmacy_current_stock.php";
    $out.="<iframe src=$url height='85%' width='100%' >";
    return $out;
}

function loadPharmacyStockReport() {



    $out = "";
    $from_date = $_GET['fdate'];
    $to_date = $_GET['tdate'];
    $lines = $_GET['lines'];
    $ops = $_GET['ops'];
    if ($from_date == "")
        $from_date = date("Y-m-d");
    if ($to_date == "")
        $to_date = date("Y-m-d");
    if ($lines == "")
        $lines = 30;
    if ($ops == "")
        $ops = 1000;
    $report = new MDSReport();
    $report->rdate = date("Y-m-d");
    $report->rtype = "pharmacy_stock";
    $report->rtitle = "Drug order list";
    $report->rheaders = array('Drug Name', 'Current stock', 'Order Required');
    $report->rheaders_width = array('300', '100', '100');
    $report->rtext_align = array('left', 'right');

    $report->fdate = $from_date;
    $report->lines = $lines;
    $report->rsql = "SELECT drugs.Name, Stock,''  FROM `drugs` where 
                                 Active = 1 
                                 and (drugs.Stock < '$ops' )                                 
                             ORDER BY Name";

    $filter = $report->loadSideFilter();
//    $rcont = $report->loadReport();
//    $out .=$filter . $rcont;
    $out .=$filter ;
    $url = "include/form_templates/pharmacy_drug_order.php?ops=$ops";
    $out.="<iframe src=$url height='85%' width='100%' >";
    return $out;
}
function loadReportMenu() {
   $menu = "";
   $menu .="<div id='left-sidebar'>\n";
		$menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
			$menu .="<a>Patient</a>\n";
			$menu .="<div>\n";
					$menu .="<input type='button' class='submenuBtn' value='Encounter Statistics'  onclick=openDialogBox('date_range_selector','Encounter&nbsp;Statistics','patient_statistics')>\n";
					$menu .="<input type='button' class='submenuBtn' value='Visit Complaints Treated'  onclick=openDialogBox('date_range_selector','Visit&nbsp;Complaints&nbsp;Treated','visit_complaints_treated','include/visit_complaints_report_pop.php') >\n";

			$menu .="</div>\n";
			
			$menu .="<a>Hospital</a>\n";
			$menu .="<div>\n";
					$menu .="<input type='button' class='submenuBtn' value='Current stock balance'  onclick=self.document.location='home.php?page=report&report=drug_list'>\n";
					$menu .="<input type='button' class='submenuBtn' value='Create drug order'  onclick=self.document.location='home.php?page=report&report=pharmacy_stock&ops=1000' >\n";
					$menu .="<input type='button' class='submenuBtn' value='Daily drugs dispensed'  onclick=self.document.location='home.php?page=report&report=pharmacy_balance' >\n";
					$menu .="<input type='button' class='submenuBtn' value='Hospital IMMR'  onclick=self.document.location='home.php?page=report&report=immr' >\n";	
					$menu .="<input type='button' class='submenuBtn' value='Hospital performance'  onclick=openDialogBox('date_range_selector','Hospital&nbsp;Indicator','hospital_indicator')>\n";
					
			$menu .="</div>\n";			
	$menu .=" </div>\n";
	$menu .="</div>\n";
	$menu .="<script language='javascript'>\n";
		$menu .="$('#list1a').accordion({navigation: true,active: false,header: '.LeftMenuItem'});\n";
	$menu .="</script>\n";
	echo $menu ;
}
function loadReportItems(){
        $quarter =  array(  '00'=>'1','01'=>'1','02'=>'1',
                            '03'=>'2','04'=>'2','05'=>'2',
                            '06'=>'3','07'=>'3','08'=>'3',
                            '09'=>'4','10'=>'4','11'=>'4');    
    include_once 'class/MDSCalendar.php';
	echo loadHeader("Reports");
    $c = new MDSCalendar();
    $year = $_GET['year'];
    $month = $_GET['month'];
    $c->render($year,$month);
    loadReportMenu();
}
?>
