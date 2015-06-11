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
//include 'checksession.php';



session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}

include 'mdscore.php';

include 'class/MDSMail.php';
include 'class/MDSDataBase.php';

$capval = $_POST["capval"];

if ($capval != $_SESSION["CAPTCHA"]){
    echo -99;
    die('');
    return null;
    
}
else {
    if (session_start()) {
        unset($_SESSION["CAPTCHA"]);
    }
}

$info = $_POST["info"];
$type = $_POST["typ"];
$msg = $_POST["msg"];
$ret = $_POST["ret"];
$hospital = $_POST["h"];
$user = $_POST["u"];
$user_group = $_POST["ug"];
$url = $_POST["url"];
$browser = $_POST["b"];

$header = "";
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
  $eol="\r\n"; 
} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
  $eol="\r"; 
} else { 
  $eol="\n"; 
}
$headers .= "Content-type: text/html".$eol; ; 
$headers .= 'From: MDSFoss.org <mailer@mdsfoss.org>'.$eol; 
$headers .= 'Reply-To: MDSFoss.org <mailer@mdsfoss.org>'.$eol; 
//$headers .= "Message-ID:<".$now." mailer@".$_SERVER['SERVER_NAME'].">".$eol; 
$headers .= "X-Mailer: PHP v".phpversion().$eol;           // These two to help avoid spam-filters 

$body ="";
$body .="<table width=100% style='font-size:12px;font-family:courier;'>";
$body .="<tr>";
    $body .="<td colspan=2><b>".$type." from ".$hospital."</b></td>";

$body .="</tr>";
$body .="<tr>";
    $body .="<td >Type</td>";
    $body .="<td >".$type."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td >Browser</td>";
    $body .="<td >".$browser."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td nowrap>Logged User</td>";
    $body .="<td >".$user."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td nowrap>Logged User Group</td>";
    $body .="<td >".$user_group."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td >Hospital</td>";
    $body .="<td >".$hospital."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td >Stamp</td>";
    $body .="<td >".date(DATE_RFC822)."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td nowrap>Application URL</td>";
    $body .="<td >".$url."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td >Message</td>";
    $body .="<td >".$msg."</td>";
$body .="</tr>";
$body .="<tr>";
    $body .="<td >SESSION</td>";
    $body .="<td >".session_encode()."</td>";
$body .="</tr>";
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();
	$sql_adm = " SELECT count(admission.ADMID)  from admission ";
	$result_adm = $mdsDB->mysqlQuery($sql_adm);
    $row_adm = $mdsDB->mysqlFetchArray($result_adm);
$body .="<tr>";
    $body .="<td nowrap>Admissions</td>";
    $body .="<td >".$row_adm[0]."</td>";
$body .="</tr>";	
	$sql_opd = " SELECT count(OPDID)  from opd_visits ";
	$result_opd = $mdsDB->mysqlQuery($sql_opd);
    $row_opd = $mdsDB->mysqlFetchArray($result_opd);
$body .="<tr>";
    $body .="<td nowrap>Visits</td>";
    $body .="<td >".$row_opd[0]."</td>";
$body .="</tr>";
	$sql_pat = " SELECT count(PID)  from patient ";
	$result_pat = $mdsDB->mysqlQuery($sql_pat);
    $row_pat = $mdsDB->mysqlFetchArray($result_pat);
$body .="<tr>";
    $body .="<td nowrap>Patients</td>";
    $body .="<td >".$row_pat[0]."</td>";
$body .="</tr>";	
	$sql_lab = " SELECT count(LAB_ORDER_ID)  from lab_order ";
	$result_lab = $mdsDB->mysqlQuery($sql_lab);
    $row_lab = $mdsDB->mysqlFetchArray($result_lab);
$body .="<tr>";
    $body .="<td nowrap>Lab test Ordered</td>";
    $body .="<td >".$row_lab[0]."</td>";
$body .="</tr>";	
	$sql_prs = " SELECT count(PRSID)  from opd_presciption ";
	$result_prs = $mdsDB->mysqlQuery($sql_prs);
    $row_prs = $mdsDB->mysqlFetchArray($result_prs);
$body .="<tr>";
    $body .="<td nowrap>Prescriptions</td>";
    $body .="<td >".$row_prs[0]."</td>";
$body .="</tr>";	
	$sql_not = " SELECT count(NOTIFICATION_ID)  from notification ";
	$result_not = $mdsDB->mysqlQuery($sql_not);
    $row_not = $mdsDB->mysqlFetchArray($result_not);
$body .="<tr>";
    $body .="<td nowrap>Notifications</td>";
    $body .="<td >".$row_not[0]."</td>";
$body .="</tr>";

$body .="</table>";
$mdsDB->close();
$mdsmail= new MDSMail();
$mdsmail->setTo("tsruban@mdsfoss.org");

$mdsmail->setSubject($type." from ".$hospital);
$mdsmail->setMessage($body);
$mdsmail->setHeader($headers);
echo $mdsmail->sendMail();

?>
