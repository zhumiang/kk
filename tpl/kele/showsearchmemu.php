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
<div class="menu">Form Manage ㄧ <a href="kele.php?model=show&contro=function&view=table">Form Set ㄧ </a>&nbsp;
<a href="kele.php?model=show&contro=function&view=searchmemu">Read All</a>
</div>
<table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      <tr>
      	<td>NO</td>
        <td>Form Name</td>
        <td>Function name</td>
        <td>Operating</td>
      </tr>
      <tr>
	  <?php
	  if ($page=keledata::httpval("page"))keledata::checkdata($page,"number");
		!$page && $page=1;$size=20;
		$sum=keledatabase::getnum("kele_searchmemu");
		keledata::pagemover($size,$sum,"?model=show&contro=function&view=searchmemu",$page);
		$limit=array("start"=>($page-1)*$size,"num"=>$size);
	  $data=keledatabase::getarray("kele_searchmemu","","*","id desc","",$limit);
	  foreach ($data as $value){
	  ?>
	  	<td><?php echo $value['id']?></td>
        <td><?php echo $value['name']?></td>
        <td><?php echo $value['value']?></td>
        <td><a href="kele.php?model=amend&contro=function&view=searchmemu&id=<?php echo $value['id']?>">Form Manage</a>
        &nbsp;<a href="kele.php?model=delete&contro=function&view=searchmemu&id=<?php echo $value['id']?>" onClick="return confirm('Are you sure you want to delete?');" >Delete</a></td>
      </tr>
      <?php }?>
    </table> <div style="width:40%;float:left;margin:10px;" align="right"></div>
        <?php kele::import("tpl_system_page");?>
</body>
</html>
