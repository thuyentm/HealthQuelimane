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




include_once 'MDSPatient.php';
class MDSChart extends MDSPersistent
{
	private $patient = null;
	private $data = null;
	public function __construct($type) {
		if ($type == "patient_exam") {
			if (!$_GET["PID"]) return null;
			
			$patient = new MDSPatient();
			
			$patient->openId($_GET["PID"]);
			
			$this->patient = $patient;
		}
	}
	public function plot(){
		include_once 'MDSExam.php';
		$exams = new MDSExam();
		$header = $patInfo = $graph_div = $js ="";
		$header = loadHeader("Patient Examination Graph");
		$patInfo = $this->patient->patientBannerTiny();
		$graph_div .= "<div class='patientBanner'>";
		$graph_div .= "<div id='graph'>Loading graph...</div>";
		$graph_div .= "</div>";
		$this->data = $exams->getData($this->patient->getId());
		$js .= "<script language='javascript' >";
		$js .= $this->data;
		$js .= "</script>";
		
		echo $patInfo.$graph_div.$js;
	}
}

?>