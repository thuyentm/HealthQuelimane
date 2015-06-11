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
include_once 'MDSAdmission.php';
include_once 'MDSOpd.php';
include_once 'MDSPatient.php';
include_once 'MDSWard.php';
include_once 'MDSStaff.php';

class MDSNotification extends MDSPersistent
{
	private static $instance; 
	private $table = "notification";
        private $css_Cont_class =  " opdCont ";
        private $subject = "";
        private $patient = null;
        private $epicode = null;
        private $epicode_type = null;
        private $ward = null;
        private $doctor = null;
        
        
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
        
	public function display(){
            $out = "";
            $this->init();
            if ( $this->getValue("LabConfirm") == 1 ){
                $pat_lab_d = "Yes"; 
            }
            else {
                $pat_lab_d = "No"; 
            }  
            $this->subject = $this->getValue("Disease")." in ".$this->patient->getValue("Address_Village")." (NOTIFICATION)";
            $out  = "<div class='".$this->css_Cont_class."' style='margin-top:40px;' > <div class='opdHead' id='adh1' > ".getPrompt("Notification of communicable disease")." </div>\n";
            $out .= "<div class='lab_Cont' id='adb'>\n";
            $out .= "<table  class='PrescriptionInfo' border=0 cellspacing=2 cellpadding=5 width=100% style='border-color:#fcfcda;background:#fafade;'>";
            $out .= "<tr>";
                $out .= "<td width=100 >".getPrompt("To Email Address:")."  : </td><td align='left' colspan=3>";
                $out .= "<textarea width=100% class='input' style='width:500;' readonly>".$this->getValue("TOID")."</textarea>";
                $out .= "</td>";
            $out .= "</tr>";
            $out .= "<tr>";
                $out .= "<td width=100 >".getPrompt("Subject:")."  : </td><td align='left' colspan=3>";
                $out .= "<input type='text' class='input' style='width:500;' readonly value='".$this->subject."'>";
                $out .= "</td>";
            $out .= "</tr>";
            $out .= "<tr>";
                $out .= "<td  colspan=4>".$this->mailCompose()." </td>";
            $out .= "</tr>";
              $out .= "<tr>";
                $out .= "<td colspan=4 align=center>";
                $out .= "<input type='button'  class='formButton'  value='Edit' onclick=self.document.location='home.php?page=notification&action=Edit&NOTIFICATION_ID=".$this->getId()."&RETURN='+encodeURIComponent(self.document.location)+''>\n";
                $out .= "<input type='button'  class='formButton'  value='Send EMail' onmouseup='this.disabled=true; this.value=\"Sending Mail...\"' onmousedown=self.document.location='home.php?page=notification&action=Send&NOTIFICATION_ID=".$this->getId()."'>\n";
                $out .= "<input type='button'  class='formButton'  value='Print' onclick=printReport('".$this->getId()."','notification')>&nbsp;&nbsp;&nbsp;\n";
                $out .= "<input type='button'  class='formButton'  value='Cancel' onclick=self.document.location='home.php?page=notification'>\n";
                $out .= "</td>";
            $out .= "</tr>";            
            $out .= "</table>";
            $out .= "</div>";
            $out .= "</div>";
            //$out .= "Status".$this->sendMail();
            echo $out;
        }
        private function init(){
                if ($this->getValue("Episode_Type")=='admission'){
                $admid= $this->getValue("EPISODEID");
                $admission = new MDSAdmission();
                $admission->openId($admid);
                $this->epicode = $admission;
                $patient = $admission->getAdmitPatient();
                $this->patient=$patient;
                $ward = new MDSWard();
                $ward->OpenId($admission->getValue("Ward"));
                $this->ward = $ward;
                $doctor = new MDSStaff();
                $doctor->openId($this->getValue("ConfirmedBy"));
                $this->doctor = $doctor;
                $this->epicode_type = "Admission";
                 $this->subject = $this->getValue("Disease")." in ".$this->patient->getValue("Address_Village")." (NOTIFICATION)";
            }
            else if($this->getValue("Episode_Type")=='opd'){
                 $opdid= $this->getValue("EPISODEID");
                $opd = new MDSOpd();
                $opd->openId($opdid);
                $this->epicode = $opd;
                $this->epicode_type = "Opd";
                $patient = $opd->getOpdPatient();
                $this->patient=$patient;
                $doctor = new MDSStaff();
                $doctor->openId($this->getValue("ConfirmedBy"));
                $this->doctor = $doctor;
                $this->subject = $this->getValue("Disease")." in ".$this->patient->getValue("Address_Village")." (NOTIFICATION)";           
            }
            else {
                echo " Episode not found";
            }  
           
        }
        public function mailCompose(){
            $out = "";
     
            if ($this->getValue("LabConfirm") ==1){
                $pat_lab_d = "Yes"; 
            }
            else {
                $pat_lab_d = "No"; 
            }                       
            $out .= "<table  class='PrescriptionInfo' border=1 cellspacing=2 cellpadding=5 width=100% style='border-color:#fcfcda;background:#f6ff00;'>";
            $out .= "<tr>";
                $out .= "<td colspan=4  align = center ><b style='font-size:18px;'>NOTIFICATION OF COMMUNICABLE DISEASE</b></td>";
            $out .= "</tr>";
            $out .= "<tr>";
                $out .= "<td width=100  align='right'>".getPrompt("Institute").":</td><td align='left' >".$this->patient->getHospital()."</td>";
                $out .= "<td width=150  align='right'>".getPrompt("Disease").":</td><td  align='left' >".$this->getValue("Disease")."</td>";
            $out .= "</tr>";
            $out .= "<tr>";
            $out .= "<td  align='right'>".getPrompt("Name of patient").":</td><td align='left' >".$this->patient->getFullName()."(".$this->patient->getValue("PID").")</td>";
            $out .= "<td  align='right'>".getPrompt("Date of Onset").":</td><td  align='left' >";
            if (!$this->epicode->getValue("OnSetDate")){$out .= $this->epicode->getValue("OnSetDate"); }
            else { $out .= "-"; }
            $out .= "</td>";
            $out .= "</tr>";
            $out .= "<tr>";
                $out .= "<td  align='right'>".getPrompt("Guardian").":</td><td align='left' >-</td>";
                if ($this->epicode_type == "Admission") {
                    $out .= "<td  align='right'>".getPrompt("Date of Admission").":</td><td  align='left' >".$this->epicode->getValue("AdmissionDate")."</td>";
                }
            $out .= "</tr>";
            $out .= "<tr>";
                $out .= "<td colspan=4>";
                    $out .= "<table  class='PrescriptionInfo' border=0 cellspacing=0 cellpadding=5 width=100%>";
                    $out .= "<tr>";
                    if ($this->epicode_type == "Admission") {
                        $out .= "<td align='right'  nowrap>".getPrompt("BHT No").":</td><td align='left' nowrap>".$this->epicode->getValue("BHT")."</td>";
                        $out .= "<td align='right'  nowrap>".getPrompt("Ward").":</td><td align='left' nowrap>".$this->ward->getValue("Name")."</td>";
                    }
                    else if ($this->epicode_type == "Opd") {
                        $out .= "<td align='right'  nowrap>".getPrompt("Ward").":</td><td align='left' nowrap>OPD</td>";
                    }
                    $out .= "<td align='right'  nowrap>".getPrompt("Age").":</td><td align='left' nowrap>".$this->patient->getAge('y')."</td>";
                    $out .= "<td align='right'  nowrap>".getPrompt("Sex").":</td><td align='left' nowrap>".$this->patient->getValue("Gender")."</td>";
                    $out .= "</tr>";
                    $out .= "</table>";
                $out .= "</td>";
            $out .= "</tr>";
             $out .= "<tr>";
                $out .= "<td width=156 nowrap  align='right'>".getPrompt("Laboratory Results").":</td><td align='left' >".$pat_lab_d."</td>";
                $out .= "<td ></td><td  align='left' ></td>";
            $out .= "</tr>";           
            $out .= "<tr>";
                $out .= "<td width=100  align='right'>".getPrompt("Home Address").":</td><td align='left' colspan=3>".$this->patient->getAddress("txt")."</td>";
            $out .= "</tr>";           
            $out .= "<tr>";
                $out .= "<td width=100 nowrap align='right'>".getPrompt("Patient's Home Telephone").":</td><td align='left' colspan=3>".$this->patient->getValue("Telephone")."</td>";
            $out .= "</tr>";           
            $out .= "<tr>";
                $out .= "<td width=100 nowrap align='right'>".getPrompt("Remarks").":</td><td align='left' colspan=3>".$this->getValue("Remarks")."  ".$this->patient->getValue("Remarks")."</td>";
            $out .= "</tr>";           
            $out .= "<tr>";
                $out .= "<td width=100 nowrap align='right'>".getPrompt("Date of Notification").":</td><td align='left' colspan=3>".date(DATE_RFC822)."</td>";
            $out .= "</tr>";  
            $out .= "<tr>";
                $out .= "<td align='left' colspan=4 align='right'>Notification Confirmed by: ".$this->doctor->getFullName().", Sent By: ".getLoggedUser()."<br><i>Automatically generated by HHMIS patient record database system. </i></td>";
            $out .= "</tr>";             
            $out .= "</table>";
            //$out .= "Status".$this->sendMail();
            return $out;            
        }
        public function sendMail(){
            include_once 'MDSPermission.php';
            $mdsPermission = MDSPermission::GetInstance();
            if (!$mdsPermission->haveAccess($_SESSION["UGID"],"notification_Edit")) {
					echo mdsError("You dont have enough permission to Edit/Send a 'Notification' <br> Contact your system Administrator!");
					return;
            }
            include_once 'MDSMail.php';
            $this->init();
            $header = "";
            if (strtoupper(substr(PHP_OS,0,3)=='WIN')) { 
              $eol="\r\n"; 
            } elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) { 
              $eol="\r"; 
            } else { 
              $eol="\n"; 
            }
            $headers .= "Content-type: text/html".$eol; ; 
            $headers .= 'From: MDSFoss.org <mailer@mdsfoss.org>'.$eol; 
            $headers .= 'Reply-To: MDSFoss.org <mailer@mdsfoss.org>'.$eol; 
            //$headers .= "Message-ID:<".$now." mailer@".$_SERVER['SERVER_NAME'].">".$eol; 
            $headers .= "X-Mailer: PHP v".phpversion().$eol;           // These two to help avoid spam-filters 
            $mdsmail= new MDSMail();
            $mdsmail->setTo($this->getValue("TOID"));
            $mdsmail->setFrom($this->getValue("TOID"));
            $mdsmail->setSubject($this->subject);
            $mdsmail->setMessage($this->mailCompose());
            $mdsmail->setHeader($headers);
            return $mdsmail->send();
            
        }
	public function check( $epid, $disease ){
            	$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql=" SELECT NOTIFICATION_ID FROM notification WHERE  ( EPISODEID = '".$epid."' ) AND( Disease = '".$disease."' )  ORDER BY NOTIFICATION_ID ";
		$result=$mdsDB->mysqlQuery($sql); 
                $count = $mdsDB->getRowsNum($result);
                if ( $count == 0 ) {
                    return 0;
                }
                else {
                    $row = $mdsDB->mysqlFetchArray($result);
                    return $row["NOTIFICATION_ID"];
                }
        }       
        
}

?>