<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/contro
 * @version $Id: index.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
 class keleindex{
 	private $data;

	private  $dispatcher;
	private $area;
 	public function keleindex($area,$power){
 		$this->area=$area;
 		keleindex::data();
 		keleindex::view();
 		keleindex::file(); 		
 		keleindex::checkaction($area,$power);
		$this->data=array('model','contro','view');
 		$array=keledata::httpval($this->data);
 		keleindex::actiondid($array);
 	}
 	public function checkaction($area,$power){
 		keledata::checkdata(array($area,$power),'letter');
		keleindex::action("usedb","database","error");
		kele::monitor($area,$power);		
 	}
 	public function actiondid($array){
 		if(!$array['model'] && !$array['contro'] && !$array['view'])$array = array('model'=>'show','contro'=>'function','view'=>'index');
 		keledata::checkdata($array,'letter');
 		keleindex::action($array['model'],$array['contro'],$array['view']);
 	}
 	public function action($model,$contro,$view){
 		global $kele; 
 		$kele=$this->dispatcher = $this->area.$contro;
		if(!(kele::getinclass($this->area.'_'.$contro,false))){
			$kele=$this->dispatcher = 'kele'.$contro;
			if(!(kele::getinclass('app_contro_'.$contro,false))){		
				 kele::exception('error','wrongcontro');
			}
		}
		if(!is_object($this->dispatcher)){
			$kele = new $this->dispatcher($model,$contro,$view);	
		}else{
			$kele->$this->dispatcher($model,$contro,$view);	
		}
 	}
 	public function data(){
		kele::getinclass('app_model_data');
		new keledata();
 	}
 	public function view(){
		kele::getinclass('app_view_tpl');
		new keletpl();
 	}
 	public function file(){
		kele::getinclass('app_model_filebase');
		new kelefile();
 	}
 	
 }
?>