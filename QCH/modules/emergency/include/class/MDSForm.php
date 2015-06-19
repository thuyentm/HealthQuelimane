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




include_once 'MDSPersistent.php';
include_once 'MDSDataBase.php';

class MDSForm 
{
	public $FrmName 	= NULL;	
	private $OBJID		= NULL;
	private $FrmObj		= NULL;
	private $FrmConf	= NULL;
	private $isOpen		= 0;
	private $Js			= "";
	private $JqDte		= "";
	private $FrmOut		= "";
	private $isBlocked = false;
	private $css_cont_class = "formCont";
    public $isContainFile = false;    
    public $left=20;
        
	public function __construct() {
	
	}
	
	public function render($frm,$blocked=false){
		if (!$this->FrmName) {echo "Render Error:"; return NULL;}
		if (!$frm) {echo "Render Error1:"; return NULL;}
		$this->isBlocked = $blocked;
		if ($this->isBlocked ) $this->css_cont_class = "formCont fromContBlocked";
		$this->FrmConf = $frm;
		$this->isOpen = $this->getObject();
		$patient_Banner = "";
                $left =20;
		if ($_GET["PID"]) {
			$patient = new MDSPatient();
			$patient->openId($_GET["PID"]);
			$patient_Banner = $patient->patientBannerTiny($left);
		}
                else if ($_GET["OPDID"]) {
                    $opd = new MDSOpd();
                    $opd->openId($_GET["OPDID"]);
                    $patient_Banner = $opd->getOpdPatient()->patientBannerTiny($left);
                }
		$this->FrmOut = $this->displayForm();
		return $patient_Banner.$this->FrmOut;
	}
	
	private function getObject(){
		//$this->OBJID = $_SESSION[$this->FrmConf["OBJID"]];
		if (!$this->OBJID) $this->OBJID = $_GET[$this->FrmConf["OBJID"]];
		if ( $this->OBJID ){
			if (!$this->FrmConf["TABLE"]) {echo "Render Error Table:"; return NULL;}
			$this->FrmObj = new MDSPersistent($this->FrmConf["TABLE"]);
			$this->FrmObj->openId($this->OBJID );
			return $this->FrmObj->getId();
		}
	}
	
