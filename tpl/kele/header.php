<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
<script language="javascript">
function leftmenu(url,id){
	var left = parent.leftFrame;
	var main = parent.mainFrame;
	left.location.href+="&id="+id;
	main.location.href=url;
}
</script>
<style>
* {padding:0px;margin:0px auto;font-family:Verdana, Arial, Helvetica, sans-serif;}
body {margin: 0px; font-size:12px;}
a{ text-decoration:none;}
img {border:none;vertical-align:middle;}
ul li{list-style:none;}
.header{ width:100%; height:52px; background:url(<?php echo http_dir?>CGI/images/kele/headerbg.png);}
.log{ margin:0px;}
.tabula{ width:100%; height:28px; background:url(<?php echo http_dir?>CGI/images/kele/tabula.png);}
.menu{width:1003px; font-size:14px; float:right; height:37px; margin-top:-30px;}
.menu a{color:#000000; }
.menu ul{float:right; width:60%; height:30px; line-height:30px;}
.menu ul li{float:left; width:83px; margin-left:3px; text-align:center; background:url(<?php echo http_dir?>CGI/images/kele/menulist1.png);}
.menu .chmenu{ background:url(<?php echo http_dir?>CGI/images/kele/menulist2.png);}
.menu .chmenu a{color:#ffffff;}
</style>
<script language="LiveScript">
function time(){
	today = new Date();
	var days= new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	var day=today.getDay();
	document.getElementById('htime').innerHTML="nowTime:"+today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate()+" "+"&nbsp;"+days[day]+"&nbsp;"+today.getHours()+":"+today.getMinutes()+":"+today.getSeconds()+"&nbsp;";
	 setTimeout("time()", 1000);
}
</script>
</head>
<body onload="time()">
<div class="header">
<div class="log"><img src="<?php echo http_dir?>CGI/images/kele/log.png" border="0"  /></div>
<div class="menu">
<ul>
<?php 
$column=keledatabase::getarray("kele_column","upcolumnid=0");
if($column){
foreach ($column as $key=> $value){
?>
<li id="menu<?php echo $key+1?>"><a href="javascript:void(0);" onclick="change(<?php echo $key+1?>);leftmenu('<?php echo $value['linkurl']?>',<?php echo $value['id']?>);"><?php echo $value['name']?></a></li>
<?php
}}
?>
<script>
function change(num){
	var s=<?php echo $key?>+1;
	for(var i=1;i<=s;i++){
		if(i==num)document.getElementById('menu'+i).className="chmenu";
		else document.getElementById('menu'+i).className="";
	}
}
</script>
</ul>
</div>
</div>
<div class="tabula">
	<p id="htime" style="height:28px; margin-left:20px; line-height:28px; float:left;">
	</p>
<span style="float:right; height:28px; line-height:28px; margin-right:20px;">Welcome to you,<?php echo keledata::getsession('username')?>
&nbsp;&nbsp;<a href="<?php echo http_dir?>index.php"  target="_blank">Home Page </a>
&nbsp;&nbsp;<a href="kele.php?model=logout&contro=member&view=kele"  target="_parent">Logout</a></span>
</div>
</body>
</html>
