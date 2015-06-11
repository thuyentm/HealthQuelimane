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
Page Author: Gihan Seneviratna
URL: http://www.mdsfoss.org
*/


include_once 'class/MDSPager.php';
include_once '../config.php';
include_once 'mds_reporter/MDSReporter.php';
$dat_d = date('y-m-d');
$page = (int) sanitize($_POST['page'], false, true);
$rp = sanitize($_POST['rows'], false, true);
$sortname = sanitize($_POST['sidx'], false, true);
$sortorder = sanitize($_POST['sord'], false, true);
$ddtype = sanitize($_POST['cell']);
$title = sanitize($_POST['title']) ? sanitize($_POST['title']) : '';
$orientation = sanitize($_POST['orientation']) ? sanitize($_POST['orientation']) : 'P';
$saveAsName = sanitize($_POST['save']).'_'.$dat_d;
$colHeaders = sanitize($_POST['colHeaders']) ? sanitize($_POST['colHeaders']) : array();
$widths = sanitize($_POST['widths']) ? sanitize($_POST['widths']) : array();
$id = sanitize($_POST['id'], false, true);
$rowid = sanitize($_POST['rowid'], false, true);
$search = sanitize($_POST['_search'], false, true);
$query = sanitize($_POST['exec']);
$hospitalName = $_SESSION["Hospital"] ? $_SESSION["Hospital"] : "Demo Hospital";

$link = mysql_connect(HOST, USERNAME, PASSWORD) or
die("Could not connect: " . mysql_error());
mysql_select_db(DB);

if (!($orientation == 'p' || $orientation == 'P' || $orientation == 'l' || $orientation == 'L'))
$orientation = 'P';
$colHeaders = str_replace('[', '', $colHeaders);
$colHeaders = str_replace(']', '', $colHeaders);
$colHeaders = str_replace("'", '', $colHeaders);
$colHeaders = explode(',', $colHeaders);

$widths = str_replace('[', '', $widths);
$widths = str_replace(']', '', $widths);
$widths = str_replace("'", '', $widths);
$widths = explode(',', $widths);

function sanitize($data, $enc=true, $param=false) {
	if ($param) {
		$data = trim($data);
		$data = htmlspecialchars($data);
		$data = mysql_escape_string($data);
		$data = stripslashes($data);
	}
	if ($enc) {
		$data = urldecode($data);
		$data = unserialize(mcrypt_cbc(MCRYPT_TripleDES, PASSWORD, $data, MCRYPT_DECRYPT));
	}
	return $data;
}

$ddtype = json_decode($ddtype);
$ddtypes = array();
//print_r($ddtype);
foreach ($ddtype as $value) {
	$ddtypes[$value->name] = array("value" => $value->value, "table" => $value->table, "column" => $value->column);
}
//print_r($ddtypes);
//echo "SEARCH $sortname";
//$query = base64_decode($query);
//$query = decrypt($query);
//echo "SQL $query";

$where = '';
//$split = explode("GROUP BY", $query);
$split = array();
$split = preg_split("/GROUP BY/i", $query);
$query = $split[0];
$groupBy = $split[1];
if ($groupBy != '') {
	$groupBy = " GROUP BY $groupBy";
}
//echo "$query : $groupBy";
//print_r($split);
if (stripos($query, 'where') == false) {
	$where.=' where ';
} else {
	$where.=' and ';
}
foreach ($ddtypes as $key => $value) {
	$searchField = sanitize($_POST[$key], false, true);
	if ($sortname == $key) {
		$sortname = $value['column'];
	}
	if ($value["table"] != '') {
		$key = $value["table"] . '.' . '`' . $value['column'] . '`';
	} else {
		$key = '' . $value['column'] . '';
	}
	if ($searchField != '') {
		if ($value["value"] == "DDTYPE") {
			$where.="$key like '%$searchField%' and ";
		} else if ($value["value"] == "DSTYPE") {
			$where.="$key='$searchField' and ";
		}
	}
}
$where = substr($where, 0, -4);

$query.=" $where ";
//meta data
$result = mysql_query($query);
$total = mysql_num_rows($result);
if (!$sortname) {
	$meta = mysql_fetch_field($result, 0);
	$sortname = $meta->name;
}
if (!$rowid) {
	$meta = mysql_fetch_field($result, 0);
	$rowid = $meta->name;
}
if (!$sortorder) {
	$sortorder = 'desc';
}


$sort = "ORDER BY `$sortname` $sortorder";

$query.="$groupBy $sort ";
header("Content-type: application/pdf");
$pdf = new MDSReporter($orientation, 'mm', 'A4');
$pdf->AddPage();
$pdf->writeTitle($hospitalName);
$pdf->writeSubTitle($title);
$pdf->mysqlReport($query, $colHeaders, $widths);
$pdf->Output($saveAsName,'I');
?>