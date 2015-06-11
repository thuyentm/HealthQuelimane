
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
    header("location: http://".$_SERVER['SERVER_NAME']);
}

	include '../config.php';
	  $con  = mysql_connect(HOST, USERNAME, PASSWORD);
        $el_id = $_GET["ELID"];
        $type ="";
        $type = $_GET["TYPE"];
	  if (!$con)  {
		  die('Could not connect: ' );
	  }
		mysql_select_db(DB, $con) or die("cannot select DB");
	  
	 $out = "";
	  $sql=" SELECT Name,isNotify ";
	  $sql .= " FROM complaints WHERE Active = TRUE " ;
      if ($type!="") {
        $sql .= " AND Type = '".$type."'";
      }
	  $sql .= " ORDER BY Name ";
	  $result=mysql_query($sql);   
	  if (!$result) {  
		echo  $sql ;
	 }
	  $out .="Press CTRL key for mutiple select.<br>\n";
      $out .="<div>";
      $out .="<select class='input' style='width:400;'  onChange=lookUpComplaints('".$el_id ."',this.value) >";
      if ($type!="") {
           $out .="<option value='' selected>".$type."</option> ";
     }
        $out .="<option value='' >Category-All</option> ";
        $out .="<option value='Cause' >Cause</option> ";
        $out .="<option value='Diagnosis' >Diagnosis</option> ";
        $out .="<option value='Findings' >Findings</option> ";
        $out .="<option value='Procedure' >Procedure</option> ";
        $out .="<option value='Symptom' >Symptom</option> ";
        $out .="<option value='Vague' >Vague Term</option> ";
        $out .="</select>";
        $out .="</div>";
      $out .="<select class='input' style='width:400;'  id='".$id."'   name='".$id."'  multiple='multiple' size='20' onclick=updateComplaint(this,'".$el_id."'); >\n";
	  while($row = mysql_fetch_array($result))  {
		if($row["isNotify"] == 1) {
		$out .="<option value='".$row["Name"]."' style='color:#FF0000;'>".$row["Name"]."</option>\n";
		}
		else {
		$out .="<option value='".$row["Name"]."' >".$row["Name"]."</option>\n";
		}

	  }
		$jq = "\n";
		$jq .= "<script language='javascript'>\n";
		$jq .= "</script>\n";
	  $out .="</select>\n";
      $btns="<br><input type='button' value='Ok' onclick=closeOPDDialog('opdDialog')>";
		echo $out.$btns;

?>
