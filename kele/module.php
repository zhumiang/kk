<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage kele
 * @version $Id: module.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class kelemodule{
	public  $model;
	private $contro;
	public  $view;
	
	public function kelemodule($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		kele::getinclass("app_contro_function");
		if(in_array($this->model,array('show','append','amend','delete','search'))){
			kelemonitor::power($this->model,$this->view);
			$data=kelemodule::$model($view);
			keletpl::tplget($this->model,$view,$data);
		}else kele::exception('error',"model");
	}
		
	public function show($view){
		$id=keledata::httpval('id');
		if ($id) {
			keledata::checkdata($id,'number');
			$data['table']=keledatabase::getthisone("kele_table","id=".$id);
			$data['field']=keledatabase::getarray("kele_field","id in (".$data['table']['fields'].")");
			return $data;
		}
	}
	public function append($view){
		$parameter=keledata::httpval('append');
		if($parameter==true){
			$table=keledata::httpval('table');
			if($table['value']&&$table['fields']&&$table['classify']){
			if(keledatabase::getthisone("kele_table","value='".$table['value']."'","id"))kele::exception("error","tablename");
			$fields=keledatabase::getarray("kele_field","id in (".$table['fields'].")");
			$count=array_count_values(explode(",",$table['fields']));
			foreach ($fields as $value){
				if($count[$value['id']]>1)kele::exception("error","fieldsame");
				$value['size']=$value['size']?'('.$value['size'].')':'';
				if ($value['id']=="1") $field[]="`".$value['value']."` ".$value['type'].$value['size']." NOT NULL AUTO_INCREMENT ,PRIMARY KEY ( `id` )";
				else $field[]="`".$value['value']."` ".$value['type'].$value['size']." NOT NULL ";
			}
			}else kele::exception("error","dataless");
			$field=implode(",",$field);
			keledatabase::insert($table,'kele_table',array_keys($table));
			$sql="CREATE TABLE `{$GLOBALS['dbmation']['dbname']}`.`".$table['value']."` ( ".$field." ) ENGINE = MYISAM;";
			keledatabase::query($sql,'unbuffered');
			kele::exception('append',$view);	
		}
	}
	public function amend($view){
		$parameter=keledata::httpval('amend');
		if($parameter==true){
		if($view=="table"){
			$table=keledata::httpval('table');
			$oldtable=keledatabase::getthisone("kele_table","id=".$table['id']);
			if(keledatabase::getthisone("kele_table","value='".$table['value']."' and id!=".$table['id']))
			kele::exception("error","tablename");
			foreach ($table as $key => $value){
				if ($value!=$oldtable[$key]) {
					$updates[]=$key."='".$value."'";
				}
			}
			if($table['fields']!=$oldtable['fields']){
				$fields=array_diff(explode(",",$table['fields']),explode(",",$oldtable['fields']));
				$fields=implode(",",$fields);
				$fields=keledatabase::getarray("kele_field","id in (".$fields.")");
				if(!$fields)kele::exception("error","fieldwrong");
				$count=array_count_values(explode(",",$table['fields']));
				foreach ($fields as $value){
					$value['size']=$value['size']?'('.$value['size'].')':'';
					if($count[$value['id']]>1)kele::exception("error","fieldsame");
					$field[]="  ADD `".$value['value']."`".$value['type'].$value['size']." NOT NULL ";
				}
				$field=implode(",",$field);
				$sql="ALTER TABLE `".$oldtable['value']."`".$field;
				keledatabase::query($sql,'unbuffered');
			}
			if($oldtable['value']!=$table['value']){
			$sql="RENAME TABLE `{$GLOBALS['dbmation']['dbname']}`.`".$oldtable['value']."` TO `{$GLOBALS['dbmation']['dbname']}`.`".$table['value']."` ;";
			keledatabase::query($sql,'unbuffered');
			}
			if($updates)keledatabase::update("kele_table",$updates,"id=".$table['id']);
			kele::exception("amend",$view);
		}elseif ($view=="field"){
			$field=keledata::httpval('field');
			$oldfield=keledatabase::getthisone("kele_field","id=".$field['id']);
			if(keledatabase::getthisone("kele_field","value='".$field['value']."' and id!=".$field['id']))
			kele::exception("error","fieldsame");
			foreach ($field as $key => $value){
				if ($oldfield[$key]!=$value){
					$updates[]=$key."='".$value."'";
					if(in_array($key,array("value","type","size")))$chang=" CHANGE `".$oldfield['value']."` `".$field['value']."`".$field['type']."(".$field['size'].") NOT NULL ";
				}
			}
			if ($chang) {
				$array=keledatabase::getarray("kele_table");
				foreach ($array as $value){
					if(in_array($field['id'],explode(",",$value['fields']))){
						$sql="ALTER TABLE `".$value['value']."`".$chang;
						keledatabase::query($sql,'unbuffered');
					}
				}
			}
			if($updates)keledatabase::update("kele_field",$updates,"id=".$field['id']);
			kele::exception("amend",$view);
		}
		}else {
			return kelemodule::show($view);
		}
	}
	public function delete($view){
			if ($view=="table") {
				keledata::checkdata($id=keledata::httpval('id'),'number');
				if ($id) {
				$table=keledatabase::getthisone("kele_table","id=".$id,"value");
				$sql="DROP TABLE `".$table."`;";
				keledatabase::query($sql,'unbuffered');
				keledatabase::delete("kele_table","id=".$id);
				}
				kele::exception("delete",$view);
			}elseif ($view=="field") {
				$array=keledata::httpval(array('table','field'));
				if(!$array['field']['id'])kele::exception('error',"nodata");
				$table=keledatabase::getthisone("kele_table","id=".$array['table']['id']);
				$fieldvalue=keledatabase::getarray("kele_field","id in (".implode(",",$array['field']['id']).")");
				$ids=explode(",",$table['fields']);
				foreach ($ids as $id){
					if(!in_array($id,$array['field']['id']))$fields[]=$id;
				}
				keledatabase::update("kele_table","fields='".implode(",",$fields)."'","id=".$array['table']['id']);
				foreach ($fieldvalue as $value){
					$field[]=" DROP `".$value['value']."`";
				}
				$field=implode(",",$field);
				$sql="ALTER TABLE `".$table['value']."`".$field;
				keledatabase::query($sql,'unbuffered');
				kele::exception("delete",$view);
			}	
		}
}
?>