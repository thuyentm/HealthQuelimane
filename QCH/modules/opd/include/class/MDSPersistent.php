<?php

session_start();

include_once 'MDSDataBase.php';
include_once 'MDSLogger.php';
include_once '../config.php';

class MDSPersistent
{
	public	$TableName = "";
	public $Fields = array();
	public $ObjField = NULL;
	private $isOpen = false;
	
	public function __construct($TableName) {
		$this->TableName = $TableName;
		$this->isOpen = false;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery('SHOW COLUMNS FROM '.$this->TableName.' FROM mds62 '); 
		
		if (!$result) {
			die('Query failed: ' . mysql_error().$mdsDB->logger);
		}
		
		$i = 0;
                while($row = mysql_fetch_array($result))  {
                    $this->Fields[$row["Field"]] = "";
                    if ($row["Key"] == "PRI"){
                        $this->ObjField = $row["Field"];
                    }
                }
                /*
                 
		while ($i < $mdsDB->getFieldsNum($result)) {
			$meta = $mdsDB->fetchField($result, $i);
			if (!$meta) {
				return NULL;
			}
			//$this->{$meta->name} = "";
			$this->Fields[$meta->name] = "";
			if ($meta->primary_key == 1) {
				$this->ObjField = $meta->name;
			}
			$i++;
		}
                */
		mysql_free_result($result);
		$mdsDB->close();
	} 
	
	function displayFields(){
		print_r($this->Fields);
	}
	public function setInActive(){
		if ((!$this->TableName)||(!$this->ObjField)) return NULL;
		$this->setValue("Active",0);
	}
	public function setActive(){
		if ((!$this->TableName)||(!$this->ObjField)) return NULL;
		$this->setValue("Active",1);
	}
	
	public function status($txt1,$txt2){
		if ($this->getValue("Active") == 1 ) {
			return $txt1;
		}
		else {
			return $txt2;
		}
	}
	function getValue($fld){
		//return $this->FirstName;
		if (array_key_exists($fld, $this->Fields)) {
			return $this->Fields[$fld];
		}
		else {
			return "Field Not Found";
		}
	}
	
	function setValue($fld,$val){
		if ($fld == $this->ObjField) return "NOT Permitted!";
		if (array_key_exists($fld, $this->Fields)) {
			$this->Fields[$fld] = $val;
		}
		else {
			return "Field Not Found";
		}		
	}
	public function setId($fld,$val){
		if (!isset($fld)||(!$fld)) return;
		if (array_key_exists($fld, $this->Fields)) {
			$this->Fields[$fld] = $val;
		}
		
	}
	private function setUpdateUser(){
		if (array_key_exists("LastUpDateUser", $this->Fields)) {
			$this->Fields["LastUpDateUser"] = $_SESSION["FirstName"]." ".$_SESSION["OtherName"];
			
		}
		if (array_key_exists("LastUpDate", $this->Fields)) {
			$this->Fields["LastUpDate"] = date("Y-m-d H:i:s");
		}
	
	}
	
	public function getHospital(){
		return $_SESSION["Hospital"];
	}
	private function setCreateUser(){
		if (array_key_exists("CreateUser", $this->Fields)) {
			$this->Fields["CreateUser"] = $_SESSION["FirstName"]." ".$_SESSION["OtherName"];
		}
		if (array_key_exists("CreateDate", $this->Fields)) {
			$this->Fields["CreateDate"] = date("Y-m-d H:i:s");
		}
	}	
	function openId($id){
		$this->isOpen = false;
		if (!id) return NULL;
		if ((!$this->TableName)||(!$this->ObjField)) return NULL;
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$result=$mdsDB->mysqlQuery("select * from ".$this->TableName." where ".$this->ObjField." = '".$id."' " ); 		
		$count = $mdsDB->getRowsNum($result);
		if ($count!=1) return NULL;
		$row = $mdsDB->mysqlFetchArray($result) or die(mysql_error());
		$i = 0;
		while ($i < $mdsDB->getFieldsNum($result)) {
			$meta = $mdsDB->fetchField($result, $i);
			if (!$meta) {
				$this->isOpen = false;
				return NULL;
			}
			$this->Fields[$meta->name] = $row[$i];
			$i++;
		}
		$mdsDB->close();
		if ($this->Fields[$this->ObjField]) {
			$this->isOpen = true;
			$this->registerObject();
			return $this->Fields[$this->ObjField];
		}
		else {
			$this->isOpen = false;
			return NULL;
		}
	}

