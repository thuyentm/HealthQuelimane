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

//print_table.php?TABLE=table_name&SORTBY=sort_field;

include '../config.php'; // Config file contains all table, fields configurations.

require('mysql_report.php');

$table = "";
$sort_by = "";
$table = $_GET["TABLE"];  // Gets the table name to print
$sort_by = $_GET["SORTBY"];  // Gets the sorting fields name
$search = $_GET["SEARCH"];

if (!$table)
    echo "Error in opening table";
include '../form_config/' . $table . '_config.php';
$table_config = ${$table};
$table_columns = $table_config["LIST"]; // This contains the list of fields to display . it can be modified in config.php

$sql = " SELECT  " . str_replace(" , ", " ", implode(", ", $table_columns)) . " ";
$sql .=" FROM   " . $table_config["TABLE"] . " ";
//echo $sql;
$dat_d = date('y-m-d');

$title = '';
$file_name = '';
if ($table == 'userForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Users';
    $file_name = 'users' . $dat_d;
} else if ($table == 'userGroupForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'User Groups';
    $file_name = 'user_groups' . $dat_d;
} else if ($table == 'visitTypeForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Visit Types';
    $file_name = 'visit_types' . $dat_d;
} else if ($table == 'HospitalForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Hospital Settings';
    $file_name = 'hospital_settings' . $dat_d;
} else if ($table == 'userMenuForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'User Menu';
    $file_name = 'user_menu' . $dat_d;
} else if ($table == 'complaintForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Complaints';
    $file_name = 'complaints' . $dat_d;
} else if ($table == 'treatmentForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Treatments';
    $file_name = 'treatments' . $dat_d;
} else if ($table == 'drugsForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Drugs';
    $file_name = 'drugs' . $dat_d;
} else if ($table == 'drugs_dosageForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Drug Dosages';
    $file_name = 'drug_dosage' . $dat_d;
} else if ($table == 'drugs_frequencyForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Drug Dosage Frequencies';
    $file_name = 'drug_dosage_frequency' . $dat_d;
} else if ($table == 'CannedTextForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Canned Texts';
    $file_name = 'canned_text' . $dat_d;
} else if ($table == 'labTestForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Lab Tests';
    $file_name = 'lab_tests' . $dat_d;
} else if ($table == 'labTestGroupForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Lab Test Groups';
    $file_name = 'lab_test_groups' . $dat_d;
} else if ($table == 'labTestDepartmentForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Lab Test Departments';
    $file_name = 'lab_test_departments' . $dat_d;
} else if ($table == 'wardForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'Wards';
    $file_name = 'wards' . $dat_d;
} else if ($table == 'quest_structForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Questionnaires';
    $file_name = 'questionnaire' . $dat_d;
} else if ($table == 'ICDForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'International Classification of Diseases (ICD)';
    $file_name = 'icd' . $dat_d;
    $sql.=addFilters($ICDForm["LIST"]);
    
} else if ($table == 'IMMRForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'IMMR';
    $file_name = 'immr' . $dat_d;
    $sql.=addFilters($IMMRForm["LIST"]);
} else if ($table == 'VillageForm') {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Villages';
    $file_name = 'villages' . $dat_d;
    $sql.=addFilters($VillageForm["LIST"]);
} else if ($table == 'SNOMEDFindingForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'SNOMED Findings';
    $file_name = 'SNOMED_Findings' . $dat_d;
    $sql="SELECT FINDID,CONCEPTID,TERM FROM finding ";
    $sql.=addFilters(array("FINDID","CONCEPTID","TERM"));
} else if ($table == 'SNOMEDEventForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'SNOMED Events';
    $file_name = 'SNOMED_Events' . $dat_d;
    $sql="SELECT EVENTID,CONCEPTID,TERM FROM event ";
    $sql.=addFilters(array("EVENTID","CONCEPTID","TERM"));
} else if ($table == 'SNOMEDDisorderForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'SNOMED Disorders';
    $file_name = 'SNOMED_Disorders' . $dat_d;
    $sql="SELECT DISORDERID,CONCEPTID,TERM FROM disorder ";
    $sql.=addFilters(array("DISORDERID","CONCEPTID","TERM"));
} else if ($table == 'SNOMEDProceduresForm') {
    $pdf = new PDF('P', 'pt', 'A5');
    $title = 'SNOMED Procedures';
    $file_name = 'SNOMED_Procedures' . $dat_d;
    $sql="SELECT PROCEDUREID,CONCEPTID,TERM FROM procedures ";
    $sql.=addFilters(array("PROCEDUREID","CONCEPTID","TERM"));
} else {
    $pdf = new PDF('L', 'pt', 'A5');
    $title = 'Data file ' . $table_config["TABLE"] . '  (' . $dat_d . ')';
    $file_name = $table;
}
$sql .=" ORDER BY " . $sort_by . " ";
//echo $sql;
$pdf->SetTopMargin(60);
$pdf->SetFont('Arial', '', 10.5);
$pdf->connect(HOST, USERNAME, PASSWORD, DB);
$attr = array('titleFontSize' => 12, 'titleText' => $title);
$pdf->mysql_report($sql, false, $attr);
$pdf->Output($file_name, 'I');

function addFilters($aColumns) {
    $sWhere = "";
    if ($_GET['SEARCH'] != "") {
        $sWhere = "WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['SEARCH']. "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    return $sWhere;
}
?>
