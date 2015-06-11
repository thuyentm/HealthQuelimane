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
<title>HHIMS Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/login.css" /> 
<link rel="icon" type="image/ico" href="images/mds-icon.png">
<link rel="shortcut icon" href="images/mds-icon.png">

<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery.cookie.js"></script> 
<?php 
    include 'include/class/MDSLicense.php';
    $license = new MDSLicense();
    $license->readKey("mdsfoss.key");
    if ($_GET['err']) {
        $err = $_GET['err']; 
    }
    if ($err>0){
       echo " <script language='javascript'> \n" ;
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
<div id="MDSError" class="mdserror"></div>
<div class="login">
<div id="login" class="body">
<form id="form_login" action="include/logincheck.php" method="post" onsubmit="">
<fieldset><ul><li> 
<label class="inputLabel">User Name</label>
<span class="input"><input id="myusername" class="uname" name="username" type="text"  value="" tabindex="1" lang="en">
</span>
</li>
<li><label class="inputLabel">Password</label><span class="input">
            
<input type="hidden" name='LIC' id="LIC" value="<?php echo $_SESSION["LIC"]; ?>" >        
<input type="hidden" name='BC' id="BC" value="<?php echo $_SESSION["BC"]; ?>" >   
<input type="hidden" name='AP' id="AP" value="<?php echo $_SESSION["AP"]; ?>" >   
<input type="hidden" name='AA' id="AA" value="<?php echo $_SESSION["AA"]; ?>" >   
<input type="hidden" name='continue' id="continue" value='<?php echo $_GET["continue"]; ?>' >  
<input type="hidden" name='LIC_HOS' id="LIC_HOS" value="<?php echo $_SESSION["LIC_HOS"]; ?>" >
<input id="mypassword" class="password" name="password" type="password" value="" tabindex="2" autocomplete="off" lang="en"></span>

</li><li class="buttons"><input type="submit" id="submit_button" class="submit withLabels" value="Login "> 
    </li></ul>
</fieldset>

    <div id='cap_cont' style='padding:5px;text-align:center;'> </div>  
<a href="javascript:void(0)">Licensed to: <?php echo $license->hospital;  ?></a></div></div>
</div>
</form></div>

<div class="cover">
<div class="description">
<h2>What is HHIMS Foss?</h2>
<p>
HHIMS Foss is a Free and Open Source Hospital Health Information Management System that includes a patient record system, a pharmacy management system and a laboratory information system. The system has been developed by the ICT Agency of Sri Lanka in partnership with the Office of the Regional Director of Health Services, Kegalle with technical support from NetCom Technologies, Kalutara. Adapted from a WHO-designed database,  it is equally at home in the out-patient clinic, the ward, the pharmacy and the laboratory as it is when producing public health reports and statistics.    
</p> 
</div>
<div class="mainPoints">
<ul>
<li class="xlocal">
   <h3>Fast</h3>
   <p>From a single-user laptop in a doctor's practice to a multi-user network in a large hospital, you can enter patient data faster than you can write, and show it on the screen quicker than you can find the patient's old card.</p>
</li>
<li class="xlocal">
   <h3>User friendly</h3>
   <p>
   The secret of the system is simplicity. After the half-day training course, even new computer users are able to enter patient information, and choosing from lists such as diseases, drugs or villages takes the guesswork out of data entry.
  </p>
</li>
<li class="xlocal">
   <h3>Affordable</h3>
     <p>
   The software license is free. The only costs are for hardware, installation and training. An optional annual fee provides hot-line support and keeps your system up-to-date with the latest developments.
    </p>
</li>
</ul>
</div>
</div>
<div style="position: absolute;top:100%;margin-top: -150px;text-align: center;width:100%;color:#FFFFFF; ">
    <div>Visit <a href="http://www.hhims.org" target="_blank" ><b>www.hhims.org</b></a> for more details..</div><br>
     <a href='http://www.gov.lk/' target='_blank'><img src="images/SriLankalogo.jpg"  height=39></a>
	 <a href='http://www.icta.lk/' target='_blank'><img src="images/icta-logo.jpg" ></a>
	 <a href='http://www.icta.lk/en/programmes/e-society.html' target='_blank'><img src="images/esrilanka.jpg" ></a>
	 <a href='http://www.icta.lk/' target='_blank'><img src="images/e-samajaya-logo.jpg" width=101 height=39 ></a>
     <a href='http://www.hhims.org/' target='_blank'><img src="images/hhims_white.png" width=101 height=39></a>
	 <a href='http://www.lunartechnologies.net' target='_blank'><img src="images/lt_logo_tr_100.png" width=40 height=40 ></a>
</div>
</body>
</html>
