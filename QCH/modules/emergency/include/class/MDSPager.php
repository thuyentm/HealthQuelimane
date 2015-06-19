<?php

header('Content-type: text/css');
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
  Class Author: Gihan Seneviratna
  URL: http://www.mdsfoss.org
  ----------------------------------------------------------------------------------
 */

/**
 * This class is use to generate pager from 
 * database tables.
 *
 * @author kavinga
 */
include_once 'MDSPagerColumn.php';
include_once '../config.php';

class MDSPager {
    const YES_NO_FORMATTER_EL = "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}";

    public static $GENDER_SELECT_EL = array('value' => ':All;Male:Male;Female:Female');
    private $id_EL = '_mds';
    private $sql_EL = '';
    private $exec_EL = '';
    private $sidx = '';
//    private $url = "include/pager_backing.php";
    private $datatype = 'local';
//    private $datatype = 'include/pager_backing.php';
    private $colNames_JSAR = array();
    private $colModel_JSAR = array();
    private $rowNum = 25;
    private $rowList_JS = "[10,25,50,100]";
    private $imgpath = 'css/images';
    private $pager = '';
    private $grid_EL = '';
    private $sortname = '';
    private $viewrecords = true;
    private $sortorder = 'desc';
    private $caption = 'MDSPager Example';
    private $multiselect = false;
    private $width = 'auto';
    private $height = 'auto';
    private $autowidth = true;
    private $mtype = 'POST';
    private $rowid;
    private $rowclass;
    private $onSelectRow_JS = "function(rowid){ }";
    private $afterInsertRow_JS = "function(rowid,data){
		
	var alertText = '';
	
for (property in data) {
	
alertText +=data[property];

}

if (alertText.match(/^.*Critical$/)) 
{ 
   $('#'+rowid).css({'background':'#EE2C2C'});
}

else if (alertText.match(/^.*Non Urgent$/)) 
{ 
    $('#'+rowid).css({'background':'#00FF00'});
}

else if (alertText.match(/^.*Urgent$/)) 
{ 
    $('#'+rowid).css({'background':'#FFFF00'});
}





   	}";
    private $colIndexes_EL = array();
    private $showHeaderRow_EL = 1;
    private $showFilterRow_EL = 1;
    private $showPager_EL = 1;
    //private $toppager_JS = 'true';$(this).jqGrid('setRowData', rowid, false, 'StyleCss');
//    private $pgbuttons_JS='false';
//    private $pgtext_JS='null';
//    private $viewrecords_JS='false';
    //TSR
    private $divid_EL = '';
    private $divstyle_EL = '';
    private $divclass_EL = '';
    private $color = '';
    //properties used in reports
    private $widths_EL = array();
    private $color_EL = array();
    private $orientation_EL = 'P';
    private $colHeaders_EL = array();
    private $title_EL = '';
    private $save_EL = '';
    private $report_EL = 'print_pager';
    private $link_EL;

    public static function getGenderSelector($default = '', $options = array()) {
        return array_merge(array('stype' => 'select', 'editoptions' => array('value' => ':All;Male:Male;Female:Female'), "searchoptions" => array("defaultValue" => $default)), $options);
    }

    public static function getYesNoFormatter($default = '', $options = array()) {
        return array_merge(array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}", 'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"), "searchoptions" => array("defaultValue" => '')), $options);
