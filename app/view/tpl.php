<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. (http://www.xixihe.com)
 * @author zhumingվ (www.xixihe.com)
 * @package kelecms
 * @subpackage app/view
 * @version $Id: tpl.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class keletpl{
	public $tpl;
	
	public function keletpl(){
		
	}
	public function tplget($model,$view,$data=''){		
		if($data)$GLOBALS['DATA']=$data;
		if($model=='append'||$model=='amend'||$model=='import')$model='edit';
		elseif($model=='show'||$model=='search')$model='show';
		$tpl=keledatabase::getthisone("kele_column","value='".$view."'",array("tpl","upcolumnid"));
		if(!$tpl)kele::exception('error','columnwrong');
		if($tpl['upcolumnid']<0)$tplname=$tpl['tpl'];
		else $tplname=$tpl['tpl']?$model.$tpl['tpl']:$model;
		$this->tpl = $tplname.'.php';
		if(!(kele::import(tpl_dir.$this->tpl,false))){
			$this->tpl = $tplname.$view.'.php';
			if(!(kele::import(tpl_dir.$this->tpl,false))){
				$this->tpl = $model.'.php';
				kele::import(tpl_dir.$this->tpl);
			}
		}
		kelemonitor::close();
	}
	public function tplupdate(){
		
	}
	public function tpluse(){
		
	}
}
?>