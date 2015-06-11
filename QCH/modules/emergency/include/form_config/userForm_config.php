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


  

						
////////Configuration for User form
$userForm = array();
$userForm["OBJID"] = "UID";
$userForm["TABLE"] = "user";
$userForm["LIST"] = array( 'UID', 'FirstName', 'OtherName', 'DateOfBirth', 'Gender','Post','UserName','UserGroup','Address_Village');
$userForm["DISPLAY_LIST"] = array( 'Id', 'First name', 'Other name', 'Date of birth', 'Gender','Post','User name','User group','Village');
$userForm["AUDIT_INFO"] = true;
$userForm["NEXT"]  = "home.php?page=preferences&mod=Users&UID=";

//pager starts
$userForm["CAPTION"]  = "Users";
$userForm["ACTION"]  = "home.php?page=preferences&mod=UserNew&UID=";
$userForm["ROW_ID"]="UID";
$userForm["COLUMN_MODEL"] = array( 'UID'=>array("width"=>"35px"), 'FirstName', 'OtherName', 'DateOfBirth', 'Gender'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;Male:Male;Female:Female'),"searchoptions" => array("defaultValue"=>'')),'Post','UserName','UserGroup','Address_Village');
$userForm["ORIENT"] = "L";

//pager ends

$userForm["FLD"]=array( array(
                                    "Id"=>"Title", "Name"=>"Title",
                                    "Type"=>"select",  "Value"=>array("Mr.","Ms.","Mrs.","Rev.","Dr.","Prof.","Hon."),
                                    "Help"=>"User's title Mr./Dr./Mrs./Mrs./Prof./Ref.", "Ops"=>"",
                                    "valid"=>""
                                    ),
									array(
                                    "Id"=>"FirstName", "Name"=>"First Name",    "Type"=>"text",
                                    "Value"=>"",     "Help"=>"First Name/Initial of the user",   "Ops"=>"",
                                    "valid"=>"*"
                                    ),
									array(
                                    "Id"=>"OtherName",    "Name"=>"Other Name",  "Type"=>"text",
                                    "Value"=>"",   "Help"=>"Other  Name of the user",  "Ops"=>"",
                                    "valid"=>""
                                    ),array(
                                    "Id"=>"Gender",   "Name"=>"Gender",    "Type"=>"select",
                                    "Value"=>array("Male","Female"), "Help"=>"User's gender Male/Female",     "Ops"=>"",
                                    "valid"=>"*"
                                    ),
									//array(
                                    //"Id"=>"CivilStatus",     "Name"=>"Civil Status",   "Type"=>"select",
                                    //"Value"=>array("Single","Married","Divorced","Widow","UnKnown"),   "Help"=>"Civil status of the User.",    "Ops"=>""
                                    //),
									//array(
                                   // "Id"=>"DateOfBirth",   "Name"=>"Date of birth",    "Type"=>"date",  "Value"=>"",
                                   // "Help"=>"user's date of birth. 1978-02-09",    "Ops"=>"",
                                   // "valid"=>""
                                   // ),
									//array(
                                    //"Id"=>"NIC",   "Name"=>"NIC",    "Type"=>"text",  "Value"=>"",
                                    //"Help"=>"National ID Card number ",    "Ops"=>""
                                    //),
									array(
                                    "Id"=>"Post",     "Name"=>"Post",   "Type"=>"post",
                                    "Value"=>"",   "Help"=>"Post of the staff",    "Ops"=>"", "valid"=>"*"
                                    ),
									array(
                                    "Id"=>"Speciality",     "Name"=>"Speciality",   "Type"=>"speciality",
                                    "Value"=>"",   "Help"=>"Speciality of the staff",    "Ops"=>"", "valid"=>""
                                    ),
									array(
                                    "Id"=>"Telephone",   "Name"=>"Contact Telephone",  "Type"=>"text",
                                    "Value"=>"",  "Help"=>"Contact Telephone Number",   "Ops"=>""
                                    ),
									array(
                                    "Id"=>"Address_Street",   "Name"=>"Address1",   "Type"=>"text",  
                                    "Value"=>"",  "Help"=>"Address : eg. 32/2  Kovil Road.",   "Ops"=>"",
                                    "valid"=>""
                                    ),
									//array(
                                    //"Id"=>"Address_Village", "Name"=>"Address2",  "Type"=>"lookup",
                                    //"Value"=>"",   "Help"=>"Village: eg. Navatkudah", "Ops"=>"Village",
                                    //"valid"=>""
                                    //),
									array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    ),
									array(
                                    "Id"=>"Address_DSDivision", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    ),
									array(
                                    "Id"=>"Address_District", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    ),
									array(
                                    "Id"=>"UserGroup", "Name"=>"User Group",   "Type"=>"select_usergroup",     "Value"=>"",     "Help"=>"User group",   "Ops"=>"", "valid"=>"*"
                                    ),
									array(
                                    "Id"=>"UserName", "Name"=>"User name",   "Type"=>"text",     "Value"=>"",     "Help"=>"Login user name",   "Ops"=>"", "valid"=>"*"
                                    ),
									array(
                                    "Id"=>"Password", "Name"=>"Current password",   "Type"=>"password",     "Value"=>"",     "Help"=>"Password",   "Ops"=>"", "valid"=>""
                                    ),
									array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    ),
									array(
                                    "Id"=>"HID", "Name"=>"",   "Type"=>"hidden",     "Value"=>$_SESSION["HID"],     "Help"=>"",   "Ops"=>""),
									array( 
                                    "Id"=>"Active", "Name"=>"Active",   "Type"=>"bool",     "Value"=>"1",     "Help"=>"User Active or not",   "Ops"=>"", "valid"=>"*"
                                    )
);									
						
$userForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
  
     $userForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"Cancel", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
////////Configuration for patient form END;          
?>