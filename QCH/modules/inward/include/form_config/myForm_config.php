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


  			

////////Configuration for EDIT ME form
$myForm = array();
$myForm["OBJID"] = "UID";
$myForm["TABLE"] = "user";
$myForm["LIST"] = array( 'UID', 'FirstName', 'OtherName', 'DateOfBirth', 'Gender','Post','UserName','UserGroup','Address_Village');
$myForm["DISPLAY_LIST"] = array( 'UID', 'First Name', 'Other Name', 'Date Of Birth', 'Gender','Post','User Name','User Group','Address Village');
$myForm["AUDIT_INFO"] = true;
$myForm["NEXT"]  = "home.php?page=logout&UID=";	


   $myForm["FLD"][0]=array(
                                    "Id"=>"DefaultLanguage", "Name"=>"Default language",  "Type"=>"select",
                                    "Value"=>array("English","Tamil","Sinhala"),   "Help"=>"User Interface language", "Ops"=>"",
                                    "valid"=>""
                                    );    

   $myForm["FLD"][1]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
$myForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                    
     $myForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );      
     $myForm["BTN"][2]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
////////Configuration for MY form END;       
?>