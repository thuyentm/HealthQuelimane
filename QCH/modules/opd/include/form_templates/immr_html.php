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

//include_once 'mds_reporter/MDSReporter.php';
include_once('fpdf/fpdf.php');
include '../config.php'; // Config file contains all table,fields configurations.
include_once '../class/MDSAdmission.php';
include_once '../class/MDSPatient.php';
include_once '../class/MDSHospital.php';
include_once '../class/MDSDataBase.php';

    $IMMR = array();
     $sdate = "";
     $fdate = "";
     
     
    $lbht   = '';          //Last BHT number of the quarter (General Admission)
     $fbht   = '';                 //First BHT number of the quarter (General Admission)
     $diff_bht   = '';         //Difference in BHT number of the quarter (General Admission)
     $lba   = '';          //Last BHT number of the quarter (Accident Services)
     $fba   = '';                 //First BHT number of the quarter (Accident Services)
     $dba   = '';         //Difference in BHT number of the quarter (Accident Services)
     $lbu   = '';            //Last BHT number of the quarter (PCU)
     $fbu   = '';                //First BHT number of the quarter (PCU)
     $dbu   = '';          //Difference in BHT number of the quarter (PCU)
     $lbp   = '';            //Last BHT number of the quarter (Paying section)
     $fbp   = '';                 //First BHT number of the quarter (Paying section)
     $dbp   = '';            //Difference in BHT number of the quarter (Paying section)
     $lbt    = '-';            //Last BHT number of the quarter (Total Admissions)
     $fbt    = '-';                 //First BHT number of the quarter (Total Admissions)
     $dbt    = '';           //Difference in BHT number of the quarter (Total Admissions)
    
     $yer  = '';              // Year
     $qur  = '';                  // Quarter
    
     $aaa  = 0;               //Number of patients remaining in hosp. at beginning of quarter
     $bbb  = 0;          //Number of patients admitted during the quarter
     $ccc   = 0;         // Number discharged alive (excl. transfers)
     $ddd  = 0;                 // Number transferred to other hospitals
     $eee  = 0;                 //Number of deaths within 48 hours of admission
     $fff  = 0;                 //Total hospital deaths
     $ggg  = 0;               //Number of patients in hospital at the end of the quarter
     $hhh  = 0;                   //Number of missing BHTs
     $iii      = 0;       //Total patient days
     $jjj      = 0;              //Patient beds    
