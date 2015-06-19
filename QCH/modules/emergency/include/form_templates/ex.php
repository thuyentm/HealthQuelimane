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
include_once '../config.php';

require('mysql_report.php');
$dat_d = date('d/m/Y');
$pdf = new PDF('L', 'pt', 'A4');
$pdf->SetTopMargin(50);
$pdf->SetFont('Arial', '', 10.5);
$pdf->connect('localhost', 'root', PASSWORD, DB);
$attr = array('titleFontSize' => 18, 'titleText' => 'Data file Drugs - all fields      (' . $dat_d . ')');
$pdf->mysql_report("SELECT * FROM Drugs ORDER BY Name ", false, $attr);
$pdf->Output('data_drugs_all.pdf', 'D');
?>
