<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc.
 * @author zhuming
 * @package kelecms
 * @subpackage index
 * @version $Id: monitor.php  2008--@zhuming$
 */
!defined('kele_start') && die('NOTFINDE');
class indexmonitor{
	
	public $action;
	
	public $column;
	
	public function indexmonitor($model,$column,$classify){
		if($classify=='public')return true;
		if($classify!='sys')kele::exception('error','powerwrong');
		$groupid=keledata::getsession('usergroupid');
		$operate=array();
		if($groupid&&$column){
			$operateids=keledatabase::getthisone(array("group_power","kele_column"),array("kele_column.value='".$column."'",
					"group_power.usergroupid =".$groupid,"group_power.columnid=kele_column.id"),"group_power.operateids");
			$otheroperateid=keledatabase::getthisone(array("special_power","kele_column"),array("kele_column.value='".$column."'",
					"special_power.usersid='".keledata::getsession("userid")."'","kele_column.id=special_power.columnid"),
					"special_power.operateids");
			if($otheroperateid)$operateids.=','.$otheroperateid;
			$operateids=trim($operateids,",");
			if($operateids)$operate=keledatabase::getthisone("kele_action","id in ($operateids)","GROUP_concat(value) as val");
			$operate = explode(',', $operate);
			if(!in_array($model, $operate))kele::exception('error','powerwrong');
		}
		if(count($operate)>0){
			foreach ($operate as $val){
				$GLOBALS['POWER'][$column][$val]=1;
			}
		}
		return true;
	}
	public function getcolumn($id=""){
		$usersession=keledata::getsession(array('departmentid','positionid'));		
		$columnids = keledatabase::getthisone("department_power",array("departmentid='".$usersession['departmentid']."'",
				"positionid='".$usersession['positionid']."'"),"columnids");
		$columnidsadd = keledatabase::getthisone("special_power","usersid='".keledata::getsession("userid")."'",
				"GROUP_concat(columnid) as val");
		if($columnidsadd)$columnids.=','.$columnidsadd;
		if(!$columnids)return ;
		if ($id){
			$where = " and upcolumnid=".$id;
		}else{
			$where = " and upcolumnid=0";
		}
		$data = keledatabase::getarray("kele_column","id in ($columnids) $where");
		return $data;
	}
	public function limit($view){
		$data=keledatabase::getthisone("kele_power_select","value='".$view."'",array("wheres","usergroupid"));
		if($data['usergroupid']<keledata::getsession("usergroupid")){
			$where=keledata::resolve($data['wheres']);
		}
		return $where;
	}
}
?>