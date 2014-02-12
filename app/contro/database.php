<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/contro
 * @version $Id: database.php 2008--@zhuming$
 */

 !defined('kele_start') && die('NOTFINDE');
class keledatabase {
	private $model;
	private $contro;
	private $view;
	public function keledatabase($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		kele::getinclass("app_model_mysqldb");
		kele::getinclass("app_model_database");
		keledatabase::$model();
	}
	public function usedb(){
		global $db;
		if(!is_object($db)){
			$db= new kelemakedb();
		}
	}
	public function getthisone($table_name,$where,$fields="*",$order="",$group=""){
		global $db;
		return $db->getthisone($table_name,$where,$fields,$order,$group);
	}
	public function getarray($table_name,$where='',$fields="*",$order="",$group="",$limit=""){
		global $db;
		return $db->getarray($table_name,$where,$fields,$order,$group,$limit);
	}
	public function getlinkarray($tables,$where,$fields="*",$orders="",$groups="",$limit=""){
		global $db;
		return $db->getlinkarray($tables,$where,$fields,$orders,$groups,$limit);
	}
	public function insert($inserts, $table_name,$fields){
		global $db;
		return $db->insert($inserts, $table_name,$fields);
	}
	public function update($table_name,$updates,$where){
		global $db;
		return $db->update($table_name,$updates,$where);
	}
	public function delete($table_name,$where,$using=''){
		global $db;
		return $db->delete($table_name,$where,$using);
	}
	public function insert_id(){
		global $db;
		return $db->insert_id();
	}
	public function affected_rows(){
		global $db;
		return $db->affected_rows();
	}
	public function getnum($table_name,$where=""){
		global $db;
		return $db->getnum($table_name,$where);
	}
	public function query($sql,$type = ''){
		global $db;
		return $db->query($sql,$type);
	}
	public function getrows($sql,$ismuch = ''){
		global $db;
		return $db->getrows($sql,$ismuch);
	}
	public function close(){
		global $db;
		return $db->close();
	}
	/**
	 * 得到主表
	 * @param unknown_type $view
	 */
	public function gettable($view){
		$array=keledatabase::getthisone(array("kele_tablecolumn","kele_table","kele_column"),
				array("kele_column.value='".$view."'","kele_tablecolumn.columnid=kele_column.id",
						"kele_table.id=kele_tablecolumn.tableid"),array("kele_table.*"));
		return $array;
	}	
	public function valueck($array,$data,$insert,$olddata=""){
		foreach ($data as $key => $value){
			if (!is_array($value)) {
				
				foreach ($array['field'] as $values){
						$fieldids[]=$values['value'];
				}
				
				foreach (array_keys($data) as $keys){
					if (!in_array($keys,$fieldids))unset($data[$keys]);
				}
				
				foreach ($array['field'] as $val){
					if($val['defaultvalue']=="notnull" && empty($data[$val['value']])){						
                      				kele::exception("error","dataless");
                  			 }
					//等待修改if( $data[$val['value']])keledata::checkdata($data[$val['value']],$val['checkdata']);
					if ($val['operate']=="append") {
						if ($val['type']=="int") {
							if($data[$val['value']])keledata::checkdata($data[$val['value']],"number");
						}else {
							if($data[$val['value']])$data[$val['value']]=keledata::strval($data[$val['value']]);
						}
					}elseif($val['operate']=="system"){
						$data[$val['value']]=keledatabase::systemval($array['value'],$data[$val['value']],$val['defaultvalue'],$insert,$val['value'],$olddata[$val['value']],$array['classify']);
                    }elseif ($insert=="append"&&$val['operate']=="noadd"){
						$data[$val['value']]="";
					}
					if ($insert=="amend" && $data[$val['value']]!=$olddata[$val['value']]) {
						if (in_array($val['value'],array_keys($data)))$updates[]=$array['value'].".".$val['value']."='".$data[$val['value']]."'";
					}
				}
				break;
			}else{		
				$data[$key]=keledatabase::valueck($array,$data[$key],$insert);
			}
		}
		if ($insert=="amend")return $updates;
		else return $data;
	}
	public function systemval($table,$value,$switch,$insert,$field,$oldvalue,$classify){
		switch ($switch){
			case "time":
				$value= time();
				break;
			case "getip":
				$value= keledata::getip();
				break;
			case "addtime":
				if($insert=="append"){
				$value=time();
				}else $value=$oldvalue;
				break;
			case "image":
				$image=kelefile::upfile($classify,$field,'img');
				if($image){
					$value=$image;
				}else{
					$value=$oldvalue;
				}
				break;
			case "file":
				$file=kelefile::upfile($classify,$field,'file');
				if($file){
					$value=$file;
				}else{
					$value=$oldvalue;
				}
				break;
			case "user":
				if($insert=="append"){
				if($table=="kele_userdata"){
					$value=keledatabase::getthisone("kele_monitor","name='id'","value");
				}else $value=keledata::getsession("userid");
				}else $value=$oldvalue;
				break;
			case "insertid":
				if ($insert=="append") {
					$value=keledatabase::getthisone("kele_monitor","name='id'","value");
				}else $value=$oldvalue;
				break;
			case "md5":
				if($value&&keledata::checkdata($value)){
					$value=md5($value);
				}else $value=$oldvalue;
				break;
			case "ispass":
				if($insert=="append"){
					if (kelemonitor::pro()=='kele')$value=keledata::strval($value);
					else $value="true";
				}else {
					if (kelemonitor::pro()=='kele')$value=keledata::strval($value);
					else $value=$oldvalue;
				}
				break;
			case "array":								
				if($value)$value=implode(",",keledata::strval($value));
				break;
			case "different":
				$value=keledata::strval($value);
				if($insert=="append"){	
					if(keledatabase::getthisone($table,$field."='".$value."'","*"))kele::exception('error','different');
				}else if($insert=="amend"){
					if($value!=$oldvalue && keledatabase::getthisone($table,$field."='".$value."'","*"))kele::exception('error','different');
				}
				break;
			default:
				$value="";
				break;
		}
		return $value;
	}

