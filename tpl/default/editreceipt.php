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
<?php 
$cid=keledata::httpval("cid");
if (!$cid)kele::exception('error','idwrong');
keledata::checkdata($cid,"number");
$data = keledatabase::getthisone("collaborative","id=".$cid);
if (!$data)kele::exception('error','nodata');
$data2=keledatabase::getthisone("coll_receipt","collaborativeid=".$cid);
if($data2&&$this->model!="amend")echo "<script>location.href='".http_dir."?model=amend&contro=function&view=".$this->view."&id=".$data2['id']."&cid=".$cid."'</script>";
?>
<div class="menu"> 
<ul>
<li class="onck">&nbsp;<a href="<?php echo http_dir?>?model=show&contro=function&view=collaborative">ShowForm</a></li>
</ul>
</div>
<?php
	$collmemu=kelefunction::memu("collaborative",'all');
?>	
<table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php 
      	foreach ($collmemu['element'] as $cmemus){
      	foreach($cmemus as $k => $val){
      			echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$data[$val['field']],$val['size'],'read')."</td></tr>";
      	}?>      	
      	<?php }?>
</table>
<?php		
	$memu=kelefunction::memu($this->view);
?>
	<form name="<?php echo $data['memu']['value']?>" action="<?php echo http_dir?>?model=<?php echo $this->model?>&contro=function&view=<?php echo $this->view?>" enctype="multipart/form-data" method="post">
    <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php 
      	foreach ($memu['element'] as $memus){
      	foreach($memus as $k => $val){
      			echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['classify']][$val['field']],$val['size'])."</td></tr>";
      	}?>
      	<input type="hidden" name="<?php echo $val['classify']?>[id]" value="<?php echo $GLOBALS['DATA'][$val['classify']]['id']?>"/>
      	<input type="hidden" name="<?php echo $val['classify']?>[collaborativeid]" value="<?php echo $cid;?>"/>
      	<?php }?>
      </table>
		<div align="center">
		<input type="hidden" name="<?php echo $this->model?>" value="true" />
	      <input type="submit" name="Submit" value="Submit" />
        </div>
  </form>
</body>
</html>
