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


////////Configuration for patient form
$patientForm = array();
$patientForm["OBJID"] = "PID";
$patientForm["TABLE"] = "patient";
$patientForm["SAVE"] = "patient_save.php";
$patientForm["LIST"] = array('PID', 'LPID', 'Full_Name_Registered', 'Personal_Used_Name', 'DateOfBirth', 'Gender', 'Personal_Civil_Status', 'NIC', 'Address_Village');
$patientForm["DISPLAY_LIST"] = array('PID', 'LPID', 'Clinic Number', 'First name', 'Other name', 'Date of birth', 'Gender', 'Civil status', 'NIC', 'Village');
$patientForm["AUDIT_INFO"] = true;
$patientForm["NEXT"] = "home.php?page=patient&action=View&PID=";
$patientForm["FLD"][0] = array(
    "Id" => "Personal_Title", "Name" => "Title",
    "Type" => "select", "Value" => array("Mr.", "Ms.", "Mrs.", "Master", "Rev.", "Dr.", "Prof.", "Hon.", "Baby"),
    "Help" => "Patient's title Mr./Dr./Mrs./Mrs./Prof./Ref.", "Ops" => "",
    "valid" => ""
);
$patientForm["FLD"][1] = array(
    "Id" => "Full_Name_Registered", "Name" => "Name", "Type" => "name",
    "Value" => "", "Help" => "Name of the patient", "Ops" => "",
    "valid" => "*", "Style" => "font-weight:bold;font-size:16;height:25px;width:400px;"
);
if ($_SESSION["USE_ONE_FIELD_NAME"] == 1) {
    $patientForm["FLD"][2] = array(
        "Id" => "_", "Name" => "", "Type" => "", "Value" => "", "Help" => "", "Ops" => ""
    );
} else {
    $patientForm["FLD"][2] = array(
        "Id" => "Personal_Used_Name", "Name" => "Other Name / Initials", "Type" => "text",
        "Value" => "", "Help" => "Other  Name / Initials of the patient ", "Ops" => "",
        "valid" => "", "Style" => "font-weight:bold;font-size:16;height:25px;"
    );
}
 
/* $patientForm["FLD"][3]=array(
  "Id"=>"ClinicNo",   "Name"=>"Clinic Number",    "Type"=>"text",
  "Value"=>"", "Help"=>"Patient's Clinic number",     "Ops"=>"",
  "valid"=>""
  ); */

$patientForm["FLD"][3] = array(
    "Id" => "Gender", "Name" => "Gender", "Type" => "select",
    "Value" => array("Male", "Female"), "Help" => "Patient's gender Male/Female", "Ops" => "",
    "valid" => "*"
);
$patientForm["FLD"][4] = array(
    "Id" => "Personal_Civil_Status", "Name" => "Civil Status", "Type" => "select",
    "Value" => array("Single", "Married", "Divorced", "Widow", "UnKnown"), "Help" => "Civil status of the patient.", "Ops" => ""
);

if (($_SESSION["USE_CALENDAR_DOB"] == 1) || ($_GET["PID"]) > 0) {
    $patientForm["FLD"][5] = array(
        "Id" => "DateOfBirth", "Name" => "Date of birth", "Type" => "date", "Value" => "",
        "Help" => "patient's date of birth. 1978-02-09", "Ops" => "",
        "valid" => ""
    );
} else {
    $patientForm["FLD"][5] = array(
        "Id" => "DateOfBirth", "Name" => "Date of birth", "Type" => "date", "Value" => "",
        "Help" => "patient's date of birth. 1978-02-09", "Ops" => "",
        "valid" => ""
    );
}
/*
  $patientForm["FLD"][7]=array(
  "Id"=>"Age",   "Name"=>"Age",    "Type"=>"age",  "Value"=>"",
  "Help"=>"patient's Age in Year/Month/Day    ",    "Ops"=>"",
  "valid"=>"na"
  ); */

$patientForm["FLD"][6] = array(
    "Id" => "NIC", "Name" => "ID Number", "Type" => "nic", "Value" => "",
    "Help" => "patient's ID Card number ", "Ops" => ""
);
$patientForm["FLD"][7] = array(
    "Id" => "Telephone", "Name" => "Contact Telephone", "Type" => "phone",
    "Value" => "", "valid" => "", "Help" => "Contact Telephone Number", "Ops" => ""
);
$patientForm["FLD"][8] = array(
    "Id" => "Address_Street", "Name" => "Address 1", "Type" => "text",
    "Value" => "", "Help" => " eg. No32/2  ", "Ops" => "",
    "valid" => "*"
);
$patientForm["FLD"][9] = array(
    "Id" => "Address_Street1", "Name" => "Address 2", "Type" => "text",
    "Value" => "", "Help" => " Lake Road", "Ops" => "",
    "valid" => ""
);

$patientForm["FLD"][10] = array(
    "Id" => "Address_Village", "Name" => "Town / Village", "Type" => "village",
    "Value" => "", "Help" => "Birth address: eg. Navatkudah", "Ops" => "Village",
    "valid" => "*"
);
$patientForm["FLD"][11] = array(
    "Id" => "Remarks", "Name" => "Remarks", "Type" => "remarks", "Value" => "",
    "Help" => "Any remarks (Canned text enabled)", "Ops" => ""
);
$patientForm["FLD"][12] = array(
    "Id" => "_", "Name" => "", "Type" => "line", "Value" => "", "Help" => "", "Ops" => ""
);
// $patientForm["FLD"][13]=array(
//"Id"=>"PID", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>""
// );      
$patientForm["FLD"][13] = array(
    "Id" => "Address_DSDivision", "Name" => "", "Type" => "hidden", "Value" => "", "Help" => "", "Ops" => ""
);
$patientForm["FLD"][14] = array(
    "Id" => "Address_District", "Name" => "", "Type" => "hidden", "Value" => "", "Help" => "", "Ops" => ""
);
$patientForm["FLD"][15] = array(
    "Id" => "PID", "Name" => "PID", "Type" => "hidden", "Value" => "", "Help" => "", "Ops" => ""
);
$patientForm["FLD"][16] = array(
    "Id" => "FS", "Name" => "FS", "Type" => "hidden", "Value" => "0", "Help" => "", "Ops" => ""
);
$patientForm["BTN"][0] = array(
    "Id" => "SaveBtn", "Name" => "Save", "Type" => "button", "Value" => "Save",
    "Help" => "", "Ops" => "", "onclick" => "saveData()",
    "Next" => ""
);
//$patientForm["BTN"][1]=array(
//    "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
//    "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
//    "Next"=>""
//     );      
$patientForm["BTN"][1] = array(
    "Id" => "CancelBtn", "Name" => "Cancel", "Type" => "button", "Value" => "Cancel",
    "Help" => "", "Ops" => "", "onclick" => "window.history.back()",
    "Next" => ""
);
$patientForm["JS"] = "
<script>
function ForceSave(){
	$('#FS').val('1');
	$('#Remarks').val('Forced Saved By {$_SESSION["FirstName"]}  {$_SESSION["OtherName"]}' );
	saveData();
}
</script>
";
////////Configuration for patient form END;                   
?>