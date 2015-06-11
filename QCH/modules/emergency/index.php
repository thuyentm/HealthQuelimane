<?php 
if((session_start())&&(!session_is_registered(username))){
        header("location:login.php");
}
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


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" type="image/ico" href="images/govt_logomoz.png">
<link rel="shortcut icon" href="images/govt_logomoz.png">
<title>Emergency Department HIS</title>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/browser.detect.js"></script> 
<script language="javascript">
    var support =false;
    function checkBrowser(){
        BrowserDetect.init();
        if ((BrowserDetect.browser == "Chrome")){
            support = true;
        }
        else if (BrowserDetect.browser == "Firefox") {
            support = true;
        }
        
        else if (BrowserDetect.browser == "Opera") {
            support = true;
        }
        else if (BrowserDetect.browser == "Mozilla") {
            support = true;
        }        
        else {
            support = false;
            alert(BrowserDetect.browser);
            alert("Your browser currently not support to run MDSFoss. Please use Chrome!");
            self.document.location='login.php';
        }
    }
 //history.replaceState({foo: "baz"}, "bar page", "\hhims");
</script>
</head>
<body style="padding:0px;margin:0px" onload="checkBrowser(); " bgcolor="#5C5C5C">
<iframe id="home" width=100% height =98% src="home.php?page=home&support=" frameborder=0 autofocus >
</body>
</html>
