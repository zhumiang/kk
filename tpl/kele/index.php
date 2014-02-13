<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>"/>
<title><?php echo $GLOBALS['KELE']['title']?></title>
</head>
	<frameset rows="80,*" cols="*" frameborder="no" border="0" framespacing="0">
	  <frame src="kele.php?model=show&contro=function&view=header" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
	  <frameset cols="220,*" frameborder="no" border="0" framespacing="0">
		<frame src="kele.php?model=show&contro=function&view=left" name="leftFrame" scrolling="auto" noresize="noresize" id="leftFrame" title="leftFrame" />
		<frame src="kele.php?model=show&contro=function&view=main" name="mainFrame" scrolling="yes"  noresize="noresize" id="mainFrame" title="mainFrame" />
	  </frameset>
	</frameset>
	<noframes>
		<body></body>
	</noframes>
</html>
