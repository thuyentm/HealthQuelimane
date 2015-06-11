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

// ------------------------------------------------------------------------- //
////Prescription

//not used START
$dosage = array();
$dosage["VALUE"]=array(
	"1/2" =>0.5,
	"1 1/2" =>1.5,
	"1" =>1,	
	"1/4"=>	0.25,	
	"1/3"=>0.33,	
	"2/3"=>	0.67,	
	"2"=> 2
 );
$frequency = array();
$frequency["VALUE"]=array(
	"daily"=>1,
	"bd"=>2,
	"tds"=>3,
	"qds"=>4,
	"nocte"=>1,
	"mane"=>1,
	"mane, nocte"=>	2,
	"mane, vesper"=>2,
	"vesper"=>1,
	"eod"=>0.5
   );

//not used END
$howlong = array();
$howlong["VALUE"] = array("For 1 day" => 1,"For 2 days" => 2,"For 3 days" => 3,"For 4 days" => 4,"For 5 days" => 5,"For 1 week" => 7 ,"For 2 weeks" => 14,"For 3 weeks" => 21,"For 1 month" => 30,"For 2 months" => 60,"For 3 months" => 90);
/////period
$period = array();
$period["TEXT"] = array("For 1 day","For 2 days","For 3 days","For 4 days","For 5 days","For 1 week","For 2 weeks","For 3 weeks","For 1 month","For 2 months","For 3 months");
$period["VALUE"] = array("For 1 day" => 1,"For 2 days" => 2,"For 3 days" => 3,"For 4 days" => 4,"For 5 days" => 5,"For 1 week" => 7 ,"For 2 weeks" => 14,"For 3 weeks" => 21,"For 1 month" => 30,"For 2 months" => 60,"For 3 months" => 90);

?>
