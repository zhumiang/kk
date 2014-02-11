<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<link href="<?php echo http_dir?>CGI/css/admincss.css" rel="stylesheet" type="text/css" />
<script src="<?php echo http_dir?>CGI/js/jquery.js" type="text/javascript"></script>
<title><?php echo $GLOBALS['KELE']['title']?></title>

</head>
<body>
<?php 
if($GLOBALS['POWER'][$this->view]['search']){
$search=kelefunction::seachmemu($this->view);
if($search){
?>
<div class="menu"> 
Search With
</div>
<form name="<?php echo $search['memu']['value']?>" action="<?php echo http_dir?>?model=search&contro=function&view=<?php echo $this->view?>" enctype="multipart/form-data" method="post">
 <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
 <tr>
<?php 
$i=0;
      	foreach ($search['element'] as $searchfields){
      	foreach($searchfields as $val){
      		$i++;      		
      		echo"<td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['SEARCH'][$val['classify']][$val['field']],$val['size'])."</td>";      		
      		if($i%4==0)echo "</tr><tr>";
      	}}?>    	
<td align="center" <?php $i++; if($i%4!=0)echo "colspan=".((4-($i%4)+1)*2); ?>>
		<input type="hidden" name="search" value="true" />
	      <input type="submit" name="Submit" value="Submit" />
</td>
</tr> 
 </table>
</form>
<?php }}?>
<?php 
$moveday=keledata::httpval("month");
if(!$moveday)$moveday=time();
$days=date(t,$moveday);
$user=keledatabase::getarray(array("users","department"),array("users.ispass='true'","users.departmentid=department.id"),array("users.fullname","users.id","department.name","users.departmentid"));
$month=date(m,$moveday);
$year=date(Y,$moveday);
$data=keledatabase::getarray("attendance",array("cycle>=".strtotime($year.'-'.$month.'-'.'1'),"cycle<".strtotime($year.'-'.$month.'-'.$days)));
foreach ($data as $val){
	$data2[$val['usersid']][$val['cycle']]=$val;
	if($val['completetime']=="√")$data2[$val['usersid']]['chuqing1']+=1;
	if($val['completetime2']=="√")$data2[$val['usersid']]['chuqing2']+=1;
}
$a=array('日','一','二','三','四','五','六');
?>  
<div class="menu"> 
<p style="float:left;"><a href="<?php echo http_dir?>?model=show&contro=do&view=<?php echo $this->view?>&month=<?php echo strtotime("last month",$moveday)?>">前一个月</a>
<a href="<?php echo http_dir?>?model=show&contro=do&view=<?php echo $this->view?>&month=<?php echo strtotime("next month",$moveday)?>">后一个月</a>
</p>
<p style="text-align:center;"><?php echo $year."年".$month."月————出勤情况表"?></p>
</div>
  <div style="margin-left:10px;width:90%;height:600px;overflow:scroll;">
  <table border="0" cellpadding="0" cellspacing="0">
  <tr><td valign="top">

	  <table border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9">
	  <tr>
	  <td><nobr>部门</nobr></td>
	  <td><nobr>姓名</nobr></td>
	  <td align=center><nobr>日<br>星期</nobr></td>
	  <?php
 	for ($i=1;$i<=$days;$i++){
?>
        <td><nobr><font <?php if($a[date('w',strtotime($year.'-'.$month.'-'.$i))]=="六"||$a[date('w',strtotime($year.'-'.$month.'-'.$i))]=="日")echo "style='color:#FF000A;'";?>>
        <?php echo $i?><br/><?php echo $a[date('w',strtotime($year.'-'.$month.'-'.$i))];?></font></nobr>
        <input type="hidden" id="m_<?php echo $i;?>" name="date" value="<?php echo strtotime($year.'-'.$month.'-'.$i);?>"></input>
        </td>
<?php }?>
	<td><nobr>本月<br />出勤</nobr></td>
</tr>
	  <?php 
	  foreach ($user as $key => $values){
	  	?>
	  <tr>
	  <td rowspan="2"><nobr><?php echo $values['name'];?><input type="hidden" name="departmentid" value="<?php echo $values['departmentid'];?>" id="d_<?php echo $key?>"></input></nobr></td>
	  <td rowspan="2"><nobr><?php echo $values['fullname'];?><input type="hidden" name="uid" value="<?php echo $values['id'];?>" id="u_<?php echo $key?>"></input></nobr></td>
	  <td><nobr>上午</nobr></td>
<?php
 	for ($i=1;$i<=$days;$i++){
?>
        <td><nobr>
        <?php if($GLOBALS['POWER'][$this->view]['append']){?>
        <input id="t1_<?php echo $key."_".$i;?>" type="text" name="completetime" size="1" value="<?php echo $data2[$values['id']][strtotime($year.'-'.$month.'-'.$i)]['completetime']?>"></input>
        <?php 
			}else{
        		echo $data2[$values['id']][strtotime($year.'-'.$month.'-'.$i)]['completetime'];
        	}
        ?>
        <input id="i_<?php echo $key."_".$i;?>" type="hidden" name="id" value="<?php echo $data2[$values['id']][strtotime($year.'-'.$month.'-'.$i)]['id']?>"></input>
        </nobr></td>
<?php }?>
<td><?php echo $data2[$values['id']]['chuqing1'];?></td>
 </tr>
 <tr>
 <td><nobr>下午</nobr></td>
<?php
 	for ($i=1;$i<=$days;$i++){
?>
        <td><nobr>
        <?php if($GLOBALS['POWER'][$this->view]['append']){?>
        <input id="t2_<?php echo $key."_".$i;?>" type="text" name="completetime2" size="1" value="<?php echo $data2[$values['id']][strtotime($year.'-'.$month.'-'.$i)]['completetime2']?>"></input>
        <?php 
			}else{
        		echo $data2[$values['id']][strtotime($year.'-'.$month.'-'.$i)]['completetime2'];
        	}
        ?>        
        </nobr></td>
<?php }?>
<td><?php echo $data2[$values['id']]['chuqing2'];?></td>
 </tr>    
 <?php }?>  