	public function insertvalue($data,$array,$insert,$olddata=""){
		if(!in_array($insert,array("append","amend")))kele::exception('error','modelwrong');
			$array['field']=keledatabase::getarray("kele_field","id in (".$array['fields'].")");
			$data=keledatabase::valueck($array,$data,$insert,$olddata);
			unset($array);
			return $data;
	}
	
	public function getsearchvalue($table,$parent,$field,$switch){
		switch ($switch){
			case "text":				
				$data=keledata::httpval($parent);
				if($data[$field]){
					$GLOBALS['SEARCH'][$parent][$field]=$data[$field];
					keledata::strval($data[$field]);
					$where[]=$table.".".$field." like '%".$data[$field]."%'";
					$where[]='&'.$parent.'['.$field.']='.$data[$field];
				}
				break;
			case "select":
				$data=keledata::httpval($parent);
				if($data[$field]){
					$GLOBALS['SEARCH'][$parent][$field]=$data[$field];
					keledata::strval($data[$field]);
					$where[]=$table.".".$field."='".$data[$field]."'";
					$where[]='&'.$parent.'['.$field.']='.$data[$field];
				}
				break;
			case "time":
				$data=keledata::httpval($parent);
				if($data[$field]){
					$GLOBALS['SEARCH'][$parent][$field]=$data[$field];
					if(isset($data[$field."1"]))
						$GLOBALS['SEARCH'][$parent][$field."1"]=$data[$field."1"];
					keledata::strval($data);
					if($data[$field]&&$data[$field."1"]){
						$where[]=$table.".".$field.">='".$data[$field]."' and ".$table.".".$field."<='".$data[$field."1"]."'";
						$where[]='&'.$parent.'['.$field.']='.$data[$field].'&'.$parent.'['.$field.'1]='.$data[$field.'1'];
					}
					elseif ($data[$field]) {
						$where[]=$table.".".$field."='".$data[$field]."'";	
						$where[]='&'.$parent.'['.$field.']='.$data[$field];
					}
				}
				break;						
		}
		return $where;
	}
}
?>