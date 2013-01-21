<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc.
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: data.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class keledata{
	public function keledata(){
		keledata::filter();
 		if(!get_magic_quotes_gpc()){
			keledata::addval($_POST);
			keledata::addval($_GET);
			keledata::addval($_COOKIE);
		}
		keledata::addval($_FILES);
	}
	public function fordata($array,$dispatcher,$is_function){	
		foreach ($array as $key=>$value){
			if(!is_array($value)){
				if($is_function==false)$array[$key] = keledata::$dispatcher($value);
				else $array[$key] = $dispatcher($value);
			}else {
				$array[$key]=keledata::fordata($array[$key],$dispatcher,$is_function);
			}
		}
		return $array;
	}
	
	public function httpval($data){
		if(!is_array($data)){ 
			if(isset($_GET[$data]))$array=$_GET[$data];
			elseif (isset($_POST[$data]))$array=$_POST[$data];
		}else{
			$array = array();
			foreach ($data as $val){
				if(isset($_GET[$val])){
					$array[$val]=$_GET[$val];
				}elseif (isset($_POST[$val])){
					$array[$val]=$_POST[$val];
				}
			}
		}
		return $array;
	}
	
	public function addval($array){
		if (!is_array($array)) {
			$array = addslashes($array);
		}else {
			$array = keledata::fordata($array,'addslashes',true);
		}	
		return $array;
	}
	
	public function stripval($array){
		if (!is_array($array)) {
			$array = stripslashes($array);
		}else {
			$array = keledata::fordata($array,'stripslashes',true);
		}	
		return $array;
	}
	
	public function strval($array){
		if (!is_array($array)) {
			$array = keledata::replace($array);
		}else {
			$array = keledata::fordata($array,'replace',false);
		}	
		return $array;
	}
	
	public function replace($value){		
		$value = str_replace('&','&amp;',$value);
		//$value = str_replace('&nbsp;',' ',$value);
		$value = str_replace('"','&quot;',$value);
		$value = str_replace("'",'&#039;',$value);
		$value = str_replace("<","&lt;",$value);
		$value = str_replace(">","&gt;",$value);
		$value = str_replace("\t","   &nbsp;   &nbsp;",$value);
		$value = str_replace("\r","",$value);
		$value = str_replace("\n","<br>",$value);
		$value = str_replace("   "," &nbsp; ",$value);
		return $value;
	}

	public function pagemover($size,$sum,$url,$page,$pagesize='5'){
		if($page<1)$page=1;
		$num=ceil($sum/$size);
		!$num&&$num=1;
		$pagedb=array();
		$pagedb['url']=$url;
		$pagedb['page']=($page<=$num)?$page:$num;
		($num<=1 || $pagedb['page']==1)?$pagedb['pagebefor']=1:$pagedb['pagebefor']=$pagedb['page']-1;
		($num<=1)?$pagedb['pageback']=1:($pagedb['page']==$num?$pagedb['pageback']=$num:$pagedb['pageback']=$pagedb['page']+1);
		((intval($pagedb['page']/$pagesize)+1)*$pagesize<$num)?($pagedb['pagemax']=(intval($pagedb['page']/$pagesize)+1)*$pagesize):$pagedb['pagemax']=$num;
		intval($pagedb['page']/$pagesize)?$pagedb['pagenum']=(intval($pagedb['page']/$pagesize))*$pagesize:$pagedb['pagenum']=1;
		if(($num/$pagesize)>1){($pagedb['page']>($pagedb['pagenum']-1)&&($pagedb['pagenum']-1)>0)?$pagedb['pageone']='...':$pagedb['pageone']='';
		($pagedb['page']<$pagedb['pagemax']&&$pagedb['pagemax']<$num)?$pagedb['pagetowe']='...':$pagedb['pagetowe']='';}	
		$pagedb['pagelast']=$num;
		return $GLOBALS["pagedb"]=$pagedb;
	}
	
	public function checkdata($data,$switch='',$false=true){
		global $checkdataswitch;
		$checkdataswitch=$switch;
		if(!is_array($data)){
			$true=keledata::strcheck($data);
		}else {
			$true=keledata::fordata($data,'strcheck',false);
		}
		if($true) return $true;
		elseif ($false==false) return false;
		else kele::exception("error","datawrong");
	}
	
	public function strcheck($data){
		global $checkdataswitch,$dbmation;
		switch ($checkdataswitch){
			case 'number':
				$str="/^-?[0-9]\d*$/";
				break;
			case 'letter':
				$str="/^[A-Za-z]+$/";
				break;
			case 'chinese':
				if($dbmation['charset']=="gbk")$str="/^[".chr(0xa1)."-".chr(0xff)."]+$/";
				else $str="/[\x7f-\xff]/";
				break;
			case 'email':
				$str = "/^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i";
				break;
			default:
				$str="/^[A-Za-z0-9]+$/";
				break;
		}
		return preg_match($str,$data);
	}
	
	public function getcookies(){
			
	}
	
	//cookiesֵ
	public function setcookies(){
		
	}
	
	public function getsession($array){
		session_start();
		$card=kelemonitor::pro();
		if(!is_array($array)){
			$array = $_SESSION[$card.$array];
		}else {
			foreach ($array as $value){
				$array[$value]=$_SESSION[$card.$value];
			}
		}
		if(!$array)return false;
		else return $array;
	}
	
	public function setsession($array){
		session_start();
		$card=kelemonitor::pro();
		if(!is_array($array)){
			$_SESSION[$card.$array]=$array;
		}else {
			foreach ($array as $key => $value){
				session_register($card.$key);
				$_SESSION[$card.$key]=$value;
			}
		}
		return true;
	}
	public function delsession($array){
		$card=kelemonitor::pro();
		session_start();
		if(!is_array($array)){
			unset($_SESSION[$card.$array]);
		}else {
			foreach ($array as $value){
				unset($_SESSION[$card.$value]);
			}
		}
		return true;
	}

	public function substrs($content,$length,$num=0,$add=0,$code=''){
		$code = $code ? $code : 'gbk';
		$content = strip_tags($content);
		if($length && strlen($content)>$length){
			$retstr='';
			if($code == 'UTF-8'){
				$retstr = utf8_trim($content,$length,$num);
			}else{
				for($i = 0; $i < $length; $i++) {
					if(ord($content[$i]) > 127){
						if($num){
							$retstr .=$content[$i].$content[$i+1];
							$i++;
							$length++;
						}elseif(($i+1<$length)){
							$retstr .=$content[$i].$content[$i+1];
							$i++;
						}
					}else{
						$retstr .=$content[$i];
					}
				}
			}
			return $retstr.($add ? '...' : '');
		}
		return $content;
	}
	
	public function utf8_trim($string,$length,$num) {
		if($length && strlen($string)>$length){
			if($num){
				$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
				preg_match_all($pa, $string, $t_string);
				return join('', array_slice($t_string[0], 0, $length));
			}else{
				$hex = '';
				$str = substr($string,0,$length);
				for($i=$length-1;$i>=0;$i--){
					$ch   = ord($str[$i]);
					$hex .= ' '.$ch;
					if(($ch & 128)==0)	return substr($str,0,$i);
					if(($ch & 192)==192)return substr($str,0,$i);
				}
				return($str.$hex);
			}
		}
		return $string;
	}
	
	public function getip(){
		if($_SERVER['HTTP_X_FORWARDED_FOR']){
			$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif($_SERVER['HTTP_CLIENT_IP']){
			$onlineip= $_SERVER['HTTP_CLIENT_IP'];
		}else{
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		$onlineip = preg_match("/^[\d]([\d\.]){5,13}[\d]$/", $onlineip) ? $onlineip : 'unknown';
		return $onlineip;
	}
	
	public function geturl($str=""){
		if($_SERVER['SERVER_PORT']!="80") $port = ":" . $_SERVER['SERVER_PORT'];
		else $port="";
		$url['now']='http://'.$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];		
		$url['index']="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$url['goback']=keledata::getsession("goback");
		$url['back']=keledata::getsession("back");
		keledata::setsession(array("goback"=>$url['back']));
		keledata::setsession(array("back"=>keledata::getsession("now")));
		keledata::setsession(array("now"=>$url['now']));
		return $url[$str];
	}
	public function htmlchars_decode($str){
		$encode = array('   &nbsp;   &nbsp;','&quot;','&#039;','&lt;','&gt;','<br>','&amp;',' &nbsp; ');
		$decode = array("\t",'"','\'','<','>',"\n",'&','   ');
		$str = str_replace($encode,$decode,$str);
		return $str;
	}
	public function filter(){
		$defineds = get_defined_vars();
		foreach ($defineds as $key => $value){
			if(!in_array($key,array('GLOBALS','_POST','_GET','_COOKIE','_SERVER','_FILES'))){
				unset(${$key});
			}
		}
	}
	public function resolve($str,$val=""){
		if($str){
			if(stristr($str,"%userid")){
				$encode[]='%userid';
				$decode[]=$val?$val:keledata::getsession("userid");
			}
			if(stristr($str,"%departmentid")){
				$encode[]='%departmentid';
				$decode[]=$val?$val:keledata::getsession("departmentid");
			}
			if(stristr($str,"%ttime")){
				$encode[]='%ttime';
				$decode[]=$val?date("Y-m-d",$val):date("Y-m-d",time());
			}
			if($encode)$str = str_replace($encode,$decode,$str);
		}
		return $str;
	}
}
?>