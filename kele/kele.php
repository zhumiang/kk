<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage kele
 * @version $Id: kele.php  2008--@zhuming$
 */
class kelekele{

	public $area;

	public $power;

	public function kelekele($area='',$power=''){
		error_reporting(0);
		$this->area='kele';
		$this->power='member';
		if($area || $power){
			if($area!==$this->area && $power!==$this->power)
				kele::exception();
			else {
				kele::getinclass("app_contro_index");
				new keleindex($this->area,$this->power);
			}
		}else kelekele::index();
	}
	

	public function index(){
		if ($this->area==strtolower(substr(dirname(__FILE__), -4))) {
			$dir=strtolower(substr(dirname(__FILE__),0,-4));
			$http_dir="http://".$_SERVER ['HTTP_HOST'].strtolower(substr(dirname($_SERVER['PHP_SELF']),0,-4));
			define('http_dir',$http_dir);
			define('kele_dir',$dir);
			define('kele_start',true);
			define('kele_debug',false);
			define('tpl_dir','tpl/kele/');
		}else exit;
		require(kele_dir.'app/index.php');
		new kele($this->area,$this->power);
	}
}
if(!defined('kele_start'))new kelekele();
?>