//        return array("width" => "75px", "formatter_JS" => MDSPager::YES_NO_FORMATTER_EL,'stype' => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"));
    }

    public function getDateSelector($default = '', $options = array()) {
        $js = "function(el){";
        $js.="$(el).datepicker({";
        $js.="dateFormat:'yy-mm-dd',";
        $js.="changeMonth:true,";
        $js.="changeYear:true,";
        $js.="showButtonPanel:true,";
        $js.="autoSize:true,";
        $js.="onSelect:function(dateText,inst){";
        $js.="{$this->getGrid()}[0].triggerToolbar();";
        $js.="}";
        $js.="});";
        $js.="}";
        return array_merge(array("stype" => "text", "searchoptions" => array("dataInit_JS" => $js, "defaultValue" => "$default")), $options);
    }

    function __construct($sql) {
        $this->sql_EL = $sql;
        $this->init();
    }

    private function init() {
        $this->link_EL = mysql_connect(HOST, USERNAME, PASSWORD);
        if (!$this->link_EL) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db(DB);
        $this->id_EL = uniqid("_");
        $this->createColModel();
        $this->pager = $this->getPager();
        $this->exec_EL = $this->encrypt($this->sql_EL, PASSWORD);
        foreach ($this->colModel_JSAR as $column) {
            $this->rowid = $column->getIndex();
            $this->sidx = $column->getIndex();
            continue;
        }
    }

    public function __destruct() {
        mysql_close($this->link_EL);
    }

    function encrypt($str, $key = PASSWORD) {
        $enc = mcrypt_cbc(MCRYPT_TripleDES, $key, serialize($str), MCRYPT_ENCRYPT);
        $enc = urlencode($enc);
//        return $str;
        return $enc;
    }

    function createColModel() {
        $result = mysql_query($this->sql_EL);
        $num_rows = mysql_num_rows($result);


        $count = mysql_num_rows($result);
        $i = 0;
        while ($i < mysql_num_fields($result)) {
            $uid = uniqid("_");
            $meta = mysql_fetch_field($result, $i);
            $column = new MDSPagerColumn($this->id_EL);

            if ($meta) {
                $title = $meta->name;
                $table = $meta->table;
//                if (!$table)
//                    $column->search = false;

                $column->setIndex($uid);
                $column->setName($uid);

                $column->setName_EL($title);
                $column->setTable($table);
                $column->setWidth(0);
                $column->setSortable(true);
                $column->setAlign('left');
                array_push($this->colNames_JSAR, $title);
                $this->caption = $table;
            } else {
                $column->setDisplay('Default');
                $column->setName('Default');
                $column->setTable('');
                $column->setWidth(0);
                $column->setSortable(true);
                $column->setAlign('left');
                array_push($this->colNames_JSAR, 'Title' . $i);
            }
//            $this->colModel[ $column->getName()] = $column;
            array_push($this->colIndexes_EL, $column->getName());
            $this->colModel_JSAR['"' . $column->getName_EL() . '"'] = $column;
            $i++;
        }
        mysql_free_result($result);

//        print_r($this->colModel);
    }

    public function getColModel() {
        $model = '';
        foreach ($this->colModel_JSAR as $value) {
            $model.=$value->getColumnModel() . ",\n";
        }
        $model = substr($model, 0, -2);
        $model.="\n";
        return $model;
    }

    public function getDataModel() {
        $ddmodel = '';
        foreach ($this->colModel_JSAR as $column) {
            $ddmodel.=$column->getDataModel() . ',';
        }
        $ddmodel = substr($ddmodel, 0, -1);
        return $ddmodel;
    }

//
    public function render($echoEnabled = true) {
        $js = '<script type="text/javascript">';
        $js.= "\n";
        //TSR: to load the table in given DIV
        $js .= "$(\"<div id='" . $this->divid_EL . "' style='" . $this->divstyle_EL . "' class='" . $this->divclass_EL . "'></div>\").appendTo('body');\n";
        $js .= "$(\"<table id='grid{$this->getId()}' class='scroll' cellpadding='0' cellspacing='0'></table>\").appendTo($('#" . $this->divid_EL . "'));\n";
        $js .= "$(\"<div id='pager{$this->getId()}' class='scroll' style='text-align:center;'></div>\").appendTo($('#" . $this->divid_EL . "'));\n";
        $js.= "$(function(){";
        $js.= "{$this->getGrid()}.jqGrid({";
        $js.="{$this->getPagerModel()},";
        $js.="postData:{cell:'{$this->getEncCellModel()}',id:'{$this->id_EL}',rowid:'{$this->getRowid()}',exec:\"$this->exec_EL\"}";
        $js.="});\n";
        $js.=$this->getGrid() . ".jqGrid('navGrid','{$this->getPager()}',{del:false,add:false,edit:false,search:false});\n";
        $js.=$this->getGrid() . ".jqGrid('navButtonAdd','{$this->getPager()}',{caption:'Print',title:'Print this table',buttonicon:'ui-icon-print',onClickButton:function(){
            var data={$this->getArrayModel($this->colIndexes_EL)};
            var sortname={$this->getGrid()}.jqGrid('getGridParam','sortname');
            var sortorder={$this->getGrid()}.jqGrid('getGridParam','sortorder');
            var params={};
            params._search=false;
            for (var i=0;i<data.length;i++){var val=$('#gs_'+data[i]).val();if(val!='' && val!=undefined){params[data[i]]=val;params._search=true;};};
            params.sidx=sortname;
            params.sord=sortorder;
            params.exec=\"{$this->exec_EL}\";
            params.cell=\"{$this->getEncCellModel()}\";
            params.headers=\"{$this->encrypt($this->getArrayModel($this->colNames_JSAR))}\";
            params.title='{$this->encrypt($this->getTitle_EL())}';
            params.widths=\"{$this->encrypt($this->getArrayModel($this->widths_EL))}\";
            params.colHeaders=\"{$this->encrypt($this->getArrayModel($this->getColHeaders_EL()))}\";
            params.orientation='{$this->encrypt($this->orientation_EL)}';
            params.save='{$this->encrypt($this->getSave_EL())}';
            params.report='{$this->report_EL}';
            printPager(params);
        },position:'last'});\n";