/*
class PDF extends FPDF  {

    

            
        
    function printFirstPage(){
                            // Document variables (to be passed to the script) - defined here for testing
                $hospital = New MDSHospital();
                $hospital->openDefaultHospital();
                $hos = $hospital->getValue('Name'); // Institute
                $rdh  = $hospital->getValue('Address_DSDivision');    // RDHS Division
                $dsd  = $hospital->getValue('Address_District');    // DS Division
                $tel   = $hospital->getValue('Telephone1'); // Inst telephone number
                $beds  = $hospital->getBedCount();  
                //$this->aaa  = $hospital->getPatientCountBeforeQuarter();  
                $this->jjj = $beds;
                $this->yer  = $_GET["year"];              // Year
                $this->qur  = $_GET["quarter"];                  // Quarter
                if ($this->qur == 1) {
                    $sdate = mktime(0, 0, 0, 1, 1, $this->yer);
                    $fdate = mktime(0, 0, 0, 3, 31, $this->yer);
                }else if ($this->qur == 2){
                    $sdate = mktime(0, 0, 0, 4, 1, $this->yer);
                    $fdate = mktime(0, 0, 0, 6, 30, $this->yer);
                }else if ($this->qur == 3){
                    $sdate = mktime(0, 0, 0, 7, 1, $this->yer);
                    $fdate = mktime(0, 0, 0, 9, 30, $this->yer);
                }else if ($this->qur == 4){
                    $sdate = mktime(0, 0, 0, 10, 1, $this->yer);
                    $fdate = mktime(0, 0, 0, 12, 31, $this->yer);
                }
                $this->aaa  = $hospital->getPatientCountBeforeQuarter(date("Y-m-d",$sdate),date("Y-m-d",$fdate));
                $this->ggg  =$hospital->getPatientCountRemainQuarter(date("Y-m-d",$sdate),date("Y-m-d",$fdate));
                                        // TSR:Here goes the code for printing the first page
                            // There is less indent before each SetXY() so that they are easy to find
                                        $this->addPage();
                                        $this->SetAutoPageBreak(0);
                                        $this->SetFont('Times','',12);
                        $this->SetXY(245,5);
                                        $this->Cell(30,5,'IMMR/100/R09',0,1,'L');
                                        $this->SetFont('Times','B',14);
                        $this->SetXY(60,10);
                                        $this->Cell(180,5,'REPORT ON INDOOR MORBIDITY AND MORTALITY IN HOSPITALS',0,1,'C');
                                        $this->SetFont('Times','',12);
                        $this->SetXY(25,25);
                                        $this->Cell(60,10,'Name of Institution:',0,2,'L');
                                        $this->Cell(60,10,'RDHS Division:',0,2,'L');
                                        $this->Cell(60,10,'Divisional Secretary Division:',0,2,'L');
                        $this->SetXY(85,25);
                                        $this->SetFont('Times','B',12);
                                        $this->Cell(120,10,$hos,0,2,'L');
                                        $this->Cell(120,10,$rdh,0,2,'L');
                                        $this->Cell(120,10,$dsd,0,2,'L');
                        $this->SetXY(200,25);
                                        $this->SetFont('Times','',12);
                                        $this->Cell(40,10,'Telephone number:',0,2,'L');
                                        $this->Cell(25,10,'Year:',0,2,'L');
                                        $this->Cell(20,10,'Quarter:',0,2,'L');
                        $this->SetXY(245,25);
                                        $this->SetFont('Times','B',12);
                                        $this->Cell(40,10,$tel,0,2,'L');
                                        $this->Cell(20,10,$this->yer,0,2,'C');
                                        $this->Cell(20,5,$this->qur,1,2,'C');
                        $this->SetXY(25,55);
                                        $this->SetFont('Times','BU',12);
                                        $this->Cell(250,5,'Important :',LTR,2,'L');
                                        $this->SetFont('Times','',12);
                                        $this->Cell(60,5,'Institutions under the Line Ministry :',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(60,5,'Institutions under RDHS :',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(60,5,'',L,2,'L');
                                        $this->Cell(65,5,'',LB,2,'L');
                        $this->SetXY(90,60);
                                        $this->Cell(95,5,'Complete two copies','',2,'L');
                                        $this->SetFont('Times','I',12);
                                        $this->Cell(60,5,'1. Retain one copy as office copy','',2,'L');
                                        $this->Cell(60,5,'2. Forward one copy to Medical Statistics Unit','',2,'L');
                                        $this->Cell(60,5,'','',2,'L');
                                        $this->SetFont('Times','',12);
                                        $this->Cell(60,5,'Complete two copies','',2,'L');
                                        $this->SetFont('Times','I',12);
                                        $this->Cell(60,5,'1. Retain one copy as office copy','',2,'L');
                                        $this->Cell(60,5,'2. Forward one copy to Medical Statistics Unit','',2,'L');
                            $this->Cell(60,5,'   through RDHS','',2,'L');
                                        $this->SetFont('Times','',12);
                            $this->Cell(95,5,'','B',2,'L');
                        $this->SetXY(185,60);
                                        $this->Cell(90,5,'N.B.: Request for new Indoor and Mortality',R,2,'L');
                                        $this->Cell(90,5,'Register should be made to',R,2,'L');
                                        $this->Cell(90,5,'   Director',R,2,'L');
                                        $this->Cell(90,5,'   Medical Statistics Unit',R,2,'L');
                                        $this->Cell(90,5,'   "Suwasiripaya",Ministry of Health',R,2,'L');
                                        $this->Cell(90,5,'   385,Rev. Baddegama Wimalawansa Thero MW,',R,2,'L');
                                        $this->Cell(90,5,'   Colombo 10.',R,2,'L');
                                        $this->SetFont('Times','B',12);
                                        $this->Cell(90,5,'   Telephone: 011 - 269 5734',R,2,'L');
                                        $this->SetFont('Times','',12);
                                        $this->Cell(90,5,'   E-mail: ',RB,2,'L');
                        $this->SetXY(25,105);
                                        $this->SetFont('Times','B',11);
                            $this->Cell(250,5,'For office use only  (Do not write anything below this line)',LTRB,2,'C');
                                        $this->SetFont('Times','',12);
                        $this->SetXY(25,110);
                                        $this->Cell(120,5,'Date received',LR,2,'L');
                                        $this->Cell(120,85,'',LBR,2,'L');
                        $this->SetXY(145,110);
                            $this->Cell(60,5,'Date of review by supervisor',BR,2,'L');
                                        $this->Cell(130,5,'Data entry',1,2,'C');
                            $this->Cell(60,10,'Data entry operator',BR,2,'L');
                            $this->Cell(60,10,'Date assigned to DEO',BR,2,'L');
                            $this->Cell(60,10,'Date handed over to supervisor',R,2,'L');
                                        $this->Cell(130,5,'Verification',1,2,'C');
                            $this->Cell(60,10,'Verifier',R,2,'L');
                                        $this->Cell(130,5,"Verifier's findings",1,2,'C');
                            $this->Cell(40,20,'Correct and complete',1,2,'L');
                                        $this->Cell(130,10,"Signature and date",1,2,'L');
                            $this->SetXY(205,110);
                            $this->Cell(23,5,'DD',1,0,'C');
                            $this->Cell(24,5,'MM',1,0,'C');
                            $this->Cell(23,5,'YY',1,2,'C');
                        $this->SetXY(205,120);
                                        $this->SetFont('Times','U',12);
                            $this->Cell(23,10,'Code',1,2,'C');
                                        $this->SetFont('Times','',12);
                            $this->Cell(23,10,'DD',1,2,'C');
                            $this->Cell(23,10,'DD',1,2,'C');
                        $this->SetXY(228,120);
                                        $this->SetFont('Times','U',12);
                            $this->Cell(47,10,'Name',1,2,'C');
                                        $this->SetFont('Times','',12);
                            $this->Cell(23,10,'MM',1,2,'C');
                            $this->Cell(23,10,'MM',1,2,'C');
                        $this->SetXY(251,130);
                            $this->Cell(24,10,'YY',1,2,'C');
                            $this->Cell(24,10,'YY',1,2,'C');
                        $this->SetXY(205,155);
                                        $this->SetFont('Times','U',12);
                            $this->Cell(23,10,'Code',1,0,'C');
                            $this->Cell(47,10,'Name',1,2,'C');
                                        $this->SetFont('Times','',12);
                        $this->SetXY(185,170);
                            $this->Cell(20,10,'Wrong /','R',2,'L');
                            $this->Cell(20,10,'incomplete','R',2,'L');
                        $this->SetXY(205,170);
                            $this->Cell(70,5,'Date given back to DEO',1,2,'C');
                            $this->Cell(23,15,'DD',1,0,'C');
                            $this->Cell(23,15,'MM',1,0,'C');
                            $this->Cell(24,15,'YY',1,0,'C');
                        $this->SetXY(220,200);
                            $this->Cell(40,5,'(Revised in October,2009)',0,0,'L');
    }
            
    function printSummaryPage(){
 

            $this->addPage();
            $this->SetAutoPageBreak(0);
            $this->SetFont('Times','BU',14);
$this->SetXY(60,10);
            $this->Cell(180,5,'FINAL SUMMARY',0,1,'C');
$this->SetFont('Times','',10);
$this->SetXY(5,25);
$w=29;
            $this->Cell($w,10,'',1,2,'L');
            $this->Cell($w,5,'General Admission',1,2,'L');
            $this->Cell($w,5,'Accident Services*',1,2,'L');
            $this->Cell($w,5,'PCU*',1,2,'L');
            $this->Cell($w,5,'Paying Section*',1,2,'L');
            $this->Cell($w,5,'Total Admissions',1,2,'L');
$this->SetXY(34,25);
$w=27;
            $this->Cell($w,5,'Last BHT Number',TR,2,'C');
            $this->Cell($w,5,'of the quarter (i)',BR,2,'C');
            $this->Cell($w,5,$this->lbht,1,2,'R');
            $this->Cell($w,5,$this->lba,1,2,'R');
            $this->Cell($w,5,$this->lbu,1,2,'R');
            $this->Cell($w,5,$this->lbp,1,2,'R');
            $this->Cell($w,5,$this->lbt,1,2,'R');
$this->SetXY(61,25);
$w=27;
            $this->Cell($w,5,'First BHT Number',TR,2,'C');
            $this->Cell($w,5,'of the quarter (ii)',BR,2,'C');
            $this->Cell($w,5,$this->fbht,1,2,'R');
            $this->Cell($w,5,$this->fba,1,2,'R');
            $this->Cell($w,5,$this->fbu,1,2,'R');
            $this->Cell($w,5,$this->fbp,1,2,'R');
            $this->Cell($w,5,$this->fbt,1,2,'R');
$this->SetXY(88,25);
$w=27;
            $this->Cell($w,5,'(i) - (ii)',TR,2,'C');
            $this->Cell($w,5,'',BR,2,'C');
            $this->Cell($w,5,$this->diff_bht,1,2,'R');
            $this->Cell($w,5,$this->dba,1,2,'R');
            $this->Cell($w,5,$this->dbu,1,2,'R');
            $this->Cell($w,5,$this->dbp,1,2,'R');
            $this->Cell($w,5,$this->diff_bht,1,2,'R');
$this->SetXY(5,70);
$w=30;        
            $this->Cell($w,10,'Year:',0,0,'L');
            $this->Cell($w,10,$this->yer,0,0,'L');
            $this->Cell($w,10,'Quarter:',0,0,'L');
            $this->Cell($w,10,$this->qur,0,0,'L');
$this->SetXY(117,25);
$w=10;
            $this->Cell($w,5,'Item',LTR,2,'C');
            $this->Cell($w,5,'',LBR,2,'C');
            $this->Cell($w,5,A,1,2,'C');
            $this->Cell($w,5,B,1,2,'C');
            $this->Cell($w,5,C,1,2,'C');
            $this->Cell($w,5,D,1,2,'C');
            $this->Cell($w,5,E,1,2,'C');
            $this->Cell($w,5,F,1,2,'C');
            $this->Cell($w,5,G,1,2,'C');
            $this->Cell($w,5,H,1,2,'C');
            $this->Cell($w,5,I,1,2,'C');
            $this->Cell($w,5,J,1,2,'C');
$this->SetXY(127,25);
$w=130;
$this->SetFont('Times','BU',14);
            $this->Cell($w,10,'Hospital Statistics',1,2,'C');
$this->SetFont('Times','',10);
            $this->Cell($w,5,'Number of patients remaining in hospital at the beginning of the quarter',1,2,'L');
            $this->Cell($w,5,'Number of patients admitted during the quarter',1,2,'L');
            $this->Cell($w,5,'Number discharged alive from the hospital (Excluding the transfers)',1,2,'L');
            $this->Cell($w,5,'Number transferred to other hospitals',1,2,'L');
            $this->Cell($w,5,'Number of deaths occurring within 48 hours of admission to the hospital',1,2,'L');
            $this->Cell($w,5,'Total hospital deaths',1,2,'L');
            $this->Cell($w,5,'Number of patients remaining in the hospital at the end of the quarter',1,2,'L');
            $this->Cell($w,5,'Number of missing BHTs',1,2,'L');
$this->SetFont('Times','',8);
            $this->Cell($w,5,'Total patient days (arrived at by adding the daily count of all patients resident in the hospital during the quarter',1,2,'L');
$this->SetFont('Times','',10);
            $this->Cell($w,5,'Patient beds (excluding labour, examination and unserviceable)',1,2,'L');
$this->SetXY(257,25);
$w=25;
            $this->Cell($w,5,'Indicator',LTR,2,'C');
            $this->Cell($w,5,'',LBR,2,'C');
            $this->Cell($w,5,$this->aaa,1,2,'R');
            $this->Cell($w,5,$this->bbb,1,2,'R');
            $this->Cell($w,5,$this->ccc,1,2,'R');
            $this->Cell($w,5,$this->ddd,1,2,'R');
            $this->Cell($w,5,$this->eee,1,2,'R');
            $this->Cell($w,5,$this->fff,1,2,'R');
            $this->Cell($w,5,$this->ggg,1,2,'R');
            $this->Cell($w,5,$this->hhh,1,2,'R');
            $this->Cell($w,5,$this->iii,1,2,'R');
            $this->Cell($w,5,$this->jjj,1,2,'R');
$this->SetFont('Times','BU',10);
$this->SetXY(5,95);
$w=140;
            $this->Cell($w,5,'For the preparing officer',LTR,2,'L');
$this->SetFont('Times','',10);
            $this->Cell($w,5,'Important: The returns must be prepared with great care. It is your responsibility for',LR,2,'L');
            $this->Cell($w,5,'accuracy, timeliness and reality of the data.',LBR,2,'L');
$this->SetFont('Times','I',10);
$w=20;
            $this->Cell($w,10,'Prepared by',LT,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',LB,2,'L');
$this->SetXY(25,110);
$w=40;
            $this->Cell($w,10,'Name',T,2,'L');
            $this->Cell($w,6,'Designation',0,2,'L');
            $this->Cell($w,6,'Signature',0,2,'L');
            $this->Cell($w,6,'Direct/mobile number',0,2,'L');
            $this->Cell($w,6,'Date',B,2,'L');
$this->SetXY(65,110);
$w=80;
            $this->Cell($w,10,'............................................................',TR,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',BR,2,'L');
$this->SetFont('Times','BU',10);
$this->SetXY(145,95);
$w=140;
            $this->Cell($w,5,'For the certifying officer',LTR,2,'L');
$this->SetFont('Times','',10);
            $this->Cell($w,5,'Please ensure that an Indoor Morbidity and Mortality Register is maintained. A random check',LR,2,'L');
            $this->Cell($w,5,'of the entries made in this return should be done before certifying.',LBR,2,'L');
$this->SetFont('Times','I',10);
$w=20;
            $this->Cell($w,10,'Certified by',LT,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',L,2,'L');
            $this->Cell($w,6,'',LB,2,'L');
$this->SetXY(165,110);
$w=40;
            $this->Cell($w,10,'Name',T,2,'L');
            $this->Cell($w,6,'Designation',0,2,'L');
            $this->Cell($w,6,'Signature',0,2,'L');
            $this->Cell($w,6,'Direct/mobile number',0,2,'L');
            $this->Cell($w,6,'Date',B,2,'L');
$this->SetXY(205,110);
$w=80;
            $this->Cell($w,10,'............................................................',TR,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',R,2,'L');
            $this->Cell($w,6,'............................................................',BR,2,'L');
$this->SetFont('Times','',10);
$this->SetXY(5,170);
$w=280;
            $this->Cell($w,5,'* According to the general circular (circular number: 01-05 / 99), all inpatient admissions must be in one admission source for all sections. (If any institution maintains separate admission registers',0,2,'L');
            $this->Cell($w,5,'or separate systems e.g., General Admission, Accident Service Admissions, Primary Care Admissions or Admissions to the Paying Section etc., they may be advised to maintain/prepare separate',0,2,'L');
            $this->Cell($w,5,'IMMR reports for each section. This method can be useful for maintaining the accuracy of the hospital records.)',0,2,'L');
$this->SetXY(130,200);
            $this->Cell(20,5,'Page 19',0,2,'C');
    }		
  
    function printPageHeaderOdd(){
                ///TSR:Here goes the code for printing the page header
                // Set the x,y coordinates of the cursor
    $this->SetFont('Times','',10);
        $this->SetXY(10,5);
                $this->SetAutoPageBreak(0);
                $this->Cell(180,20,'Disease Group',1,0,'C');
                $this->Cell(90,5,'Live Discharges',1,2,'C');
                $this->Cell(10,15,'Dis.Gr.',1,0,'C');
                $this->Cell(80,5,'Male by Age group',1,2,'C');
                $this->Cell(10,5,'< 1',1,0,'C');
                $this->Cell(10,5,'1 - 4',1,0,'C');
                $this->Cell(10,5,'5 - 16',1,0,'C');
                $this->Cell(10,5,'17 - 49',1,0,'C');
                $this->Cell(10,5,'50 - 69',1,0,'C');
                $this->Cell(10,5,'70 - +',1,0,'C');
                $this->Cell(10,5,'N/Av',1,0,'C');
                $this->Cell(10,5,'Total',1,0,'C');
        $this->SetXY(200,20);
                $this->Cell(10,5,'1',1,0,'C');
                $this->Cell(10,5,'2',1,0,'C');
                $this->Cell(10,5,'3',1,0,'C');
                $this->Cell(10,5,'4',1,0,'C');
                $this->Cell(10,5,'5',1,0,'C');
                $this->Cell(10,5,'6',1,0,'C');
                $this->Cell(10,5,'7',1,0,'C');
                $this->Cell(10,5,'8',1,0,'C');
    }
        
		function printPageHeaderEven(){
			///TSR:Here goes the code for printing the even page header
		$this->SetXY(10,5);
			$this->SetAutoPageBreak(0);
			$this->Cell(90,5,'Live Discharges',1,2,'C');
			$this->Cell(10,15,'Dis.Gr.',1,0,'C');
			$this->Cell(80,5,'Female by Age group',1,2,'C');
			$this->Cell(10,5,'< 1',1,0,'C');
			$this->Cell(10,5,'1 - 4',1,0,'C');
			$this->Cell(10,5,'5 - 16',1,0,'C');
			$this->Cell(10,5,'17 - 49',1,0,'C');
			$this->Cell(10,5,'50 - 69',1,0,'C');
			$this->Cell(10,5,'70 - +',1,0,'C');
			$this->Cell(10,5,'N/Av',1,0,'C');
			$this->Cell(10,5,'Total',1,0,'C');
		$this->SetXY(20,20);
			$this->Cell(10,5,'9',1,0,'C');
			$this->Cell(10,5,'10',1,0,'C');
			$this->Cell(10,5,'11',1,0,'C');
			$this->Cell(10,5,'12',1,0,'C');
			$this->Cell(10,5,'13',1,0,'C');
			$this->Cell(10,5,'14',1,0,'C');
			$this->Cell(10,5,'15',1,0,'C');
			$this->Cell(10,5,'16',1,0,'C');
		$this->SetXY(100,5);
			$this->Cell(180,5,'Deaths',1,2,'C');
			$this->Cell(10,15,'Dis.Gr.',1,0,'C');
			$this->Cell(80,5,'Male by Age group',1,2,'C');
			$this->Cell(10,5,'< 1',1,0,'C');
			$this->Cell(10,5,'1 - 4',1,0,'C');
			$this->Cell(10,5,'5 - 16',1,0,'C');
			$this->Cell(10,5,'17 - 49',1,0,'C');
			$this->Cell(10,5,'50 - 69',1,0,'C');
			$this->Cell(10,5,'70 - +',1,0,'C');
			$this->Cell(10,5,'N/Av',1,0,'C');
			$this->Cell(10,5,'Total',1,0,'C');
		$this->SetXY(110,20);
			$this->Cell(10,5,'17',1,0,'C');
			$this->Cell(10,5,'18',1,0,'C');
			$this->Cell(10,5,'19',1,0,'C');
			$this->Cell(10,5,'20',1,0,'C');
			$this->Cell(10,5,'21',1,0,'C');
			$this->Cell(10,5,'22',1,0,'C');
			$this->Cell(10,5,'23',1,0,'C');
			$this->Cell(10,5,'24',1,0,'C');
		$this->SetXY(190,10);
			$this->Cell(10,15,'Dis.Gr.',1,0,'C');
			$this->Cell(80,5,'Female by Age group',1,2,'C');
			$this->Cell(10,5,'< 1',1,0,'C');
			$this->Cell(10,5,'1 - 4',1,0,'C');
			$this->Cell(10,5,'5 - 16',1,0,'C');
			$this->Cell(10,5,'17 - 49',1,0,'C');
			$this->Cell(10,5,'50 - 69',1,0,'C');
			$this->Cell(10,5,'70 - +',1,0,'C');
			$this->Cell(10,5,'N/Av',1,0,'C');
			$this->Cell(10,5,'Total',1,0,'C');
		$this->SetXY(200,20);
			$this->Cell(10,5,'25',1,0,'C');
			$this->Cell(10,5,'26',1,0,'C');
			$this->Cell(10,5,'27',1,0,'C');
			$this->Cell(10,5,'28',1,0,'C');
			$this->Cell(10,5,'29',1,0,'C');
			$this->Cell(10,5,'30',1,0,'C');
			$this->Cell(10,5,'31',1,0,'C');
			$this->Cell(10,5,'32',1,0,'C');
		}
		
		function printEvenPageData($even_data){
			$even_i = 0;
            $this->SetXY(10,25);               
			$this->SetFont('Times', '', 9);
			for ($even_i = 0; $even_i < count($even_data); $even_i++) {
				if ($even_data[$even_i] == "cat") {  
					$this->Cell(270,5,'',1,1,'L'); // TSR : Blank space fot IMMR Category
					$even_i++;
				}					
				$this->Cell(10,5,$even_data[$even_i],1,0,'C');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][9],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][10],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][11],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][12],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][13],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][14],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][15],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][16],1,0,'R');
						
				$this->Cell(10,5,$even_data[$even_i],1,0,'C');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][17],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][18],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][19],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][20],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][21],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][22],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][23],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][24],1,0,'R');

				$this->Cell(10,5,$even_data[$even_i],1,0,'C');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][25],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][26],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][27],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][28],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][29],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][30],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][31],1,0,'R');
				$this->Cell(10,5,$this->IMMR[$even_data[$even_i]]["data"][32],1,0,'R');
						
				$this->SetXY(10,25+5*($even_i+1));
			}		
		}
		
                

        function plotData(){
            $this->printFirstPage();
            $this->addPage();
            $this->printPageHeaderOdd();
            $this->SetXY(10,25); 

            $i = 0; // the number of the row of data (IMMR code amd IMMR text - currently not the calculations)
            $cat = "";
            $even_data = array();

            $con = mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
            mysql_select_db(DB) or die("cannot select DB");
            $sql=" SELECT  * FROM immr ";
            $result = mysql_query($sql);
            if (!$result) {
                    $this->addPage();
                    $this->Cell(200,5,'ERROR : Connection',1,2,'C');
                    return null;
            }
                     
            while($row = mysql_fetch_array($result))  {
                                     
                        $this->SetFont('Times', 'BU', 9);
                        if ($cat != $row["Category"]) {  // this checks whether the category has changed and if so prints it
                                $this->Cell(270,5,$row["Category"],1,1,'L');
                                $cat = $row["Category"];
                                array_push($even_data,"cat"); 
                                $i++;
                        }
                        $this->SetFont('Times', '', 9);
                        $this->Cell(10,5,$row["Code"],1,0,'C',false);
                        //,'http://'.$_SERVER['SERVER_NAME'].'/home.php?page=search'
                        $this->Cell(170,5,$row["Name"],1,0,'L');
                        $this->Cell(10,5,$row["Code"],1,0,'C');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][1],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][2],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][3],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][4],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][5],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][6],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][7],1,0,'R');
                        $this->Cell(10,5,$this->IMMR[$row["Code"]]["data"][8],1,0,'R');
                        $this->SetXY(10,25+5*($i+1));
                        array_push($even_data, $row["Code"]); // TSR: Storing the IMMR data code for later use for printing the even page
                        $i++;
                        if ( $i == 34 ) {  //after 35 rows of IMMR data and categories throws a new page
                        //
                        // This is where the even page should be printed
                        // -------------------------------------------------------------------------------------------------

                                $i = 0;
                                $this->addPage();
                                $this->printPageHeaderEven();
                                $this->printEvenPageData($even_data);
                        //--------------------------------------------------------------------------------------------------
                                $even_data = array(); //reset the array
                                $this->addPage();
                                $this->printPageHeaderOdd();
                                $this->SetXY(10,25);
                        }
             }
             $i = 0;
                $this->addPage();
                $this->printPageHeaderEven();
                $this->printEvenPageData($even_data);
                $this->printSummaryPage();
            }
        
} //class
*/
//$pdf = new PDF('L','mm','A4');
//define('FPDF_FONTPATH', 'fpdf/font/');
//$pdf->AddFont('Times', '', 'times.php');
//$pdf->AddFont('Times', 'B', 'timesbd.php');
//$pdf->AddFont('Times', 'BI', 'timesbi.php');
//$pdf->AddFont('Times', 'I', 'timesi.php');
//
//$pdf->loadData();
//$pdf->plotData();
////$pdf->Output();
//$pdf->Output("immr_report.pdf","I");


		function loadData() {
			$i = 0; // the number of the row of data (IMMR code amd IMMR text - currently not the calculations)
			$cat = "";
			$even_data = array();
                        
			$con = mysql_connect(HOST, USERNAME, PASSWORD) or die("cannot connect"); 
			mysql_select_db(DB) or die("cannot select DB");
			$sql=" SELECT  * FROM immr ";
			$result = mysql_query($sql);
			if (!$result) {
				//$this->addPage();
				//$this->Cell(200,5,'ERROR : Connection',1,2,'C');
				return null;
			}

			while($row = mysql_fetch_array($result))  {
                           // $ICDForm["FLD"][0]=array(
                                  //  "Id"=>"Code", "Name"=>"Code",
                                  //  "Type"=>"text",  "Value"=>"",
                                  //  "Help"=>"ICD Code", "Ops"=>"",
                                  //  "valid"=>"*"
                                 //   );
 
                            //$this->IMMR[$row["Code"]]["cat"]=$row["Category"];
                            //$this->IMMR[$row["Code"]]["code"]=$row["Code"];
                            //$this->IMMR[$row["Code"]]["name"]=$row["Name"];
                            $IMMR[$row["Code"]]["data"]=array(
                                "1"=>"","2"=>"","3"=>"","4"=>"","5"=>"","6"=>"","7"=>"","8"=>"",
                                "9"=>"","10"=>"","11"=>"","12"=>"","13"=>"","14"=>"","15"=>"","16"=>"",
                                "17"=>"","18"=>"","19"=>"","20"=>"","21"=>"","22"=>"","23"=>"","24"=>"",
                                "25"=>"","26"=>"","27"=>"","28"=>"","29"=>"","30"=>"","31"=>"","32"=>""
                            );
                            
                            
        
			}
                        $year  = $_GET["year"];              // Year
                        $qur  = $_GET["quarter"];           // Quarter
                        if ($qur == 1) {
                            $sdate = mktime(0, 0, 0, 1, 1, $year);
                            $fdate = mktime(0, 0, 0, 3, 31, $year);
                        }else if ($qur == 2){
                            $sdate = mktime(0, 0, 0, 4, 1, $year);
                            $fdate = mktime(0, 0, 0, 6, 30, $year);
                        }else if ($qur == 3){
                            $sdate = mktime(0, 0, 0, 7, 1, $year);
                            $fdate = mktime(0, 0, 0, 9, 30, $year);
                        }else if ($qur == 4){
                            $sdate = mktime(0, 0, 0, 10, 1, $year);
                            $fdate = mktime(0, 0, 0, 12, 31, $year);
                        }
                        else{
                            //$this->addPage();
                            //$this->Cell(200,5,'ERROR : Date , Quarter',1,2,'C');
                            return null;
                        }
                        //echo date("Y-m-d",$sdate)."-".date("Y-m-d",$fdate);
                        $sdate = $sdate;
                        $fdate = $fdate;
                        $mdsDB = MDSDataBase::GetInstance();
                        $mdsDB->connect();
                        $sql= " SELECT admission.ADMID, 
                            admission.DischargeDate, 
                            admission.AdmissionDate, 
                            admission.Discharge_IMMR_Code, 
                            admission.BHT, 
                            admission.OutCome, 
                            patient.DateOfBirth, 
                            patient.Gender 
                            from admission,patient  WHERE  
                            (admission.DischargeDate >= '".date("Y-m-d",$sdate)."') 
                                AND (admission.DischargeDate < '".date("Y-m-d",$fdate)."') 
                                AND (patient.PID = admission.PID)    ";
                        //Discharge_IMMR_Code
                        $result = $mdsDB->mysqlQuery($sql);
                        if (!$result) {
                            echo "ERROR".$sql;
                            return null;
                        }
                        $diff_bht=$count = $mdsDB->getRowsNum($result);
                        //echo $diff_bht;
                        $c = 0;
                        while ($row = $mdsDB->mysqlFetchArray($result)) {
                            
                                if ($row["ADMID"]>0){
                                       //$admission = new MDSAdmission();
                                    //$admission->openId($row["ADMID"]);
                           
                                    if ($c == 0){ $fbht = $row["BHT"]; $c++; } 
                                    $lbht = $row["BHT"];
                                   
                                    //$patient = MDSPatient::GetInstance();
                                    $immr_code = $row["Discharge_IMMR_Code"];
                                    
                                    $dischsrge_date = $row["DischargeDate"];
                                    $dob = $row["DateOfBirth"];
                                    $status = $row["OutCome"];
                                    $sex  = $row["Gender"];  
                                    
                                    if (($dischsrge_date)&&($dob)) $age = round(strtotime($dischsrge_date) - strtotime($dob))/86400/(365.35);
                                    else  $age = 999;
                                    if ($immr_code == "") $immr_code = "0245";
                                    
                                    if (($row["AdmissionDate"]>=date("Y-m-d",$sdate)) && ($row["AdmissionDate"] < date("Y-m-d",$fdate)))$bbb++;
                                    if (($status != "Died") && ($status != "Referred to another institution")) $ccc++;
                                    if ($status == "Referred to another institution") $ddd++;
                                    
                                    list ($yrs,$mths,$dys) = dateDifference($row["AdmissionDate"] , $row["DischargeDate"] ); 
                                    $iii += $dys;
                                    if (($status == "Died") && ($dys <= 2) ){$eee++;}
                                    if ($status == "Died") $fff++;
                                    if (($row["BHT"] == "") ) $hhh++;
                                    
                                    if (($sex == "Male") && ($age < 1) && ($status != "Died")){ $IMMR[$immr_code]["data"][1]++; $IMMR[$immr_code]["data"][8]++; continue; }
                                    if (($sex == "Male") && ($age < 5) && ($status != "Died")){ $IMMR[$immr_code]["data"][2]++; $IMMR[$immr_code]["data"][8]++; continue; }    
                                    if (($sex == "Male") && ($age < 17) && ($status != "Died")){ $IMMR[$immr_code]["data"][3]++; $IMMR[$immr_code]["data"][8]++; continue; }    
                                    if (($sex == "Male") && ($age < 50) && ($status != "Died")){ $IMMR[$immr_code]["data"][4]++; $IMMR[$immr_code]["data"][8]++; continue; }    
                                    if (($sex == "Male") && ($age < 70) && ($status != "Died")){ $IMMR[$immr_code]["data"][5]++; $IMMR[$immr_code]["data"][8]++; continue; }    
                                    if (($sex == "Male") && ($age < 999) && ($status != "Died")){ $IMMR[$immr_code]["data"][6]++; $IMMR[$immr_code]["data"][8]++; continue; } 
                                    if (($sex == "Male") &&  ($status != "Died")){ $IMMR[$immr_code]["data"][7]++; $IMMR[$immr_code]["data"][8]++; continue; }    
                                    
                                    if (($sex == "Female") && ($age < 1) && ($status != "Died")){ $IMMR[$immr_code]["data"][9]++; $IMMR[$immr_code]["data"][16]++; continue; }
                                    if (($sex == "Female") && ($age < 5) && ($status != "Died")){ $IMMR[$immr_code]["data"][10]++; $IMMR[$immr_code]["data"][16]++; continue; }    
                                    if (($sex == "Female") && ($age < 17) && ($status != "Died")){ $IMMR[$immr_code]["data"][11]++; $IMMR[$immr_code]["data"][16]++; continue; }    
                                    if (($sex == "Female") && ($age < 50) && ($status != "Died")){ $IMMR[$immr_code]["data"][12]++; $IMMR[$immr_code]["data"][16]++; continue; }    
                                    if (($sex == "Female") && ($age < 70) && ($status != "Died")){ $IMMR[$immr_code]["data"][13]++; $IMMR[$immr_code]["data"][16]++; continue; }    
                                    if (($sex == "Female") && ($age < 999) && ($status != "Died")){ $IMMR[$immr_code]["data"][14]++; $IMMR[$immr_code]["data"][16]++; continue; } 
                                    if (($sex == "Female") &&  ($status != "Died")){ $IMMR[$immr_code]["data"][15]++; $IMMR[$immr_code]["data"][16]++; continue; }    
                                    
                                    if (($sex == "Male") && ($age < 1) && ($status == "Died")){ $IMMR[$immr_code]["data"][17]++; $IMMR[$immr_code]["data"][24]++; continue; }
                                    if (($sex == "Male") && ($age < 5) && ($status == "Died")){ $IMMR[$immr_code]["data"][18]++; $IMMR[$immr_code]["data"][24]++; continue; }    
                                    if (($sex == "Male") && ($age < 17) && ($status == "Died")){ $IMMR[$immr_code]["data"][19]++; $IMMR[$immr_code]["data"][24]++; continue; }    
                                    if (($sex == "Male") && ($age < 50) && ($status == "Died")){ $IMMR[$immr_code]["data"][20]++; $IMMR[$immr_code]["data"][24]++; continue; }    
                                    if (($sex == "Male") && ($age < 70) && ($status == "Died")){ $IMMR[$immr_code]["data"][21]++; $MMR[$immr_code]["data"][24]++; continue; }    
                                    if (($sex == "Male") && ($age < 999) && ($status == "Died")){ $IMMR[$immr_code]["data"][22]++; $IMMR[$immr_code]["data"][24]++; continue; } 
                                    if (($sex == "Male") &&  ($status != "Died")){ $IMMR[$immr_code]["data"][23]++; $IMMR[$immr_code]["data"][24]++; continue; } 
                                    
                                    if (($sex == "Female") && ($age < 1) && ($status == "Died")){ $IMMR[$immr_code]["data"][25]++; $IMMR[$immr_code]["data"][32]++; continue; }
                                    if (($sex == "Female") && ($age < 5) && ($status == "Died")){ $IMMR[$immr_code]["data"][26]++; $IMMR[$immr_code]["data"][32]++; continue; }    
                                    if (($sex == "Female") && ($age < 17) && ($status == "Died")){ $IMMR[$immr_code]["data"][27]++; $IMMR[$immr_code]["data"][32]++; continue; }    
                                    if (($sex == "Female") && ($age < 50) && ($status == "Died")){ $IMMR[$immr_code]["data"][28]++; $IMMR[$immr_code]["data"][32]++; continue; }    
                                    if (($sex == "Female") && ($age < 70) && ($status == "Died")){ $IMMR[$immr_code]["data"][29]++; $IMMR[$immr_code]["data"][32]++; continue; }    
                                    if (($sex == "Female") && ($age < 999) && ($status == "Died")){ $IMMR[$immr_code]["data"][30]++; $IMMR[$immr_code]["data"][32]++; continue; } 
                                    if (($sex == "Female") &&  ($status != "Died")){ $IMMR[$immr_code]["data"][31]++; $IMMR[$immr_code]["data"][32]++; continue; } 
                                    
                                   
                                }
                        }
                       // echo $IMMR["0245"]["data"][1];
                        //echo print_r($this->IMMR);
			//$this->printSummaryPage();
                       
                    
        }
 function dateDifference($startDate, $endDate) 
        { 
            
            $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
            
            $years = $months = $days = 0;

            $two = $startDate; $one = $endDate;
            $invert = false;
            if ($one > $two) {
                list($one, $two) = array($two, $one);
                $invert = true;
            }

            $key = array("y", "m", "d", "h", "i", "s");
            $a = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $one))));
            $b = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $two))));

            $result = array();
            $result["y"] = $b["y"] - $a["y"];
            $result["m"] = $b["m"] - $a["m"];
            $result["d"] = $b["d"] - $a["d"];
            $result["h"] = $b["h"] - $a["h"];
            $result["i"] = $b["i"] - $a["i"];
            $result["s"] = $b["s"] - $a["s"];
            $result["invert"] = $invert ? 1 : 0;
            $result["days"] = intval(abs(($one - $two)/86400));

            if ($invert) {
                _date_normalize(&$a, &$result);
            } else {
                _date_normalize(&$b, &$result);
            }

           
            return array($result["y"], $result["m"], $result["d"]); 
        }         
        echo "ok";
        loadData();
        echo "ok";
?>
