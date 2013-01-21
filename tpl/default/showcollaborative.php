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
kelemonitor::power('show','receipt');
if($GLOBALS['POWER'][$this->view]['search']){
$search=kelefunction::seachmemu($this->view);
if($search){
?>
<div class="menu"> 
Search With
</div>
<form name="<?php echo $search['memu']['value']?>" action="<?php echo http_dir?>?model=search&contro=function&view=<?php echo $this->view?>" enctype="multipart/form-data" method="post">
 <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
 <tr>
<?php 
$i=0;
      	foreach ($search['element'] as $searchfields){
      	foreach($searchfields as $val){
      		$i++;      		
      		echo"<td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['SEARCH'][$val['classify']][$val['field']],$val['size'])."</td>";      		
      		if($i%4==0)echo "</tr><tr>";
      	}}?>    	
<td align="center" <?php $i++; if($i%4!=0)echo "colspan=".((4-($i%4)+1)*2); ?>>
		<input type="hidden" name="search" value="true" />
	      <input type="submit" name="Submit" value="Submit" />
</td>
</tr> 
 </table>
</form>
<?php }}?>
<div class="menu"> 
<?php if($GLOBALS['POWER'][$this->view]['append']){?>
<a href="<?php echo http_dir?>?model=append&contro=function&view=<?php echo $this->view?>">AddFrom</a>&nbsp;
<?php }?>
<a href="<?php echo http_dir?>?model=show&contro=function&view=<?php echo $this->view?>">ShowForm</a>
</div>
<?php if(keledata::httpval('id')){	
	$data=keledatabase::getthisone("coll_receipt","collaborativeid=".$GLOBALS['DATA']['id']);
	if($data)$receiptmemu=kelefunction::memu("receipt",'all');
	$memu=kelefunction::memu($this->view,'all');
?>
    <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php 
      	foreach ($memu['element'] as $memus){
      	foreach($memus as $k => $val){
      			echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['field']],$val['size'],'read')."</td></tr>";
      	}?>      	
      	<?php }?>
      </table>
<?php if($receiptmemu){?>
<div class="menu"> 协同回执内容 </div>
<table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php 
      	foreach ($receiptmemu['element'] as $rmemus){
      	foreach($rmemus as $k => $val){
      			echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$data[$val['field']],$val['size'],'read')."</td></tr>";
      	}?>      	
      	<?php }?>
</table>
<?php }else{?>
      <div align="left" style="margin-left:10px;">
		<?php if($GLOBALS['POWER']['receipt']['append']&&$GLOBALS['DATA']['departmentid2']==keledata::getsession('departmentid')){?>
        <a href="<?php echo http_dir?>?model=append&contro=function&view=receipt&cid=<?php echo $GLOBALS['DATA']['id']?>">
        <input type="button" name="button" value=" 回  执 " />
        </a>
		<?php }?>
        </div>
<?php }?>
        
<?php }else{?>
  <form name="list" action="<?php echo http_dir?>?model=delete&contro=function&view=<?php echo $this->view?>" method="post">
	  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
	  <tr>
	  <td>Select</td>
<?php
  $field=kelefunction::memu($this->view,'list');
  foreach ($field['element'] as $values){
  	foreach ($values as $val){
?>
        <td><?php echo $val['name']?></td>
        <?php }}?>
        <td>Operate</td>
 </tr>      
	  <?php 
	  if($GLOBALS['DATA']){
	  	foreach ($GLOBALS['DATA'] as $value){
	  	echo"<tr><td><input type=\"checkbox\" name=\"id[]\" value=\"".$value['id']."\"></td>";
	  	foreach ($field['element'] as $fields){
      	foreach($fields as $k => $val){
	  ?>
        <td><?php echo element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$value[$val['field']],$val['size'],'read')?></td>
<?php }}?>
        <td>
        <a href="<?php echo http_dir?>?model=show&contro=function&view=<?php echo $this->view?>&id=<?php echo $value['id']?>">Detailed</a>&nbsp;
        <?php if($GLOBALS['POWER'][$this->view]['amend']){?>
        <a href="<?php echo http_dir?>?model=amend&contro=function&view=<?php echo $this->view?>&id=<?php echo $value['id']?>">Modify</a>&nbsp;
        <?php }?>
        <?php if($GLOBALS['POWER'][$this->view]['delete']){?>
        <a href="<?php echo http_dir?>?model=delete&contro=function&view=<?php echo $this->view?>&id=<?php echo $value['id']?>" onClick="return confirm('Are you sure you want to delete?');" >Delete</a>&nbsp;
		<?php }?>
		<?php if($GLOBALS['POWER']['receipt']['append']&&$value['departmentid2']==keledata::getsession('departmentid')){?>
        <a href="<?php echo http_dir?>?model=append&contro=function&view=receipt&cid=<?php echo $value['id']?>">回执</a>&nbsp;        
		<?php 
		if($value['status']==0){
			echo '<a href="'.http_dir.'?model=system&contro=function&view='.$this->view.'&id='.$value['id'].'&system=status&status=1">已安排</a>&nbsp;';
		}
	  	}		
		?>
		<?php 
		if($GLOBALS['POWER']['receipt']['system']&&$value['departmentid']==keledata::getsession('departmentid')){
		if($value['status']>0&&$value['status']<2){
			echo '<a href="'.http_dir.'?model=system&contro=function&view='.$this->view.'&id='.$value['id'].'&system=status&status=2">已完成</a>&nbsp;';
		}elseif ($value['status']>1&&$value['status']<3){
			echo '<a href="'.http_dir.'?model=system&contro=function&view='.$this->view.'&id='.$value['id'].'&system=status&status=3">已验收</a>&nbsp;';
		}
		}				
		?>
		</td>
      </tr>
      <?php }}?>    
</table>
 <div style="width:40%;float:left;margin:10px;" align="right">
	<input type="button" name="button" value="select all" onclick="checkall()">
	<?php if($GLOBALS['POWER'][$this->view]['delete']){?>
	<input type="submit" name="Submit" value="Delete" onClick="return confirm('Are you sure you want to delete?');" />
	<?php }?>
    </div>
   </form>
    <?php kele::import("tpl_system_page");?>
<script>
function checkall(){
	var ckbox=document.getElementsByTagName('input'); 
	var len=ckbox.length;
	if(len>0)
	{
		var i=0;
		for(i=0;i<len;i++){
		if (ckbox[i].type.toLowerCase() == 'checkbox'){
				ckbox[i].checked==true?ckbox[i].checked=false:ckbox[i].checked=true;
			}
		}

	}
}
</script>
<?php }?>
</body>
</html>
