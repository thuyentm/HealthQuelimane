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



include_once 'MDSPermission.php';
class MDSLeftMenu
{
        public $Type = NULL;
        public $Alert = true;

        private static $instance; 
  
        public static function getInstance() { 
                if(!self::$instance) { 
                        self::$instance = new self(); 
                } 
                return self::$instance; 
        }       
        
        function __construct() {

        } 
        
        public function renderLeftMenu($type,$obj){
                if ($type == "Patient"){
                        $this->renderPatientLeftMenu($obj);
                }
                else if ($type == "Opd") {
                        $this->renderOpdLeftMenu($obj);
                }
                else if ($type == "Admission") {
                        $this->renderAdmissionLeftMenu($obj);
                }               
                else if ($type == "Preference") {
                        $this->renderPreferenceLeftMenu($obj);
                }               
                else if ($type == "Ward") {
                        $this->renderWardLeftMenu();
                } 
				  else if ($type == "Message") {
                        $this->renderMessageLeftMenu();
                }
                else if ($type == "WardPlan") {
                        $this->renderWardPlanMenu($obj);
                }                 
                else if ($type == "notification") {
                        $this->renderNotificationLeftMenu();
                }   
                else if ($type == "search") {
                        $this->renderSearchLeftMenu();
                }   
         }
        private function renderPatientLeftMenu($patient){
            include_once 'MDSLicense.php';
                $menu = "";
                $menu .="<div id='left-sidebar' class='left-sidebar'>\n";
                                $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                        $menu .="<a  href='#1'>".getPrompt("Commands")."</a>\n";
                                        $menu .="<div> \n";
											$menu .="<input type='button' class='submenuBtn' value='".getPrompt("Create a visit")."' onclick=self.document.location='home.php?page=opd&action=new&PID=".$patient->getValue("PID")."'>\n";
											if (!$patient->haveAnyOpenedAdmission()){ 
												$menu .="<input type='button' class='submenuBtn' value='".getPrompt("Give an Admission")."' onclick=self.document.location='home.php?page=admission&action=New&PID=".$patient->getValue("PID")."'>\n";
											}    
											$menu .= getAppointmentLink($patient->getValue("PID"));
											$menu .= $this->addPatientHistoryCommand($patient);
											$menu .= $this->addPatientAllergyCommand($patient);
											$menu .= $this->addPatientExamCommand($patient,'patient_exam','Examination',true); 
											$menu .= getAttachLink('patient',$patient->getValue("PID"));
                                        $menu .="</div> \n";
                                        $menu .="<a href='#2'>".getPrompt("Prints")."</a>\n";
                                        $menu .="<div> \n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient slip")."'  onclick=printReport('".$patient->getValue("PID")."','PatientSlip'); >\n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient card")."'  onclick=printReport('".$patient->getValue("PID")."','PatientCard'); >\n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient summary")."' onclick=printReport('".$patient->getValue("PID")."','PatientHistory'); >\n";
                                        $menu .="</div>\n"; 
                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;            
        }
        
        public function renderOpdLeftMenu($visit) {
                $menu = "";
                $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                        $menu .="<a href='#1'>".getPrompt("Commands")."</a>\n";
                                        $menu .="<div> \n";
                                                $menu .="<input type='button' class='submenuBtn' value='&laquo; ".getPrompt("Patient overview")."'  onclick=self.document.location='home.php?page=patient&PID=".$visit->getValue("PID")."&action=View'>\n";
                                                $menu .= $this->addPatientHistoryCommand($visit,$visit->isOpened);
                                                $menu .= $this->addPatientAllergyCommand($visit,$visit->isOpened); 
                                                $menu .= $this->addPatientExamCommand($visit,'patient_exam','Examination',$visit->isOpened); 
                                                $menu .= $this->addOPDCommand($visit,'opdLabOrder','Order LabTest');
                                                $menu .= $this->addOPDCommand($visit,'opdPrescription','Prescribe drugs');
                                                $menu .= $this->addOPDCommand($visit,'opd_treatment','Treatments');
                                        
                                        $menu .="</div> \n";
                                        $menu .="<a  href='#3'>".getPrompt("Questionnaire")."</a>\n"; 
                                        $menu .="<div>\n"; 
                                        $questionnaires = $visit->getQuestionnaires();
                                        $menu .=$questionnaires; 
                                        $menu .="</div>\n";
                                        $menu .="<a href='#2'>".getPrompt("Prints")."</a>\n";
                                        $menu .="<div> \n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Prescription")."'  onclick=printReport('".$visit->getId()."','OpdPrescription'); >\n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Lab test")."' onclick=printReport('".$visit->getId()."','OpdLabTest'); >\n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient slip")."'  onclick=printReport('".$visit->getValue("PID")."','PatientSlip'); >\n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient card")."'  onclick=printReport('".$visit->getValue("PID")."','PatientCard'); >\n";   
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Visit Summary")."'  onclick=printReport('".$visit->getValue("PID").'&OPD='.$visit->getId()."','VisitSummery'); >\n";       
                                        $menu .="</div>\n";  
										$menu .=$this->loadPluginsControl();										
                        $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
           echo $menu ;
        }
        public function renderAdmissionLeftMenu($admission) {
                $menu = "";
                $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                        $menu .="<a href='#1'>".getPrompt("Commands")."</a>\n";
                                        $menu .="<div> \n";
                                                        if ($_GET["WID"]){
                                                        $menu .="<input type='button' class='submenuBtn' value='&laquo; ".getPrompt("Back to ward")."'  onclick=window.history.back();>\n";
                                                        }
                                                        $menu .="<input type='button' class='submenuBtn' value='&laquo; ".getPrompt("Patient overview")."'  onclick=self.document.location='home.php?page=patient&PID=".$admission->getValue("PID")."&action=View'>\n";
                                                        $menu .= $this->addPatientHistoryCommand($admission,$admission->isOpened);
                                                        $menu .= $this->addPatientAllergyCommand($admission,$admission->isOpened);
                                                        $menu .= $this->addPatientExamCommand($admission,'patient_exam','Examination',$admission->isOpened);
                                                        $menu .= $this->addAdmissionCommand($admission,'admission_diagnosis','Diagnosis');
                                                        //$menu .= $this->addAdmissionCommand($admission,'admission_treatment','Treatments');
                                                        $menu .= $this->addAdmissionCommand($admission,'admLabOrder','Order lab test');
                                                        $menu .= $this->addAdmissionCommand($admission,'admPrescription','Prescribe drugs');
                                                        $menu .= $this->addAdmissionCommand($admission,'admission_procedures','Procedures');
                                                        $menu .= $this->addAdmissionCommand($admission,'admission_notes','Notes');
                                                        $menu .= $this->addAdmissionCommand($admission,'admission_tranfer','Ward transfer');
                                                        $menu .= $this->addAdmissionCommand($admission,'discharge','Discharge');
                                        $menu .="</div> \n";
                                        $menu .="<a href='#2'>".getPrompt("Prints")."</a>\n";
                                        $menu .="<div> \n";
                                                $menu .="<input type='button' class='submenuBtn' value='".getPrompt("BHT")."'  onclick=printReport('".$admission->getId()."','bht'); >\n";      
                                                                                                
                                                //$menu .="<input type='button' class='submenuBtn' value='".getPrompt("Drugs orderd")."'  onclick=printReport('".$admission->getId()."','AdmDrugs'); >\n";
                                                //$menu .="<input type='button' class='submenuBtn' value='".getPrompt("Clinical information")."'  onclick=printReport('".$admission->getId()."','AdmInfo'); >\n";
                                                //$menu .="<input type='button' class='submenuBtn' value='".getPrompt("Lab test")."' onclick=printReport('".$admission->getId()."','AdmLabTest'); >\n";
                                                //if (!$admission->isOpened) {
                                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Transfer letter")."'  onclick=printReport('".$admission->getId()."','AdmTransfer'); >\n";
                                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Discharge ticket")."'  onclick=printReport('".$admission->getId()."','AdmDischargeTicket'); >\n";
                                                        
                                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Admission summary")."' onclick=printReport('".$admission->getId()."','PatientSummery','".$admission->getValue("PID")."'); >\n";
                                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient slip")."'  onclick=printReport('".$admission->getValue("PID")."','PatientSlip'); >\n";
                                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Print patient card")."'  onclick=printReport('".$admission->getValue("PID")."','PatientCard'); >\n";
                                                //}
                                        $menu .="</div>\n";                                     
                        $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
           echo $menu ;
        }       
        private function renderPreferenceLeftMenu() {
        $mdsPermission = MDSPermission::GetInstance();
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1'> \n";
                                $menu .="<a class='LeftMenuItem' href=''>System Tables</a>\n";
                                $menu .="<div> \n";
                                        $access =$mdsPermission->haveAccess($_SESSION["UGID"],"systems_table_Edit");
                                        if ($access==0) {
                                            if ($_SESSION["UGID"] ==6) $access=1;
                                        }
                                        $menu .=$this->addSYSCommand($access,"Users","Add/Edit Users");
                                        $menu .=$this->addSYSCommand($access,"userGroup","Add/Edit Group");
                                        $menu .=$this->addSYSCommand($access,"Permission","Permission allocation");
                                        $menu .=$this->addSYSCommand($access,"visitType","Add/Edit Visit Type");
                                        $menu .=$this->addSYSCommand($access,"Hospital","Hospital Settings");
                                        $menu .=$this->addSYSCommand($access,"institution","Institutions");
                                        $menu .=$this->addSYSCommand($access,"Menu","Menu Bar");
                                $menu .="</div> \n";
                                
                                $menu .="<a  class='LeftMenuItem' href=''>Clinical Tables</a>\n";
                                $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Complaints")."' onclick=loadDataTable('Complaints','')>\n";                                              
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Treatments")."' onclick=loadDataTable('treatment','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Drugs'")." onclick=loadDataTable('Drugs','')>\n";
										$menu .="<input type='button' class='submenuBtn' value='".getPrompt("My Drugs'")." onclick=loadDataTable('mydrugs','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Drugs dosage'")." onclick=loadDataTable('drugs_dosage','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Drugs frequency'")." onclick=loadDataTable('drugs_frequency','')>\n";
                                        
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Canned text'")." onclick=loadDataTable('CannedText','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("LabTest'")." onclick=loadDataTable('LabTest','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Lab test group'")." onclick=loadDataTable('labTestGroup','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Lab test department'")." onclick=loadDataTable('labTestDepartment','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Wards'")." onclick=loadDataTable('ward','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Questionnaires")."' onclick=loadDataTable('quest_struct','')>\n";
                                $menu .="</div> \n";          

                                $menu .="<a  class='LeftMenuItem' href=''>Application Tables</a>\n"; 
                                $menu .="<div>\n"; 
