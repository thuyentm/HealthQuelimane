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
class MDSExam extends MDSPersistent
{
	private static $instance; 
	private $table = "patient_exam";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
	

	public function getData($pid){
		$data = " var myChart = new JSChart('graph', 'line'); \n";
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$sql = "select * from ".$this->TableName." where PID = '".$pid."' order by ExamDate ";
		$result=$mdsDB->mysqlQuery($sql); 
		$count = $mdsDB->getRowsNum($result);
		if ($count == 0) return NULL;
		$data .= " myChart.setDataArray([ \n";
		while($row = $mdsDB->mysqlFetchArray($result))  {
			if (!$row["PATEXAMID"])return null;
			$data .= " [1, 80],";
		}	
		$data = substr_replace( $data, "", -1 );
		$data .= "], 'blue'); \n";

		/*
			var myChart = new JSChart('graph', 'line');

			myChart.setDataArray([[1, 80],[2, 40],[3, 60],[4, 65],[5, 50],[6, 50],[7, 60],[8, 80],[9, 150],[10, 100]], 'blue');
		*/
		$mdsDB->close();	
		return 	$data;	
	}

}

?>