</table>
  </td>
  <td valign="top">
  <table border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9">
<tr>
<td colspan="9"><nobr>考勤记用符号</nobr></td>
</tr>
<tr>
<td colspan="9"><nobr>
1、本资料为工资计发依据，望按时填报。<br/>
2、每日正常上班时间以8小时计算。<br/>
3、假期与周末均以蓝色字体标注。<br/>
4、迟到、早退、请假均以红色字体标注。</nobr></td>
</tr>
<tr>
<td><nobr>
类别</nobr></td>
<td><nobr>
出勤</nobr></td>
<td><nobr>
事假</nobr></td>
<td><nobr>
病假</nobr></td>
<td><nobr>
旷工</nobr></td>
<td><nobr>
早退</nobr></td>
<td><nobr>
公休</nobr></td>
<td><nobr>
迟到</nobr></td>
<td><nobr>
公差</nobr></td>
</tr>
<tr>
<td><nobr>
符号</nobr></td>
<td><nobr>
√</nobr></td>
<td><nobr>
○</nobr></td>
<td><nobr>
△</nobr></td>
<td><nobr>
╳</nobr></td>
<td><nobr>
分钟</nobr></td>
<td><nobr>
G</nobr></td>
<td><nobr>
分钟</nobr></td>
<td><nobr>
□</nobr></td>
</tr>
</table>
  </td>
  </tr>  
  </table>
</div>
<div id="selectval" style="position:absolute; width:30px; border:1px solid #ccc;display:none;line-height:130%;text-align:center;">
<ul>
<li>√</li>
<li>○</li>
<li>△</li>
<li>╳</li>
<li>G</li>
<li>□</li>
</ul>
</div>
<script>
var url1="<?php echo http_dir?>?model=append&contro=function&view=<?php echo $this->view?>";
var url2="<?php echo http_dir?>?model=amend&contro=function&view=<?php echo $this->view?>";
var arr=new Array();
$(document).ready(function (){
	$("input[name='completetime'],input[name='completetime']").each(function (i){
		$(this).click(function (){
			showselect(this);
		});
		$(this).focusout(function (){
			closeslect(this);
			cksub(this);
		});
	});
});
function cksub(obj){	
	var str=obj.id.split("_");
	var id=$("#i_"+str[1]+"_"+str[2]).val();
	var com1,com2;
	if(obj.name=="completetime")com1=obj.value;
	else if(obj.name=="completetime2")com2=obj.value;
	if(id){
		$.post(url2,
				{
			'attendance[id]':id,
			'attendance[usersid]':$("#u_"+str[1]).val(),
			'attendance[departmentid]':$("#d_"+str[1]).val(),
			'attendance[cycle]':$("#m_"+str[2]).val(),
			'attendance[completetime]':com1,
			'attendance[completetime2]':com2,
			is_ajax:"1",
			amend:"true"},
				function (data){
					backdo(data);			
				});
	}else {
		$.post(url1,
				{
			'attendance[id]':id,
			'attendance[usersid]':$("#u_"+str[1]).val(),
			'attendance[departmentid]':$("#d_"+str[1]).val(),
			'attendance[cycle]':$("#m_"+str[2]).val(),
			'attendance[completetime]':com1,
			'attendance[completetime2]':com2,
			is_ajax:"1",
			append:"true"},
				function (data){
					backdo(data,str);
				});
	}
}
function showselect(obj){
	$("#selectval").css({"left":$(obj).offset().left,"top":$(obj).offset().top+18});
	$("#selectval").css({"display":"block"});
	$("#selectval ul li").each(function (i){		
		$(this).mouseover(function (){
			$(obj).val($(this).html());
		});
	});
}
function closeslect(obj){
	$("#selectval ul li").each(function (i){
		$(this).unbind("mouseover");
	});
	$("#selectval").css({"display":"none"});
}
function backdo(data,arr){	
	if(data&&data!='true')$("#i_"+arr[1]+"_"+arr[2]).val(data);	
}
</script>
</body>
</html>
