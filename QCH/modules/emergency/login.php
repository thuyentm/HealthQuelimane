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
<title>Emergency Department HIS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/login.css" />
<link rel="stylesheet" href="css/login1.css" /> 
<link rel="icon" type="image/ico" href="images/govt_logomoz.png">
<link rel="shortcut icon" href="images/govt_logomoz.png">

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

<div id="paneOuter">
<div class="pane">
     
<div class="left">
		<span class="img2"><img src="images/logo_moz.png" /></span>
  	
  	 </div> 
  	 <div class="right">
  	    			<form action="include/logincheck.php" method="post">

	<table class="login" cellpadding="0" cellspacing="0">
					<thead>
						<th colspan="4" style="font-weight:bold;" >User Login</th>
					</thead>
					<tr style="height:10px;"></tr>
					<tr>
						<td style="width:5%"></td>
						<td style="width:25%; font-weight:bold;" align="left">User Name</td>
							<td><input id="myusername" class="uname" name="username" type="text"  value="" tabindex="1" lang="en"></td>
						
						<td style="width:10%"></td>
					</tr>
					<tr>
						<td></td>
						<td style="font-weight:bold;"align="left">Password</td>
						<td><input id="mypassword" class="password" name="password" type="password" value="" tabindex="2" autocomplete="off" lang="en"></td>
						<td></td>
					</tr>					
					<tr>
						<td></td>
						<td colspan="2"><button id="login_submit" type="submit">Login</button></td>
						<td></td>
					</tr>
					<tr style="height:10px;"></tr>
				</table>
				
			</form>
		</div>


</div>	
</div>
	



<!--
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
            
<input type="hidden" name='LIC' id="LIC" value="<?php //echo $_SESSION["LIC"]; ?>" >        
<input type="hidden" name='BC' id="BC" value="<?php //echo $_SESSION["BC"]; ?>" >   
<input type="hidden" name='AP' id="AP" value="<?php //echo $_SESSION["AP"]; ?>" >   
<input type="hidden" name='AA' id="AA" value="<?php //echo $_SESSION["AA"]; ?>" >   
<input type="hidden" name='continue' id="continue" value='<?php //echo $_GET["continue"]; ?>' >  
<input type="hidden" name='LIC_HOS' id="LIC_HOS" value="<?php //echo $_SESSION["LIC_HOS"]; ?>" >
<input id="mypassword" class="password" name="password" type="password" value="" tabindex="2" autocomplete="off" lang="en"></span>

</li><li class="buttons"><input type="submit" id="submit_button" class="submit withLabels" value="Login "> 
    </li></ul>
</fieldset>

    <div id='cap_cont' style='padding:5px;text-align:center;'> </div>  
</div></div>
</div>
</form></div> -->

</body>
</html>
