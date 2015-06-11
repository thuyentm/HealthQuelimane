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
      if(!session_is_registered(username)){
         header("location:../../login.php");
      }
      include '../mdsCore.php';
	  include_once '../class/MDSHospital.php';
	  include "../search.php";
?>
<html>
<head>
<title>Look up</title>
   <link href="css/jquery-ui-1.8.7.custom.css" rel="stylesheet" type="text/css">
    <link href="css/lookup.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="../../js/mdsCore.js"></script> 
 		<style type="text/css" title="currentStyle"> 
			@import "css/demo_page.css";
			@import "css/demo_table.css";
		</style>   
 <script language="javascript">
 function villageSelect(vge,dsd,ds){
     opener.villageUpdate(vge,dsd,ds);
     window.close();
}
 </script>
</head>
<body>
<?php
    $district =""; 
    $dsdivision="";
    $district = $_GET["DISTRICT"];
    $dsdivision = $_GET["DSDIVISION"];
    if ((!$district) && (!$dsdivision)){
		$hospital = new MDSHospital();
		list ($district,$dsdivision) = $hospital->getDistrictDSDivision();
	}
	echo "<div id='mdsHead' class='mdshead'>Village lookup\t&nbsp;&nbsp;";
    echo getDistricts($district );
    if ($district !=""){
        echo getDSDivsions($district,$dsdivision );
    }
    echo "</div>\n" ;
     if ($dsdivision !=""){
        echo getGNDivisions($district,$dsdivision );
    }   
    

?>
</body>
</html>