<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<link href="<?php echo http_dir?>CGI/css/admincss.css" rel="stylesheet" type="text/css" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
</head>
<body>
<div class="menu">Form Manage | <a href="kele.php?model=show&contro=function&view=table">Form Set | </a>&nbsp;
<a href="kele.php?model=show&contro=function&view=searchmemu">Read All</a>
</div>
	<?php
	$memu=kelefunction::memu($this->view);
	if($this->model=="amend"){
		$action="kele.php?model=amend&contro=function&view=searchmemu";
	}else {
		keledata::checkdata($tableid=keledata::httpval('tableid'),"number");
		$lord=keledatabase::getthisone("kele_table","id=".$tableid,array("classify as value","fields"));
		$data[$lord['value']]=keledatabase::getarray("kele_field","id in (".$lord['fields'].")");
		$array=keledatabase::getarray(array("kele_table","kele_relation"),array("kele_relation.lord=".$tableid,"kele_table.id=kele_relation.schedule"),array("kele_table.*"));
		if ($array) {
		foreach ($array as $value){
			$data[$value['classify']]=keledatabase::getarray("kele_field","id in (".$value['fields'].")");
		}
		}
		$data_memu=keledatabase::getthisone("kele_searchmemu","value='".$lord['value']."'");
		if(count($data_memu)>0){
			$data_memufield=keledatabase::getarray("kele_searchfield","memuid='".$data_memu['id']."'");			
			foreach ($data_memufield as $memufieldval){
				$data_memufield[$memufieldval['field']]=$memufieldval;
			}		
		}
		$action="kele.php?model=append&contro=function&view=searchmemu";
	}?>
	<form name="<?php echo $data['memu']['value']?>" action="<?php echo $action?>" method="post">
      <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <tr>
      	<?php foreach($memu['element']['searchmemu'] as $k => $val){
      		if($this->model!="amend")$result=$data_memu[$val['field']]?$data_memu[$val['field']]:$lord[$val['field']];
      		else $result=$GLOBALS['DATA'][$val['classify']][$val['field']];
      			echo"<td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$result)."</td>";
      	}?>
      	</tr>
      	<input type="hidden" name="searchmemu[id]" value="<?php echo $GLOBALS['DATA']['searchmemu']['id']?>">
    </table>
    <div class="menu">Element information</div>
    <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php if($this->model!="amend"){$i=0;
      		foreach ($data as $keys=>$values){
      		foreach ($values as $value){
      			echo "<tr><td colspan='2' align='center'>Element".($i+1)."</td></tr>";
      		foreach($memu['element']['searchfield'] as $k => $val){
      			if($val['field']=='field')$result=$value['value'];
      			elseif ($val['field']=='classify')$result=$keys;
      			else $result=$data_memufield[$value['value']][$val['field']]?$data_memufield[$value['value']][$val['field']]:"";
      		echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$i."][".$val['field']."]",$val['defaults'],$result)."</td></tr>";
      		}
      		$i++;}}
      	?>
      	<?php }else{foreach ($GLOBALS['DATA']['searchfield'] as $key=>$value){
      		echo "<tr><td colspan='2' align='center'>Element".($key+1)."</td></tr>";
      		foreach($memu['element']['searchfield'] as $k => $val){
      			echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$value['id']."][".$val['field']."]",$val['defaults'],$value[$val['field']])."</td></tr>";
      	}?>
      	<input type="hidden" name="searchfield[<?php echo $value['id']?>][id]" value="<?php echo $value['id']?>">
      	<?php }}?>
      </table>
		<div align="center">
		<input type="hidden" name="<?php echo $this->model?>" value="true" />
	      <input type="submit" name="Submit" value="Submit" />
        </div>
  </form>
  <div style="color:red">
  Help: The default value of the format "Display value: store value" each with "|" separated ,"display value: store value | display values: stored value | display values: stored value"
  You can also use sql statement to format: "sql | select id as value, name from kele_table"; attention to avoid using this method.
  </div>
</body>
</html>
