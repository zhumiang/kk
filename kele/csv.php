<?php
/**
 * this is Redevelopment tcpdf
 * @author  zhuming
 * @version  kele
 * @deprecated D:\wamp\www\kele_utf8\kele\down.php
 * Wed May 05 15:37:22 CST 2010
 */
 !defined('kele_start') && die('NOTFINDE');
class kelecsv{
	public  $model;
	private $contro;
	public  $view;
	
	public function kelecsv($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		kele::getinclass("app_contro_function");
		if(in_array($this->model,array('down','import'))){
			kelemonitor::power($this->model,$this->view);
			$data=kelecsv::$model($view);
			keletpl::tplget($this->model,$view,$data);
		}else kele::exception('error',"model");
	}
		
	public function down($view){
		$id=keledata::httpval('id');
		if ($id) {
			keledata::checkdata($id,'number');
			$csv_sql=keledatabase::getarray("kele_csvfield","business ='".$view."'");
			if ($csv_sql) { 
				foreach ($csv_sql as $value){
					$tables[] = $value['tablename'];
					$fileds[] = $value['filedname'];
					if($value['csvtablebind'] == 'lord')$where[] = $value['tablename'].'.id='.$id;
					else $where[] = $value['csvtablebind'];
				}
				$csv_data = keledatabase::getarray($tables,$where,$fileds);
				if ($csv_data) {
					kele::getinclass('app_model_csv');
					$csv = new csv($view);
					$num = count($csv_data);
					kele::import("static/cache/csvfile/".$view,false);
					global $array;
					$files=$csv->csv_query($csv_data,$num,$array,'vertical');
				}
			}
		}
		
		if (is_array($files)) {
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
		}
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
}
?>