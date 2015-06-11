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

$ha4=260;
function getHospitalCode(){
	$hid=$_SESSION['HID'];
	return $hid;
}
function mdsTrim($longtext,$n){
    
    $newstr = preg_replace('/[\x00-\x1F\x7F]/', ' ', $longtext);
   if(strlen($newstr)>$n){
         $newstr=str_split($newstr,$n);
         $newstr=$newstr[0].'...';
   }
    return $newstr;
}

//return time from '2011-06-13 11:43:02' fromat string
function mdsGetTime($date) {
    if(!$date)
        return;
    $ar=explode(' ', $date);
    
    return $ar[1];
}
//return date from '2011-06-13 11:43:02' fromat string
function mdsGetDate($date) {
    if(!$date)
        return;
    $ar=explode(' ', $date);
    return $ar[0];
}

function mdsReplace($str,$rwith) {
    
}

?>
