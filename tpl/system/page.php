<?php
!defined('kele_start') && die('NOTFINDE');
?>
<style>
.p{width:50%;margin-left:10px;margin-top:10px;float:left;}
.p ul li{list-style:none;text-align:center;float:left;height:20px;line-height:20px;margin-left:4px;border: 1px solid #D4D0C8;}
.p .uli{background:#cccccc;}
</style>
<div  class="p">
<ul>
	<li style="text-indent:0px;"><a href="<?php echo $GLOBALS['pagedb']['url']?>">&nbsp;最前&nbsp;</a></li>
	<li style="text-indent:0px;"><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $GLOBALS['pagedb']['pagebefor']?>">&nbsp;前&nbsp;</a></li>
<?php if($GLOBALS['pagedb']['pageone']){$a=$GLOBALS['pagedb']['pagenum']-1;?>
<li><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $a?>"> &nbsp;<?php echo $GLOBALS['pagedb']['pageone']?>&nbsp; </a></li>
<?php }for($n=$GLOBALS['pagedb']['pagenum'];$n<=$GLOBALS['pagedb']['pagemax'];$n++){if($GLOBALS['pagedb']['page']==$n)$class='uli';else $class=''; ?>
	<li style="text-indent:0px;" class="<?php echo $class?>"><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $n?>">&nbsp;<?php echo $n?>&nbsp;</a></li>
<?php }if($GLOBALS['pagedb']['pagetowe']){$b=$GLOBALS['pagedb']['pagemax']+1; ?>
<li><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $b?>"> &nbsp;<?php echo $GLOBALS['pagedb']['pagetowe']?>&nbsp; </a></li>
<?php } ?>
	<li style="text-indent:0px;"><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $GLOBALS['pagedb']['pageback']?>">&nbsp;后&nbsp;</a></li>
	<li style="text-indent:0px;"><a href="<?php echo $GLOBALS['pagedb']['url']?>&page=<?php echo $GLOBALS['pagedb']['pagelast']?>">&nbsp;最后&nbsp;</a></li>
</ul>
</div>