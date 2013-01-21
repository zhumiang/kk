<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: img.php  2008--@zhuming$
 */
!defined('kele_start') && die('NOTFINDE');

class keleimg{
	public  $picheight; //附件图片缩略高度
	public $picwidth; //附件图片缩略宽度	
	public function keleimg(){
		
	}
	public function admin($picwidth,$picheight){
		$this->picheight=$picheight;
		$this->picwidth=$picwidth;
	}
	public function getAttachPath($imgsrc){ //获取到一个附件的绝对路径和文件名称
		if($this->picheight && $this->picwidth){
			$nameadd=$this->picwidth.'_'.$this->picheight.'_';
		} 
		$SourceImg = $TargetImg = $SmallImg ='';
		if (strpos($imgsrc,'http://')==0){ //说明是一个网址
			$temppath = kele_dir.'CGI/upload/temp/'; //此路径为临时图片保存目录
			$file_ext = end(explode('.',$imgsrc));
			$imgname = substr(md5($imgsrc),10,10).'.'.$file_ext;
			//$savedir = $this->saveDir();
			$SourceImg = $temppath.$imgname; //绝对路径
			$SmallImg = 'CGI/upload/img/'.$nameadd.$imgname;
			$TargetImg = kele_dir.$SmallImg;
			if(!file_exists($SourceImg)) getContent::copy($imgsrc,$SourceImg);
			/* 将图片保存至本地 */
		}else{
			$i_a = pathinfo($imgsrc);
			$SmallImg = $i_a['dirname'].'/'.'s_'.$nameadd.$i_a['basename'];
			
			$SourceImg = kele_dir.$imgsrc; //绝对路径
			$TargetImg = kele_dir.$SmallImg;
		}
		return array($SourceImg,$TargetImg,$SmallImg);
	}

	public function resize_image($oldimg='', $newimg='', $picwidth=0, $picheight=0, $quality=80){ //缩略附件图片
		$picwidth==0 && $picwidth = $this->picwidth;
		$picheight==0 && $picheight = $this->picheight;

		if(!trim($oldimg) || !trim($newimg) || !is_file($oldimg)){
			return 0;
		}
		if(!$picwidth && !$picheight){
			return 0;
		}
		if($picwidth<0 || $picheight<0 || $quality<1){
			return 0;
		}
		// Get the extend name of the old file
		$filename = $oldimg;
		if (strstr($oldimg, "/")){
			$filename = end(explode("/", $oldimg));
		}
		if (!strstr($filename, ".")){
			return 0;
		}

		$extname = strtolower(end(explode(".",$filename)));

		//检验新文件
		$filename = $newimg;
		if (strstr($newimg,"/")){
			$filename = end(explode("/",$newimg));
		}
		if (!strstr($filename,".")){
			return 0;
		}
		$nextname = strtolower(end(explode(".",$filename)));
		//文件检验完毕
		// Select the format of the new image

		switch ($extname){
			case "jpg"	:
				$im = imagecreatefromjpeg($oldimg);
				break;
			case "jpeg"	:
				$im = imagecreatefromjpeg($oldimg);
				break;
			case "gif"	:
				$im = imagecreatefromgif($oldimg);
				break;
			case "png"	:
				$im = imagecreatefrompng($oldimg);
				break;
			default		:
				return 0;
				break;
		}
		$color = imagecolorallocate($im, 255, 255, 255);
		$filesize = getimagesize($oldimg);
		if($filesize[1]==$picheight && $filesize[0]==$picwidth){
			copy($oldimg,$newimg);
			return 1;
		}
		if ($picwidth && !$picheight){
			$picheight = $filesize[1]*$picwidth/$filesize[0];
		}else if (!$picwidth && $picheight){
			$picwidth = $filesize[0]*$picheight/$filesize[1];
		}

		$p = ($picwidth/$picheight);
		if($filesize[0]/$filesize[1] > $p){ //说明宽度太大
			$newheight = $filesize[1];
			$newwidth = $newheight*$p;
		}else{
			$newwidth = $filesize[0];
			$newheight = $newwidth/$p;
		}
		if ($nextname != 'gif' && function_exists('imagecreatetruecolor')) {
			$output = imagecreatetruecolor($picwidth,$picheight);
		}else{
			$output = imagecreate($picwidth,$picheight);
		}
		if (function_exists('imagecopyresampled')){
			imagecopyresampled($output,$im,0,0,0,0,$picwidth,$picheight,$newwidth,$newheight);
		} else{
			imagecopyresized($output,$im,0,0,0,0,$picwidth,$picheight,$newwidth,$newheight);
		}
		switch($nextname){
			case "jpg" :
			case "jpeg":
				$result = imagejpeg($output, $newimg , $quality);
				break;
			case "gif" :
				$result = imagegif($output, $newimg);
				break;
			case "png" :
				$result = imagepng($output, $newimg);
				break;
			default    :
				$result = 0;
				break;
		}
		imagedestroy($output);
		if ( $result ){
			return 1;
		}else{
			return 0;
		}
	}
}

class getContent{
	public $config;

	public function copyFile($from,$to){
		if(strpos($to,"..")!==false) return ;
		if(ini_get('allow_url_fopen')){
			copy($from,$to);
			/*
			$this->data = file_get_contents($from);
			writeover($to,$this->data);
			*/
		}else{
			$this->open($from);
			$this->send();
			$this->getUrlContent();
			writeover($to,$this->data);
		}
	}

	public function open($url){
		$path = parse_url($url);
		$this->host=$path['host'];
		$this->port=$path['port'];
		$this->path=$path['path'];
		if($path['query']) $this->path .= "?".$path['query'];
		if(empty($this->port)){
			$this->port=80;
		}elseif ($path['scheme']=='https'){
			$this->port=443;
		}elseif ($path['scheme']=='http'){
			$this->port=80;
		}
		$this->scheme = $this->port==80 ? "http://" : "https://";
		$this->connect(); //开始连接
	}

	public function connect(){
		$timeout = 10;
		$errorno = 0;
		$errorstr= '';

		$this->fp=@fsockopen($this->host,$this->port,$errorno,$errorstr,$timeout);
		if(!$this->fp){
			return ;
		}
	}

	/**
	 * 向远程主机写入信息
	 *
	 */
	public function send(){
		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		$http="GET $this->path HTTP/1.1\r\n";
		$http.="Host: $this->host:$this->port\r\n";
		$http.="Accept:*/*\r\nAccept-Encoding: identity\r\n";
		$http.="User-Agent: $user_agent\r\n\r\n";
		fputs($this->fp,$http);
	}

	/**
	 * 获取网址中的页面内容
	 *
	 */
	public function getUrlContent(){
		while (!feof($this->fp)){
			$this->data .= fgets($this->fp,8192);
		}
		fclose($this->fp); //关闭连接
		$pos = strpos($this->data,"\r\n\r\n");
		$this->data = trim(substr($this->data,$pos+4)); //截取头信息
	}

	/**
	 * 静态调用方法
	 *
	 * @param string $from 来源网址
	 * @param string $to 目标文件
	 */
	public function copy($from,$to){
		$getContent = new getContent();
		$getContent->copyFile($from,$to);
	}
}
?>