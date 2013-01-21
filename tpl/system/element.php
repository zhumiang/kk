<?php
!defined('kele_start') && die('NOTFINDE');
function element($type,$name,$defult="",$value="",$size="",$view=""){
	if (!$size)$size=50;
	if($defult&&!is_array($defult)){
		if(stristr($defult,"|"))$array=explode("|",$defult);
		if($array&&is_array($array)&&count($array)>0)
		{
			$defult=array();		
			if($array[0]=="sql"){
				$defult=keledatabase::getrows(keledata::resolve(keledata::htmlchars_decode($array[1]),$value),1);
				if($array[2]){
					$temp=explode(":", $array[2]);
					array_unshift($defult,array('value'=>$temp[0],'name'=>$temp[1]));
				}
			}else {
				$i=0;
				foreach ($array as $vals){
					$vals=explode(":",$vals);
					$defult[$i]['value']=$vals[1];
					$defult[$i]['name']=keledata::resolve($vals[0],$value);
					$i++;
				}
			}
		}
	}
	switch ($type){
		case "text":
			if ($value) $defult=$value;
			if($view=='read')return $defult;
			else return "<input type=\"text\" size=\"".$size."\"  name=\"".$name."\" value=\"".$defult."\" id=\"".$name."\"/>";
			break;
		case "select":
			if ($defult){				
				if ($defult){
					foreach($defult as $val){
						if($view!='read'){
							if($value==$val['value'])$select="selected";else $select="";				
							$html.="<option value=\"".$val['value']."\" ".$select." >".$val['name']."</option>";
						}else{
							if($value==$val['value'])return $val['name'];
						}
					}
				}
				}
			return "<select id=\"".$name."\"  name=\"".$name."\">".$html."</select>";
			break;
		case "textarea":
			$rows=($size=='50')?'10':$size-50;
			if($view=='read')return keledata::htmlchars_decode($value);
			else return "<textarea name=\"".$name."\" id=\"".$name."\"  cols=\"".$size."\" rows=\"".$rows."\">".keledata::htmlchars_decode($value)."</textarea>";
			break;
		case "checkbox":
			if ($defult){				
				if ($defult){
				foreach($defult as $key=>$val){
					$temp=explode(",",$value);
					if($view!='read'){	
						if(in_array($val['value'],$temp))$check="checked";else $check="";
						$html.="<input type=\"checkbox\"  id=\"".$name."\" name=\"".$name."[]\" value=\"".$val['value']."\" ".$check." >".$val['name'];
						if(($key+1)%5==0)$html.="<br>";
					}else{					
						if(in_array($val['value'],$temp)){
							$arr[]=$val['name'];
							if (count($arr)==8){$arr2[]=implode(",", $arr);$arr=array();}
						}					
					}
				}
				if($view=='read'){
					if($arr)$arr2[]=implode(",", $arr);
					$html=implode("<br>", $arr2);
				}
				}}
			if($view=='read')$html=trim($html,',');
			return $html;
			break;
		case "radio":			
			if ($defult){				
				if ($defult){
			foreach($defult as $key=> $val){
				if($view!='read'){
					if($val['value']==$value)$check="checked";else $check="";
					$html.="<input type=\"radio\" id=\"".$name."\" name=\"".$name."\" value=\"".$val['value']."\" ".$check." >".$val['name'];
					if(($key+1)%5==0)$html.="<br>";
				}else{
					if($val['value']==$value)return $val['name'];
				}
			}}}
			return $html;
			break;
		case "file":			
			if($view!='read')$html="<input type=\"file\" id=\"".$name."\" name=\"".$name."\">&nbsp;";
			if($value)$html.="<a src=\"".http_dir.$value."\">点此下载</a>";
			else $html."没有附件";
			return $html;
			break;
		case "img":
			if($view!='read')$html="<input type=\"file\" id=\"".$name."\" name=\"".$name."\">&nbsp;";
			if($value)$html.="<img src=\"".http_dir.$value."\" width=100 height=100 >";
			else $html."没有图片";
			return $html;
		case "edithtml":
			if($view!='read'){
				$html="<input type=\"hidden\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" style=\"display:none\" /><br><iframe src=\"".http_dir."editor/editor.htm?id=".$name."&ReadCookie=0\" frameBorder=\"0\" marginHeight=\"0\" marginWidth=\"0\" scrolling=\"No\" width=\"700\" height=\"480\"></iframe>";
			}else{
				$html=keledata::htmlchars_decode($value);
			}
			return $html;
			break;
		case "password":
			$html="<input  size=\"".$size."\" type=\"password\" id=\"".$name."\" name=\"".$name."\">";
			return $html;
			break;
		case "readonly":
			if (is_array($defult)){
				if($view=='read')return $defult[0]['name'];
				else return "<input type=\"hidden\" id=\"".$name."\" name=\"".$name."\" value=\"".$defult[0]["value"]."\" style=\"display:none\" /><input type=\"text\" size=\"".$size."\" disabled=\"disabled\" value=\"".$defult[0]['name']."\"/>";
			}else{
				$defult=keledata::resolve($defult,$value);
				if($view=='read')return $defult;
				else return "<input type=\"hidden\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" style=\"display:none\" /><input type=\"text\" size=\"".$size."\" disabled=\"disabled\" value=\"".$defult."\"/>";
			}
			break;
		case "no":
			if($defult&&is_array($defult)){
				foreach ($defult as $val){
					if($val['value']==$value)return $val['name'];
				}
			}
			return $value;
			break;
		case "time":
			if($view!='read'){
				if(!isset($GLOBALS['KELE']['Wdate'])){
					$GLOBALS['KELE']['Wdate']=true;
					$html="<script language=\"javascript\" type=\"text/javascript\" src=\"".http_dir."CGI/JS/My97DatePicker/WdatePicker.js\"></script>";
				}
				$html.="<input class=\"Wdate\" type=\"text\" size=\"".$size."\" id=\"".$name."\" name=\"".$name."\" value=\"".$value."\" onClick=\"WdatePicker()\">";
			}else{
				$html=$value;
			}
			return $html;
			break;
		case "hidden":
			if ($value) $defult=$value;
			if($view!='read')
				return "<input type=\"hidden\" id=\"".$name."\" name=\"".$name."\" value=\"".$defult."\" style=\"display:none\" />";
			break;
	}
}
?>