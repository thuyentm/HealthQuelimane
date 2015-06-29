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

include 'config.php';

function doAuth($username, $password) {
        mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
        mysql_select_db(DB) or die("cannot select DB");
        
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = md5(mysql_real_escape_string($password));
        
        $sql=" SELECT user.UID,user.FirstName,user.OtherName,user.UserGroup,user.Department,hospital.Name, hospital.HID,user.DefaultLanguage  ";
        $sql .= " FROM user,hospital WHERE user.UserName='$username' and user.Password='$password'  " ;
        $sql .= " and user.HID = hospital.HID and user.Active = 1 " ;
        $result=mysql_query($sql);       
        $count=mysql_num_rows($result);
        if ($count ==1 ){
            $row = mysql_fetch_row($result);
            $_SESSION["LANG"] = $row [7];
             return array ($row [0],$row [1],$row [2],$row [3],$row [4],$row [5],$row [6],$row [7]);
        }

       return NULL;
    }
    


?>