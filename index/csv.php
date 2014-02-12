<?php
/**
 * this is Redevelopment tcpdf
 * @author  zhuming
 * @version  kele
 * @deprecated D:\wamp\www\kele_utf8\kele\down.php
 * Wed May 05 15:37:22 CST 2010
 */
 !defined('kele_start') && die('NOTFINDE');
class indexcsv{
	public  $model;
	private $contro;
	public  $view;
	
	public function indexcsv($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		kele::getinclass("app_contro_function");
		if(in_array($this->model,array('down','import'))){
			kelemonitor::power($this->model,$this->view);
			$data=indexcsv::$model($view);
			keletpl::tplget($this->model,$view,$data);
		}else kele::exception('error',"model");
	}
		
	public function down($view){
		$fileexport=keledata::httpval('export');
		$fileexport="xls";
		$csv_sql=keledatabase::getarray("kele_csvfield","business ='".$view."'");
		if ($csv_sql) { 
			foreach ($csv_sql as $value){
				$tables[] = $value['tablename'];
				$fileds[] = $value['filedname'];
				if($value['csvtablebind'] == 'lord')$orderby[]=$value['tablename'].".id desc";
				else $where[] = $value['csvtablebind'];
			}
			$sfields=kelefunction::seachmemu($view);				
			if($sfields){
				foreach ($sfields['element'] as $key => $value) {
					foreach ($value as $val){
						if($val['type']){
							$table=keledatabase::getthisone("kele_table","classify='".$val['classify']."'","value");
							$result=keledatabase::getsearchvalue($table,$val['classify'],$val['field'],$val['type']);
							if($result){
								$where[]=$result[0];			
							}
						}
					}
				}
			}
			$csv_data = keledatabase::getarray($tables,$where,$fileds,$orderby);			
			if ($csv_data) {				
				$csv_data=indexcsv::joincsv($csv_data);				
				kele::getinclass('app_model_csv');
				$csv = new kelecsv($view);
				$num = count($csv_data);			
				kele::import("static/cache/csvfile/".$view,true);	
				global $array,$v_or_h;
				$files=$csv->csv_query($csv_data,$num,$array,$v_or_h);
			}
		}
		
		if (is_array($files)) {
			if(!$fileexport||$fileexport=='csv'){
				$data = file_get_contents($files[0]['file']);			
				 $filename = $view.'_csv_'.$files[0]['id'].'.csv';
				if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
				{
				header('Content-Type: "text/x-comma-separated-values"');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Content-Transfer-Encoding: binary");
				header('Pragma: public');
				header("Content-Length: ".strlen($data));
				}
				else
				{
				header('Content-Type: "text/x-comma-separated-values"');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header("Content-Transfer-Encoding: binary");
				header('Expires: 0');
				header('Pragma: no-cache');
				header("Content-Length: ".strlen($data));
				}
				exit($data);
			}else{
				$filename = $view.'_xls_'.$files[0]['id'].'.xls';
				$objWriter=kelecsv::csvtoxls($files[0]['file']);
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header('Content-Disposition:inline;filename="'.$filename.'"');
				header("Content-Transfer-Encoding: binary");
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Pragma: no-cache");
				$objWriter->save('php://output');
			}
		}
		kele::exception('error',"nofiletodown");
	}
	public function import($view){ 
		$upload = keledata::httpval('upload');
		if($upload){
			$file = kelefile::upfile();
			if ($file) {
				kele::getinclass('app_model_csv');
				$csv = new csv();
				kele::import("static/cache/csvfile/".$view,false);
				global $array;
				$data = $csv->csv_to_array(kele_dir.$file,$array);
			}
			return $data;
		}
	}
	public function joincsv($data){
		$rt=array();		
		foreach ($data as $val){
			if(isset($rt[$val['id']])){
				$n[$val['id']]+=1;
				foreach ($rt[$val['id']] as $k => $v){
					if($v==$val[$k]){
						continue;
					}else {
						$rt[$val['id']][$k.$n[$val['id']]]=$val[$k];						
					}
				}
			}else{
				$rt[$val['id']]=$val;
			}
		}
		return $rt;
	}
}
?>