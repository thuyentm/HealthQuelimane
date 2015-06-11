<?php
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
HHIMS-ADMIN  Module
Copyright (c) 2012 LunarTechnologies (PVT) Ltd
<http: www.lunartechnologies.net/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:

C/- Lunar Technologies (PVT) Ltd,
15B Fullerton Estate II,
Gamagoda, Kalutara, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
URL: http: www.lunartechnologies.net
----------------------------------------------------------------------------------
*/
?>
<html><title>HHIMS ADMIN</title><head><style>
.cmd_btn{background:#fafafa;height:30px;color:#000000;}
#top_bar{background:#4b8ef9;width:100%;padding-left:15px;padding-top:5px;color:#FFFFFF;border-bottom:1px solid #7f0000;}
#ttl{background:#b0cbf4;width:100%;padding-left:15px;color:#0000bf;border-bottom:1px solid #7f0000;font-weight:bold;}
</style></head><body style='background:#eeeeee;margin:0px;font-family:Arial;font-size:12px;'>
<?php 
session_start();

if(!session_is_registered(Admin)&&(md5($_POST["pw"])==md5(passWord()))){session_register("Admin");echo "<script>self.document.location='index.php'</script>";}
$commands = array(
	array("cmd"=>"cmd0","txt"=>"Log Out","ttl"=>"LogOut","func"=>"logOut"),
	array("cmd"=>"cmd1","txt"=>"BackUp HHIMS","ttl"=>"BackUps and Settings for HHIMS","func"=>"backUpSettings"),
	array("cmd"=>"cmd1","txt"=>"BackUp HHIMS","ttl"=>"BackUps and Settings for HHIMS","func"=>"backUpSettings")
);

if(!session_is_registered(Admin)){session_destroy();die(gologIn());}else{loadAdminPage();}

/* Functions*/

function loadAdminPage(){
//<img src='lt_logo_tr_100.png' width=30 height=30 align=middle style='float:left;'>
	echo "
	<div id='top_bar' >
	<table border=0 cellpadding=0 cellspacing=0 width=100% style='color:#FFFFFF;font-size:12px;'><tr><td  width=8% nowrap >
	
	";
	echo goLogOut();
	echo "</td><td>";
	setCommands();
	echo "</td></tr></table></div>";
	processCommand();
}
function processCommand(){
	loadHeader($_POST["cmd"]);
	ExecCommand($_POST["cmd"]);
}
function setCommands(){
	$commands = $GLOBALS["commands"];
	
	for ($i = 0; $i < count($commands); ++$i){
	echo "<form name=f".$i." method=POST action='' style='display:inline-block;'>";
		echo "<input type='hidden' value='".$i."' id='cmd' name='cmd'><input type='submit' id='btn' name='btn' class='cmd_btn' value='".$commands[$i]["txt"]."' > ";
		echo "</form>";
	}
	
}
function goLogOut(){
	return "<b>HHIMS Admin </b>";
}
function gologIn(){
	$out = "<div id='top_bar' style='background:#4b8ef9;width:100%;padding-left:15px;padding-top:15px;color:#FFFFFF;border-bottom:2px solid #7f0000;'>
	<form method=POST action=''><b>HHIMS Admin Password:</b><input type='password' name='pw' id='pw' autofocus='autofocus'></form>
	</div>
	<div style='color:#7f0000;font-size:14px;padding-top:100px;width:400;text-align:center;left:50%;position:relative;margin-left:-200px'>
	<img src='lt_logo_tr_100.png' width=50 height=50><br>
	<b>HHIMS</b><br>Hospital Health Information Management System<br>
	<b>HHIMS-ADMINISTRATION MODULE</b><br>
	Copyright (c) 2012 LunarTechnologies (PVT) Ltd<br>
	<a href='http://www.lunartechnologies.net' target='_blank'>Lunar Technologies</a>
	</div>";
	return $out ;
}

function loadHeader($i){
	$commands = $GLOBALS["commands"];
	if ($i >count($commands)){
		echo "<div id='ttl'>Unknown Command</div>";
	}
	else {
		echo "<div id='ttl'>".$commands[$i]["ttl"]."</div>";
	}
}
function passWord(){return date("Y")."hhims".date("m");}
?>
</body></html>


