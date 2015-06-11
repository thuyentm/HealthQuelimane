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

$qid = $_POST["QUES_ID"];
$qstid = $_POST["QUES_ST_ID"];
if (!$qid){
    echo " error = true; ";
    return;
}
$values = array();
$values = explode('||',chop($_POST["FLDS"]));
print_r($values);                
//$questionnaire = new MDSQuestionnaire();
//$questionnaire->openId($qid);
$mdsDB = MDSDataBase::GetInstance();
$mdsDB->connect();		
$result=$mdsDB->mysqlQuery("SELECT * FROM quest_flds_struct where (QUES_ST_ID ='".$qstid."') "); 
if (!$result) { echo "ERROR getting Exam Items"; return null; }
$count = $mdsDB->getRowsNum($result);
if ($count == 0) return NULL;
$i=0;

while($row = $mdsDB->mysqlFetchArray($result))  {
    $ds = new MDSDataStore("questionnaire_data");
    $ds->setValue("QUES_ID", $qid );
    $ds->setValue("Question", $row["Field"]);
    $ds->setValue("Question", $row["Field"]);
    $ds->setValue("Answer", $values[$i]);
    $ds->setValue("Active", 1);
    $ds->save();
    $i++;
}
$mdsDB->close();
return "error = false; res=99999;";
?>