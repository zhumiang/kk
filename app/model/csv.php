<?php

class kelecsv{
	
	/**
	 * From the root directory of the local
	 *
	 * @var string
	 */
	protected $file_path = 'static/cache/';
	
	/**
	 * ftp switch
	 *
	 * @var  boolean 
	 */
	protected  $is_ftp = false;
	
	/**
	 * ftp configuration array
	 *
	 * @var array
	 */
	protected $ftp_config_arr = array();
	
	/**
	 * Specified directory
	 *
	 * @var string
	 */
	protected $folder = null;
	
	/**
	 * ftp upload path
	 *
	 * @var string
	 */
	protected $ftp_path = null;
	
	
	/**
	 * csv configure ftp and local storage path
	 *
	 * @param string $folder
	 * @return boolean
	 */
	public function kelecsv($folder = null){
		//$this->config->load('ftp_config',true);
		//$this->ftp_config_arr = $this->config->item('ftp_config');
		$this->is_ftp = false;
		$this->file_path = kele_dir.$this->file_path . $folder .'/';
		$this->folder = $folder;
		if ($this->is_ftp) {
		//$this->load->library('ftp');
			$this->ftp_path = $this->ftp_config_arr['ftp_config']['hostname'] . '/' . $this->ftp_config_arr['ftp_config']['default_folder'] . '/' . $folder .'/';
			return $this->ftp->connect($this->ftp_config_arr['ftp_config']);
		}
		return true;	
	}

	/**
	 * csv file name under the complete local path and ftp access to the path
	 *
	 * @param string $file_name
	 * @return array(Local path, ftp path exists)
	 */
	public function csv_file_get($file_name){
		if ($file_name && preg_match('/[^a-z0-9\-_.]/i', $file_name) === 0) {
			if (strtolower(substr($file_name, -4))  !=  '.csv') {
				$file_name .= '.csv';
			}
		}
		$file_local = $this->file_path.$file_name;
		$file_local = str_replace('\\','/', $file_local);
		if ($this->is_ftp) {
			$file_ftp = $this->ftp_path.$file_name;
			$file_ftp = str_replace('\\','/', $file_ftp);
			if (is_file($file_ftp) && !is_file($file_local)) {
				return array($file_ftp,null,true);
			}else {
				return array($file_ftp,$file_local,false);
			}
		}else {
			if(!file_exists($this->file_path)){
				@mkdir($this->file_path,0777);
			}
			if (is_file($file_local)) {
				return array(null,$file_local,true);
			}else{
				return array(null,$file_local,false);
			}
		}
	}
	
	/**
	 * Write to the file
	 *
	 * @param Local file $file_local
	 * @param The data written to the file $data
	 * @return boolean
	 */
	public function csv_write($file_local,$data){
		if ($file_local && $data) {
			
			if ( ! file_put_contents($file_local,$data)) {
				return false;
			}else {
				return true;
			}
		}
	}
	
	/**
	 * Uploaded to the specified ftp server, and return ftp file path
	 *
	 * @param Local file  $file_local
	 * @param ftp file  $file_ftp
	 * @return ftp file 
	 */
	public function csv_upload($file_local,$file_ftp,$close=false){
		if ($file_local && $file_ftp && $this->is_ftp) {
			return $this->ftp->upload( $file_local,$file_ftp, 'ascii', 0775);
			if($close) $this->ftp->close(); 
		}
		return true;
	}
	
