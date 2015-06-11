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


//include 'MDSDataBase.php';
//include 'MDSMainMenu.php';
//include 'MDSContent.php';
class MDSCalendar
{

	private static $instance; 
        private $year = "";
        private $month = "";
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	function __construct() {
	} 

	public function show($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){ 
            
            //// THIS METHOD NOT USED
            
		$first_of_month = gmmktime(0,0,0,$month,1,$year); 
		$day_names = array(); #generate all the day names according to the current locale 
		for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday 
			$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name 

		list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month)); 
		$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day 
		$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names 

		@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable 
		if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;'; 
		if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>'; 
		$calendar = '<table class="calendar" border=1 >'."\n". 
			'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>"; 

		if($day_name_length){ #if the day names should be shown ($day_name_length > 0) 
			foreach($day_names as $d) 
				$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>'; 
			$calendar .= "</tr>\n<tr>"; 
		} 

		if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days 
		for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){ 
			if($weekday == 7){ 
				$weekday   = 0; #start a new week 
				$calendar .= "</tr>\n<tr>"; 
			} 
			if(isset($days[$day]) and is_array($days[$day])){ 
				@list($link, $classes, $content) = $days[$day]; 
				if(is_null($content))  $content  = $day; 
				$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>'). 
					($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>'; 
			} 
			else $calendar .= "<td>$day</td>"; 
		} 
		if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days 

		return $calendar."</tr>\n</table>\n"; 
	} 
        public function render($y,$m){
                if (($y <= 0)||($y <= 2000)||($m <= 0)||($m > 12)){
                    $mnt=date('n'); 
                    $yr=date('Y'); 
                }
                else {
                    $mnt=$m; 
                    $yr=$y; 
                }
                 //  echo $mnt; 
               //     echo $yr; 
               // echo date('d',mktime(0,0,0,$mnt,2,$yr))."<br>";
               // echo mktime(0,0,0,$mnt=date('n'),date('d'),date('Y'))."<br>";
                
                $this->year =$yr;
                $this->month =$mnt;
                $week=date('w', mktime(0,0,0,$mnt,1,$yr)); 
                $insgesamt=date('t', mktime(0,0,0,$mnt,1,$yr)); 
                $d=date('d'); 
                $months=array('January','February','March','April','May','June','July','August','September','October','November','December'); 
                if($erster==0){$erster=7;} 
                echo '<div style="position:absolute;left:100px;"><table border=1 cellspacing=5 style="font-size:8pt; font-family:Verdana;border:1px solid #f1f1f1;" align=center width=80% height=500px>'; 
                echo '<th colspan=7 align=center style="font-size:20pt; font-family:Arial; color:#ff9900;background:#f1f1f1;">';
                echo '<input type=button value="&laquo;"   onclick=self.document.location="home.php?page=report&year='.$this->getYear(-1).'&month='.$this->getMonth(-1).'">&nbsp;';
                echo $months[$mnt-1].' '.$yr;
                echo '&nbsp;<input type=button value="&raquo;"  onclick=self.document.location="home.php?page=report&year='.$this->getYear(1).'&month='.$this->getMonth(1).'">';
                echo '</th>'; 
                echo '<tr><td style="color:#666666"><b>Monday</b></td><td style="color:#666666"><b>Tuesday</b></td>'; 
                echo '<td style="color:#666666"><b>Wednesday</b></td><td style="color:#666666"><b>Thursday</b></td>'; 
                echo '<td style="color:#666666"><b>Friday</b></td><td style="color:#0000cc"><b>Saturday</b></td>'; 
                echo '<td style="color:#cc0000"><b>Sunday</b></td></tr>'; 
                echo "<tr>\n"; 
                $i=1; 
                if ($week == 0) $week =7;
                while($i<$week){echo '<td>&nbsp;</td>'; $i++;} 
                $i=1; 
                while($i<=$insgesamt) 
                { 
                    $rest=($i+$week-1)%7; 
                    if($i==$d){
                            echo '<td style="font-size:8pt; font-family:Verdana; background:#fff1f1;" valign=top align=left>';
                    } 
                    else{
                            echo '<td style="font-size:8pt; font-family:Verdana" valign=top align=left>';
                    } 

                    if($i==$d){
                            echo $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
                    } 
                    else if ($i > $d){
                            echo '<span style="color:#cccccc;font-size:18pt; ">'.$this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i).'</span>';
                    } 
                    else if($rest==6){
                            echo $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
                    } 
                    else if($rest==0){
                            echo $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
                    } 
                    else{
                            echo $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
                    } 
                    echo "</td>\n"; 
                    if($rest==0){echo '</tr><tr>';} 
                    $i++; 
                } 
                echo '</tr>'; 
                echo '</table></div>'; 
        }
        private function getOption($dte,$day){
            $ops = "";
            $ops .= "<table border=0 cellspacing=0 cellpading=2 width=100%>";
            $ops .= "<tr>";
            if ($dte == date('Y-m-d')) {
                 $ops .= "<td width=15 style='color:#00a84b;font-size:18pt;font-weight:bold;' valign=top align=left>".$day ;
            }
            else {
                $ops .= "<td width=15 style='color:#000000;font-size:18pt;' valign=top align=left>".$day;
            }
            $ops .= "</td>";
            $ops .= "<td valign=top align=right style='color:#000000;font-size:8pt;'>" ;
            //TO GIHAN : $dte have the current date. pass the $dte to your reports. open your reports in new window.
            
            $ops .= "<a href='#' onclick=printReport('".$dte."','visits');>Visits</a><br>";
            $ops .= "<a href='#' onclick=printReport('".$dte."','clinics');>Clinics</a><br>";
            $ops .= "<a href='#' onclick=printReport('".$dte."','admissions');>Admissions</a><br>";
            $ops .= "<a href='#' onclick=printReport('".$dte."','discharges');>Discharges</a><br>";
            $ops .= "<a href='#' onclick=printReport('".$dte."','drugsdispensed');>Drugs dispensed</a><br>";
            $ops .= "</td>";
            $ops .= "<tr>";
            $ops .= "</table>";
            echo $ops;
        }
        private function getYear($inc){
            
            $m = $this->month + $inc;
            if ( $m <1 ){
                $y = $this->year-1;
                return $y;
            }
            else if ( $m >12 ){
                $y = $this->year+1;
                return $y;
            }
            else {
                $y = $this->year;
                return $y;
            }
        }
        private function getMonth($inc){
            $m = $this->month + $inc;
            if ($m <= 0 )
                return 12;
            else if ($m > 12 )
                return 1;
            else 
                return $m;
        }
            
}

?>