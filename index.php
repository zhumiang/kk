<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. (http://www.xixihe.com)
 * @author zhumingվ (www.xixihe.com)
 * @package kelecms
 * @subpackage kelecms
 * @version $Id: index.php 2008--@zhuming$
 */
if(defined('kele_start'))return false;
class kelecms{

	public $area;

	public $power;
	
	
	public function kelecms(){
		error_reporting(0);
		$this->area = 'index';
		$this->power = 'member';
		define('kele_start',true);		
		define('kele_debug',false);
		$http_dir="http://".$_SERVER ['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		define('http_dir',$http_dir.'/');
		define('kele_dir', dirname(__FILE__).'/');
		define('tpl_dir','tpl/default/');
		require(kele_dir.'app/index.php');
		new kele($this->area,$this->power);
		//$this->cking();
		
	}
	/*
	public function cking(){
		if(!is_readable(kele_dir.'static/config/config.php')){
			$this->goto();
		}else{
			$this->index();
		}
	}
	public function index(){
		require(kele_dir.'app/index.php');
		new kele($this->action,$this->power);
	}
	public function goto(){
		require(kele_dir.'install/index.php');
		new install();
	}*/
}
new kelecms();
?>