	private function registerObject(){
		if ($this->ObjField == "UID") return;
		$_SESSION[$this->ObjField] = $this->getId();
	}
	
	function getId(){
		if (($this->isOpen)&&($this->Fields[$this->ObjField])) {
			return $this->Fields[$this->ObjField];
		}
		else {
			return NULL;
		}
	}
	
	function isOpen(){
		return $this->isOpen;
	}
	
	function save($ops){
		if ($this->Fields[$this->ObjField]) {
			return $this->update($ops);
		}
		else {
			return $this->create($ops);
		}
	}
	
	public function update($ops){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$this->setUpdateUser();
		$sql  = "";
		$sql .= " UPDATE ".$this->TableName." ";
		$sql .= " SET ";
		reset($this->Fields);
		while (list($key, $val) = each($this->Fields)) {
                        if ($key == "Note"){
                            $sql .= " $key = '".$val."' ,"; 
                        }
                        else{
                            $sql .= " $key = '".mysql_real_escape_string(stripslashes($val))."' ,"; 
                        }
		}
		$sql  = substr_replace( $sql , "", -1 );
		$sql .= " WHERE ".$this->ObjField." = '".$this->Fields[$this->ObjField]."' ";
		$result=$mdsDB->mysqlQuery($sql); 

		if (!$result) {
			if ($ops == "rId") {
				return  mysql_error();
			}
			else {
				return  'Error=true; res="'.mysql_error().'";';
			}
			$mdsDB->close();
		}
		else {
			if ($ops == "rId") {
				return $this->Fields[$this->ObjField];
			}
			else {
				return 'Error=false; res="'.$this->Fields[$this->ObjField].'";';
			}
			$mdsDB->close();
		}
	}
	
	public function create($ops){
		$mdsDB = MDSDataBase::GetInstance();
		$mdsDB->connect();		
		$this->setCreateUser();
		$field = "";
		$value = "";
		$sql  = "";
		$sql .= " INSERT INTO ".$this->TableName." ";
		reset($this->Fields);
		while (list($key, $val) = each($this->Fields)) {
			$field .= " $key ,";
			if (mysql_real_escape_string(stripslashes($val)) == "") {
				$value .= " '' ,"; 
				//$value .= " NULL ,"; 
			}
			else {
                            if ($key == "Note"){
                               $value .= " '".$val."' ,"; 
                             }
                             else{
				$value .= " '".mysql_real_escape_string(stripslashes($val))."' ,"; 
                             }
			}
		}
		
		$field  = substr_replace( $field , "", -1 );
		$value = substr_replace($value, "", -1 );
		$sql .= "( ".$field." ) VALUES ( ".$value." )";
		
		$result=$mdsDB->mysqlQuery($sql); 
		$this->Fields[$this->ObjField] = $mdsDB->mysqlInsertId();
		$mdsDB->close();

		if (!$result) {
			if ($ops == "rId") {
				return  mysql_error();
			}
			else {
				return  'Error=true; res="'.mysql_error().'";';
			}
		}
		else {
			$mdsLog= MDSLogger::GetInstance();
			//$mdsLog->logAction('INSERT',$this->TableName,$this->Fields[$this->ObjField],"",""); //logAction($action,$table,$objid,$from,$to)
			if ($ops == "rId") {
				return $this->Fields[$this->ObjField];
			}
			else {
				return 'Error=false; res="'.$this->Fields[$this->ObjField].'";';
			}
		}
	}
	
	public function dateDifference($startDate, $endDate) 
        { 
            $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
            if ($startDate === false  || $endDate === false) 
               return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
            
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months <= 0)  { 
                $months += 12; 
                $years--; 
            } 
            if ($years < 0) 
                //return false; 
            
            // Calculate the days 
                        $offsets = array(); 
                        if ($years > 0) 
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                        if ($months > 0) 
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDate - strtotime($offsets, $startDate); 
                        $days = date('z', $days);    
                        
            return array($years,$months  ); 
        } 
}
?>
