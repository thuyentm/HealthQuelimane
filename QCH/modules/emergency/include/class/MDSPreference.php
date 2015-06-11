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
include_once 'MDSPager.php';

class MDSPreference {

    private static $instance;
    private $mod = NULL;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct($mod) {
        $this->mod = $mod;
    }

    private function loadMDSPager($fName) {
        $path = 'include/form_config/' . $fName . '_config.php';
        require $path;
        $frm = ${$fName};
        $columns = $frm["LIST"];
        $table = $frm["TABLE"];
        $sql = "SELECT ";

        foreach ($columns as $column) {
            $sql.=$column . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql.=" FROM $table ";
        $pager = new MDSPager($sql);
        $pager->setDivId('prefCont');
        $pager->setSortorder('asc');
        //set colun headings
        $colNames = array();
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        $pager->setColNames($colNames);

        //set captions
        $pager->setCaption($frm["CAPTION"]);
        //set row id
        $pager->setRowid($frm["ROW_ID"]);

        //set column models
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $pager->setColOption($columnName, $model);
            }
        }

        //set actions
        $action = $frm["ACTION"];
        $pager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='$action'+rowId;
            });
            }";
        
        //report starts
        $pager->setOrientation_EL($frm["ORIENT"]);
        $pager->setTitle_EL($frm["TITLE"]);
//        $pager->setSave_EL($frm["SAVE"]);
        $pager->setColHeaders_EL($frm["COL_HEADERS"]?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        return $pager->render(false);
//        return "<h1>$sql";
    }
	
	    private function loadMyDrugs($fName) {
			
$path = 'include/form_config/' . $fName . '_config.php';
        require $path;
        $frm = ${$fName};
		$UID=$_SESSION["UID"];
        //$columns = $frm["LIST"];
       // $table = $frm["TABLE"];
        $sql = "SELECT  Doctor_Drug.DDID,
			drugs.DRGID ,
			drugs.Name,			
			drugs.dFrequency,
			drugs.dDosage,
			drugs.Stock
			FROM Doctor_Drug, drugs 
			where (Doctor_Drug.DRGID = drugs.DRGID ) AND (Doctor_Drug.USRID = '$UID')";

       // foreach ($columns as $column) {
        //    $sql.=$column . ',';
       // }
       // $sql = substr($sql, 0, -1);
      //  $sql.=" FROM $table ";
        $pager = new MDSPager($sql);
        $pager->setDivId('prefCont');
        $pager->setSortorder('asc');
        //set colun headings
        $colNames = array();
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        $pager->setColNames($colNames);

        //set captions
        $pager->setCaption($frm["CAPTION"]);
        //set row id
        $pager->setRowid($frm["ROW_ID"]);

        //set column models
     /*   foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $pager->setColOption($columnName, $model);
            }
        }*/

        //set actions
        $action = $frm["ACTION"];
        $pager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow'});
				
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
				var checkstr =  confirm('Are you really want to delete this Drug from your list?');
if(checkstr == true){
	$.ajax({        
		type :'POST',
    	url: 'include/deletemydrug.php',
    	dataType : 'json',
    	data:{		
    		seid:rowId
    	 },
        success: function(){
             alert('Drug removed');
        }
    });
}
else{
return false;
}
                
            });
            }";
        
        //report starts
        $pager->setOrientation_EL($frm["ORIENT"]);
        $pager->setTitle_EL($frm["TITLE"]);
		$pager->setColOption($frm["ROW_ID"], array("hidden" => true));
