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

include_once '../class/MDSDataBase.php';
include_once '../class/MDSUserGroup.php';
include_once '../config.php';

$allowedtables = array("P","p");
$srch = "";
$srch = sanitize($_GET['id']);
$tbl = "P";
if(in_array($tbl, $allowedtables)){
    if ($srch !=""){
            try{
		if (!is_numeric($srch)){
                    $tbl = substr($srch,0,1);
                    $srch = substr($srch,1,strlen($srch));
                    $mdsDB = MDSDataBase::GetInstance();
                    $mdsDB->connect();	
                    if ( ($tbl =="P")|| ($tbl=="p")){
                        $qry = "SELECT PID FROM patient where ( LPID = '".$srch."' )";
                        $result=$mdsDB->mysqlQuery($qry); 
                        $link = 'patient&action=View&PID=';
                     }
                     else if ( ($tbl =="V")|| ($tbl=="v")){
                         $qry = "SELECT OPDID FROM opd_visits where ( OPDID = '".$srch."' )";
                        $result=$mdsDB->mysqlQuery($qry); 
                        $link = 'opd&action=View&OPDID=';
                     }
                     else if ( ($tbl =="L")|| ($tbl=="l")){
                         $qry = "SELECT LAB_ORDER_ID FROM lab_order where ( LAB_ORDER_ID = '".$srch."' )";
                        $result=$mdsDB->mysqlQuery($qry); 
                        $link = 'opdLabOrder&action=Edit&LABORDID=';
                     }   
                     else if ( ($tbl =="D")|| ($tbl=="d")){
                         $qry = "SELECT PRSID FROM opd_presciption where ( PRSID = '".$srch."' )";
                        $result=$mdsDB->mysqlQuery($qry); 
                        $link = 'dispense&action=Edit&PRSID=';
                     }                  
                     else{
                         echo -1; die(-1);
                     }                    
		}
                else{
                    $mdsUG = MDSUserGroup::GetInstance();
                    $mdsDB = MDSDataBase::GetInstance();
                    $mdsDB->connect();	
                    $qry = " SELECT PID FROM patient where ( LPID = '".$srch."' ) ";
                    $result=$mdsDB->mysqlQuery($qry);                     
                    if ($mdsUG->getRedirectPage($_SESSION["UserGroup"]) == "Labtests"){
                        $link = 'patient_labtest&action=Edit&PID=';
                    }
                    else if ($mdsUG->getRedirectPage($_SESSION["UserGroup"]) == "Prescriptions"){
                        $link = 'patient_prescription&action=Edit&PID=';
                    }
                    else if ($mdsUG->getRedirectPage($_SESSION["UserGroup"]) == "Treatments"){
                        $link = 'patient&action=View&PID=';
                    }
                    else{
                        $link = 'patient&action=View&PID=';
                    }
                }
                $count = $mdsDB->getRowsNum($result);
                
		if ($count == 0)  {echo -2 ; die(-2); }
		else if ($count > 1) { echo -1; die(-1);}
                else if ($count == 1)  {
                    $row = mysql_fetch_row($result);
                    echo $link.$row[0];
                }
            }  catch (Exception $e){
                echo "";
            }
    }
}
else{
    echo '';
}

function sanitize($data){
        $data=trim($data);
        $data=htmlspecialchars($data);
        $data = mysql_escape_string($data);
        $data = stripslashes($data);
        return $data;
}
?>
