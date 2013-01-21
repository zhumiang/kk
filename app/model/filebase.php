<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: filebase.php  2008--@zhuming$
 */
!defined('kele_start') && die('NOTFINDE');
class kelefile {

	private $rootpath;
	
	private  $power;

	private $system;
	
	private $data;

	public function kelefile($rootpath="",$power=""){
		$this->power = $power;
		$this->rootpath = $rootpath;
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')$this->system='win';
		else $this->system='unix';
	}

	public function dir_info($path){
		$dir = $this->rootpath.'/'.$path;
		if(is_dir($dir)){
			$dirsize = kelefile::dir_size($dir);
			$dirtime = filemtime($dir);
			if($this->system=='win'){
				
			}
			$diraccess;
		}
	}
	
	public function file_info($filename){
		
	}

	public function path(){
		
	}

	public function makedir($dir){
		$d = explode("/", $dir);
		$folder = $this->rootpath."/";
		for ($i = 0; $i < count($d); ++$i){
			if(!$d[$i])continue;
		    $folder .= "{$d[$i]}/";
		    if (!file_exists($folder))
		    {
		        if (!@mkdir($folder, 0777))return false;
		    }
		}
		return true;
	}
	
	public function chagedir(){
		
	}
	
	public function rmdir(){
		
	}
	
	public function copydir(){
		
	}
	
	public function movedir(){
		
	}
	
	public function listfile(){
		
	}

	public function chkpath(){
		
	}

	public function makefile(){
		
	}
	
	public function upfile($table,$field,$type){
		if($type='img')$pass=array('png','jpg','jpeg','gif','swf');
		else $pass=array('rar','zip','gz','doc','xls','pdf');
	    $value=$_FILES[$table];
			if(is_array($value)){
				$filename	= $value['name'][$field];
				$tmpfile	= $value['tmp_name'][$field];
				$filesize	= $value['size'][$field];
			}
			else
			{
				$filename	= ${$key.'_name'};
				$tmpfile	= $$key;
				$filesize	= ${$key.'_size'};
			}
			if(!$tmpfile || $tmpfile=='none'){
				return false;
			}elseif(function_exists('is_uploaded_file') && !is_uploaded_file($tmpfile) && !is_uploaded_file(str_replace('\\\\', '\\', $tmpfile))){
				return false;
			}
			else
			{
				$file_ext = strtolower(substr(strrchr($filename,"."),1));
				if(!in_array($file_ext,$pass))kele::exception("error","upwrong");
				$tname="CGI/upload/".date('Ymd').time().$field.".".$file_ext;
				if(strpos($tname,'..')!==false || eregi("\.php$",$tname)){
					kele::exception("error","updirwrong");
				}
				if(function_exists("move_uploaded_file") && @move_uploaded_file($tmpfile,kele_dir.$tname)){
					@chmod($tname,0777);
					keledatabase::insert(array("$tname",keledata::getsession('userid')),"kele_files",array("path","userid"));
					return $tname;
				}elseif(@copy($tmpfile, kele_dir.$tname)){
					keledatabase::insert(array("$tname",keledata::getsession('userid')),"kele_files",array("path","userid"));
					@chmod($tname,0777);
					return $tname;
				}
			}
	}
	
	public function rmfile(){
		
		P_unlink();
	}

	public function chagefile(){
		
	}	
	
	public function readfile(){
		
	}

	public function writefile(){
		
	}
	
	public function eidtfile(){
		
	}

	public function copyfile(){
		
	}

	public function movefile(){
		
	}
	
	public 	function dir_size($dir){
    	$handle=opendir($dir); 
    	while(false!==($dirOrFile=readdir($handle))){
        	if($dirOrFile!="."&&$dirOrFile!=".."){ 
        	    if(is_dir("$dir/$dirOrFile")) 
            	    $size+=dir_size("$dir/$dirOrFile"); 
            	else 
            	    $size+=filesize("$dir/$dirOrFile"); 
            	    
        		} 
    		} 
   		 closedir($handle);
   		 return $size; 
	}


	public function miniImg($sourceImg,$width,$height,$quality=85){
		//if(strtolower(end(explode('.',$sourceImg))) == 'gif') return $sourceImg;	
		global $imgmodel;
		kele::getinclass("app_model_img");
		if(!is_object($imgmodel))$imgmodel=new keleimg();
		$imgmodel->admin($width,$height);
		list($sourceImg,$targetImg,$SmallImg) = $imgmodel->getAttachPath($sourceImg);
		if(!is_file($targetImg)){
			 $imgmodel->resize_image($sourceImg,$targetImg,$width,$height,$quality);
		}
		return $SmallImg;
	}

}

?>