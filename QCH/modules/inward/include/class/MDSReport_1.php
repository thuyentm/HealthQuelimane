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
include_once "MDSDataBase.php";

class MDSReport extends MDSPersistent {

    public $rtitle = "Report";
    public $rtype = "Report";
    public $rdate = "";
    public $fdate = "";
    public $lines = "";
    public $tdate = "";
    public $rsql = "";
    public $rheaders = "";
    public $rheaders_width = "";
    public $rtext_align = "";
    public $rsort = "";
    public $rpagesize = "";
    public $rfooter = "";
    private $js = "";
    private $ppage = 0;

    public function __construct() {
        
    }

    public function plot() {
        
    }

    public function loadSideFilter() {
        $out = "";
        $out .="<div id='report_filter_cont'> \n";
        if ($this->rtype == "pharmacy_balance") {
            $out .="<form method='GET' action='home.php'><div class='report_filter_cont'> \n";
            $out .=" Date <input type='text' class='input report_input' id='fdate' name='fdate' value='" . $this->fdate . "'>  \n";
            //$out .="To Date <input type='text' class='input report_input' id='tdate' name='tdate'> \n";
            $out .=" Lines per page <input type='number' min=10 max=50 step=5 normal=30 class='input report_input' id='lines' name='lines' value='" . $this->lines . "'>  \n";
            $out .="<input type='hidden' id='page' name='page' value='" . $_GET['page'] . "'>\n";
            $out .="<input type='hidden' id='page' name='report' value='" . $_GET['report'] . "'> \n";
            $out .="<input type='submit' value='Make report' class='formButton'><input type='button' value='Print' class='formButton' onclick=printView('report_filter_cont')>\n";
            $out .="<a href='home.php?page=pharmacy'>Back to Pharmacy</a> ";
            $out .="</div> </form>\n";
        } else if ($this->rtype == "pharmacy_stock") {
            $out .="<form method='GET' action='home.php'><div class='report_filter_cont'> \n";
            $out .=" Stock less than <input type='number'  min=100  step=100 normal=500 class='input report_input' id='ops' name='ops' value='" . $_GET["ops"] . "' onkeyup=checkNumber(this); >  \n";
            //$out .="To Date <input type='text' class='input report_input' id='tdate' name='tdate'> \n";
            $out .=" Lines per page <input type='number' min=10 max=50 step=5 normal=30 class='input report_input' id='lines' name='lines' value='" . $this->lines . "'>  \n";
            $out .="<input type='hidden' id='page' name='page' value='" . $_GET['page'] . "'>\n";
            $out .="<input type='hidden' id='page' name='report' value='" . $_GET['report'] . "'> \n";
            $out .="<input type='submit' value='Make report' class='formButton'><input type='button' value='Print' class='formButton' onclick=printView('report_filter_cont')>\n";
            $out .="<a href='home.php?page=pharmacy'>Back to Pharmacy</a> ";
            $out .="</div> </form>\n";
        } else if ($this->rtype == "drug_list") {
            $out .="<form method='GET' action='home.php'><div class='report_filter_cont'> \n";
            $out .=" Lines per page <input type='number' min=10 max=50 step=5 normal=30 class='input report_input' id='lines' name='lines' value='" . $this->lines . "'>  \n";
            $out .="<input type='hidden' id='page' name='page' value='" . $_GET['page'] . "'>\n";
            $out .="<input type='hidden' id='page' name='report' value='" . $_GET['report'] . "'> \n";
            $out .="<input type='submit' value='Make report' class='formButton'><input type='button' value='Print' class='formButton' onclick=printView('report_filter_cont')>\n";
            $out .="<a href='home.php?page=pharmacy'>Back to Pharmacy</a> ";
            $out .="</div> </form>\n";
        }
        $out .="</div> \n";
        $this->js = "<script language='javascript'>";
        $this->js .="$('#fdate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});\n";
        $this->js .="$('#tdate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});\n";
        $this->js .='</script>';
        return $out . $this->js;
    }

    public function loadReport() {
        $out = "";
        $mdsDB = MDSDataBase::GetInstance();
        $mdsDB->connect();
        $result = $mdsDB->mysqlQuery($this->rsql);
        if (!$result) {
            echo "ERROR getting Exam Items";
            return null;
        }
        $count = $mdsDB->getRowsNum($result);
        if ($count == 0)
            return NULL;
        $seq = 0;
        $line = 0;
        $out .="<div class='report_cont' id='report_cont' onclick=normalView('report_filter_cont')> \n";
        $out .=$this->printReportHeader();
        while ($row = $mdsDB->mysqlFetchArray($result)) {
//            echo $seq.'<br/>';
//            if ($row[1] == 0)
//                continue;
            $seq++;
            $line++;
            if ($line == ($this->lines + 1)) {
                $line = 0;
                $this->ppage++;
                $out .=$this->printReportFooter($this->ppage);
                $out .=$this->printNewPage();
                $out .=$this->printReportHeader();
            }
            $out .="<tr> \n";
            $out .="<td class='report_body' align=right>" . $seq . "</td>";
            for ($rc = 0; $rc < count($this->rheaders); $rc++)
                $out .="<td class='report_body' align=" . $this->rtext_align[$rc] . " width=" . $this->rheaders_width[$rc] . ">" . $row[$rc] . "</td>\n";
            $out .="</tr> \n";
        }
        $out .=$this->printReportFooter($this->ppage + 1);
        $out .=$this->printReportInfo();
        $out .="</div> \n";
        $mdsDB->close();
        return $out;
    }

    private function printReportInfo() {
        $info = "<div class='report_info'>";
        $info .= "<table border=0 cellpadding=0 cellspacing=0 class='report_info'> \n";
        $info .= "<tr><td >Report Created on:</td><td >" . date("Y-m-d H:i:s") . "</td></tr> \n";
        $info .= "<tr><td >Report Created By:</td><td >" . getLoggedUser() . "</td></tr> \n";
        $info .= "</table> \n";
        $info .= "<div> \n";
        //gmdate("l dS \of F Y h:i:s A")
        return $info;
    }

    private function printReportHeader() {
        $out = "";
        $out .="<table border=0 cellpadding=0 cellspacing=0 > \n";
        $out .="<tr><td colspan='" . (count($this->rheaders) + 1) . "' class='report_title'>" . getHospital() . "<br>" . $this->rtitle . " (on " . $this->fdate . ")</td> <tr>\n";
        $out .="<tr> \n";
        $out .="<td class='report_header'>No</td> \n";
        foreach ($this->rheaders as $value) {
            $out .="<td class='report_header'>" . $value . "</td> \n";
        }
        $out .="</tr> \n";
        return $out;
    }

    private function printReportFooter($page) {
        $out = "";
        $out .="<tr><td colspan='" . (count($this->rheaders)) . "' class='report_info'> Page " . $page . "</td><td class='report_info'>PoweredBy: MDSFoss</td></tr> \n";
        $out .="</table> \n";
        return $out;
    }

    private function printNewPage() {
        return "<hr style='page-break-after: always;'>";
    }

}

?>