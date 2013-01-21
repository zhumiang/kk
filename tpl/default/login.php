<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<title><?php echo $GLOBALS['KELE']['title']?></title>
<style>
* {padding:0px;margin:0px auto;font-family:Verdana, Arial, Helvetica, sans-serif;}
body {margin: 0px;}
.input {vertical-align:middle;border: 1px solid #D4D0C8; width:180px; height:19px;}
img {border:none;vertical-align:middle;}
ul li{list-style:none;}
.font{width:90px;font-size: 13px; height:24px; line-height:24px; font-family: Arial; text-align: left; color: #666666; float:left;}
.reset{width:68px;height:51px;background:url(<?php echo http_dir?>CGI/images/kele/cancel.png); border:0px; }
.submit{width:69px;height:51px;background:url(<?php echo http_dir?>CGI/images/kele/login.png); border:0px;}
.main{ width:1003px; height:600px;}
.login{width:469px;height:296px; margin-top:13%;background:url(<?php echo http_dir?>CGI/images/kele/loginform.png);}
</style>
<script>
    function notEmpty(obj, msg)
    {
        str = obj.value;
        str1 = "";
        for (i = 0; i < str.length; i++)
        {
                if (str.charAt(i) != " ")
                {
                    str1 = str.substr(i, str.length);
                    break;
                }
        }
    
        if (str1 == "")
        {
            alert(msg);
            obj.value = "";
            obj.focus();
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
</head>
<body>
<div class="main">
<div class="login">
<form method=post action='<?php echo http_dir?>?contor=login&model=member&view=index' onSubmit="return notEmpty(username, 'username is Null')&&notEmpty(password, 'password is Null')">
<table width="290" height="217"  border="0">
    <tr>
      <td height="80">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="font">USERNAME:</td>
      <td><input type="text" name="username" id="username" onfocus="this.style.borderColor='#71D943'" onblur="this.style.borderColor='#84A4F6'" class="input" /></td>
    </tr>
    <tr>
      <td class="font">PASSWORD:</td>
      <td><input type="password" name="password" id="password" onfocus="this.style.borderColor='#71D943'" onblur="this.style.borderColor='#84A4F6'" class="input" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;<input type=hidden name=login value=true>
            <input type="submit" name="Submit" value="" class="submit" />
            &nbsp;&nbsp;
			<input type="reset" name="reset" value="" class="reset" /></td>
    </tr>
  </table>
    </form>	
</div>
</div>
</body>
</html>
