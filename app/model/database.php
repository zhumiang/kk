<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: database.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class kelemakedb extends keledb {

	public function kelemakedb(){
		keledb::keledb();
	}

	public function forarray($before,$center,$in){
		if(is_array($center)){
			foreach ($center as $k => $val){
				if($val)$center[$k]=trim($val);
				else unset($center[$k]);
			}
			$center=implode($in,$center);
		}
		if($center)$sql=' '.$before.' '.$center.' ';
		return $sql;
	}

	public function makesql($tables,$where,$fields,$order="",$group="",$limit=""){
		if (is_array($tables)) $tables=kelemakedb::forarray('',$tables,',');
		if (is_array($fields)) $fields=kelemakedb::forarray('',$fields,',');
		if ($order)	$order=kelemakedb::forarray(' order by ',$order,',');			
		if ($group) $group=kelemakedb::forarray(' group by ',$group,',');		
		if ($where) $where=kelemakedb::forarray(' where ',$where,' and ');
		if($limit){
			if(is_array($limit)){
				$limit=" limit " . $limit['start'] . "," . $limit['num'];
			}else {
				$limit=" limit " . $limit;
			}
		}
		$sql = "select {$fields} from  ". $tables . $where . $order . $group .$limit .";";
		return $sql;
	}

	public function getrows($sql,$ismuch=""){
		$query=keledb::query($sql);
		if($ismuch!=""){
			while ($rs=keledb::fetch_array($query)) {
				$data[]=$rs;
			}
		}else $data=keledb::fetch_array($query);
		keledb::free_result($query);
		return $data;
	}

	public function getresult($sql,$row=0){
		$query=keledb::query($sql);
		$data=keledb::result($query,$row);
		return $data;
	}
	
	public function getthisone($table_name,$where,$fields,$order,$group){
		$sql=kelemakedb::makesql($table_name,$where,$fields,$order,$group);
		if(!is_array($fields) && $fields!="*"){
			$data=kelemakedb::getresult($sql,0);
		}else{
			$data=kelemakedb::getrows($sql);
		}
		return $data;
	}

	public function getnum($table_name,$where){
		$fields="count(*)";
		$sql=kelemakedb::makesql($table_name,$where,$fields);
		$data=kelemakedb::getresult($sql,0);
		return $data;
	}
	

	public function getarray($table_name,$where,$fields,$order,$group,$limit){
		$sql=kelemakedb::makesql($table_name,$where,$fields,$order,$group,$limit);
		$data=kelemakedb::getrows($sql,1);
		return $data;
	}
		
	public function getlinkarray($tables,$where,$fields,$orders,$groups,$limit){
		foreach ($tables as $k=>$val){
			$tables[$k]="{$val} {$val}";
		}
		$sql=kelemakedb::makesql($tables,$where,$fields,$orders,$groups,$limit);
		$data=kelemakedb::getrows($sql,1);
		return $data;
	}
	
	public function maketable($table,$name="kele"){
		$table=str_replace($name, " " ,$table);
		$table=$name.'_'.trim($table);
		return $table;
	}

	public function update($table_name,$updates,$where){
		if(is_array($updates)) $updates = kelemakedb::forarray('',$updates,',');
		if(is_array($table_name))$table_name = kelemakedb::forarray('',$table_name,',');
		if($where) $where = kelemakedb::forarray(' where ',$where,' and ');
		$sql = "UPDATE {$table_name} SET " . $updates . $where;
		if(keledb::query($sql,'unbuffered')) return true;
		else return false;
	}
	
	public function insert($inserts, $table_name,$fields){
		if(is_array($inserts)){
			foreach ($inserts as $k => $val) {
				if(is_array($val)){
					$inserts[$k] = "('" . implode("','",$val) . "')";
					$notarray="0";
				}else {
					$inserts[$k]="'".$val."'";
					$notarray++;
				}
			}
			$inserts = kelemakedb::forarray('',$inserts,',');
		}
		if($notarray>0) $inserts = "(" . $inserts . ")"; 
		if(is_array($fields)) $fields = kelemakedb::forarray('',$fields,',');
		$sql = "INSERT INTO `{$table_name}` ({$fields}) VALUES " . $inserts;
		if(keledb::query($sql,'unbuffered')) return true;
		else return false;
	}

	public function delete($tables,$where,$using){
		if(is_array($tables))$tables = kelemakedb::forarray("",$tables,",");
		if($using)$using = kelemakedb::forarray(" using ",$using,",");
		if($where) $where = kelemakedb::forarray(' where ',$where,' and ');
		$sql = "DELETE FROM {$tables} " . $using . $where;
		if(keledb::query($sql,'unbuffered')) return true;
		else return false;
	}
}
?>