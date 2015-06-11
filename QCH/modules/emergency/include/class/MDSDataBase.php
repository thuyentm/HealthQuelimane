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

//DATAbase connection information
include_once 'config.php';



class MDSDataBase
{
    var $conn;
	public $logger="";
	
	private static $instance; 
/*
	private __construct() { } 
*/
  
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 

	} 	
	
    function connect()
    {
        if (!extension_loaded('mysql')) {
            $this->logger= "EEROR:MYSQL_NOT_LOADED";
            return false;
        }

        $this->conn = mysql_connect(HOST, USERNAME, PASSWORD);
        
        if (!$this->conn) {
            $this->logger = "ERROR in Connecting with DB";
            return false;
        }

        if (!mysql_select_db(DB)) {
               $this->logger= "EEROR:SELECT_DB";
              return false;
        }
        return true;
    }

    function fetchRow($result)
    {
        return @mysql_fetch_row($result);
    }

    function fetchArray($result)
    {
        return @mysql_fetch_assoc($result);
    }

    function mysqlFetchArray($result)
    {
        return @mysql_fetch_array($result, MYSQL_BOTH);
    }
	
	function mysqlQuery($sql){
		return @mysql_query($sql);
	}
	
    function fetchObject($result)
    {
        return @mysql_fetch_object($result);
    }
    function getRowsNum($result)
    {
        return @mysql_num_rows($result);
    }
    function getAffectedRows()
    {
        return mysql_affected_rows($this->conn);
    }
    function close()
    {
        mysql_close($this->conn);
    }

    function freeRecordSet($result)
    {
        return mysql_free_result($result);
    }
	function mysqlInsertId(){
		return @mysql_insert_id();
	}
    function error()
    {
        return "mysql error";
    }

    function errno()
    {
        return "mysql errno";
    }


    function quote($string)
    {
        return "'" . str_replace("\\\"", '"', str_replace("\\&quot;", '&quot;', mysql_real_escape_string($string, $this->conn))) . "'";
    }

  
    function query($sql, $limit = 0, $start = 0)
    {
    }



    function getFieldName($result, $offset)
    {
        return mysql_field_name($result, $offset);
    }


    function getFieldType($result, $offset)
    {
        return mysql_field_type($result, $offset);
    }


    function getFieldsNum($result)
    {
        return mysql_num_fields($result);
    }
	function fetchField($result,$i){
		return mysql_fetch_field($result,$i);
	}
}

?>