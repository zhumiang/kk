<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
<style type="text/css">
* {padding:0px;margin:0px auto;font-family:Verdana, Arial, Helvetica, sans-serif;}
body {margin: 0px; font-size:12px;}
a{ text-decoration:none;}
img {border:none;vertical-align:middle;}
ul li{list-style:none;}
.menu{ width:210px; float:left; margin-left:5px; height:auto;}
.menu a{color:#000000; }
.memu ul{width:205px; height:auto;}
.menu ul li{ width:205px; font-size:14px; height:30px; background:url(<?php echo http_dir?>CGI/images/kele/leftmenu.png); text-indent:62px; margin-top:6px; line-height:30px;}
</style>
<script language="javascript">
function urlto(url){
	var main = parent.mainFrame;
	main.location=url;
}
</script>
</head>
<body>
<div class="menu">
	<ul>
	<?php
	$id=keledata::httpval("id");
	if ($id) {
		keledata::checkdata($id,"number");
	}else $id=7;
	$column=keledatabase::getarray("kele_column","upcolumnid=$id");
	if ($column) {
	foreach ($column as $value){
	?>
<li id="<?php echo $value['value']?>"><a href="javascript:void(0);" onclick="urlto('<?php echo $value['linkurl']?>')"><?php echo $value['name']?></a></li>
<?php }}?>
	</ul>
</div>
</body>
</html>