	private function displayForm(){
		$out = "";
		$out .= "<div id='formCont' class='".$this->css_cont_class."' ";
                //if($left != "")
                if ($this->FrmConf["LEFT"]){
                     $out .= " style='left:".$this->FrmConf["LEFT"].";width:70%;'\n";   
                }
                else{
                     $out .= " style='left:".$this->left.";'\n";   
                }
                $out .= " \n";  
                $out .= ">\n";  
		
		$out .= "<form id='frm' method='post' ";
		if ($this->isContainFile) {
			$out .= " enctype='multipart/form-data' ";
		}
		$out .= ">\n";
		$out .= $this->frmId();
		for ($i = 0; $i < count($this->FrmConf["FLD"]); ++$i)
		{
			$out .="<div id ='fc".$this->FrmConf["FLD"][$i]["Id"]."' class='fieldCont'>\n";
			switch ($this->FrmConf["FLD"][$i]["Type"]) {
				case "select":
					$out .= $this->frmSelect($this->FrmConf,$i);
					break;
				case "out_come":
					$out .= $this->frmOutCome($this->FrmConf,$i);
					break;
                case "bool":
					$out .= $this->frmBool($this->FrmConf,$i);
					break;
                case "checkbox":
					$out .= $this->frmCheckBox($this->FrmConf,$i);
					break;                                    
				case "textarea":
					$out .= $this->frmTextArea($this->FrmConf,$i);
					break;
				case "textar":
					$out .= $this->frmTextAr($this->FrmConf,$i);
					break;
	
				case "remarks":
					$out .= $this->frmRemarks($this->FrmConf,$i);
					break;
				case "file":
					$out .= $this->frmFile($this->FrmConf,$i);
					break;
				case "timestamp":
					$out .= $this->frmTimeStamp($this->FrmConf,$i);
					break;
				case "datetime":
					$out .= $this->frmDateTime($this->FrmConf,$i);
					break;
				case "lookup":
					$out .= $this->frmVillageLookUp($this->FrmConf,$i);
					break;
				case "line":
					$out .= $this->frmLine();
					break;
				case "heading":
					$out .= $this->frmHeading();
					break;
				case "heading1":
					$out .= $this->frmHeading1();
					break;
				case "section":
					$out .= $this->frmSection($this->FrmConf,$i);
					break;                                    
				case "date":
					$out .= $this->frmDate($this->FrmConf,$i);
					break;	
				case "death_date":
					$out .= $this->frmDeathDate($this->FrmConf,$i);
					break;	
                case "age":
					$out .= $this->frmAge($this->FrmConf,$i);
					break;	
				case "hidden":
					$out .= $this->frmHidden($this->FrmConf,$i);
					break;	
				case "text":
					$out .= $this->frmText($this->FrmConf,$i);
					break;
				case "textvisit":
					$out .= $this->frmTextVisit($this->FrmConf,$i);
					break;	
				case "name":
					$out .= $this->frmPatientName($this->FrmConf,$i);
					break;                                    
				case "stock":
					$out .= $this->frmStock($this->FrmConf,$i);
					break;                                    
				case "label":
					$out .= $this->frmLabel($this->FrmConf,$i);
					break;
				case "staff":
					$out .= $this->frmStaff($this->FrmConf,$i);
					break;					
				case "license":
					$out .= $this->frmLicense($this->FrmConf,$i);
					break;                                    
                case "phone":
					$out .= $this->frmPhone($this->FrmConf,$i);
					break;                                    
				case "nic":
					$out .= $this->frmNIC($this->FrmConf,$i);
					break;				
				case "number":
					$out .= $this->frmNumber($this->FrmConf,$i);
					break;
				case "password":
					$out .= $this->frmPassword($this->FrmConf,$i);
					break;
				case "password1":
					$out .= $this->frmPassword1($this->FrmConf,$i);
					break;
				case "icd_text":
					$out .= $this->frmICD($this->FrmConf,$i);
					break;
				case "immr_text":
					$out .= $this->frmIMMR($this->FrmConf,$i);
					break;					
				case "snomed_text":
					$out .= $this->frmSnomed($this->FrmConf,$i,$this->FrmConf["FLD"][$i]["Ops"]);
					break;
                case "snomed_text_select":
					$out .= $this->frmSnomedSelect($this->FrmConf,$i,$this->FrmConf["FLD"][$i]["Ops"]);
					break;                                    
				case "snomed_text_procedure":
					$out .= $this->frmSnomed($this->FrmConf,$i,"proceduresForm");
					break;
				case "complaint":
					$out .= $this->frmComplaint($this->FrmConf,$i);
					break;
				case "selectdrug":
					$out .= $this->frmSelectDrug($this->FrmConf,$i);
					break;	
				case "dosage":
					$out .= $this->frmDosage($this->FrmConf,$i);
					break;
				case "frequency":
					$out .= $this->frmFrequency($this->FrmConf,$i);
					break;
                case "opd_treatment":
					$out .= $this->frmOPDTreatment($this->FrmConf,$i);
					break;
				case "doctor":
					$out .= $this->frmDoctor($this->FrmConf,$i);
					break;
				case "ward":
					$out .= $this->frmWard($this->FrmConf,$i);
					break;	
				case "post":
					$out .= $this->frmPost($this->FrmConf,$i);
					break;	
				case "speciality":
					$out .= $this->frmSpeciality($this->FrmConf,$i);
					break;						
					
				case "bht":
					$out .= $this->frmBHT($this->FrmConf,$i);
					break;					
				case "olable":
					$out .= $this->frmOutLable($this->FrmConf,$i);
					break;							
				case "select_usergroup":
					$out .= $this->frmSelectUserGroup($this->FrmConf,$i);
					break;
				case "usergroup":
					$out .= $this->frmCheckBoxUserGroup($this->FrmConf,$i);
					break;
				case "permission":
					$out .= $this->frmPermission($this->FrmConf,$i);
					break;	
				case "sysreview":
					$out .= $this->frmSysReview($this->FrmConf,$i);
					break;	
				case "pasthistory":
					$out .= $this->frmMedicalHistory($this->FrmConf,$i);
					break;	
				case "lab_dpt":
					$out .= $this->frmLabDepartment($this->FrmConf,$i);
					break;
				case "lab_grp":
					$out .= $this->frmLabGroupName($this->FrmConf,$i);
					break;
				case "visit_type":
					$out .= $this->frmVisitType($this->FrmConf,$i);
					break;
				case "severity":
					$out .= $this->frmStatusType($this->FrmConf,$i);
					break;
				case "to_user":
					$out .= $this->frmToUser($this->FrmConf,$i);
					break;	
				case "place":
					$out .= $this->frmPlace($this->FrmConf,$i,'');
					break;                                    
 				case "village":
					$out .= $this-> FrmVillage   ($this->FrmConf,$i,'');
					break;  
			}
			$out .="</div>\n";
			$this->Js .= $this->fieldJS($this->FrmConf,$i);
		}
		$out .= $this->frmAudit($this->FrmConf,$i);
		$out .= $this->buildButtons($this->FrmConf);
		$out .= "</form>\n";
        $out .= "</div>\n";
		$out .= $this->buildJS($this->FrmConf,$i);
        $out .= $this->jqOnEnter();
		return $out;
	}
	private function checkBlockField(){
		if ($this->isBlocked) {
			return " readonly=true disabled ";
		}
	
	}
	private function frmId(){
		$id = "";
		$id .= "<div id ='fieldCont' class='fieldCont' style='visibility:hidden;'>\n";
		$id .= "<div class='caption'>&nbsp; </div>\n";
		$id .= "<input  name='_'  id='_'  type='text' class='input' disabled readonly value='".$this->isOpen."' style='background:#e0edff;' \n>";
		$id .= "</div>\n";	
		return $id;
	}
	private function frmSelect($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
	    $out .= "<select class='input'  id='".$frm["FLD"][$i]["Id"]."' pos='$i'   name='".$frm["FLD"][$i]["Id"]."' ".$this->checkBlockField()." >\n";
	    $out .= "<option value=''></option>";
	    for ($j = 0; $j < count($frm["FLD"][$i]["Value"] ); ++$j){
			if ($this->FrmObj) {
				if ($this->FrmObj->getValue($frm["FLD"][$i]["Id"]) == $frm["FLD"][$i]["Value"][$j] ) { 
					$out .="<option selected value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
				}
				else {
					if ($frm["FLD"][$i]["Value"][$j] == $frm["FLD"][$i]["Default"]){
					$out .="<option value='".$frm["FLD"][$i]["Value"][$j]."' selected>".$frm["FLD"][$i]["Value"][$j]."</option>";
					}
					else {
						$out .="<option value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
					}
				}
			}
			else {
					$out .="<option value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
			}
			
		}
		
		$out .= "</select>\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmOutCome($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
	    $out .= "<select class='input'  id='".$frm["FLD"][$i]["Id"]."' pos='$i'   name='".$frm["FLD"][$i]["Id"]."' ".$this->checkBlockField()." >\n";
	    $out .= "<option value=''></option>";
	    for ($j = 0; $j < count($frm["FLD"][$i]["Value"] ); ++$j){
			if ($this->FrmObj) {
				if ($this->FrmObj->getValue($frm["FLD"][$i]["Id"]) == $frm["FLD"][$i]["Value"][$j] ) { 
					$out .="<option selected value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
				}
				else {
					if ($frm["FLD"][$i]["Value"][$j] == $frm["FLD"][$i]["Default"]){
					$out .="<option value='".$frm["FLD"][$i]["Value"][$j]."' selected>".$frm["FLD"][$i]["Value"][$j]."</option>";
					}
					else {
						$out .="<option value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
					}
				}
			}
			else {
                            $out .="<option value='".$frm["FLD"][$i]["Value"][$j]."'>".$frm["FLD"][$i]["Value"][$j] ."</option>";
			}
			
		}
		
		$out .= "</select>\n";
 
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
                
                $out .= "<script>\n";
                $out .= "  $('#DeathDate').hide(); \n";
                $out .= " $('#".$frm["FLD"][$i]["Id"]."').change(function(){ \n";
                    $out .= " if ($(this).val() == 'Died') { \n;";
                        $out .= "  $('#fcDeathDate').show(); \n";
                    $out .= " }\n";
                    $out .= " else {\n";
                        $out .= "  $('#fcDeathDate').hide(); \n";
                    $out .= " }\n";
                $out .= " });\n";

                $out .= "</script>\n";
                
		return $out;
	}
	private function frmDeathDate($frm,$i){
		$out = "";
		$out .= "<b style='color:red'>".$this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"])."</b>";
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$this->JqDte .="$('#".$frm["FLD"][$i]["Id"]."').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-1:c+1',dateFormat: 'yy-mm-dd',maxDate: '+0D'});\n";
                if (!$this->FrmObj->getValue($frm["FLD"][$i]["Id"])){
                    $this->JqDte .="$('#fcDeathDate').hide(); \n";
                }
                
		return $out;
	}        
	private function frmBool($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .= "<select class='input' style='width:75px;'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'   name='".$frm["FLD"][$i]["Id"]."'   ".$this->checkBlockField()."  >\n";
		$out .= "<option value=''></option>";
		if ($this->FrmObj) {
			if ($this->FrmObj->getValue($frm["FLD"][$i]["Id"]) == "1" ) { 
				$out .= "<option selected  value='1'>Yes</option>";
				$out .= "<option   value='0'>No</option>";
			}
			else {
				$out .= "<option value='1'>Yes</option>";
				$out .= "<option  selected   value='0'>No</option>";                                           
			}
		}
		else {
                        if ($frm["FLD"][$i]["Value"] == 'No'){
                            $out .= "<option   value='1'>Yes</option>";
                            $out .= "<option  selected value='0'>No</option>";
                        }
                        else if ($frm["FLD"][$i]["Value"] == 'Yes'){
                            $out .= "<option selected  value='1'>Yes</option>";
                            $out .= "<option  value='0'>No</option>";
                        }
                        else{
                            if ($frm["FLD"][$i]["Id"] == "Active" || $frm["FLD"][$i]["Id"] =="Alert" || $frm["FLD"][$i]["Id"] =="Voice"){
                            $out .= "<option selected  value='1'>Yes</option>";
                            $out .= "<option  value='0'>No</option>";
                            }
							else if ($frm["FLD"][$i]["Id"] == "UNR" || $frm["FLD"][$i]["Id"] =="Pain"){
                            $out .= "<option selected  value='0'>No</option>";
                            $out .= "<option  value='1'>Yes</option>";
                            }
                            else{
                                $out .= "<option   value='1'>Yes</option>";
                                $out .= "<option  value='0'>No</option>";
                            }
                        }
                        
		}
		$out .= "</select>\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmTextArea($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<textarea   name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  class='input' style='width:450;'   ".$this->checkBlockField()."  ".$frm["FLD"][$i]["Ops"]." >\n";
		if ($this->FrmObj) {
			$out .="".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .="".$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
		private function frmTextAr($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		//$pid=9;
		//$date=date("Y-m-d h:i:s");
		
		//$res = $pid . "_" . $date;
		
		if ($this->FrmObj) {
					$out .="

<div class='tools'>
  <a href='#tools_sketch' data-tool='marker'>Marker</a>
  <a href='#tools_sketch' data-tool='eraser'>Eraser</a>
  
  
</div>
<canvas id='tools_sketch' width='300' height='300' style='background:no-repeat center center;border:black 1px solid'></canvas>
<script type='text/javascript'>

 var sigCanvas = document.getElementById('tools_sketch');
   var context = sigCanvas.getContext('2d');      
		 
var imageObj = new Image();
imageObj.src = '".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."';

imageObj.onload = function() {
  context.drawImage(this, 0, 0,sigCanvas.width,sigCanvas.width);
};

  $(function() {
    $('#tools_sketch').sketch({defaultColor: '#FF0000'});
  });

</script>";
			
					}
		
		//".$frm["FLD"][$i]["Id"]."background-image:url(images/human-face.jpg);
		else{
		$out .="

<div class='tools'>
  <a href='#tools_sketch' data-tool='marker'>Marker</a>
  <a href='#tools_sketch' data-tool='eraser'>Eraser</a>
  
  
</div>
<canvas id='tools_sketch' width='300' height='300' style='background:no-repeat center center;border:black 1px solid'></canvas>
<script type='text/javascript'>

 var sigCanvas = document.getElementById('tools_sketch');
   var context = sigCanvas.getContext('2d');      
		 
var imageObj = new Image();
imageObj.src = 'images/human_body.jpg';

imageObj.onload = function() {
  context.drawImage(this, 0, 0,sigCanvas.width,sigCanvas.width);
};

  $(function() {
    $('#tools_sketch').sketch({defaultColor: '#FF0000'});
  });

</script>";
		
		// $out .="<textarea   name='".$frm["FLD"][$i]["Id"]."'  id='colors_sketch'  pos='$i'  class='input' style='width:250;height:250;background-image:url(images/human-face.jpg); '   ".$this->checkBlockField()."  ".$frm["FLD"][$i]["Ops"]." >\n";
		// if ($this->FrmObj) {
			// $out .="".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		// }
		// else {
			// $out .="".$frm["FLD"][$i]["Value"]."</textarea>\n";
		// }
}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmRemarks($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<textarea   name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  class='input' style='width:450;height:70' onKeyUp='getCannedText(this)'    >\n";
		if ($this->FrmObj) {
			$out .="".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .="".$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmCheckBox($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input   name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='checkbox'  \n";
		if ($this->FrmObj) {
			$out .="checked=".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."/> \n";
		}
		else {
			$out .="checked=".$frm["FLD"][$i]["Value"]." />\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmTimeStamp($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."' pos='$i'   type='text' class='input' disabled=true     ".$this->checkBlockField()."   \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else{
			$out .=" value='".date("Y-m-d H:i:s")."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmDateTime($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."' pos='$i'   type='text' class='input' readonly    ".$this->checkBlockField()."   \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else{
			$out .=" value='".date("Y-m-d H:i:s")."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$this->JqDte .="$('#".$frm["FLD"][$i]["Id"]."').datetimepicker({changeMonth: true,changeYear: true,yearRange: 'c-100:c+100',dateFormat: 'yyyy-mm-dd HH:MM:ss ',maxDate: '+0D'});\n";
		return $out;
	}	
	private function frmVillageLookUp($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input' readonly onclick=openSearch('".$frm["FLD"][$i]["Ops"]."','".$frm["FLD"][$i]["Id"]."')  onkeypress=openSearch('".$frm["FLD"][$i]["Ops"]."','".$frm["FLD"][$i]["Id"]."')    ".$this->checkBlockField()."  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}

	private function frmDate($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$this->JqDte .="$('#".$frm["FLD"][$i]["Id"]."').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});\n";
		return $out;
	}

	private function frmNumber($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."' pos='$i'   type='number' class='input' ".$frm["FLD"][$i]["Ops"]."   ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value=''/>\n";
		}
		if ($frm["FLD"][$i]["Value"]!="") {
			$out .="<img src='images/thumbup.png' title='click to enter normal value' valign=bottom style='cursor:pointer;' onclick=getNormal('".$frm["FLD"][$i]["Id"]."','".$frm["FLD"][$i]["Value"]."') >\n";
		
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	/*private function frmNIC($frm,$i){
		$out = "";
		$data ="data:({";
		$data.= $frm["FLD"][$i]["Id"].":$('#".$frm["FLD"][$i]["Id"]."').val(),";   
		$data .="})";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."' placeholder='NNNNNNNNN[vVxX]'  pos='$i'  id='".$frm["FLD"][$i]["Id"]."'  type='text' class='input'    ".$this->checkBlockField()."  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		//$out .="<img src='images/search.png' title='Search for this NIC' valign=bottom style='cursor:pointer;' onclick=checkBeforeSave({".$data."}); >\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	*/
	
	private function frmNIC($frm,$i){
		$out = "";
		$data ="data:({";
		$data.= $frm["FLD"][$i]["Id"].":$('#".$frm["FLD"][$i]["Id"]."').val(),";   
		$data .="})";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."' pos='$i'  id='".$frm["FLD"][$i]["Id"]."'  type='text' class='input'    ".$this->checkBlockField()."  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		//$out .="<img src='images/search.png' title='Search for this NIC' valign=bottom style='cursor:pointer;' onclick=checkBeforeSave({".$data."}); >\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmOutLable($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()." disabled \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}

	private function frmPatientName($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()."  ";
                if ($frm["FLD"][$i]["Style"]!=""){
                    $out .=" style='".$frm["FLD"][$i]["Style"]."'";
                }
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."' ";
                        if ($_SESSION["UserGroup"] !="Programmer") $out .=" disabled ";
                        $out .=" />\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
                $out .="\n<script language='javascript'>";
                      $out .="\n $( document).ready(function() {
                            $('#".$frm["FLD"][$i]["Id"]."').keyup(function(){
                               ajaxLookUp($(this)) ;    
                            })
                          })\n";
                $out .="</script>\n";
		return $out;
	}        
	private function frmText($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()."  ";
                if ($frm["FLD"][$i]["Style"]!=""){
                    $out .=" style='".$frm["FLD"][$i]["Style"]."'";
                }
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmTextVisit($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' disabled readonly class='input'    ".$this->checkBlockField()."  ";
                if ($frm["FLD"][$i]["Style"]!=""){
                    $out .=" style='".$frm["FLD"][$i]["Style"]."'";
                }
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmFile($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='file'    ".$this->checkBlockField()."  ";
                if ($frm["FLD"][$i]["Style"]!=""){
                    $out .=" style='".$frm["FLD"][$i]["Style"]."'";
                }
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmLabel($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    readonly style='font-weight:bold;'  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmStaff($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='hidden' class='input'    readonly style='font-weight:bold;'  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$_SESSION["UID"]."' />\n";
		}
		include_once"MDSStaff.php";
		$staff = new MDSStaff();
		$staff->openId($_SESSION["UID"]);
		
		$out .="<input id='_' name='_'  pos='$i'  type='text' class='input'    readonly  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$staff->getFullName()."'>\n";
		}		
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmLicense($frm,$i){
            include_once 'MDSLicense.php';
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<textarea   name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  class='input' style='width:450;height:130;'   ".$this->checkBlockField()."  ".$frm["FLD"][$i]["Ops"]." readonly >\n";
                $out .= getLICInfo();
		$out .="</textarea>\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}        
	private function frmStock($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    readonly style='font-weight:bold;'  \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
                $out .="<input type='number' id='inpStock".$frm["FLD"][$i]["Ops"]."' step=50 min=50 max=5000 class='' value='1000'> \n";
                $out .="<input type='button' id='btnStock".$frm["FLD"][$i]["Ops"]."' class='formButton' value='Add'>\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
                $out .="<script language='javascript'>\n";
                $out .="$(document).ready(function() {\n";
                    $out .=" $('#btnStock".$frm["FLD"][$i]["Ops"]."').click(function(){ \n";
                    $out .=" var stk = $('#inpStock".$frm["FLD"][$i]["Ops"]."').val() \n";
                    $out .=" if (isNaN(stk) ) {\n" ;
                    $out .=" alert('Invalid')\n" ;
                    $out .=" } else {\n" ;
                        $out .=" var new_stk = Number($('#".$frm["FLD"][$i]["Id"]."').val())+Number(stk) \n" ;
                        $out .=" $('#".$frm["FLD"][$i]["Id"]."').val(new_stk) \n" ;
                    $out .=" }\n" ;
                    $out .="}) \n";
                 $out .=" });\n";
                $out .="</script>\n";
		return $out;
	}        
	private function frmPhone($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='text' class='input'    ".$this->checkBlockField()."  onkeyup=checkPhone(this); \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}        
 
        private function frmPlace($frm,$i,$place=''){
		$out = "";
                
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input type='text' name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."' pos='$i'    class='input' style='width:450;'    ".$this->checkBlockField()." ";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."' />\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."' />\n";
		}
               // $out .="<img src='images/search.png' title='Search for complaint' valign=top style='cursor:pointer;' onclick=lookUpComplaints('".$frm["FLD"][$i]["Id"]."','');  ".$this->checkBlockField()." >\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$out .="<div id='placeDiv' title='Place lookup'></div>\n";
                $out .="<script language='javascript'>\n";
                 $out .="$(document).ready(function() {\n";
                    $out .="$('#".$frm["FLD"][$i]["Id"]."').autocomplete({\n";
                        //$out .="    select: function(event, ui) { alert(1) }, \n";
                    $out .="    minLength: 3,\n";
                            $out .= $this->getPlace($frm,$i)."\n";
                                 $out .="});\n";
                 $out .=" });\n";
                $out .="</script>\n";
		return $out;
	}        
        private function FrmVillage($frm,$i){
		$out = "";
                
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input type='text' name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."' pos='$i'    class='input' style='width:450;'    ".$this->checkBlockField()." ";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."' />\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."' />\n";
		}
                //$out .="<img src='images/search.png' title='Search for village' valign=top style='cursor:pointer;' onclick=openSearch('".$frm["FLD"][$i]["Ops"]."','".$frm["FLD"][$i]["Id"]."')  ".$this->checkBlockField()." >\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$out .="<div id='placeDiv' title='Place lookup'></div>\n";
                $out .="<script language='javascript'>
                    var data = ".  $this->getVillage()." \n";
                 $out .="$(document).ready(function() {\n";
                            $out .="$('#".$frm["FLD"][$i]["Id"]."').blur( function(){ checkVillage(); } ).keypress(function(){
                                if (String($(this).val()).length >1) {
                                    $(this).autocomplete({";
                                            $out .=" minLength: 2, max:100, \n";
                                            $out .= "source:data, \n";
                                            $out .= "focus: function( event, ui ) {
                                                        $('#".$frm["FLD"][$i]["Id"]."').val( ui.item.value );
                                                        $('#Address_DSDivision').val(ui.item.dsd)    
                                                        $('#Address_District').val(ui.item.dss)    
                                                        return false;
                                                }, \n";
                                            $out .= "select: function( event, ui ) {
                                                        $('#".$frm["FLD"][$i]["Id"]."').val( ui.item.value );
                                                        $('#Address_DSDivision').val(ui.item.dsd)    
                                                        $('#Address_District').val(ui.item.dss)    
                                                        return false;
                                                }, \n";

                                         $out .=" }).data('autocomplete' )._renderItem = function( ul, item ) {
                                                        return $( '<li></li>' )
                                                        .data( 'item.autocomplete', item )
                                                        .append( '<a><b>' + item.value + '</b>, &nbsp;' + item.dsd + ' , &nbsp; ' +item.dss + ' </a>' )
                                                        .appendTo( ul );
                                        };
                                }
                            })\n";
                 $out .=" })\n";
               $out .="
                   function checkVillage(){
                        var ok = false;
                        for (var x =0 ; x < data.length; x++){
                            if (data[x].value == $( '#".$frm["FLD"][$i]["Id"]."').val() ){
                                ok = true;
                                break;
                            }
                        }
                        if (!ok) {
							
						var r=confirm('village not found. Do You Like to ADD VILLAGE ?');
if (r==true)
  {
 window.location='home.php?page=preferences&mod=VillageNew';
  }
else
  {
  
  }
                 							
                            $( '#".$frm["FLD"][$i]["Id"]."').val('').focus();
                            $('#Address_DSDivision').val();
                            $('#Address_District').val();  
                        }
                   }
                   </script>\n";
		return $out;
	}        
        private function getVillage(){
           $place = $frm["FLD"][$i]["Place"];
           $mdsDB = MDSDataBase::GetInstance();
           $mdsDB->connect();		
           
           $rep = array("'",  "&");
           $with   = array("\'", "and");
           
           $sql = " SELECT  District, DSDivision,GNDivision 
                FROM village WHERE Active = TRUE 
                ORDER BY GNDivision ";
           
            $result=$mdsDB->mysqlQuery($sql); 		
            if (!$result) {  
                return "[{}],";
             }
            $out = " [ ";
            while($row = $mdsDB->mysqlFetchArray($result))  {
                $out .= "{value:\"".str_replace($rep, $with, $row["GNDivision"])."\", \n ";
                 $out .= "dsd:\"".str_replace($rep, $with, $row["DSDivision"])."\", \n ";
                 $out .= "dss:\"".str_replace($rep, $with, $row["District"])."\"}, \n ";
            }
            $out .="{value:\"\",dsd:\"\",dss:\"\"}]";
          
            return $out;
        }              
        private function frmComplaint($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<textarea  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."' pos='$i'   rows =4 class='input' style='width:450;height:40'    ".$this->checkBlockField()." >";
		if ($this->FrmObj) {
			$out .=$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .=$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
                $out .="<img src='images/search.png' title='Search for complaint' valign=top style='cursor:pointer;' onclick=lookUpComplaints('".$frm["FLD"][$i]["Id"]."','');  ".$this->checkBlockField()." >\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$out .="<div id='complaintDiv' title='Complaints lookup'></div>\n";
                $out .="<script language='javascript'>
                function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}
                    \n";
                $out .=" var data = ".  $this->getComplaints()." \n";
                 $out .="$(document).ready(function() {\n";
                    $out .="$('#".$frm["FLD"][$i]["Id"]."').bind( 'keydown', function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( 'autocomplete' ).menu.active ) {
					event.preventDefault();
				}
			}).autocomplete({\n";
                    $out .="    minLength: 2,
                        focus: function() {return false;},
                        select: function( event, ui ) {
                            var terms = split( this.value );
					terms.pop();
					terms.push( ui.item.value );
					terms.push( '' );
					this.value = terms.join( ',' );
					return false;
                        },
                        \n";
                            $out .="source:function( request, response ) {
						response( $.ui.autocomplete.filter(
						data, extractLast( request.term ) ) );
				}";
                     $out .="});\n";
                 $out .=" });\n";
                $out .="</script>\n";
		return $out;
	}
	
	private function frmPassword($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input AUTOCOMPLETE='OFF'  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  type='password' class='input'   ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='' readonly onmousedown=changePassword('".$_GET["UID"]."') placeholder='****************************************' />\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmPassword1($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  AUTOCOMPLETE='OFF' name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."' pos='$i'   type='password' class='input'   ".$this->checkBlockField()." readonly onmousedown=changePassword('".$_GET["UID"]."') \n";
		if ($this->FrmObj) {
			$out .="value='********************************'/>\n";
		}
		else {
			$out .="value=''/>\n";
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmHidden($frm,$i){
		$out = "";
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."'   type='hidden'    ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$frm["FLD"][$i]["Value"]."'/>\n";
		}
		return $out;
	}
	
	private function frmICD($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
	   $out .="<textarea  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  rows =2  class='input' style='width:450px;' readonly onfocus=onclick=lookUpICD('".$frm["FLD"][$i]["Id"]."','','".$frm["FLD"][$i]["Id"]."',$('#SNOMEDmap').val());  ".$this->checkBlockField()." >";
		if ($this->FrmObj) {
			$out .=$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .=$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .=$this->clearbutton($frm,$i);	
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);t;
		$out .="<div id='icdDiv' title='ICD lookup'></div>\n";
		return $out;
	}	
	private function frmIMMR($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
	   $out .="<textarea  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  pos='$i'  rows =2  class='input' style='width:450px;' readonly  ".$this->checkBlockField()."  >";
		if ($this->FrmObj) {
			$out .=$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .=$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .=$this->clearbutton($frm,$i);
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);t;
		$out .="<div id='immrDiv' title='IMMR lookup'></div>\n";
		return $out;
	}	
	private function frmSnomed($frm,$i,$type){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
	   $out .="<input type='hidden' id='SNOMEDmap' value=''><textarea  name='".$frm["FLD"][$i]["Id"]."'  pos='$i'   id='".$frm["FLD"][$i]["Id"]."'  rows =2  class='input' style='width:450px;' readonly onfocus=onclick=lookUpSNOMED('".$frm["FLD"][$i]["Id"]."','".$type."',$('#Complaint').val());  ".$this->checkBlockField()." >";
		if ($this->FrmObj) {
			$out .=$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .=$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .=$this->clearbutton($frm,$i);
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);t;
		$out .="<div id='snomedDiv' title='SNOMED lookup'></div>\n";
		return $out;
	}	
	private function frmSnomedSelect($frm,$i,$type){
                $out = "";
 
                
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
                $out .= "<select size='4' id='snomed_select'  pos='$i'  onchange=lookUpSNOMED('".$frm["FLD"][$i]["Id"]."',$('#snomed_select').val(),$('#Complaint').val());>
                    <option value='disorderForm'>Disorder</option> 
                    <option value='eventForm'>Event</option> 
                    <option value='findingForm'>Finding</option> 
                    <option  value='proceduresForm'>Procedure</option> 
                    </select>";
                $out .="<input type='hidden' id='SNOMEDmap' value=''><textarea  name='".$frm["FLD"][$i]["Id"]."'   id='".$frm["FLD"][$i]["Id"]."'  rows =3  class='input' style='width:450px;' readonly onclick=lookUpSNOMED('".$frm["FLD"][$i]["Id"]."',$('#snomed_select').val(),$('#Complaint').val());  ".$this->checkBlockField()." >";
		if ($this->FrmObj) {
			$out .=$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."</textarea>\n";
		}
		else {
			$out .=$frm["FLD"][$i]["Value"]."</textarea>\n";
		}
		$out .=$this->clearbutton($frm,$i);
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		$out .="<div id='snomedDiv' title='SNOMED lookup '+$('#snomed_select').val()+''></div>\n";
		return $out;
	}
	
	private function frmSelectDrug($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getDrugList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getDrugList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
        
	private function frmDosage($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getDosageList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getDosageList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}        
 	private function frmFrequency($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getFrequencyList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getFrequencyList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
        }	       
        
	private function frmDoctor($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getDoctorList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getDoctorList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmWard($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getWardList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getWardList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmPost($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getPostList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getPostList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmSpeciality($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getSpecialityList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getSpecialityList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmOPDTreatment($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getTreatmentList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]),'OPD',$frm["FLD"][$i]["Ops"]);
		}	
		else {
			$out .=$this->getTreatmentList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"],'OPD',$frm["FLD"][$i]["Ops"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}		
	private function frmBHT($frm,$i){
		include_once "MDSHospital.php";
		$out = $bht = "";
		$hospital = new MDSHospital();
		$hospital->openDefaultHospital();
		$bht =$hospital->getCurrentBHT();

		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		$out .="<input  name='".$frm["FLD"][$i]["Id"]."'  id='".$frm["FLD"][$i]["Id"]."' pos='$i'   type='text' class='input'  ".$this->checkBlockField()." \n";
		if ($this->FrmObj) {
			$out .="value='".$this->FrmObj->getValue($frm["FLD"][$i]["Id"])."'/>\n";
		}
		else {
			$out .="value='".$bht."'/>\n";
		}
		if (!$this->FrmObj) 
			$out .="<img src='images/refresh.png' width=20 height=20 valign=middle style='cursor:pointer' onclick=getBHT('getBHT','','".$frm["FLD"][$i]["Id"]."')>\n";
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}		
	private function frmVisitType($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getVisitTypeList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getVisitTypeList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	
		private function frmStatusType($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getPatientStatus($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getPatientStatus($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
		
		private function frmToUser($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .= $this->getUsers($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .= $this->getUsers($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	
	private function frmSelectUserGroup($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getUserGroupList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getUserGroupList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmCheckBoxUserGroup($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getUserGroupCheckBox($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getUserGroupCheckBox($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}
	private function frmPermission($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getModluePermission($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getModluePermission($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	
	private function frmSysReview($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getSysReview($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getSysReview($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	
	private function frmMedicalHistory($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=$this->getMedicalHistory($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=$this->getMedicalHistory($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	
	private function frmLabDepartment($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=getLabDepartmentList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=getLabDepartmentList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}	
	private function frmLabGroupName($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
		if ($this->FrmObj) {
			$out .=getLabGroupList($frm["FLD"][$i]["Id"],$this->FrmObj->getValue($frm["FLD"][$i]["Id"]));
		}	
		else {
			$out .=getLabGroupList($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Value"]);
		}
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}		
	private function frmAge($frm,$i){
		$out = "";
		$out .= $this->fldName($frm["FLD"][$i]["Name"],$frm["FLD"][$i]["valid"]);
                if ($this->FrmObj) {
                    include_once 'MDSPatient.php';
                    $p = new MDSPatient();
                    list ($yrs,$mths,$dys)= $p->dateDifference($this->FrmObj->getValue("DateOfBirth"),date('Y/m/d'));
                    $out .="<input  name='DOB'  id='DOB'  type='hidden' class='input'  value='".$this->FrmObj->getValue("DateOfBirth")."'/>\n";
                    $out .="<input  name='age_year'  id='age_year'  type='text'  class='input' style='width:40px'  pos='$i' value='".$yrs."' onkeyup=checkAge(this); /> &nbsp;".getPrompt("Years")."\n";
                    $out .="<input  name='age_month'  id='age_month'  type='text'  class='input' style='width:40px'  pos='$i' value='".$mths."' onkeyup=checkMonth(this); />&nbsp;".getPrompt("Months")."\n";
                    $out .="<input  name='age_day'  id='age_day'  type='text'  class='input' style='width:40px'  pos='$i' value='".$dys."' onkeyup=checkDay(this);  /> &nbsp;".getPrompt("Days")."\n";
                }
                else {
                    $out .="<input  name='DOB'  id='DOB'  type='hidden' class='input'  value=''/>\n";
                    $out .="<input  name='age_year'  id='age_year'  type='text'  class='input' style='width:40px'  pos='$i' value='' onkeyup=checkAge(this); /> &nbsp;".getPrompt("Years")."\n";
                    $out .="<input  name='age_month'  id='age_month'  type='text'  class='input' style='width:40px'  pos='$i' value='' onkeyup=checkMonth(this); />&nbsp;".getPrompt("Months")."\n";
                    $out .="<input  name='age_day'  id='age_day'  type='text'  class='input' style='width:40px'  pos='$i' value='' onkeyup=checkDay(this);  /> &nbsp;".getPrompt("Days")."\n";
                   
                }
		$out .= $this->fldHelp($frm["FLD"][$i]["Id"],$frm["FLD"][$i]["Help"]);
		return $out;
	}		
	
	private function frmAudit($frm,$i){
		$out = "";
		$out .="<div id ='fieldCont' class='fieldCont' style='color:#333333;'>\n";
		$out .="<div class='caption' >".getPrompt("Data created")." :</div>\n";
		if ($this->FrmObj) {
			$out .="<input  name='CreateDate'  id='CreateDate'  type='text' class='auditCont' disabled readonly value='".$this->FrmObj->getValue("CreateDate")."'  \n>";
		}
		else {
			$out .="<input  name='CreateDate'  id='CreateDate'  type='text' class='auditCont'disabled readonly value='".date("Y-m-d H:i:s")."'   \n>";
		}
		$out .="&nbsp;";
		if ($this->FrmObj) {
			$out .="<input  name='CreateUser'  id='CreateUser'  type='text' class='auditCont'disabled readonly value='".$this->FrmObj->getValue("CreateUser")."'  \n>";
		}
		else {
			$out .="<input  name='CreateUser'  id='CreateUser'  type='text' class='auditCont' disabled readonly value='".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]."'  \n>";
		}
		$out .="</div>";

		$out .="<div id ='fieldCont' class='fieldCont' style='color:#333333;'>\n";
		if ($this->FrmObj) {
			$out .="<div class='caption' >".getPrompt("Data accessed")." :</div>\n";
			$out .="<input  name='_'  id='_'  type='text'  disabled readonly value='".$this->FrmObj->getValue("LastUpDate")."'  class='auditCont' \n>";
		}
		$out .="<input  name='LastUpDate'  id='LastUpDate'  type='hidden' class='auditCont' disabled readonly value='".date("Y-m-d H:i:s")."' class='formCont' \n>";

		
		if ($this->FrmObj) {
			$out .="&nbsp;";
			$out .="<input  name='_'  id='_'  type='text' class='auditCont' disabled readonly value='".$this->FrmObj->getValue("LastUpDateUser")."'  \n>";
		}
		$out .="<input  name='LastUpDateUser'  id='LastUpDateUser'  type='hidden' class='auditCont'disabled readonly value='".$_SESSION["FirstName"]." ".$_SESSION["OtherName"]."' \n>";
		$out .="</div>";	
		return $out;
	}
	
	private function fldName($name,$valid){
                $out = "";
                $out .= "<div class='caption'>";
                if (strstr( $valid, "*"))  $out .= "*";
                $out .= getPrompt($name)."</div>\n";
		return $out;
	}
	private function fldHelp($id,$help){
		return "<lable id='h".$id."' class='fieldHelp'>".$help."</lable>\n";
	}
	
	private function frmLine(){
		
		return "<br>\n";
                //return "<div class='caption' style='width:70%;border-top:1px solid #637aae;height:1px;align:right;'></div>";
	}
	private function frmHeading(){
		
		return "<center><h3>Systemic Review</h3></center>\n";
                //return "<div class='caption' style='width:70%;border-top:1px solid #637aae;height:1px;align:right;'></div>";
	}
	private function frmHeading1(){
		
		return "<center><h3>Past Medical History</h3></center>\n";
                //return "<div class='caption' style='width:70%;border-top:1px solid #637aae;height:1px;align:right;'></div>";
	}
	private function frmSection($frm,$i){
                return "<div class='caption' style='width:100%;border-bottom:2px dashed #637aae;height:15px;text-align:left;color: #637aae;'><b>".$frm["FLD"][$i]["Value"]."</b></div><br><br>";
	}        
	private function fieldJS($frm,$i){
		$jq = "";
		$jq .="$('#".$frm["FLD"][$i]["Id"]."').focus( ";
		$jq .="function(){ \n";
		$jq .=" $('#h".$frm["FLD"][$i]["Id"]."').css({'visibility':'visible'});\n";
		$jq .="});\n";
		$jq .="$('#".$frm["FLD"][$i]["Id"]."').blur( ";
		$jq .="function(){ \n";
		$jq .=" $('.fieldHelp').css({'visibility':'hidden'});\n";
		$jq .="});\n";            
		//$jq .="$('#complaintDiv').dialog({autoOpen:false,height: 400,height: 500, position:'right'});\n";							   
		if ($frm["FLD"][$i]["Type"] == "age" ) {	
			$jq .="$('#age_year').focus( ";
			$jq .="function(){ \n";
			$jq .=" $('#h".$frm["FLD"][$i]["Id"]."').css({'visibility':'visible'});\n";
			$jq .="}).blur(function(){ $('.fieldHelp').css({'visibility':'hidden'}); });\n";								
			$jq .="$('#age_month').focus( ";
			$jq .="function(){ \n";
			$jq .=" $('#h".$frm["FLD"][$i]["Id"]."').css({'visibility':'visible'});\n";
			$jq .="}).blur(function(){ $('.fieldHelp').css({'visibility':'hidden'})});\n";	
			$jq .="$('#age_day').focus( ";
			$jq .="function(){ \n";
			$jq .=" $('#h".$frm["FLD"][$i]["Id"]."').css({'visibility':'visible'});\n";
			$jq .="}).blur(function(){ $('.fieldHelp').css({'visibility':'hidden'})});\n";	
		}
		return $jq;	
	}
	private function buildJS($frm,$i){
		$jq = "";
		$jq .="<script language='javascript'>\n";
		$jq .="$('.fieldHelp').css({'visibility':'hidden'});\n";
                $jq .="$('#MDSError').hide();\n";
		$jq .= "\n".$this->Js."\n";
		if ($this->JqDte) {
                     $jq .= $this->JqDte ;
                 }
		$jq .="\n function getNormal(obj,val) {\n";
		$jq .="\n $('#'+obj).val(val); \n";
		$jq .="\n }\n";
		$jq .="\n function saveData(ops,redir) { \n";

			$jq .=" var ok = ''; \n";
			$data =  "data:({";
			for ($i = 0; $i < count($frm["FLD"]); ++$i) 
			{ 
				if (strstr($frm["FLD"][$i]["valid"],"*") !="" ) {
					$jq .="   if ($('#".$frm["FLD"][$i]["Id"]."').val() =='') { $('#fc".$frm["FLD"][$i]["Id"]."').addClass('fieldContError'); ok +='".$frm["FLD"][$i]["Name"].",' ; } else { $('#fc".$frm["FLD"][$i]["Id"]."').removeClass('fieldContError'); }\n";
				
				}
				//$jq .=" if (!ok) return; \n";
				if ($frm["FLD"][$i]["Id"] == "Age")  {
					$jq .=" var dob = $('#DateOfBirth').val();  \n";
					$jq .=" $('#age_year').click( function(){ $('#DateOfBirth').val('');} ); \n";
					$jq .=" $('#age_month').click( function(){ $('#DateOfBirth').val('');} ); \n";
					$jq .=" $('#age_day').click( function(){ $('#DateOfBirth').val('');} ); \n";
					$jq .=" if (dob === '') { \n";
					$jq .=" var ymd = validate1($('#age_year').val(),$('#age_month').val(),$('#age_day').val(),'na');\n";
						$jq .=" if ( ymd == -1) { $('#fc".$frm["FLD"][$i]["Id"]."').addClass('fieldContError'); ok += 'Date of birth';} \n" ;
						$jq .=" else { $('#fc".$frm["FLD"][$i]["Id"]."').removeClass('fieldContError'); $('#DateOfBirth').val(ymd); }\n";
					$jq .="  } \n";
					$jq .=" if (dob !== '') {  \n";
					$jq .=" 	$('#age_year').val(''); $('#fc".$frm["FLD"][$i]["Id"]."').removeClass('fieldContError');  \n";
					$jq .=" }  \n";
				
				}
				//if ($frm["FLD"][$i]["type"] =="number" ){
					//$jq .=" if ( $('#".$frm["FLD"][$i]["Id"]."').val() == 0) { $('#".$frm["FLD"][$i]["Id"]."').val(''); } \n" ;
				//}
				if (strstr($frm["FLD"][$i]["valid"],"nic") != "" ){
					$jq .="  if ($('#".$frm["FLD"][$i]["Id"]."').val() !='') {\n";
						$jq .=" if ( !checkNIC($('#".$frm["FLD"][$i]["Id"]."').val()) ) { $('#fc".$frm["FLD"][$i]["Id"]."').addClass('fieldContError');ok += 'NIC,'; } \n" ;
						$jq .=" else{ $('#fc".$frm["FLD"][$i]["Id"]."').removeClass('fieldContError');  } \n" ;
					$jq .="} \n";
				}

				if ($frm["FLD"][$i]["Id"]!="_") {
					 $data.= $frm["FLD"][$i]["Id"].":$('#".$frm["FLD"][$i]["Id"]."').val(),";   
				}

			}
                        $jq .="  if (ok!='') { $('#MDSError').show().html('Missing fields: '+ok); return;};\n";
			$data .= 'FORM:'.'"'.$this->FrmName.'" ';
			if ($this->FrmObj) {
				$data .= ', '.$this->FrmConf["OBJID"].':"'.$this->isOpen.'" ';
			}
			$data .=  "}),";
			
			if ($this->FrmConf["SAVE"] == "patient_save.php") {
				if ($_GET["action"] != "Edit") {
					$jq .="\n if(ops !='New') { \n";
						$jq .="\n var presult = checkBeforeSave({".$data."}); \n";
						$jq .="\n  if (presult) return; \n";
					$jq .="\n } \n";	
				}
			}
			if($frm["TABLE"]=="messages"){$jq .=" $('#SaveBtn').attr('disabled','true').val('Sending..'); \n";}
			else{
			$jq .=" $('#SaveBtn').attr('disabled','true').val('Saving..'); \n";
			}
			$jq .=" var resM=$.ajax({ \n";
                                if ($this->FrmConf["SAVE"] != "") {
                                        $jq .="url: 'include/".$this->FrmConf["SAVE"]."?',\n";
                                }
                                else {
                                     $jq .="url: 'include/data_save.php?',\n";
									
                                }

                                   $jq .="global: false,\n";
                                   $jq .="type: 'POST',\n";
                                   $jq .=$data."\n";
                                   $jq .="async:false\n";
                                $jq .="}).responseText;\n";
                                if ($this->FrmConf["SAVE"] == "patient_save.php") {
                                    $jq .=" $('#fRes').remove(); \n"; 
                                    $jq .="\n $('<div id=\'fRes\' title=\'Alert\'></div>').appendTo('body').html(resM); \n";
                                    $jq .=" $('#fRes').dialog({ \n";
                                    $jq .=" width:400, \n"; 
                                    $jq .=" height:130, \n"; 
                                    $jq .=" autoOpen:true, \n"; 
                                    $jq .=" modal: true, \n"; 
                                    $jq .=" resizable:false,  \n";
                                    $jq .=" position:'center' \n";
                                    $jq .=" }); \n";
                                    $jq .=" $('#SaveBtn').removeAttr('disabled').val('Save'); \n";
                                }
                                else {
                                    $jq .=" eval(resM);  \n";
                                    $jq .=" if (!Error) { \n";
                                                $jq .=" if (redir) {  \n";
                                                        $jq .=" self.document.location=''+redir+res+'' ; return ;\n";
                                                $jq .=" } else {\n";
                                                        if ($_GET["RETURN"]) {
                                                                $jq .=" self.document.location='".$_GET["RETURN"]."' ; \n";
                                                        }
                                                else {
													          if($frm["TABLE"]=="messages"){ $jq .=" self.document.location='".$frm["NEXT"]."'; \n";}
															  else{
															  $jq .=" self.document.location='".$frm["NEXT"]."'+res+'' ; \n";
															  }
													
                                                        }
                                                $jq .="} 
                                            \n} else { 
											$('#MDSError').show().html(res); 
											$('#SaveBtn').removeAttr('disabled').val('Save');
											}\n";
                                    $jq .="  \n";
                                }
                                
                                
		$jq .="}\n"; //rnd of function saveData		
		$jq .=" function updateUG(cb) {\n";
			$jq .=" var ug = '';\n";
			$jq .=" $('input:checked').each(function (i) { \n";
				$jq .=" ug += $(this).val()+',' ;\n";
			$jq .=" })\n";
			$jq .=" $('#UserGroup').val(ug);\n";
		$jq .=" }\n";
		
		$jq .="</script>\n";
                if ($this->FrmConf["JS"] != ""){
                    $jq .= $this->FrmConf["JS"];
                }
		return $jq;	
	}
        private function jqOnEnter(){
            $jq = <<<'EOT'
             <script language='javascript'>
            jQuery(function($){
                $(".input").keyup(function (e) {
                    if (( e.which == 13 )){
                       //$(this).next().text('ss'); 
                       //$(".input[pos='"+(parseInt($(this).attr('pos'))+1)+"']").first().focus();
                    }
                })
            })
            </script>
EOT;
            return $jq;
        }
	private function buildButtons($frm){
		$out ="";
		$out .="<div id ='fieldCont' class='fieldCont'>\n";
		//if ($this->isBlocked) {
			//$out .="<div class='caption'>&nbsp;</div>\n";
			//$out .="<input   name='Ok'  id='Ok'  type='button' value='Ok' onclick=window.history.back(1);>";	
		//}
		//else {
		$out .="<div class='caption'>&nbsp;</div><div>\n";
                        $out .="<table ><tr><td>";
			for ($k = 0; $k< count($frm["BTN"]); ++$k) {
				$out .="<input class='formButton'  name='".$frm["BTN"][$k]["Id"]."'  id='".$frm["BTN"][$k]["Id"] ."'  type='".$frm["BTN"][$k]["Type"] ."' value='".$frm["BTN"][$k]["Value"]."'  ";
					if ($frm["BTN"][$k]["onclick"] !="") { 
							$out.=" onclick='".$frm["BTN"][$k]["onclick"] ."'";
					}
			   $out.=">";
                           if ($frm["BTN"][$k]["Next"] =='NL'){
                               $out.="</td></tr><tr><td>";
                           }
			}
			$out .= $this->loadPluginButtons();
                        $out .="</td></tr></table>";
		//}	
		$out .="</div></div>";
		return $out;
	}
	private function loadPluginButtons(){
		if (file_exists("plugins/plugins_conf.php")){
			try{
				include_once "plugins/plugins_conf.php";
				for ($i = 0; $i < count($plugins); ++$i){
					for ($j = 0; $j < count($p_hhims[$plugins[$i]]); ++$j){
						if ( ($p_hhims[$plugins[$i]][$j]["page"] == $_GET["page"])  && ($p_hhims[$plugins[$i]][$j]["action"] == $_GET["action"]) )
							{
								try {
									return  "<span class='formButton' style='height:30;font-size:12;padding:4px;background:#f9e3cf;border:1px solif #830101;color:#FFFFFF;'><a name='".$plugins[$i].$i."'  id='".$plugins[$i].$i."'  type='".$p_hhims[$plugins[$i]][$j]["type"]."' value='".$p_hhims[$plugins[$i]][$j]["value"]."'  target='' onclick=qbillPopup('".$p_hhims[$plugins[$i]][$j]["click"]."',600,700) href='javascript:void(0);'>".$p_hhims[$plugins[$i]][$j]["value"]."</a><img src='".$p_hhims[$plugins[$i]][$j]["img"]."' width=40 valign=middle></span>";
								}
								catch (Exception $e) {}
							}
						}
					
				}
			}
			catch (Exception $e) {
			}
		}		
	}
	
	private function getUserGroupList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Name ";
		$sql .= " FROM user_group WHERE Active = TRUE " ;
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."' >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."' >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Name"] == $value) {
				$out .="<option value='".$row["Name"]."' selected>".$row["Name"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Name"]."' >".$row["Name"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}
        private function getPlace($frm,$i){
           $place = $frm["FLD"][$i]["Place"];
           $mdsDB = MDSDataBase::GetInstance();
           $mdsDB->connect();		
           $out = "source: [ ";
           $rep = array("'",  "&");
           $with   = array("\'", "and");
           if ($place == "District" ){
           $sql = " SELECT distinct(District) as Name
                FROM village WHERE Active = TRUE 
                ORDER BY Name ";
           }
           else if($place == "DSDivision" ){
                $sql = " SELECT distinct(DSDivision) as Name FROM village WHERE (Active = TRUE ) ";
                $sql .= " ORDER BY Name ";
           }
           else if($place == "GNDivision" ){
                $sql = " SELECT distinct(GNDivision) as Name
                FROM village WHERE (Active = TRUE )
                ORDER BY Name ";
           }
           else{
               return "";
           }
            $result=$mdsDB->mysqlQuery($sql); 		
            if (!$result) {  
                return "[]";
             }
            while($row = $mdsDB->mysqlFetchArray($result))  {
                $out .= "'".str_replace($rep, $with, $row["Name"])."', ";
            }
            $out .=" '']";
              
           
            return $out;
        }        
        private function getComplaints(){
           $mdsDB = MDSDataBase::GetInstance();
           $mdsDB->connect();		
           $out = "[ ";
           $rep = array("'",  "&");
           $with   = array("\'", "and");

            $sql = " SELECT Name,isNotify 
                FROM complaints WHERE Active = TRUE 
                ORDER BY Name ";
            $result=$mdsDB->mysqlQuery($sql); 		
            if (!$result) {  
                return "[]";
             }
            while($row = $mdsDB->mysqlFetchArray($result))  {
                $out .= "'".str_replace($rep, $with, $row["Name"])."', ";
            }
            $out .=" '']";
              
           
            return $out;
        }
	private function getDrugList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT DRGID,Name ";
		$sql .= " FROM drugs WHERE  (Active = 1) " ;
		//AND (HID='".$_SESSION["HID"]."')
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Name"] == $value) {
				$out .="<option value='".$row["DRGID"]."' selected>".$row["Name"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["DRGID"]."' >".$row["Name"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	} 	
	private function getDosageList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Dosage ";
		$sql .= " FROM drugs_dosage WHERE  (Active = 1) " ;
		//AND (HID='".$_SESSION["HID"]."')
		//$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Dosage"] == $value) {
				$out .="<option value='".$row["Dosage"]."' selected>".$row["Dosage"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Dosage"]."' >".$row["Dosage"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}        

        
	private function getFrequencyList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Frequency ";
		$sql .= " FROM drugs_frequency WHERE  (Active = 1) " ;
		//AND (HID='".$_SESSION["HID"]."')
		//$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Frequency"] == $value) {
				$out .="<option value='".$row["Frequency"]."' selected>".$row["Frequency"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Frequency"]."' >".$row["Frequency"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}           
  

        private function getPostList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT  Name ";
		$sql .= " FROM user_post WHERE  (Active = TRUE) " ;
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Name"] == $value) {
				$out .="<option value='".$row["Name"]."' selected>".$row["Name"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Name"]."' >".$row["Name"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}  
        private function getSpecialityList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT  Name ";
		$sql .= " FROM user_speciality WHERE  (Active = TRUE) " ;
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Name"] == $value) {
				$out .="<option value='".$row["Name"]."' selected>".$row["Name"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Name"]."' >".$row["Name"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}  	
        
        private function getWardList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT WID, Name ";
		$sql .= " FROM ward WHERE  (Active = TRUE) " ;
		//AND (HID='".$_SESSION["HID"]."')
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input' disabled readonly id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["WID"] == $value) {
				$out .="<option value='0' selected>PCU</option>\n";
			}
			else {
					$out .="<option value='0' >PCU</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}
	private function getTreatmentList($id,$value,$type,$ops) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Treatment ";
		$sql .= " FROM treatment WHERE  (Active = TRUE) and (Type='".$type."') " ;
		//AND (HID='".$_SESSION["HID"]."')
		$sql .= " ORDER BY treatment ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." ".$ops.">\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()."  ".$ops.">\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Treatment"] == $value) {
				$out .="<option value='".$row["Treatment"]."' selected>".$row["Treatment"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Treatment"]."' >".$row["Treatment"]."</option>\n";
			}
		  }
		$out .="</select>";
                if ($ops =="")
                    $out .="<img src='images/add.png' width=15 height=15 valign=middle style='cursor:pointer;' onclick=reDirect('preferences&mod=treatmentNew&ispopup=1&RETURN='+encodeURIComponent(self.document.location)+'','')>\n";
		$mdsDB->close();
		return $out;
	}	
	private function getDoctorList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT UID,Title,FirstName,OtherName ";
		$sql .= " FROM user WHERE (Active = TRUE) AND ((Post = 'OPD Doctor') OR (Post = 'Consultant')) " ;
		$sql .= " ORDER BY OtherName ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input' disabled readonly id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			$dr_name = $row["Title"]." ".ucwords($row["FirstName"])." ".ucwords($row["OtherName"]);
			if ($row["UID"] == $value) {
				
				$out .="<option value='".$row["UID"]."' selected>".$dr_name."</option>\n";
			}
			else {
				if ($_SESSION["UID"] ==  $row["UID"]) {
					$out .="<option value='".$row["UID"]."' selected>".$dr_name."</option>\n";
				}
				else {
					$out .="<option value='".$row["UID"]."' >".$dr_name."</option>\n";
				}
				 
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}	
	private function getUserGroupCheckBox($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Name ";
		$sql .= " FROM user_group WHERE Active = TRUE " ;
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<input type='text' class='input'  id='".$id."'   name='".$id."' \n";
			$out .=" value='No Data' >\n";
			return $out;
		 }
		$out .="<div><input type= 'hidden' class='input'  id='".$id."'   name='".$id."' value='".$value."'>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if(stristr($value, $row["Name"])) {
					$out .="<input type='checkbox' value='".$row["Name"]."' checked onclick=updateUG(this) >".$row["Name"]."";
			}
			else {
					$out .="<input type='checkbox' value='".$row["Name"]."' onclick=updateUG(this) >".$row["Name"]."";
			}
		  }
		  $out .="</div>";
		$mdsDB->close();
		return $out;
	}
	private function getVisitTypeList($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Name ";
		$sql .= " FROM visit_type WHERE Active = TRUE " ;
		$sql .= " ORDER BY Name ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."' onchange=setCookie('vType',this.value) >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Name"] == $value) {
				$out .="<option value='".$row["Name"]."' >".$row["Name"]."</option>\n";
				
					$out .="<option selected='selected' >OPD Visit</option>\n";
			}
			else {
					$out .="<option value='".$row["Name"]."' ";
					if ($_COOKIE["vType"] ==$row["Name"]) $out .= "selected ";
					$out .= ">".$row["Name"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}
	
		private function getPatientStatus($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT Type";
		$sql .= " FROM patient_status WHERE Active = TRUE " ;
		$sql .= " ORDER BY Status_id ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."' onchange=setCookie('vType',this.value) >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if ($row["Type"] == $value) {
				$out .="<option value='".$row["Type"]."' selected>".$row["Type"]."</option>\n";
			}
			else {
					$out .="<option value='".$row["Type"]."' ";
					if ($_COOKIE["vType"] ==$row["Type"]) $out .= "selected ";
					$out .= ">".$row["Type"]."</option>\n";
			}
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}
		
		private function getUsers($id,$value) {
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
 		$out = "";
		$sql="SELECT UID,FirstName ";
		$sql .= " FROM user WHERE Active = TRUE " ;
		$sql .= " ORDER BY UID ";
		$result=$mdsDB->mysqlQuery($sql); 		
		  if (!$result) {  
			$out .="<select class='input'  id='".$id."'   name='".$id."'  ".$this->checkBlockField()." >\n";
			$out .="<option value='No Data'>No Data</option>\n";
			$out .="</select>\n";
				return $out;
		 }
		$out .="<select class='input'  id='".$id."'   name='".$id."' onchange=setCookie('vType',this.value) >\n";
		$out .="<option value=''></option>\n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
		
					$out .="<option value='".$row["UID"]."' selected>".$row["FirstName"]."</option>\n";
					if ($_COOKIE["vType"] ==$row[" UID"]) $out .= "selected ";
					$out .= ">".$row[" UID"]."</option>\n";
			
		  }
		$out .="</select>\n";
		$mdsDB->close();
		return $out;
	}
	
	private function getModluePermission($id,$value) {
		$out .="<div><input type= 'hidden' class='input'  id='".$id."'   name='".$id."' value='".$value."'>\n";
		$out .="<table  class='input' style='font-size:14px;background:#FFFFFF;width:400;' cellpadding=4px cellspacing=0>";
		$out .="<tr class='lab_head_cont' style='font-weight:bold;'><td>Module</td><td>Print</td><td>View</td><td>Edit</td><td>Create</td></tr>";
		
		
		$table = array();
		$table= array(
                        array("table"=>"patient","display"=>"Patient"),
                        array("table"=>"patient_alergy","display"=>"Patient alergy"),
                        array("table"=>"patient_history","display"=>"Patient history"),
                        array("table"=>"patient_exam","display"=>"Patient exam"),
                        array("table"=>"opd_visit","display"=>"Visit"),
                        array("table"=>"opd_treatment","display"=>"OPD Treatment"),
                        array("table"=>"admission","display"=>"Admission"),
                        array("table"=>"admission_diagnosis","display"=>"Admission diagnosis"),
                        array("table"=>"admission_procedures","display"=>"Admission surgical procedure"),
                        array("table"=>"admission_notes","display"=>"Admission notes"),
                        array("table"=>"appointment","display"=>"Appointments"),
                        array("table"=>"-","display"=>"-"),
                        array("table"=>"lab_order","display"=>"Lab Order"),
                        array("table"=>"opd_presciption","display"=>"Prescription Order"),
                        array("table"=>"drugs","display"=>"Drugs"),
                        array("table"=>"lab_tests","display"=>"Lab Tests"),
                        array("table"=>"lab_test_group","display"=>"Lab Tests Groups"),
                        array("table"=>"lab_test_department","display"=>"Lab Department"),
                        array("table"=>"canned_text","display"=>"Canned Text"),
                        array("table"=>"notification","display"=>"Notification"),
                        array("table"=>"ward","display"=>"Wards"),
                        array("table"=>"-","display"=>"-"),
                        array("table"=>"systems_table","display"=>"Systems table"),
						array("table"=>"attach","display"=>"Attch file")
                    );
		for ($i=0; $i < count($table); $i++){
			if ($table[$i]["table"] =="-") {
			$out .="<tr class='lab_item'><td  colspan='5'><hr></td><tr>";
			}
			else {
				$out .="<tr class='lab_item'><td>".$table[$i]["display"]."</td>";
				$out .="<td><input type='checkbox' mod='Print' value='".$table[$i]["table"]."' ".$this->checkAccess($table[$i]["table"]."_Print",$value)." onclick=updatePermission('".$id."',this) ></td>";
				$out .="<td><input type='checkbox' mod='View'  value='".$table[$i]["table"]."' ".$this->checkAccess($table[$i]["table"]."_View",$value)."  onclick=updatePermission('".$id."',this) ></td>";
				$out .="<td><input type='checkbox' mod='Edit' value='".$table[$i]["table"]."' ".$this->checkAccess($table[$i]["table"]."_Edit",$value)."  onclick=updatePermission('".$id."',this) ></td>";
				$out .="<td><input type='checkbox' mod='New' value='".$table[$i]["table"]."' ".$this->checkAccess($table[$i]["table"]."_New",$value)."  onclick=updatePermission('".$id."',this) ></td></tr>";
			}	
		}
		$out .="</table>";
		$out .="</div>";
		return $out;
	}
	
	private function getSysReview($id,$value) {
		
		$out .="<table  class='input' style='font-size:14px;background:#FFFFFF;width:500;' cellpadding=4px cellspacing=0>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input name='sreview' type='checkbox' value='Cough' ".$this->checkAccessNew('Cough',$value)." onclick=updateSysReview('".$id."',this)> Cough</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Chest Pain' ".$this->checkAccessNew('Chest Pain',$value)." onclick=updateSysReview('".$id."',this)>Chest Pain</td>";
		$out .="<td><input name='sreview' type='checkbox' value='UoP' ".$this->checkAccessNew('UoP',$value)." onclick=updateSysReview('".$id."',this)>UoP</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Difficulty Breathing' ".$this->checkAccessNew('Difficulty Breathing',$value)." onclick=updateSysReview('".$id."',this)> Difficulty & Breathing</td></tr>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input name='sreview' type='checkbox' value='ABD Pain' ".$this->checkAccessNew('ABD Pain',$value)." onclick=updateSysReview('".$id."',this)>ABD Pain</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Dutherea' ".$this->checkAccessNew('Dutherea',$value)." onclick=updateSysReview('".$id."',this)>Diarrhoea</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Headache' ".$this->checkAccessNew('Headache',$value)." onclick=updateSysReview('".$id."',this)>Headache</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Lethargy' ".$this->checkAccessNew('Lethargy',$value)." onclick=updateSysReview('".$id."',this)>Lethargy</td></tr>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input name='sreview' type='checkbox' value='Faintishness' ".$this->checkAccessNew('Faintishness',$value)." onclick=updateSysReview('".$id."',this)>Faintishness</td>";
		$out .="<td><input name='sreview' type='checkbox' value='Vomiting' ".$this->checkAccessNew('Vomiting',$value)." onclick=updateSysReview('".$id."',this)>Vomiting</td>";
		$out .="<td><input name='sreview' type='checkbox' value='LoA' ".$this->checkAccessNew('LoA',$value)." onclick=updateSysReview('".$id."',this)>LoA</td></tr>";
		
		$out .="</table>";
		$out .="<div><input type= 'hidden' class='input'  id='".$id."'   name='' value='".$val."'>\n";
		$out .="</div>";
		return $out;
	}
	
	private function getMedicalHistory($id,$value) {
		$out .="<div><input type= 'hidden' class='input'  id='".$id."'   name='".$id."' value='".$value."'>\n";
		$out .="<table  class='input' style='font-size:14px;background:#FFFFFF;width:500;' cellpadding=4px cellspacing=0>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input type='checkbox' name='mhistory' value='Diabetes Mellitus' ".$this->checkAccessNew('Diabetes Mellitus',$value)." onclick=updateMedicalHistory('".$id."',this)>Diabetes Mellitus</td>";
		$out .="<td><input type='checkbox' name='mhistory' value='Hypertension' ".$this->checkAccessNew('Hypertension',$value)." onclick=updateMedicalHistory('".$id."',this)>Hypertension</td>";
		$out .="<td><input type='checkbox' name='mhistory' value='Ischaemic Heart Disease' ".$this->checkAccessNew('Ischaemic Heart Disease',$value)." onclick=updateMedicalHistory('".$id."',this)>Ischaemic Heart Disease</td></tr>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input type='checkbox' name='mhistory' value='Bronchial Asthma' ".$this->checkAccessNew('Bronchial Asthma',$value)." onclick=updateMedicalHistory('".$id."',this)>Bronchial Asthma</td>";
		$out .="<td><input type='checkbox' name='mhistory' value='Epilepsy' ".$this->checkAccessNew('Epilepsy',$value)." onclick=updateMedicalHistory('".$id."',this)>Epilepsy</td>";
		$out .="<td><input type='checkbox' name='mhistory' value='CVA' ".$this->checkAccessNew('CVA',$value)." onclick=updateMedicalHistory('".$id."',this)>CVA</td></tr>";
		
		$out .="<tr class='lab_head_cont' style=''>";		
		$out .="<td><input type='checkbox' name='mhistory' value='Renal Failure' ".$this->checkAccessNew('Renal Failure',$value)." onclick=updateMedicalHistory('".$id."',this)>Renal Failure</td>";
		$out .="<td><input type='checkbox' name='mhistory' value='Liver Disease' ".$this->checkAccessNew('Liver Disease',$value)." onclick=updateMedicalHistory('".$id."',this)>Liver Disease</td></tr>";
		
		$out .="</table>";
		$out .="</div>";
		return $out;
	}
	
	public function addErrorDiv(){
		return "<div id='MDSError' class='mdserror'></div>";
	}
	private function checkAccess($mod,$value){
	$obj = json_decode($value);
	 if ($obj->{$mod}) {
		return "checked";
	 }
	 else {
		return "";
	 }
	}
	
	private function checkAccessNew($mod,$value){
		
	$results = explode(',', $value,-1);	
	
	if(in_array($mod, $results)){
	
	return "checked";
	}
	else{
	return "";
	}
	
	
	}
		
	
	private function clearbutton($frm,$i){
	if (!$this->isBlocked)
		return "<img src='images/clear.png' title='Clear field' width=15 height=15 valign=top style='cursor:pointer' onclick=$('#".$frm["FLD"][$i]["Id"]."').val('')>\n";
	}
}

?>