//        $js.=$this->getGrid() . ".jqGrid({pgbuttons:false, recordtext:'', pgtext:''});\n";    

        if ($this->showFilterRow_EL) {
            $js.=$this->getGrid() . ".jqGrid('filterToolbar',{searchOnEnter:false});\n";
            $js.=$this->getGrid() . ".jqGrid('setGridParam',{datatype:'json',url:'include/pager_backing.php'});\n";
            $js.=$this->getGrid() . "[0].clearToolbar();\n";
        } else {
            $js.=$this->getGrid() . ".jqGrid('setGridParam',{datatype:'json',url:'include/pager_backing.php'});\n";
            $js.=$this->getGrid() . ".trigger('reloadGrid');";
        }
        if (!$this->showHeaderRow_EL) {
//            $js.=$this->getGrid() . ".parents('div.ui-jqgrid-view').children('div.ui-jqgrid-hdiv').hide();";
            $js.=$this->getGrid() . ".parents('div.ui-jqgrid-view').children('div.ui-jqgrid-hdiv').find('tr.ui-jqgrid-labels').hide();\n";
        }

        $js.=$this->getGrid() . ".jqGrid('navGrid','#" . $this->id_EL . "pager',{
            'add':false,
            'del':false,
            'refresh':false
            })";
        $js.="});\n";
        if (!$this->showPager_EL) {
            $js.="$(\"#pager$this->id_EL\").remove(); \n";
        }
        $js.= "</script>\n";
        if ($echoEnabled) {
            echo $js;
        } else {
            return $js;
        }
    }

    private function getEncCellModel() {
        $toenc = '[' . $this->getDataModel() . ']';
        return $this->encrypt($toenc);
    }

    private function getBase64Enc($param) {
        return base64_encode($param);
    }

    public function getPagerModel($array) {
        if (!$array) {
            $options = $this;
        } else {
            $options = $array;
        }
        $model = '';
//        $model.="{";
        foreach ($options as $property => $value) {
            $ar = explode("_", $property);
            if (count($ar) == 2) {
                $property = $ar[0];
                $sf = $ar[1];

                switch ($sf) {
                    case 'JS':
                        $model.="$property:";
                        $model.=$value;
                        $model.=',';
//                        echo "$property : $sf<br>";
                        continue 2;
                        break;
                    case 'JSAR':
                        $model.="$property:";
                        $model.=$this->getArrayModel($value);
                        $model.=',';
//                        echo "$property : $sf<br>";
                        continue 2;
                        break;
                    case 'EL':
//                        echo "$property : $sf<br>";
                        continue 2;
                        break;
                    default:
                        break;
                }
            }

            $model.="$property:";
//            echo "PROP:$property<br>";
            $model.=$this->getType($value);
        }

        $model = substr($model, 0, -1);
        return $model;
    }

    private function getArrayModel($array) {
        $model = '[';
        foreach ($array as $value) {
            $model.=$this->getType($value);
        }
        $model = substr($model, 0, -1);
        $model.=']';
        return $model;
    }

    private function getType($value) {
        $model = '';
        switch (gettype($value)) {
            case 'string':
                $model.="'$value',";
                break;
            case 'integer':
                $model.=$value;
                $model.=',';
                break;
            case 'boolean':
                $model.=$value ? 'true' : 'false';
                $model.=',';
                break;
            case 'array':
//                    echo $property.'<br>';
                $model.=$this->getPagerModel($value);
                $model.=',';
                break;
            case 'object':
                $model.="$value,";
                break;
            default:
                $model.="'D$value',";
                break;
        }
//        $model=substr($model, 0,-1);
        return $model;
    }

    public function setColOption($name, $options) {
        $column = $this->colModel_JSAR['"' . $name . '"'];
        foreach ($options as $key => $value) {
            $column->__set($key, $value);
        }
    }

    public function setDataModel($name, $model) {
        $this->colModel_JSAR['"' . $name . '"']->__set("ddtype", $model);
    }

    public function getColNames() {
        $names = '';
        foreach ($this->colNames_JSAR as $name) {
            $names.="'$name',";
        }

        return substr($names, 0, -1);
    }

    //TSR
    public function setDivId($div_id) {
        $this->divid_EL = $div_id;
    }

    public function setDivClass($div_class) {
        $this->divclass_EL = $div_class;
    }

    public function setDivStyle($div_Style) {
        $this->divstyle_EL = $div_Style;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setColNames($colNames) {
        $this->colNames_JSAR = $colNames;
    }

    public function getPager() {
        return '#pager' . $this->id_EL;
    }

    public function setPager($pager) {
        $this->pager = $pager;
    }

    public function getSortname() {
        if ($this->sortname) {
            return $this->sortname;
        } else {
            foreach ($this->colModel_JSAR as $column) {
                return $column->getIndex();
            }
        }
    }

    public function setSortname($sortname) {
        $this->sortname = $sortname;
    }

    public function getViewrecords() {
        return $this->viewrecords ? 'true' : 'false';
    }

    public function setViewrecords($viewrecords) {
        $this->viewrecords = $viewrecords;
    }

    public function getMultiselect() {
        return $this->multiselect ? 'true' : 'false';
    }

    public function setMultiselect($multiselect) {
        $this->multiselect = $multiselect;
    }

    public function getSql() {
        return $this->sql_EL;
    }

    public function setSql($sql) {
        $this->sql_EL = $sql;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getDatatype() {
        return $this->datatype;
    }

    public function setDatatype($datatype) {
        $this->datatype = $datatype;
    }

    public function getRowNum() {
        return $this->rowNum;
    }

    public function setRowNum($rowNum) {
        $this->rowNum = $rowNum;
    }

    public function getRowList() {
        return $this->rowList_JS;
    }

    public function setRowList($rowList) {
        $this->rowList_JS = $rowList;
    }

    public function getImgpath() {
        return $this->imgpath;
    }

    public function setImgpath($imgpath) {
        $this->imgpath = $imgpath;
    }

    public function getSortorder() {
        return $this->sortorder;
    }

    public function setSortorder($sortorder) {
        $this->sortorder = $sortorder;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function setCaption($caption) {
        $this->caption = $caption;
    }

    public function getOnSelectRow() {
        if ($this->onSelectRow_JS) {
            return "function(rowid){" . $this->onSelectRow_JS . "}";
        } else {
            return "function(rowid){}";
        }
    }

    public function setOnSelectRow($onSelectRow) {
        $this->onSelectRow_JS = $onSelectRow;
    }

    public function getPagerOptions() {
        return $this->pagerOptions;
    }

    public function setPagerOptions($pagerOptions) {
        $this->pagerOptions = $pagerOptions;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getMtype() {
        return $this->mtype;
    }

    public function setMtype($mtype) {
        $this->mtype = $mtype;
    }

    public function getId() {
        return $this->id_EL;
    }

    public function getGrid() {
        return '$("#grid' . $this->id_EL . '")';
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getRowid() {
        if ($this->rowid) {
            return $this->rowid;
        } else {
            foreach ($this->colModel_JSAR as $column) {
                return $column->getIndex();
            }
        }
    }

    public function setRowid($rowid) {
        $this->rowid = $rowid;
    }

    /*   public function setRowclass($rowclass) {
      $this->rowclass = $rowclass;
      } */

    public function getAfterInsertRow() {
        if ($this->afterInsertRow_JS) {
            return "function(rowid, data){{$this->afterInsertRow_JS}}";
        } else {
            return "function(rowid, data){}";
        }
    }

    public function setSidx($sidx) {
        $this->sidx = $sidx;
    }

    public function setWidths_EL($widths_EL) {
        $this->widths_EL = $widths_EL;
    }

    public function setColor_EL($color_EL) {
        $this->color_EL = $color_EL;
    }

    public function setOrientation_EL($orientation_EL) {
        $this->orientation_EL = $orientation_EL;
    }

    public function setColHeaders_EL($colHeaders_EL) {
        $this->colHeaders_EL = $colHeaders_EL;
    }

    public function setTitle_EL($title_EL) {
        $this->title_EL = $title_EL;
    }

    public function setSave_EL($save_EL) {
        $this->save_EL = $save_EL;
    }

    public function getTitle_EL() {
        return $this->title_EL ? $this->title_EL : $this->caption;
    }

    public function getColHeaders_EL() {
        return count($this->colHeaders_EL) > 0 ? $this->colHeaders_EL : $this->colNames_JSAR;
    }

    public function setReport_EL($report_EL) {
        $this->report_EL = $report_EL;
    }

    public function getSave_EL() {
        return $this->save_EL ? $this->save_EL : $this->caption;
    }

    public function setShowHeaderRow($showHeaderRow_EL) {
        $this->showHeaderRow_EL = $showHeaderRow_EL;
    }

    public function setShowFilterRow($showFilterRow_EL) {
        $this->showFilterRow_EL = $showFilterRow_EL;
    }

    /**
     * set pager visibility.default to true
     */
    public function setShowPager($showPager_EL) {
        $this->showPager_EL = $showPager_EL;
    }

    /**
     * @param String afterInsertRow javascript code to
     * execute after insert new row
     * call after insert row.referances
     * rowid, data
     */
    public function setAfterInsertRow($afterInsertRow) {
        $this->afterInsertRow_JS = $afterInsertRow;
    }

}

?>