	/**
	 * Database data into an array, write the file, and save, return to the list of files, update time data export, support ftp upload to remote
	 *
	 * @param string $query Database data
	 * @param int $num Database number
	 * @param array $array Cache array
	 * @param  string $v_or_h Vertical and horizontal
	 * @return unknown
	 */
	public function csv_query($query,$num,$array,$v_or_h = 'vertical',$file_name='',$is_output=true){
		$keys = array_keys($array);
		$key=0;
		foreach ($query as $value){			
			$result = true;
			$otherkey=array();
			if(!$file_name)$file_name = $this->folder.'_csv_' . $value['id'];
			list($file_ftp,$file_local,$is_saved) = $this->csv_file_get($file_name);
			if (!$is_saved || ($is_saved && $is_output)) {	
				if ($v_or_h == 'vertical') {
					foreach ($value as $k => $val){
						if (in_array($k,$keys)) {
							$array[$k]['value'] = $val;
						}
					}
				}elseif ($v_or_h == 'horizontal') {
					foreach ($array['header'] as $k=>$val){						
						if(strpos($k,"|")){
							$line[$k] = kelecsv::makeforcsvline($k,$value);
						}else{
							if(isset($value[$k."1"])){
								$otherkey[]=$k;
							}
							$line[$k] = isset($value[$k])?$value[$k]:null;
						}
					}
					if($otherkey){	
						$break=false;
						$i=1;
						while ($i<100){							
							foreach ($otherkey as $tm){							
								if(isset($value[$tm.$i]))
									$line[$tm.$i] = $value[$tm.$i];
								else
									$break=true;								
							}
							if($break)break;
							$i++;
						}
					}
				}		
				if(($key+1) == $num) $close = true;else $close = false;
				
				if ($v_or_h == 'horizontal') {
					$array[] = $line;
					unset($line);
					if(($key+1) == $num)  $result = $this->array_to_csv($array,$file_ftp,$file_local,$close);
					else $result = false;
				}elseif ($v_or_h == 'vertical'){
					$result = $this->array_to_csv($array,$file_ftp,$file_local,$close);
				}
				
			}
			if ($result) {
				$file_list[0]['id'] = $value['id'];
				if ($this->is_ftp) {
					$file_list[$key]['file'] = $file_ftp;
					if(!$is_saved) unlink($file_local);
				}else{
					$file_list[0]['file'] = $file_local;
				}
			}elseif(!$result && $v_or_h == 'vertical'){
				$file_list[$key]['id'] = $value['id'];
				$file_list[$key]['file'] = false;
			}
			$key++;
		}
		return $file_list;
	}
	public function makeforcsvline($code,$arr){
		$listcode=explode("|", $code);
		$return=null;
		switch ($listcode[0]){
			case 'math':
				if (strrpos($listcode[1], ",")){
					$keys=explode(",", $listcode[1]);
				}else{
					$keys=array($listcode[1]);
				}
				$math=$listcode[2];
				foreach ($keys as $n=>$k){
					if(isset($arr[$k]))					
						$math=str_replace("{".$n."}", $arr[$k], $math);
				}	
				$return=round(eval("return $math;"),2);
				break;
			case 'str':
				if (strrpos($listcode[1], ",")){
					$keys=explode(",", $listcode[1]);
				}else{
					$keys=array($listcode[1]);
				}
				foreach ($keys as $n=>$k){
					if(isset($arr[$k]))
						$val[]=$arr[$k];
				}
				$return=implode($listcode[2], $val);
				break;
			case 'fun':
				break;
		}
		return $return;
	}
	/**
	* Array to CSV
	*
	* download == "" -> return CSV string
	* download == "toto.csv" -> download file toto.csv
	*/
	public function array_to_csv ( $array ,$file_ftp = null,$file_local, $close = false)
	{	
		ob_start ();
		$f = fopen( 'php://output' , 'w' ) or show_error ( "Can't open php://output" );
		$n = 0 ;
		foreach ( $array as $line )
		{
			$n ++;
			foreach ($line as $k=>$item){
				$line[$k]='="'.iconv("utf-8", "gb2312",keledata::htmlchars_decode($item)).'"';
			}
			if ( ! fputcsv ( $f , $line ))
			{
				show_error ( "Can't write line $n: $line" );
			}
		}
		fclose ( $f ) or show_error ( "Can't close php://output" );
		$str = ob_get_contents ();
		ob_end_clean ();
		$true = $this->csv_write($file_local,$str);
		if ($this->is_ftp && $true && $file_ftp) $true = $this->csv_upload($file_local,$file_ftp,$close);
		return $true;
	}
	public function csv_to_array($file){
		$arr=array();
		if(!file_exists($file))
			return false;
		$file = fopen($file,"r");
		if($file){
			while ($data = fgetcsv($file)) {
				$arr[]=$data;
			}			
		}
		fclose($file);		
		return $arr;
	}
	public function csvtoxls($csv){
		$xls=str_replace(".csv", ".xls", $csv);
		kele::getinclass("lib_PHPExcel");
		$objPHPExcel = new PHPExcel();		
		$arr=kelecsv::csv_to_array($csv);
		$cellline=array();
		 foreach ($arr as $n => $val){
		 	foreach ($val as $m => $str){
		 		if($m>26)kele::exception('error','xlsovercell');
		 		$cell=chr(ord('A')+$m);
		 		$row =$n+1;
		 		if(!in_array($cell, $cellline)){
		 			array_push($cellline, $cell);
		 			$objPHPExcel->getActiveSheet()->getColumnDimension($cell)->setWidth(30);
		 		}
		 		if($n>0&&$m==0){
		 			$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(90);		 			
		 		}
		 		$objPHPExcel->getActiveSheet()->getStyle($cell.$row)->getAlignment()->setWrapText(true);
		 		if(stripos($str, ".jpg")&&file_exists(kele_dir.$str)){
		 			$objDrawing = new PHPExcel_Worksheet_Drawing();
		 			$objDrawing->setPath($str);
		 			$objDrawing->setHeight(100);
		 			$objDrawing->setWidth(100);
		 			$objDrawing->setCoordinates($cell.$row);
		 			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		 		}
		 		else
					$objPHPExcel->getActiveSheet()->setCellValue($cell.$row, iconv('gb2312', 'utf-8',$str));
		 	}
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($xls);
		return $objWriter;
	}
}
?>