//        $pager->setSave_EL($frm["SAVE"]);
        $pager->setColHeaders_EL($frm["COL_HEADERS"]?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        return $pager->render(false);
//        return "<h1>$sql";
    }

    public function loadPreference() {
        $out = "";
        switch ($this->mod) {

            case "Permission":
                $out .= loadHeader("Permission settings");
                $Btns = "<input type='button' value='Create the permissions for a new group'  onclick=self.document.location='home.php?page=preferences&mod=permissionNew#1'>";
//                $Btns .= "<input type='button' value='Print this list'  onclick=openDialogBox('perm_pop','Permissions','permissions','include/permission_pop.php')>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("permissionForm");
                break;
            case "permissionNew":
                $out .= loadHeader("Permission settings");
                $out .= "<div id='prefCont' >" . loadForm("permissionForm") . "</div>";
                break;
            case "Menu":
                $out .= loadHeader("Main menu");
                $Btns = "<input type='button' value='Add new Menu' onclick=self.document.location='home.php?page=preferences&mod=MenuNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('userMenuForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("userMenuForm");
                break;
            case "MenuNew":
                if (isset($_GET["UMID"]))
                    $out .= loadHeader("Edit main menu");
                else
                    $out .= loadHeader("New main menu");
                $out .= "<div id='prefCont' >" . loadForm("userMenuForm") . "</div>";
                break;
            case "userGroup":
                $out .= loadHeader("User group");
                $Btns = "<input type='button' value='Add new User Group' onclick=self.document.location='home.php?page=preferences&mod=userGroupNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('userGroupForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("userGroupForm");
                break;
            case "userGroupNew":
                $out .= loadHeader("New User Group");
                $out .= "<div id='prefCont' >" . loadForm("userGroupForm") . "</div>";
                break;
            case "Hospital":
                $out .= loadHeader("Hospitals");
                $Btns ="";
                //$Btns = "<input type='button' value='Add new hospital' onclick=self.document.location='home.php?page=preferences&mod=HospitalNew'>";
                //$Btns = "<input type='button' value='Print this list' onclick=printTable('HospitalForm','HID');>";
                //$out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("HospitalForm");
                break;
            case "HospitalNew":
                $out .= loadHeader("Hospital settings");
                $out .= "<div id='prefCont' >" . loadForm("HospitalForm") . "</div>";
                break;
            case "institution":
                $out .= loadHeader("Institutions");
                $Btns = "<input type='button' value='Add new Institutions' onclick=self.document.location='home.php?page=preferences&mod=institutionNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('institutionForm','INSTID');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("institutionForm");
                break;
            case "institutionNew":
                $out .= loadHeader("Institutions");
                $out .= "<div id='prefCont' >" . loadForm("institutionForm") . "</div>";
                break;
            case "visitType":
                $out .= loadHeader("Visit types");
                $Btns = "<input type='button' value='Add new visit type' onclick=self.document.location='home.php?page=preferences&mod=visitTypeNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('visitTypeForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("visitTypeForm");
//                $out .= "<div id='prefOps'>" . $Btns . "</div><div id='prefCont' >" . loadTable('visitType') . "</div>";
                break;
            case "visitTypeNew":
                $out .= loadHeader("New visit type");
                $out .= "<div id='prefCont' >" . loadForm("visitTypeForm") . "</div>";
                break;
/////////////////////////////////                               
            case "Complaints":
                $out .= loadHeader("Complaints");
                $Btns = "<input type='button' value='Add new complaint' onclick=self.document.location='home.php?page=preferences&mod=ComplaintsNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('complaintForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out.=$this->loadMDSPager("complaintForm");
                break;
            case "ComplaintsNew":
                $out .= loadHeader("New Complaint");
                $out .= "<div id='prefCont' >" . loadForm("complaintForm") . "</div>";
                break;

            case "treatment":
                $out .= loadHeader("Treatment");
                $Btns = "<input type='button' value='Add new treatment' onclick=self.document.location='home.php?page=preferences&mod=treatmentNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('treatmentForm','Treatment');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('treatmentForm');
                break;
            case "treatmentNew":
                $out .= loadHeader("New treatment");
                $out .= "<div id='prefCont' >" . loadForm("treatmentForm") . "</div>";
                break;



            case "Icd":
                $out .= loadHeader("ICD 10");
                $Btns = "<input type='button' value='Print this list' onclick=printTable('ICDForm','ICDID');>";
                $out .= $this->loadMDSPager('ICDForm');
                break;
            case "IcdNew":
                $out .= loadHeader("Edit ICD");
                $out .= "<div id='prefCont' >" . loadForm("ICDForm") . "</div>";
                break;
            case "Immr":
                $out .= loadHeader("IMMR");
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('IMMRForm','IMMRID');>";
                $out .= $this->loadMDSPager('IMMRForm');
                break;
            case "Snomed":
                $out .= loadHeader("SNOMED");
                $out .= "<div id='prefOps'>" . $Btns . "</div><div id='prefCont' >" . loadTable("SNOMED") . "</div>";
                break;
            case "Finding":
                $out .= loadHeader("SNOMED Findings");
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('SNOMEDFindingForm','TERM');>";
//                $out .= "<div id='prefOps'>" . $Btns . "</div><div id='prefCont' >" . loadTable("finding") . "</div>";
                $out .= $this->loadMDSPager('findingForm');
                break;
            case "findingNew":
                $out .= loadHeader("SNOMED Findings");
                $out .= "<div id='prefCont' >" . loadForm("findingForm") . "</div>";
                break;

            case "event":
                $out .= loadHeader("SNOMED Events");
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('SNOMEDEventForm','TERM');>";
                $out .= $this->loadMDSPager('eventForm');
                break;
            case "eventNew":
                $out .= loadHeader("SNOMED Event");
                $out .= "<div id='prefCont' >" . loadForm("eventForm") . "</div>";
                break;
            case "procedures":
                $out .= loadHeader("SNOMED Procedures");
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('SNOMEDProceduresForm','TERM');>";
                $out .= $this->loadMDSPager('proceduresForm');
                break;
            case "proceduresNew":
                $out .= loadHeader("SNOMED Procedures");
                $out .= "<div id='prefCont' >" . loadForm("proceduresForm") . "</div>";
                break;
            case "disorder":
                $out .= loadHeader("SNOMED Disorders");
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('SNOMEDDisorderForm','TERM');>";
                $out .= $this->loadMDSPager('disorderForm');
                break;
            case "disorderNew":
                $out .= loadHeader("SNOMED Disorders");
                $out .= "<div id='prefCont' >" . loadForm("disorderForm") . "</div>";
                break;
            case "Village":
                $out .= loadHeader("Village list");
                  $Btns = "<input type='button' value='Add Village'  onclick=self.document.location='home.php?page=preferences&mod=VillageNew'>";                
//                $Btns = "<input type='button' value='Print this list' onclick=printTable('VillageForm','VGEID');>";
                  $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('VillageForm');
                break;
            case "VillageNew":
                $out .= loadHeader("View / Edit Village");
                $out .= "<div id='prefCont' >" . loadForm("VillageForm") . "</div>";
                break;
            case "CannedText":
                $out .= loadHeader("Canned text");
                $Btns = "<input type='button' value='Add / Edit Canned text'  onclick=self.document.location='home.php?page=preferences&mod=CannedTextNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('CannedTextForm','CTEXTID');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('CannedTextForm');
                break;
            case "CannedTextNew":
                $out .= loadHeader("Canned text edit");
                $out .= "<div id='prefCont' >" . loadForm("CannedTextForm") . "</div>";
                break;
            case "ward":
                $out .= loadHeader("Wards");
                $Btns = "<input type='button' value='Add new User / Ward'  onclick=self.document.location='home.php?page=preferences&mod=wardNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('wardForm','WID');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('wardForm');
                break;
            case "wardNew":
                $out .= loadHeader("Add / Edit ward");
                $out .= "<div id='prefCont' >" . loadForm("wardForm") . "</div>";
                break;
            case "ImmrNew":
                $out .= loadHeader("Edit IMMR");
                $out .= "<div id='prefCont' >" . loadForm("IMMRForm") . "</div>";
                break;


            case "Users":
                $out .= loadHeader("System User");
                $Btns = "<input type='button' value='Add new User / Staff'  onclick=self.document.location='home.php?page=preferences&mod=UserNew'>";
				$Btns .= "<input type='button' value='User post'  onclick=self.document.location='home.php?page=preferences&mod=user_post'>";
				$Btns .= "<input type='button' value='User speciality'  onclick=self.document.location='home.php?page=preferences&mod=user_speciality'>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager("userForm");
                break;
            case "user_post":
                $out .= loadHeader("Available posts");
                $Btns = "<input type='button' value='Add new post'  onclick=self.document.location='home.php?page=preferences&mod=user_postNew'>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('user_postForm');
                break;
            case "user_postNew":
                $out .= loadHeader("Post edit/new");
                $out .= "<div id='prefCont' >" . loadForm("user_postForm") . "</div>";
                break;
            case "user_speciality":
                $out .= loadHeader("Available speciality");
                $Btns = "<input type='button' value='Add new speciality'  onclick=self.document.location='home.php?page=preferences&mod=user_specialityNew'>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('user_specialityForm');
                break;	
			case "user_specialityNew":
                $out .= loadHeader("User speciality edit/new");
                $out .= "<div id='prefCont' >" . loadForm("user_specialityForm") . "</div>";
                break;
            case "UserNew":
                $out .= loadHeader("System user edit/new");
                $out .= "<div id='prefCont' >" . loadForm("userForm") . "</div>";
                break;
            case "Drugs":
                $out .= loadHeader("Available drug list");
                $Btns = "<input type='button' value='Add new Drug'  onclick=self.document.location='home.php?page=preferences&mod=drugsNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('drugsForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('drugsForm');
                break;
			case "mydrugs":
                $out .= loadHeader("My drug list");
                $Btns = "<input type='button' value='Add new Drug to my list'  onclick=self.document.location='home.php?page=preferences&mod=mydrugsNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('drugsForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMyDrugs('mydrugForm');
                break;	
            case "drugs_dosage":
                $out .= loadHeader("Drugs dosage ");
                $Btns = "<input type='button' value='Add new dosage'  onclick=self.document.location='home.php?page=preferences&mod=drugs_dosageNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('drugs_dosageForm','Dosage');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('drugs_dosageForm');
                break;
            case "drugs_dosageNew":
                $out .= loadHeader("Drug dosage edit/new");
                $out .= "<div id='prefCont' >" . loadForm("drugs_dosageForm") . "</div>";
                break;
            case "drugs_frequency":
                $out .= loadHeader("Drugs frequency");
                $Btns = "<input type='button' value='Add new drug frequency'  onclick=self.document.location='home.php?page=preferences&mod=drugs_frequencyNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('drugs_frequencyForm','Frequency');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('drugs_frequencyForm');
                break;
            case "drugs_frequencyNew":
                $out .= loadHeader("Drug frequency edit/new");
                $out .= "<div id='prefCont' >" . loadForm("drugs_frequencyForm") . "</div>";
                break;
            case "drugsNew":
                $out .= loadHeader("Drug edit/new");
                $out .= "<div id='prefCont' >" . loadForm("drugsForm") . "</div>";
                break;
			case "mydrugsNew":
                $out .= loadHeader("My Drugs new");
                $out .= "<div id='prefCont' >" . loadForm("doctorDrugsForm") . "</div>";
                break;	
            case "quest_struct":
                $out .= loadHeader("Questionnaire");
                $Btns = "<input type='button' value='Create a new Questionnaire'  onclick=self.document.location='home.php?page=preferences&mod=quest_structNew'>";
                //$Btns .= "<input type='button' value='Add Fields' onclick=self.document.location='home.php?page=preferences&mod=quest_flds_structNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('quest_structForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('quest_structForm');
                break;
            case "quest_structNew":
                $out .= loadHeader("Create / Edit questionnaire");
                $out .= "<div id='prefCont' >" . loadForm("quest_structForm") . "</div>";
                break;
            case "quest_flds_structNew":
                $out .= loadHeader("Create / Edit fields");
                $out .= "<div id='prefCont' >" . loadForm("quest_flds_structForm") . "</div>";
                break;
            case "LabTest":
                $out .= loadHeader("Available LabTest list");
                $Btns = "<input type='button' value='Add new LabTest'  onclick=self.document.location='home.php?page=preferences&mod=LabTestNew'>";
                $Btns .= "<input type='button' value='Add new Department'  onclick=self.document.location='home.php?page=preferences&mod=labTestDepartmentNew'>";
                $Btns .= "<input type='button' value='Add new Lab Group'  onclick=self.document.location='home.php?page=preferences&mod=labTestGroupNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('labTestForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .=$this->loadMDSPager('labTestForm');
                break;
            case "LabTestNew":
                $out .= loadHeader("LabTest edit/new");
                $out .= "<div id='prefCont' >" . loadForm("labTestForm") . "</div>";
                break;
            case "labTestGroupNew":
                $out .= loadHeader("Lab Test Group edit/new");
                $out .= "<div id='prefCont' >" . loadForm("labTestGroupForm") . "</div>";
                break;
            case "labTestGroup":
                $out .= loadHeader("Lab Test Group ");
                $Btns .= "<input type='button' value='Add new Lab Group'  onclick=self.document.location='home.php?page=preferences&mod=labTestGroupNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('labTestGroupForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('labTestGroupForm');
                break;
            case "labTestDepartment":
                $out .= loadHeader("Lab Test Department ");
                $Btns .= "<input type='button' value='Add new Department'  onclick=self.document.location='home.php?page=preferences&mod=labTestDepartmentNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('labTestDepartmentForm','Name');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager('labTestDepartmentForm');
                break;
            case "labTestDepartmentNew":
                $out .= loadHeader("Lab Test Group edit/new");
                $out .= "<div id='prefCont' >" . loadForm("labTestDepartmentForm") . "</div>";
                break;
            case "Lang":
                $out .= loadHeader("Default interface language");
                $out .= "<div id='prefCont' >" . loadForm("myForm") . "</div>";
                break;
            default:
                $out .= loadHeader("System User");
                $Btns = "<input type='button' value='Add new User / Staff'  onclick=self.document.location='home.php?page=preferences&mod=UserNew'>";
//                $Btns .= "<input type='button' value='Print this list' onclick=printTable('userForm','FirstName');>";
                $out .= "<div id='prefOps'>" . $Btns . "</div>";
                $out .= $this->loadMDSPager("userForm");
        }
        return $out;
    }

}

?>
