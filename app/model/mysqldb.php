<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/model
 * @version $Id: mysqldb.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class keledb {
	
	private $querynum = 0;
	private $link;
	private $dbvals;
	public function keledb(){
		kele::import("static/config/config.php");
		global $dbmation;$GLOBALS['dbmation']=$this->dbvals=$dbmation;
		keledb::connect($this->dbvals['dbhost'],$this->dbvals['dbuser'],$this->dbvals['dbpw'],$this->dbvals['dbname'],$this->dbvals['pconnect'],true);
	}
	
	public function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE) {
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$halt && keledb::halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpw, true)) {
				$halt &&  keledb::halt('Can not connect to MySQL server');
			}
		}
		if(keledb::version() > '4.0') {
			if(!$this->dbvals['dbcharset'] && in_array(strtolower($this->dbvals['charset']), array('gbk', 'big5', 'utf-8'))) {
				$this->dbvals['dbcharset'] = str_replace('-', '', $this->dbvals['charset']);
			}

			if($this->dbvals['dbcharset']) {
				@mysql_query("SET character_set_connection=$this->dbvals['dbcharset'], character_set_results=$this->dbvals['dbcharset'], character_set_client=binary", $this->link);
			}

			if(keledb::version() > '5.0') {
				@mysql_query("SET sql_mode=''", $this->link);
			}
			@mysql_query("SET NAMES '".$this->dbvals['dbcharset']."'", $this->link);
		}
		if($dbname) {
			@mysql_select_db($dbname, $this->link);
		}
	}
	
	public function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}
	
	public function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	public function query($sql, $type = '') {
		$func = $type == 'unbuffered' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql,$this->link))) {
			if(in_array(keledb::errno(), array(2006, 2013)) && substr($type, 0, 5) != 'FIST') {
				keledb::close();
				keledb::keledb();
				keledb::query($sql, 'FIST'.$type);
			} elseif($type != 'SILENT' && substr($type, 5) != 'SILENT') {
				keledb::halt('MySQL Query Error', $sql);
			}
		}

		$this->querynum++;
		return $query;
	}

	public function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	public function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	public function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	public function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	public function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	public function num_fields($query) {
		return mysql_num_fields($query);
	}

	public function free_result($query) {
		return mysql_free_result($query);
	}

	public function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : keledb::result(keledb::query("SELECT last_insert_id()"), 0);
	}

	public function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	public function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	public function version() {
		return mysql_get_server_info($this->link);
	}

	public function close() {
		return mysql_close($this->link);
	}

	public function halt($message = '', $sql = '') {
		echo $message.$sql.keledb::errno().keledb::error();
	}
}
?>