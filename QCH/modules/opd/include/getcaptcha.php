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

$a = rand ( 1 , 5 );
$b = rand ( 5 , 9 );
$out ="";
if (session_start()) {
    $_SESSION["CAPTCHA"] = $a+$b;
    $out .="<span id='cap' style='color:green;padding-left:5px;padding:5px;background:#fcfcda;border:1px solid green;'>".$a."&nbsp;+&nbsp;".$b."&nbsp;=&nbsp;";
    $out .="<input type='text' id='capval' name='capval' value='' onkeyup=checkCaptcha(this); placeholder='Enter the sum'>";
    $out .="<span id='chelp' style='color:red'></span></span> ";
    $out .="\n<script language='javascript'>\n";
        $out .="$('#capval').val('');\n";
        $out .=" function checkCaptcha(obj) {;\n";
            $out .=" var reg = /[A-Za-z \<\>\.\'\"\:\;\|\{\}\[\]\,]/;\n";
            $out .=" if (String(obj.value).match(reg)){\n";
                $out .=" obj.value ='';\n";
            $out .=" }\n";
        $out .=" }\n";
    $out .="</script>\n";
    echo $out;    
}
else {
    header("location: http://".$_SERVER['SERVER_NAME']);
}


?>
