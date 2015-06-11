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
    include_once '../class/MDSDataBase.php';
	include_once '../config.php';
	$search_txt = $_GET["SRH"];
	if ($search_txt == "" ) echo "";
	$mdsDB = MDSDataBase::GetInstance();
	$mdsDB->connect();	
	$sQuery = " SELECT Code,Text FROM   canned_text  ";
	$sQuery .=" WHERE (Active = 1) AND (Code =  '".strtoupper($search_txt)."') ";		
	$result=$mdsDB->mysqlQuery($sQuery ); 
	
	$Output = "";
	while ( $aRow = mysql_fetch_array( $result ) )
	{
		$Output .= $aRow["Text"];
	}
	$mdsDB->close();	
	$Output = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $Output);
	echo $Output;

   ?>