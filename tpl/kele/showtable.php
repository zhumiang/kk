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
<div class="menu"> 
<?php $column=keledatabase::getarray("kele_column","upcolumnid=1"); foreach ($column as $value){?>
<a href="<?php echo $value['linkurl']?>"><?php echo $value['name']?></a>&nbsp;
<?php }?>
</div>
	  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
	  <tr>
<?php 
  $field=kelefunction::memu($this->view,'list');
  foreach ($field['element'] as $values){
  	foreach ($values as $val){
?>
        <td><?php echo $val['name']?></td>
        <?php }}?>
        <td>Operating</td>
 </tr>
	  <?php 
	  if($GLOBALS['DATA']){
	  	foreach ($GLOBALS['DATA'] as $value){
	  		echo "<tr>";
	  foreach ($field['element'] as $fields){
      	foreach($fields as $k => $val){
	  ?>
        <td><?php echo element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$value[$val['field']],$val['size'],'read')?></td>
<?php }}?>
        <td><a href="kele.php?model=amend&contro=module&view=table&id=<?php echo $value['id']?>">Modify</a>
        &nbsp;<a href="kele.php?model=delete&contro=module&view=table&id=<?php echo $value['id']?>" onClick="return confirm('Are you sure you want to delete?');" >Delete</a>
        &nbsp;<?php if($value['master']=="yes"){?>
        <a href="kele.php?model=append&contro=function&view=memus&tableid=<?php echo $value['id']?>">Set form</a>
        &nbsp;
        <a href="kele.php?model=append&contro=function&view=searchmemu&tableid=<?php echo $value['id']?>">Set SearchForm</a>
        <?php }?></td>
      </tr>
      <?php }}?>    
</table>
<div style="width:40%;float:left;margin:10px;" align="right"></div>
<?php kele::import("tpl_system_page");?>
<div class="clear"></div>
    <div class="menu"><ul><li>New From</ul></li></div>
      <?php $memu=kelefunction::memu($this->view);?>
      	<form name="<?php echo $memu['memu']['value']?>" action="kele.php?model=append&contro=module&view=table" method="post">
      	 <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <?php
      foreach ($memu['element']['table'] as $k=>$val){
      	echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'])."</td></tr>";
      }
      ?>
      <tr><td>Field No.</td><td>&nbsp;&nbsp;<input type="text" id="returnfields" size="10" name="table[fields]" value="1">&nbsp;<input type="button" name="add" value="Selection field"  onclick="switchfield()"/></td></tr>
	</table>
	<div align="center"><input type="hidden" name="append" value="true" /><input type="submit" name="Submit" value="Submit" /></div>
	</form>
<script>
function switchfield(){
	var posLeft = 100; var posTop = 100;
   window.open("kele.php?model=append&contro=function&view=field", "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
</script>
</body>
</html>
