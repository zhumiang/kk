<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/contro
 * @version $Id: function.php 2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');	
class kelefunction {
	public  $model;
	private $contro;
	public  $view;
	private $data;
	private $grade;
	private $ajax;
	public function kelefunction($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		$this->grade=keledata::getsession('grade');
		$this->pro=kelemonitor::pro();
		$this->ajax=keledata::httpval("is_ajax");
		if(in_array($this->model,array('show','append','amend','delete','system','search'))){
			kelemonitor::power($this->model,$this->view);
			$data=kelefunction::$model($view);
			if($this->ajax){ 
				kele::getinclass("app_model_json");
				$json = new Services_JSON();
				echo $json->encode($data);exit;
			}
			keletpl::tplget($this->model,$view,$data);
		}
		else kele::exception('error','model');
	}
	
	public function show($view,$size=20,$whereadd="",$order="",$urladd="",$id=""){
		$parameter=keledata::httpval(array('id','page'));
		$parameter['id']=$parameter['id']?$parameter['id']:$id;
		if($parameter)keledata::checkdata($parameter,'number');		
		$lord=keledatabase::gettable($view);
		if($lord){
			$table=keledatabase::getarray(array("kele_table","kele_relation"),
					array("kele_relation.lord=".$lord['id']," kele_table.id=kele_relation.schedule"),
					array("kele_table.*","kele_relation.wheres"));
			foreach ($table as $tb){
				$array['wheres'][]=$tb['wheres'];
				$array['table'][]=$tb['value'];				
				$field=keledatabase::getarray("kele_field","id in (".$tb['fields'].")",'value');
				foreach ($field as $fd){
					$array['field'][]=$tb['value'].'.'.$fd['value'];
				}
			}
			$array['table']['lord']=$lord['value'];
			$field=keledatabase::getarray("kele_field","id in (".$lord['fields'].")",'value');
			foreach ($field as $fd){
				$array['field'][]=$lord['value'].'.'.$fd['value'];
			}
		}
		if($array){
			$array['wheres'][]=kelemonitor::limit($view);
			if ($parameter['id']){
				$array['wheres'][]=$array['table']['lord'].".id=".$parameter['id'];
				$data=keledatabase::getthisone($array['table'],$array['wheres'],$array['field']);
				if (!$data)kele::exception('error','idwrong');
			}else {
				if ($whereadd)$array['wheres'][]=$whereadd;				
				!$parameter['page'] && $parameter['page']=1;
				$sum=keledatabase::getnum($array['table'],$array['wheres']);
				keledata::pagemover($size,$sum,"?model=".$this->model."&contro=".$this->contro."&view=".$this->view.$urladd,
				$parameter['page']);
				$limit=array("start"=>($GLOBALS['pagedb']['page']-1)*$size,"num"=>$size);
				$data=keledatabase::getarray($array['table'],$array['wheres'],$array['field'],
						$array['table']['lord'].".id desc","",$limit);
			}
		}
		return $data;
	}	
	public function append($view){
		$parameter=keledata::httpval('append');
		if($parameter==true){
			$lord=keledatabase::gettable($view);
			$data=keledata::httpval($lord['classify']);
			$data=keledatabase::insertvalue($data,$lord,"append");
			keledatabase::insert($data,$lord['value'],array_keys($data));
			$insert_id=keledatabase::insert_id(); 
			keledatabase::insert(array("id",$insert_id),"kele_monitor",array("name","value"));
			$table=keledatabase::getarray(array("kele_table","kele_relation"),
					array("kele_relation.lord=".$lord['id'],"kele_table.id=kele_relation.schedule"),
					array("kele_table.*"));
			if ($table) {
				foreach ($table as $value){					
					$data=keledata::httpval($value['classify']);
					$data=keledatabase::insertvalue($data,$value,"append");
					if(is_array($data[0]))$keys=array_keys($data[0]);
					else $keys=array_keys($data);
					keledatabase::insert($data,$value['value'],$keys);
				}
			}
			keledatabase::delete("kele_monitor","");
			if($this->ajax)return $insert_id;
			kele::exception('append',$view);
		}
	}
	public function system($view,$system="",$value=""){
		$parameter=keledata::httpval(array("system","id"));
		$parameter[$parameter['system']]=keledata::httpval($parameter['system']);
		if($parameter['id']){
			keledata::checkdata($parameter['id'],'number');
			if($parameter['system'] &&$parameter[$parameter['system']])
				keledata::checkdata(array($parameter['system'],$parameter[$parameter['system']]),'letter');
			$lord=keledatabase::gettable($view);
			$field=keledatabase::getthisone("kele_field",array("value='".$parameter['system']."'"),"id");			
			if(!in_array($field,explode(",",$lord['fields'])))kele::exception("error","systemwrong");
			if(!is_array($parameter['id']))$where="id=".$parameter['id'];
			else $where="id in (".implode(",",$parameter['id']).")";
			keledatabase::update($lord['value'],"`".$parameter['system']."`='".$parameter[$parameter['system']]."'",$where);
			kele::exception('system',$view);
		}else {
			kele::exception('error',"datanotdid");
		}
	}
	public function amend($view,$id=''){
		$parameter=keledata::httpval(array('id','amend'));
		$parameter['id']=$parameter['id']?$parameter['id']:$id;
		if($parameter['id'])keledata::checkdata($parameter['id'],'number');
		if($parameter['amend']==true){
			$lord=keledatabase::gettable($view);
			if(!$lord)kele::exception('error',"columnwrong");
			$table=keledatabase::getarray(array("kele_table","kele_relation"),
					array("kele_relation.lord=".$lord['id'],"kele_table.id=kele_relation.schedule"),
					array("kele_table.*"));
			$table[]=$lord;
			foreach ($table as $value){
				$data=keledata::httpval($value['classify']);
				foreach ($data as $key=> $val){
					$true=false;
					if (is_array($val)){
						if ($val['id']){
						$where=$value['value'].".id=".$val['id'];
						$olddata=keledatabase::getthisone($value['value'],$where);
						$updates=keledatabase::insertvalue($val,$value,"amend",$olddata);
						if($updates)keledatabase::update($value['value'],$updates,$where);
						$i++;
						}
					}else {
						$true=true;
					}
				}
				if($true==true){
					if ($data['id']){
					$where=$value['value'].".id=".$data['id'];
					$olddata=keledatabase::getthisone($value['value'],$where);
					$updates=keledatabase::insertvalue($data,$value,"amend",$olddata);
					if($updates)keledatabase::update($value['value'],$updates,$where);
					$i++;
					}
				}
			}
			if(!$i)kele::exception("error","nodata"); 
			if($this->ajax)return true;
			kele::exception("amend",$view);
		}else {
			if($parameter['id']){
				$lord=keledatabase::gettable($view);
				$where=kelemonitor::limit($view);
				$data[$lord['classify']]=keledatabase::getthisone($lord['value'],array("id=".$parameter['id'],$where));
				if(!$data)kele::exception('error','idwrong');
				$array=keledatabase::getarray(array("kele_table","kele_relation"),
						array("kele_relation.lord=".$lord['id'],"kele_table.id=kele_relation.schedule"));
				if ($array) {
					foreach ($array as $value){
						$data[$value['classify']]=keledatabase::getarray(array($value['value'],$lord['value']),
								array($value['wheres'],$lord['value'].".id=".$parameter['id']),array($value['value'].".*"),
								$value['value'].".id");
					}
				}				
				return $data;
			}else kele::exception('error',"datanotdid");
		}
	}
	public function delete($view){
		$id=keledata::httpval('id');
		if($id&&keledata::checkdata($id,"number")){
			$lord=keledatabase::gettable($view);
			if(!$lord)kele::exception('error',"columnwrong");
			$array=keledatabase::getarray(array("kele_table","kele_relation"),
					array("kele_relation.lord=".$lord['id'],"kele_table.id=kele_relation.schedule"));
			if ($array) {
				foreach ($array as $value){
					$table[]=$value['value'];
					$where[]=$value['wheres'];
				}
			}
			$table[]=$lord['value'];
			if(!is_array($id))$where['id']=$lord['value'].".id=".$id;
			else $where['id']=$lord['value'].".id in (".implode(",",$id).")";
			$where[]=kelemonitor::limit($view);
			keledatabase::delete($table,$where,$table);
			keledatabase::delete($lord['value'],$where['id']);
			if($this->ajax)return true;
			kele::exception('delete',$view);
		}else {
			kele::exception('error',"datanotdid");
		}
	}
	public function search($view){
		$parameter=keledata::httpval(array('search','page'));		
		$lord=keledatabase::gettable($view);
		if(!$lord)kele::exception('error',"columnwrong");
		$table=keledatabase::getarray(array("kele_table","kele_relation"),array("kele_relation.lord=".$lord['id'],
				"kele_table.id=kele_relation.schedule"),array("kele_table.*","kele_relation.wheres"));
		if($parameter['search']==true)$fields=kelefunction::seachmemu($view);
		$table[]=$lord;
		foreach ($table as $value){	
			if($fields){
				foreach ($fields['element'][$value['classify']] as $val) {
					if($val['type']){
						$result=keledatabase::getsearchvalue($value['value'],$value['classify'],$val['field'],$val['type']);
						if($result){
							$where[]=$result[0];
							$urladd.=$result[1];				
						}
					}
				}
				if($urladd)$urladd.='&search=true';
			}	
			$fields=keledatabase::getarray("kele_field","id in (".$value['fields'].")",'value');
			foreach ($fields as $fd){
				$field[]=$value['value'].'.'.$fd['value'];
			}				
			if($value['wheres']){
				$where[]=$value['wheres'];
			}
			$tablename[]=$value['value'];
		}
		!$parameter['page'] && $parameter['page']=1;
		$size=20;
		$sum=keledatabase::getnum($tablename,$where);
		keledata::pagemover($size,$sum,"?model=".$this->model."&contro=".$this->contro."&view=".$this->view.$urladd,
		$parameter['page']);
		$limit=array("start"=>($GLOBALS['pagedb']['page']-1)*$size,"num"=>$size);
		$where[]=kelemonitor::limit($view);
		$data=keledatabase::getarray($tablename,$where,$field,$lord['value'].'.id desc','',$limit);
		if($data)return $data;
		else kele::exception('error',"datanofinder");
	}
	public function memu($view,$select='edit'){
		$card=kelemonitor::pro();
		if (!$view)kele::exception('error',"markwrong");
		$memu=keledatabase::getthisone("kele_memu","value='".$view."'");
		if($card!="kele")$operate=" and kele_memufield.operate='all'";
		if($select=='list')$operate.=" and kele_memufield.attribute='list'";
		else if($select=='all')$operate.=" and kele_memufield.attribute!='noshow'";
		else $operate.=" and kele_memufield.type!='no'";
		$array=keledatabase::getarray(array("kele_memu,kele_memufield"),
				"kele_memu.id=kele_memufield.memuid {$operate} and kele_memu.id=".$memu['id'],
				array("kele_memufield.*"),"taxis");
		foreach ($array as $value){
			$data['element'][$value['classify']][]=$value;
		}
		$data['memu']=$memu;
		kele::import("tpl_system_element.php");
		return $data;
	}
	public function seachmemu($view){
		if(!$view)kele::exception('error',"markwrong");
		$memu=keledatabase::getthisone("kele_searchmemu","value='".$view."'");
		if($memu){
			$array=keledatabase::getarray(array("kele_searchmemu,kele_searchfield"),
					"kele_searchmemu.id=kele_searchfield.memuid and kele_searchfield.type!='no' and kele_searchmemu.id=".$memu['id'],
					array("kele_searchfield.*"),"taxis");
			foreach ($array as $value){
				$data['element'][$value['classify']][]=$value;
			}
			$data['memu']=$memu;			
		}
		kele::import("tpl_system_element.php");		
		return $data;
	}
}
?>