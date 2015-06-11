<?php
include 'MDSMainMenu.php';
include 'MDSContent.php';
include_once 'MDSUserGroup.php';
include_once 'MDSUser.php';
class MDSFoss
{
	public $FirstName = NULL;
	public $OtherName = NULL;
	public $Hospital = NULL;
	public $UserGroup = NULL;
	public $FullName = NULL;
	public $Uid = NULL;
	public $Hid = NULL;
	public $UG = NULL;
	public $Lang = "EN";
	public $Page = "";
	public $Action = "";

	private static $instance; 
  
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	function __construct() {
		$this->Uid = $_SESSION["UID"];
		$this->FirstName = $_SESSION["FirstName"];
		$this->OtherName = $_SESSION["OtherName"];
		$this->Hospital = $_SESSION["Hospital"];
		$this->UserGroup = $_SESSION["UserGroup"];
		$this->Hid = $_SESSION["HID"];
		$this->Lang = $_SESSION["LANG"];
		$this->FullName = $_SESSION["FirstName"]." ".$_SESSION["OtherName"];

		$mdsUG = new MDSUserGroup();
		$mdsU = new MDSUser();
		$mdsU->openId($this->Uid);
		$mdsUG->openId($mdsUG->openByName($mdsU->getValue("UserGroup")));
		$this->UG = $mdsUG;
		$_SESSION["UGID"]= $mdsUG->getId();
                if ( $_GET["page"] == "logout" ) {
			include "include/logout.php";

		}
	} 
	function loadMDS($page,$action){
		if ($page == "") {
			echo "NOT FOUND";
			exit();
		}
		else if ($page == "home"){
			$this->Page = $this->getHomePage();
		}
		else {
			$this->Page = $page;
		}
		$this->Action = $action;
                if (md5(false) == $_SESSION["LIC"]){
                    $_SESSION["LIC_HOS"]=$_SESSION["Hospital"]="Demo Hospital";
                    $out = "";
                    $out .= "<div style='font-family:arial;text-align:center;border-top:2px solid #FF0000;position:fixed;z-index:999999;top:100%;width:100%;height:55px;background:#dddddd;margin-top:-56;'>";
                    $out .= "Warning!<br>License not valid or currupted!<br>";
                    $out .= "Please visit <a href='http://www.mdsfoss.org' target='_blank'>MDSFoss</a> or contact <i>TSRuban@mdsfoss.org</i> to get one";
                    $out .= "</div>";
                    echo $out;
                }
                //echo $_SESSION["LIC"]."------------------".md5(false);
                $this->loadMenu();
                $this->loadContent();
	}
	
	private function loadMenu(){
		$MDSMainMenu = new MDSMainMenu();
		$MDSMainMenu->load($this);
	}
	private function loadContent(){
		$MDSContent = new MDSContent();
		$MDSContent->load($this);
	}
	private function getHomePage() {
		$hpage = $this->UG->getValue("MainMenu");
		return $hpage;
	}

}

?>
