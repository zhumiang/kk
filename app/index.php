<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc.
 * @author zhuming
 * @package kelecms
 * @subpackage app
 * @version $Id: index.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class kele{

	private  $dispatcher;

	public $power;
	public function kele($area,$power){
		$this->power = $power;
		$this->dispatcher = $area.'index';
		if(!(kele::getinclass($area.'_index',false))){
			$this->dispatcher = $area.$area;
			if(!(kele::getinclass($area.'_'.$area,false))){
				$this->dispatcher = 'kele'.$area;
				if(!(kele::getinclass('app_contro_'.$area,false))){		
					 kele::exception('error','wrongcontro');
				}
			}
		}
		new $this->dispatcher($area,$power);
	}
	public function getinclass($classname,$false=true){
		if (class_exists($classname)) { return true; }
		if (preg_match('/[^a-z0-9\-_.]/i', $classname) === 0) {
	        $filename = kele::getinfile($classname . '.php');
	        if ($filename){
	        	require_once($filename); return true;
	        }elseif ($false==false)return false;
	        else  kele::exception('error','wrongcontro');
	   }
        return false;
	}
	public function import($dir,$false=true){
		$dir = str_replace('\\','/', $dir);
		$path = kele::getinfile($dir);
       		 if ($path != '') {
       		 	require_once($path);
       		 	return true;
       		 }
       		 elseif($false==false)return false;
       		 else  kele::exception('error','filewrong');
	}
	public function getinfile($filename){
		$filename = str_replace('_','/', $filename);
		if (strtolower(substr($filename, -4)) != '.php') {
			$filename .= '.php';
		} 
		if (is_file($filename)) {
			$filepath = $filename;
		}else{
			$filepath = kele_dir.$filename; 
			$filepath = str_replace('\\','/', $filepath);
		}
		if (is_file($filepath)) {return $filepath; }
		return false;
	}
	public function exception($model='',$view=''){
		kele::import("static/cache/url.php");
		global $gourl;
		if($model=="error")$GLOBALS['DATA']['jumptime'] = 2;
		else $GLOBALS['DATA']['jumptime'] = 0;
		$error=$gourl[$model][$view]?$gourl[$model][$view]:$gourl[$model]['default'];
		$gotourl=$gourl[$model][$view."_url"]?$gourl[$model][$view."_url"]:$gourl[$model]['default_url'];
		if($gotourl=="-1"){
			$GLOBALS['DATA']=array(
				'result' => $error,
				'url'=>'javascript:history.go(-1);',
			);
			kele::import("tpl_system_jumppage");
		}
		else{
			if ($gotourl=="back")$url=keledata::geturl("back");
			elseif ($gotourl=="goback")$url=keledata::geturl("goback");
			else $url=$gotourl?$gotourl:"";
			$GLOBALS['DATA']=array(
				'result' => $error,
				'url'	 => $url
			);
			kele::import("tpl_system_jumppage");
			/**
			echo "<script>alert('{$error}');location.href='$url'</script>";
			echo "<script>alert('{$error}');history.go(-1);</script>";
			**/
		}
		kelemonitor::close();
	}
	
	public function monitor($area,$power){
		kele::getinclass("app_model_monitor");
		new kelemonitor($area,$power);
	}
}

?>