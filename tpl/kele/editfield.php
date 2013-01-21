<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<link href="<?php echo http_dir?>CGI/css/admincss.css" rel="stylesheet" type="text/css" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
<script>
function returnfield(){
var obj=document.getElementsByName('id[]');
var str='';
for(var i=0;i<obj.length;i++){
	if(obj[i].checked==true){
		if(str=='')str=obj[i].value;
		else str+=","+obj[i].value;
	}
}
var val=window.opener.document.getElementById('returnfields').value;
if(!val)window.opener.document.getElementById('returnfields').value=str;
else window.opener.document.getElementById('returnfields').value=val+","+str;
if(document.all) window.opener=true;
window.close();
}
</script>
</head>
<body>
<?php if ($this->model=="amend") {?>
     <div class="menu">ModifyField&nbsp;&nbsp;<?php $column=keledatabase::getarray("kele_column","upcolumnid=1");foreach ($column as $value){?>
<a href="<?php echo $value['linkurl']?>"><?php echo $value['name']?></a>&nbsp;
<?php }?></div>
      <?php $memu=kelefunction::memu($this->view);?>
      	<form name="<?php echo $memu['memu']['value']?>" action="kele.php?model=amend&contro=module&view=field" method="post">
      	  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <?php
      foreach ($memu['element']['field'] as $k=>$val){
      	echo "<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['classify']][$val['field']])."</td></tr>";
      }
      ?>
	</table>
	    <div style="width:100%" align="center">
	  <input type="hidden" name="amend" value="true" />
	  <input type="hidden" name="field[id]" value="<?php echo $GLOBALS['DATA']['field']['id']?>"/>
      <input type="submit" name="Submit" value="Submit" />
    </div>
	 <div class="menu">Use the data table</div>
	<?php
      $tables=keledatabase::getarray("kele_table",'',array("id","name","value","fields"));
      if ($tables) {?>
       <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
    <?php foreach ($tables as $value){
        	if (in_array($GLOBALS['DATA']['field']['id'],explode(",",$value['fields']))){
        		echo "<tr><td>".$value['id']."</td><td>&nbsp;&nbsp;".$value['name']."</td><td>".$value['value']."</td></tr>";}}?>
     </table>
    <?php }?>
	</form>
<?php }else{?>
  <?php 
  $fields=keledatabase::getthisone("kele_table","value='kele_field'","fields");
  $field=keledatabase::getarray("kele_field","id in (".$fields.")");
  ?>
  <div class="menu">Field selection</div>
  <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <tr>
      <?php foreach ($field as $val){?>
        <td><?php echo $val['name']?></td>
        <?php }?>
         <td>Selection</td>
      </tr>
      <tr>
	  <?php $data=kelefunction::show("field","20");
	  foreach ($data as $value){
	  	foreach ($field as $val){
	  ?>
        <td><?php echo $value[$val['value']]?>&nbsp;</td>
        <?php }?>
        <td><input type="checkbox" id="id[]" name="id[]" value="<?php echo $value['id']?>"></td>
      </tr>
      <?php }?>
    </table>
     <?php if($this->model!="amend"){?><?php kele::import("tpl_system_page");?><?php }?>
    <div style="width:100%" align="center">
	      <input type="submit" name="Submit" value="Submit"  onclick="returnfield()"/>
    </div>
<?php }?>
</body>
</html>
