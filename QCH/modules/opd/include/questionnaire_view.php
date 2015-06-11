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


//include_once 'class/MDSQuestionnaire.php';
include_once 'class/MDSDataStore.php';

$qid = $_GET["QUES_ID"];

$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();		
$result=$mdsDB->mysqlQuery("SELECT * FROM questionnaire_data where (QUES_ID ='".$qid."') "); 
if (!$result) { echo "ERROR getting Exam Items"; return null; }
$count = $mdsDB->getRowsNum($result);
if ($count == 0) return NULL;
$out="";
$out .= "<body style='background:#efefef;'>";
$out .= "<table style='font-family:Arial;font-size:14;'>";
$out .= "<tr><td  style='background:#0000FF;color:white;'><b>Question</b></td><td   style='background:#0000FF;color:white;'><b>Answer</b></td></tr>";
while($row = $mdsDB->mysqlFetchArray($result))  {
    $out .= "<tr ><td  style='padding-left:15;background:#ffffef;'>".$row["Question"]."</td><td style='padding-left:15;background:#ffffff;'>".$row["Answer"]."</td></tr>";

}
$out .= "<table>";
$out .= "</body>";
$mdsDB->close();
echo $out;
?>