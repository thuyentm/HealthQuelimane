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
	include_once 'class/MDSAttachment.php';
	include_once 'class/MDSUpload.php';
	include_once 'class/MDSPatient.php';
	$upfile = new MDSUpload();
	$upfile->upload_type = $_POST["Attach_Type"];
	$error  = "";
	$msg  = "";
	$file_name = "";
	$fileElementName = 'fileToUpload';

	if(!empty($_FILES[$fileElementName]['error'])){
		switch($_FILES[$fileElementName]['error']){
			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;
			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none'){
		$error = 'No file was uploaded..';
	}
	elseif (!$upfile->isFileTypeAllowed($_FILES['fileToUpload']['name'])){
		$error = 'File type not allowed';
	}
	elseif (($_POST["PID"] == "")||($_POST["PID"] == null)||(!isset($_POST["PID"]))){
		$error = 'Patient not Found';
	}
	else {
			$patient = new MDSPatient();
			$patient->openId($_POST["PID"]);
			$upfile->patient = $patient;
			$upfile->upload_to = $_POST["Attach_To"];
			if ($upfile->createFolder()==-1){
				$error .= " Error Directory";
			}
			else{
				$file_name = $upfile->getFileName($_FILES['fileToUpload']['name']);
				if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_name)){
					if (saveAttachment($_FILES['fileToUpload']['name'],$upfile->link,$upfile->hash )>0){
						$msg .= " File Name: " . $_FILES['fileToUpload']['name']." saved" ;
						@unlink($_FILES['fileToUpload']);		
					}
					else{
						$error .= " Error Save";
					}
				}
				else{
					if(!file_exists($file_name)) {
						$error .= " : Folder don't exist.";
					} elseif(!is_writable($file_name)) {
						$error .= " : Folder not writable.";
					} 
					else {
						$error .= " : ERROR";
					}
				}
			}
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
	exit;
	
	function saveAttachment($fname,$link,$hash){
		$id = -1;
		$attach = new MDSAttachment();
		$attach->setValue("PID",($_POST['PID']));
		$attach->setValue("Attach_To",($_POST['Attach_To']));
		$attach->setValue("Attached_By",($_POST['Attached_By']));
		$attach->setValue("Attach_Type",($_POST['Attach_Type']));
		$attach->setValue("Attach_Description",($_POST['Attach_Description']));
		$attach->setValue("Attach_Description",($_POST['Attach_Description']));
		$attach->setValue("Attach_Name",strtolower(str_replace(" ","_",$fname)));
		$link_url = strtolower(str_replace(" ","_",$_SESSION["LIC_HOS"]))."/patient/".$link;
		$attach->setValue("Attach_Link",$link_url);
		$attach->setValue("EPISODE",$_POST['EPISODE']);
		$attach->setValue("Active",$_POST['Active']);
		$attach->setValue("Attach_Hash",$hash);
		
		$id= $attach->save('rId');
		return $id;
	}
	
  ?>