<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jumpPage</title>
<style>  
*{margin:0; padding:0;}
body{  border:0px}
body,html{ height:98%;}
#outer{ width:98%; height:98%;position:relative;}
#outer[id]{ display:table;}
#middle{ position:absolute;top:49%;}
#middle[id]{ display:table-cell; position:static; vertical-align:middle}
#inner{ position:relative; top:-49%;}
#content{ width:200px; height:200px; margin:0 auto;}
</style>  

</head>

<body>
<div id="outer">  
<div id="middle">  
<div id="inner"> 
	<div id="content" align="center">	
	<meta http-equiv="refresh" content="10<?php //echo $GLOBALS['DATA']['jumptime'];?>;url=<?php echo $GLOBALS['DATA']['url']?>"/>
		<a href="<?php echo $GLOBALS['DATA']['url']?>"><?php 
			echo $GLOBALS['DATA']['result'];
		?></a>
	</div>
</div>
</div>  
</body>

</html>
