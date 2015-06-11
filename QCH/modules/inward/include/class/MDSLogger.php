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


class MDSLogger
{
	
	private static $instance; 

	private function __construct() { 

        } 
 
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	function saveUserLog($path,$msg){
            $today = date("Ymd");
	    $errFile = $path.$today."-userlog.txt";
            $stringData = date(DATE_RFC822)." UID : ".$_SESSION["UID"].", NAME : ".$_SESSION["FirstName"]." ".$_SESSION["OtherName"].", (".$msg.") FROM : ".$_SERVER["REMOTE_ADDR"]."  \r\n";
            error_log($stringData, 3, $errFile);
	}
        function saveSysLog($path,$msg){
            $today = date("Ymd");
	    $errFile = $path.$today."-syslog.txt";
            $stringData = date(DATE_RFC822)." ".$msg." FROM : ".$_SERVER["REMOTE_ADDR"]."  \r\n";
            error_log($stringData, 3, $errFile);
	}
        
       function saveAccessLog($path,$msg){
	    $today = date("Ymd");
	    $errFile = $path.$today."-accesslog.txt";
            $stringData = date(DATE_RFC822)." ".$msg." FROM : ".$_SERVER["REMOTE_ADDR"]."  \r\n";
            error_log($stringData, 3, $errFile);
	}
       function saveErrorLog($path,$msg){
	    $today = date("Ymd");
	    $errFile = $path.$today."-errorlog.txt";
            $stringData = date(DATE_RFC822)." ".$msg." USID:".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]." FROM : ".$_SERVER["REMOTE_ADDR"]."  \r\n";
            error_log($stringData, 3, $errFile);
	}        
}

?>