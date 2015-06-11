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


function mdsGetArrayMax($num_array) {
    $max = 0;
    $temp=0;
    if (!$num_array)
        return;
    foreach ($num_array as $num) {
        if($num>$temp){
            $max=$num;
            $temp=$num;
        }
    }
    if($max>=260){
//        $pdf->addPage('P','A4');
        return 10;
    }
    return $max;
}
function mdsGetArraySum($num_array) {
    $sum = 0;
    if (!$num_array)
        return;
    foreach ($num_array as $num) {
        $sum+=$num;
    }
    return $sum;
}

function mdsGetNextYCord($y,&$pdf) {
    if($y>250){
        $pdf->addPage('P','A4');
        return 10;
    }else{
        return $y;
    }
}
//echo mdsGetMax(array(45,6,78,988,44,44,999,999,99,1000));
?>