//                                        $menu .="<input type='button' class='submenuBtn' value='SNOMED Findings' onclick=loadDataTable('Finding','')>\n";
//                                        $menu .="<input type='button' class='submenuBtn' value='SNOMED Disorders' onclick=loadDataTable('disorder','')>\n";
//                                        $menu .="<input type='button' class='submenuBtn' value='SNOMED Events' onclick=loadDataTable('event','')>\n";
//                                        $menu .="<input type='button' class='submenuBtn' value='SNOMED Procedures' onclick=loadDataTable('procedures','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='ICD 10' onclick=loadDataTable('Icd','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='IMMR' onclick=loadDataTable('Immr','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Village'")." onclick=loadDataTable('Village','')>\n";
                                $menu .="</div>\n";
                                $menu .=$this->loadPluginsControl();
//				$menu .="<a  class='LeftMenuItem' href='#4'>Logs</a>\n"; 
//				$menu .="<div>\n"; 
//					$menu .="<p>\n"; 
//                                        $menu .="<input type='button' class='submenuBtn' value='User logins' onclick=popup('log.php?l=userlog')>\n";
//					$menu .="<input type='button' class='submenuBtn' value='System logs' onclick=popup('log.php?l=syslog')>\n";
//                                        $menu .="<input type='button' class='submenuBtn' value='Error logs' onclick=popup('log.php?l=errorlog')>\n";
//					$menu .="<input type='button' class='submenuBtn' value='Failed logins' onclick=popup('log.php?l=accesslog')>\n";
//					$menu .="</p>\n"; 
//				$menu .="</div>\n";
         $menu .=" </div> \n";
        $menu .="</div> \n";
		 $js = "";
                $js  .="<script language='javascript'>\n";
                //$js  .=";\n";
                $js  .="</script>\n";
        $menu .= $js;
        echo $menu ;
        }       
		private function loadPluginsControl(){
		$out = "";
			if (file_exists("plugins/plugins_conf.php")){
				try{
					include_once "plugins/plugins_conf.php";
					
					for ($i = 0; $i < count($plugins); ++$i){
					
						for ($j = 0; $j < count($p_hhims[$plugins[$i]]); ++$j){
						$out .= "";
							if ( ($p_hhims[$plugins[$i]][$j]["page"] == $_GET["page"])   )
								{
									try {
										//$out .= "<span style='height:30;font-size:12;padding:4px;background:#f9e3cf;border:1px solif #830101;color:#FFFFFF;'><a name='".$plugins[$i].$i."'  id='".$plugins[$i].$i."'  type='".$p_hhims[$plugins[$i]][$j]["type"]."' value='".$p_hhims[$plugins[$i]][$j]["value"]."'  target='' onclick='' href='javascript:void(0);'>".$p_hhims[$plugins[$i]][$j]["value"]."</a><img src='".$p_hhims[$plugins[$i]][$j]["img"]."' width=40 valign=middle></span>";
										$out .= "<a  class='LeftMenuItem' href='#4' style='color:red;'>Plugins</a>";
										$out .= "<div><p>";
										$out .="<img src='".$p_hhims[$plugins[$i]][$j]["img"]."' width=40 valign=middle onclick='".$p_hhims[$plugins[$i]][$j]["click"]."' style='cursor:pointer;'>\n";
										$out .= "</p></div>";
									}
									catch (Exception $e) {}
								}
							}
						
					}
					
					return $out;
				}
				catch (Exception $e) {
				}
			}			
		}
        public function renderWardLeftMenu(){
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Reports")."</a>\n";
                                $menu .="<div> \n";
                                $menu .="</div> \n";
                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;
        } 
		   public function renderMessageLeftMenu(){
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Messages")."</a>\n";
                               $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Compose Message")."' onclick=loadMessage('inbox','')>\n";                                              
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Inbox")."' onclick=loadMessage('inbox','')>\n";
                                        $menu .="<input type='button' class='submenuBtn' value='".getPrompt("Sent Messages'")." onclick=loadMessage('outbox','')>\n";
                                                                               
                                        $menu .="</div> \n"; 
                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;
        }
        public function renderSearchLeftMenu(){
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Reports")."</a>\n";
                                $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='Patient Statistics'  onclick=openPatientStatisticsPopup()>\n";
                                        //$menu .="<input type='button' class='submenuBtn' value='CLINIC Prescriptions'>\n";
                                $menu .="</div> \n";

                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;
        } 
        public function renderNotificationLeftMenu(){
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Reports")."</a>\n";
                                $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='Pending'  onclick=reDirect('notification','')>\n";
                                        //$menu .="<input type='button' class='submenuBtn' value='CLINIC Prescriptions'>\n";
                                $menu .="</div> \n";

                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;
        }  
        public function renderWardPlanMenu($ward){
           $menu = "";
           $menu .="<div id='left-sidebar'>\n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Commands")."</a>\n";
                                $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='&laquo;Back to ward list'  onclick=reDirect('ward','')>\n";
                                        //$menu .="<input type='button' class='submenuBtn' value='Bed view'  onclick=reDirect('wardfloorplan','WID=".$ward->getValue("WID")."')>\n";
                                        //$menu .="<input type='button' class='submenuBtn' value='Patient list view'  onclick=reDirect('wardpatient','WID=".$ward->getValue("WID")."')>\n";
                                $menu .="</div> \n";

                $menu .=" </div> \n";
                        $menu .="<div class='basic' style='float:left;'  id='list1a'> \n";
                                $menu .="<a>".getPrompt("Reports")."</a>\n";
                                $menu .="<div> \n";
                                        $menu .="<input type='button' class='submenuBtn' value='Midnight Census'  onclick=openDateRangeBox('date_range_selector','Midnight&nbsp;Census','midnight_census','".$ward->getId()."')>\n";
                                $menu .="</div> \n";

                $menu .=" </div> \n";
                $menu .="</div> \n";
                $menu .= $this->leftMenuJS();
                echo $menu ;
        }         
       
        
        private function leftMenuJS(){
                $js = "";
                $js  .="<script language='javascript'>\n";
                $js  .="$('#list1a').accordion({navigation: true,active: false,header: '.LeftMenuItem'});\n";
                $js  .="$('.LeftMenuItem').click(function(event){  window.location.hash=this.hash;});   \n";
                //$js  .=";\n";
                $js  .="</script>\n";
                return $js;
        }
        private function addPatientHistoryCommand($episode,$ops=true){

                $menu_item .= "<input type='button' class='submenuBtn' value='".getPrompt("Add history")."'  ";
                if (!$ops){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }
                $menu_item .=" onclick=self.document.location='home.php?page=patient_history&action=New&PID=".$episode->getValue("PID")."&RETURN='+encodeURIComponent(self.document.location)+''>\n";   
                return $menu_item ;
        }
        private function addPatientAllergyCommand($episode,$ops=true){
                $menu_item = "<input type='button' class='submenuBtn' ";
                if (!$ops){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }
                $menu_item .= " value='".getPrompt("Add allergy")."'  onclick=self.document.location='home.php?page=alergy&action=New&PID=".$episode->getValue("PID")."&RETURN='+encodeURIComponent(self.document.location)+''>\n";
                return $menu_item;
        }
        private function addPatientExamCommand($episode,$table,$text,$ops=true){
                $menu_item = "<input type='button' class='submenuBtn' ";
                if (!$ops){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }

                $menu_item .=  " value='".getPrompt("Examination")."'  onclick=self.document.location='home.php?page=".$table."&action=New&PID=".$episode->getValue("PID")."&RETURN='+encodeURIComponent(self.document.location)+''>\n";
                return $menu_item;
        }
        private function addAdmissionCommand($episode,$table,$text){
                $menu_item = "";
                $menu_item .= "<input type='button' class='submenuBtn'  ";
                if (!$episode->isOpened){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }
        $menu_item .=  "  value='".getPrompt($text)."' onclick=self.document.location='home.php?page=".$table."&ADMID=".$episode->getID()."&action=Edit'>\n";
                return $menu_item ;
        }               
        private function addOPDCommand($episode,$table,$text){
                $menu_item = "";
                $menu_item .= "<input type='button' class='submenuBtn'  ";
                if (!$episode->isOpened){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }
                $menu_item .=  "  value='".getPrompt($text)."' onclick=self.document.location='home.php?page=".$table."&OPDID=".$episode->getID()."&action=Edit&PID=".$episode->getValue("PID")."' />\n";
                return $menu_item ;
        }               
        private function addSYSCommand($access,$table,$text){
                $menu_item = "";
                $menu_item .= "<input type='button' class='submenuBtn'  ";
                if (!$access){
                        $menu_item .= "style='color:#cccccc;cursor:not-allowed;'  disabled  "; 
                }
                $menu_item .=  "  value='".getPrompt($text)."'  onclick=loadDataTable('".$table."','') >\n";
                return $menu_item ;
        }       
}

?>
