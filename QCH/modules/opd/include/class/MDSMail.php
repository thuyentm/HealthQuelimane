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

require("phpmailer/class.phpmailer.php");
include_once 'config.php';
class MDSMail 
{
        private $To = NULL;
        private $From = NULL;
        private $Subject = NULL;
        private $Msg  = NULL;
        private $Header  = NULL;
        public $Error = "";
        
        public function setTo($to){
            $this->To = $to;
        }
        public function setFrom($from){
            $this->From = $from;
        }
        public function setMessage($msg){
            $this->Msg = $msg;
        }
        public function setHeader($header){
            $this->Header = $header;
        }
        public function setSubject($subject){
            $this->Subject = $subject;
        }
        public static function validateAddress($address) {
            if (function_exists('filter_var')) { 
              if(filter_var($address, FILTER_VALIDATE_EMAIL) === FALSE) {
                return false;
              } else {
                return true;
              }
            } else {
              return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
            }
        }        
        
        public function send(){
            $status = false;
            if (!$this->validateAddress($this->To)){
                $this->Error .= "Invalid To Address<br>";
            }
            if (!$this->validateAddress($this->From)){
                $this->Error .= "Invalid From Address<br>";
            }
            if ($this->Error)
                     return $this->Error."Notification not Sent";
            
            
            //$status = mail($this->To, $this->Subject, $this->Msg, $this->Header );

            $mail = new PHPMailer();

            $mail->IsSMTP();                                      // set mailer to use SMTP
            //$mail->Host = "smtp.gmail.com";  // specify main and backup server
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = MAIL_UN;  // SMTP username
            $mail->Password = MAIL_PW; // SMTP password

            $mail->From = MAIL_UN;
            $mail->FromName = $_SESSION["Hospital"]." Mailer";
            $mail->AddAddress($this->To);

             $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $this->Subject;
            $mail->Body    = $this->Msg;
            //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

            if(!$mail->Send())
            {
               return $this->Error."Notification not Sent";
            }            
            else {
               return 1;
            }
            
        }
        public function sendMail(){
            $status = false;
            $mail = new PHPMailer();

            $mail->IsSMTP();                                      // set mailer to use SMTP
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = MAIL_UN;  // SMTP username
            $mail->Password = MAIL_PW; // SMTP password

            $mail->From = MAIL_UN;
            $mail->FromName = $_SESSION["Hospital"]." Mailer";
            $mail->AddAddress("tsruban@mdsfoss.org");
            $mail->AddAddress("gihan@mdsfoss.org");
            
            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $this->Subject;
            $mail->Body    = $this->Msg;
            //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

           return $mail->Send();
            
        }        
}