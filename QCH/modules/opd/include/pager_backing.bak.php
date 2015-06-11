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

session_start();
if (!session_is_registered(username)) {
    header("location: ../login.php");
}

include_once 'class/MDSDataBase.php';
include_once 'class/MDSPager.php';
include_once 'config.php';
$page = (int) sanitize($_POST['page'],false,true);
$rp = sanitize($_POST['rows'],false,true);
$sortname = sanitize($_POST['sidx'],false,true);
$sortorder = sanitize($_POST['sord'],false,true);
$ddtype = sanitize($_POST['cell']);
$id = sanitize($_POST['id'],false,true);
$rowid = sanitize($_POST['rowid'],false,true);
$search = sanitize($_POST['_search'],false,true);
$query = sanitize($_POST['exec']);

mysql_connect(HOST, USERNAME, PASSWORD) or
        die("Could not connect: " . mysql_error());
mysql_select_db(DB);

function sanitize($data, $enc=true, $param=false) {
    if ($param) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = mysql_escape_string($data);
        $data = stripslashes($data);
        return $data;
    }
    $data = str_replace(" ", "+", $data);
    $str = base64_decode($data);
    if ($enc) {
        $str = mcrypt_decrypt(MCRYPT_DES, PASSWORD, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('des', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        if ($pad && $pad < $block && preg_match(
                        '/' . chr($pad) . '{' . $pad . '}$/', $str
                )
        ) {
            $str = substr($str, 0, strlen($str) - $pad);
        }
        return $str;
    }
    return $str;
}

$ddtype = json_decode($ddtype);
$ddtypes = array();
//print_r($ddtype);
foreach ($ddtype as $value) {
    $ddtypes[$value->name] = array("value" => $value->value, "table" => $value->table);
}
//print_r($ddtypes);
//$query = base64_decode($query);
//$query = decrypt($query);
//echo "SQL $query";

switch ($search) {
    case 'true':
        $search = true;
        break;
    case 'false':
        $search = false;
        break;
    default:
        $search = false;
        break;
}
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
if ($search) {
    if (stripos($query, 'where') == false) {
        $where.=' where ';
    } else {
        $where.=' and ';
    }
    foreach ($ddtypes as $key => $value) {
        $searchField = sanitize($_POST[$key],false,true);
        if ($value["table"] != '') {
            $key = $value["table"] . '.' . "`$key`";
        } else {
            $key = '`' . $key . '`';
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
}

//meta data
$result = mysql_query($query);
$count = mysql_num_rows($result);
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
if (!$page)
    $page = 1;
if (!$rp)
    $rp = 10;
$start = (($page - 1) * $rp);

$limit = "LIMIT $start, $rp";
//$total = $mdsDB->getRowsNum($result);
//$total_pages = 0;
//if ($total > 0) {
//    $total_pages = ceil($total / $rp);
//}
header("Content-type: text/x-json");
$i = 0;
$fields = array();
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result, $i);
    array_push($fields, $meta->name);
    $i++;
}
mysql_free_result($result);
//total calc
$query.="$where $groupBy $sort ";

$result = mysql_query($query);
$total = mysql_num_rows($result);
$total_pages = 0;
if ($total > 0) {
    $total_pages = ceil($total / $rp);
}
mysql_free_result($result);
$query.="$limit ";
//echo $query . "\n";
$result = mysql_query($query);

$response->page = $page;
$response->total = $total_pages;
$response->records = $total;

$i = 0;
while ($row = mysql_fetch_array($result)) {
    $response->rows[$i]['id'] = $row[$rowid];

    $cell = array();
    foreach ($fields as $field) {
//        array_push($cell, str_replace("DDTYPE", $row[$field], $ddtypes[$field]));
        array_push($cell, $row[$field]);
    }
    $response->rows[$i]['cell'] = $cell;
    $i++;
}
mysql_free_result($result);
mysql_close($link);
//print_r($response);
echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
//echo json_encode($response);
?>
