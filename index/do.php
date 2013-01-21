<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage index
 * @version $Id: do.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
 class indexdo{
 	
 	public  $model;//操作函数
	public  $contro;//操作指令
	public  $view;//操作页面
	public function indexdo($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		$this->grade=keledata::getsession('grade');
		kele::getinclass("app_contro_function");
		if(in_array($this->model,array('show','append','amend','delete','system','search'))){
			kelemonitor::power($this->model,$this->view);
			keletpl::tplget($this->model,$view);
		}
		else kele::exception('error','model');
	}
 }
 ?>