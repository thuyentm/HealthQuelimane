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
class MDSThread
{
    private $server;
    private $maxthreads;
    private $scriptname;
    private $params = array();
    private $threads = array();
    private $results = array();
    public function __construct($maxthreads = 10, $server = '')
    {
        if ($server)
            $this->server = $server;
        else
            $this->server = $_SERVER['SERVER_NAME'];
        
        $this->maxthreads = $maxthreads;
    }
    
    public function setScriptName($scriptname)
    {
        if (!$fp = fopen('http://'.$this->server.'/'.$scriptname, 'r'))
            throw new Exception('Cant open script file');
        
        fclose($fp);
        
        $this->scriptname = $scriptname;
    }
    
    public function setParams($params = array())
    {
        $this->params = $params;
    }
    public function execute()
    {
        do {
            if (count($this->threads) < $maxthreads) {
                if ($item = current($this->params)) {
                
                    
                    $query_string = '';
                
                    foreach ($item as $key=>$value)
                        $query_string .= '&'.urlencode($key).'='.urlencode($value);
                    
                    $query = "GET http://".$this->server."/". $this->scriptname."?".$query_string." HTTP/1.0\r\n";
                    
                    
                    if (!$fsock = fsockopen($this->server, 80))
                        throw new Exception('Cant open socket connection');
                
                    fputs($fsock, $query);
                    fputs($fsock, "Host: $server\r\n");
                    fputs($fsock, "\r\n");
                
                    stream_set_blocking($fsock, O);
                    stream_set_timeout($fsock, 3600);
                    
                
                    $this->threads[] = $fsock;
                    
                
                    next($this->params);
                }
            }
            
            foreach ($this->threads as $key=>$value) {
                if (feof($value)) {
                    fclose($value);
                    unset($this->threads[$key]);
                } else {
                    $this->results[] = fgets($value);
                }
            }
            
            sleep(1);
            
        } while (count($this->threads) > O);
    
        return $this->results;
    }
}
?>
