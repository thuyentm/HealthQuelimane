<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
/*
  --------------------------------------------------------------------------------
  HHIMS - Hospital Health Information Management System
  Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
  http: www.hhims.org
  ----------------------------------------------------------------------------------
  This program is free software: you can redistribute it and/or modify it under the
  terms of the GNU Affero General Public License as published by the Free Software
  Foundation, either version 3 of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,but WITHOUT ANY
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
  A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License along
  with this program. If not, see http://www.gnu.org/licenses or write to:
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
        <title>Health Information System</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="stylesheet" href="index_resources/index.css" />
        <link rel="icon" type="image/ico" href="index_resources/images/govt_logomoz.png">
        <link rel="shortcut icon" href="index_resources/images/govt_logomoz.png">

        <script type="text/javascript" src="style/jquery.js"></script> 
        <script type="text/javascript" src="style/jquery.cookie.js"></script> 
        <?php
        include 'index_resources/MDSLicense.php';
        $license = new MDSLicense();
        $license->readKey("mdsfoss.key");
        if ($_GET['err']) {
            $err = $_GET['err'];
        }
        if ($err > 0) {
            echo " <script language='javascript'> \n";
            echo "jQuery().ready(function(){ \n";
            echo " $('#MDSError').html('Username or Password incorrect!'); \n";
            echo "}); \n";
            echo " </script>\n";
        }
        ?>
        <script language='javascript'>
            jQuery().ready(function(){
            $('#myusername').focus();
            });
        </script>
    </head>
    <body >




        <div class="left">
            <span class="imgdefault"><img src="index_resources/images/logo_moz.png" /></span>

        </div> 

        <div class="panedefault">

            <center style="font-family:Times New Roman;color:green;font-size:25px;">Main Menu </center> <br>  <br>
            <center>
                <a href="modules/opd/login.php"><img src="index_resources/images/opd.JPG" onmouseover="this.width=310;this.height=200;" onmouseout="this.width=210;this.height=150" alt="Out Patient Department" width="210" height="150" ></a>
                &nbsp &nbsp &nbsp &nbsp &nbsp
                <a href="modules/emergency/login.php"><img src="index_resources/images/emergency.JPG" onmouseover="this.width=310;this.height=200;" onmouseout="this.width=210;this.height=150" alt="Emergency" width="210" height="150" ></a>
                &nbsp &nbsp &nbsp &nbsp &nbsp
                <a href="modules/inward/login.php"><img src="index_resources/images/inward.JPG" onmouseover="this.width=310;this.height=200;" onmouseout="this.width=210;this.height=150" alt="In-Ward" width="250" height="150" ></a>

            </center>

        </div>







    </body>
</html>
