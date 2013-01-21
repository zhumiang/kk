<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<link href="<?php echo http_dir?>CGI/css/admincss.css" rel="stylesheet" type="text/css" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
<style>
body{line-height:150%;}
</style>
</head>
<body>
<div class="menu"> 
<?php $column=keledatabase::getarray("kele_column","upcolumnid=1");foreach ($column as $value){?>
<a href="<?php echo $value['linkurl']?>"><?php echo $value['name']?></a>&nbsp;
<?php }?>
</div>
  <?php 
  $field=kelefunction::memu($this->view,'list');
  ?>
  <form name="fieldform" action="kele.php?model=delete&contro=function&view=field" method="post">
	  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <tr>
      <?php foreach ($field['element'] as $values){
  	foreach ($values as $val){?>
        <td><?php echo $val['name']?></td>
        <?php }}?>
        <td>Operating</td>
      </tr>      
	  <?php if($GLOBALS['DATA']){
	  	foreach ($GLOBALS['DATA'] as $value){
	  		echo "<tr>";
	  foreach ($field['element'] as $fields){
      	foreach($fields as $k => $val){
	  ?>
        <td><?php echo element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$value[$val['field']],$val['size'],'read')?></td>
<?php }}?>
        <td><a href="kele.php?model=amend&contro=function&view=field&id=<?php echo $value['id']?>">Modify</a>&nbsp;
        <?php
        $tables=keledatabase::getarray("kele_table",'',"fields");
        foreach ($tables as $number){
        	if (in_array($value['id'],explode(",",$number['fields']))){
        		$true=true;break;
        	}else $true=false;
        }
        if (!$true) {
        ?>
         <a href="kele.php?model=delete&contro=function&view=field&id=<?php echo $value['id']?>" onClick="return confirm('Are you sure you want to delete?');" >Delete</a>
         <input type="checkbox" name="id[]" value="<?php echo $value['id']?>">
         <?php }?>
         </td>
      </tr>
      <?php }}?>
    </table>
   <div style="width:40%;float:left;margin:10px;" align="right">
	  <input type="submit" name="Submit" value="Delete" onClick="return confirm('Are you sure you want to delete?');" />
    </div>
        <?php kele::import("tpl_system_page");?>
    </form>
    <div class="clear"></div>
 <div class="menu">Add a new field</div>
      <?php $memu=kelefunction::memu($this->view);?>
      	<form name="<?php echo $memu['memu']['value']?>" action="kele.php?model=append&contro=function&view=field" method="post">
      	  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <?php
      foreach ($memu['element']['field'] as $k=>$val){
      	echo "<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'])."</td></tr>";
      }
      ?>
	</table>
    <div style="width:100%" align="center">
	  <input type="hidden" name="append" value="true" /><input type="submit" name="Submit" value="Submit" />
    </div>
	</form>
</div>
</body>
</html>
