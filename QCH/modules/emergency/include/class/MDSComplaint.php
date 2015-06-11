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
class MDSComplaint extends MDSPersistent
{
	private static $instance; 
	private $table = "complaints";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		parent::__construct($this->table);
	}
	

	public function isNotify($cmp){
                $count = 0;
                $mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
                $comp = $cmp;
                $find[] = '&gt;';
                $replace[] = '>';
                $comp = str_replace($find, $replace, $cmp);
                $pieces = explode(",", $comp);
		$sql=" SELECT isNotify FROM complaints WHERE ";
                if (count($pieces)>0){
                    $sql .="(";
                    for ($i=0; $i<count($pieces); ++$i){
                        $sql .="( Name like '".$pieces[$i]."' ) OR";
                    }
                }
                $sql = substr_replace( $sql, "", -2 );
                $sql .=")";
                $sql .="   and (Active = '1') and (isNotify = '1') ";
		$result=$mdsDB->mysqlQuery($sql); 
		if (!$result) { echo "ERROR getting Lab Items"; return null; }
		$count = $mdsDB->getRowsNum($result);
                return $count;
	}
}

?>