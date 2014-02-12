<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: monitor.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class kelemonitor {
	public $area;

	public $power;
	
	public function pro(){
		 global $property;
		 return $property;
	}
	public function kelemonitor($area,$power){
		global $property;
		$property=$this->area=$area;
		$this->power=$power;
		kelemonitor::sysconfig();
		kelemonitor::checklogin($area,$power);
	}
	public function power($model,$column){
		global $property,$monitor;
		if($column)$classify=keledatabase::getthisone("kele_column","value='".$column."'","classify");
		if(!$classify)kele::exception('error','columnwrong');
		$newobj=$property.'monitor';
		if(kele::getinclass($property.'_monitor',false)){
			$monitor = new $newobj($model,$column,$classify);
		}
		return true;
	}
	public function limit($view){
		global $monitor;
		if(is_object($monitor))return $monitor->limit($view);
		return "";
	}
	public function checklogin($area,$power){
		if($this->power=="guest")return true;
		if(keledata::getsession('userid')){
			keleindex::action("onlineuser","member","login");
		}else{
			keleindex::action("login","member","login");
		}
	}
	public function sysconfig(){
		global $time_start;
		$system=keledatabase::getarray("kele_system",'',array("value ","systemvalue"));
		foreach ($system as $value){
			$GLOBALS['KELE'][$value['value']]=$value['systemvalue'];
		}
		$url=keledata::geturl("now");
		$time_start = kelemonitor::microtime_float();
	}
	public function microtime_float(){
   		list($usec, $sec) = explode(" ", microtime());
    		return ((float)$usec + (float)$sec);
	}
	public function close(){
		global $time_start;
		keledatabase::close();
		usleep(100);
		if(kele_debug){
			$time_end = kelemonitor::microtime_float();
			$time = $time_end - $time_start;
			echo $time;
		}
		exit();
	}

}
?>