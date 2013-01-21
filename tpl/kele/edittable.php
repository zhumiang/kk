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
<?php $column=keledatabase::getarray("kele_column","upcolumnid=1"); foreach ($column as $value){?>
<a href="<?php echo $value['linkurl']?>"><?php echo $value['name']?></a>&nbsp;
<?php }?>
</div>
	
      <?php $memu=kelefunction::memu($this->view);?>
      	<form name="<?php echo $memu['memu']['value']?>" action="kele.php?model=amend&contro=module&view=table" method="post">
     <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px; ">
      <?php
      foreach ($memu['element']['table'] as $k=>$val){
      	echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['classify']][$val['field']])."</td></tr>";
      }
      ?>
     <tr><td>Field No.</td> <td>&nbsp;&nbsp;<input type="text" id="returnfields" readonly size="10" name="table[fields]" value="<?php echo $GLOBALS['DATA']['table']['fields']?>">&nbsp;<input type="button" name="add" value="Selection field"  onclick="switchfield()"/></td></tr>
	</table>
	<div align="center"><input type="hidden" name="table[id]" value="<?php echo $GLOBALS['DATA']['table']['id']?>" /><input type="hidden" name="amend" value="true" /><input type="submit" name="Submit" value="Submit" /></div>
	</form>
	</div>
<div>
<div>
<div class="menu">Field List</div>
<?php $field=keledatabase::getarray("kele_field","id in (".$GLOBALS['DATA']['table']['fields'].")");?>
<form name="delfield" action="kele.php?model=delete&contro=module&view=field" method="post">
 <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px; ">
 <?php foreach ($field as $value){?>
      <tr>
      <?php foreach ($value as $val){?>
        <td><?php echo $val?>&nbsp;</td>
        <?php }if(count($field)>1){?>
        <td><input type="checkbox" name="field[id][]" value="<?php echo $value['id']?>"></td>
        <?php }?>
      </tr>
<?php }?>
 </table>
 <div align="center">
		<input type="hidden" name="table[id]" value="<?php echo $GLOBALS['DATA']['table']['id']?>" />
	    <input type="submit" name="Submit" value="Del" onClick="return confirm('Are you sure you want to delete?');" />
 </div>
</form>
</div>
<script>
function switchfield(){
	var posLeft = 100; var posTop = 100;
   window.open("kele.php?model=append&contro=function&view=field", "popUpImagesWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}
</script>
</body>
</html>
