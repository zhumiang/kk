<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc. 
 * @author zhuming
 * @package kelecms
 * @subpackage app/contro
 * @version $Id: member.php  2008--@zhuming$
 */
 !defined('kele_start') && die('NOTFINDE');
class kelemember {
	private $userdb;
	private $online;
	private $ip;
	private $model;
	private $contro;
	public  $view;
	
	public function kelemember($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		$this->ip=keledata::getip();
		if(in_array($this->model,array('login','onlineuser','logout','edit','forgotpwd'))){
			kelemember::$model($view);
		}
		else kele::exception('error','model');
	}
	
	public function login($view){
		$data=keledata::httpval(array("login"));
		$card=kelemonitor::pro();
		if($data['login']==true){
			$data=keledata::strval(keledata::httpval(array("username","password")));			
			if(keledata::checkdata($data['username'],'',false)||keledata::checkdata($data['username'],'chinese','',false) && keledata::checkdata($data['password'],'',false)){
				$this->userdb=keledatabase::getthisone("kele_user",array("username='".$data['username']."'"));
				if($this->userdb){
					if($this->userdb['password']==md5($data['password'])){
						if($this->userdb['ispass']!="true")kele::exception('error','unauthor');
						kelemember::onlineuser($view);
						kele::exception('login',keledata::httpval("view")?keledata::httpval("view"):$view);
					}else {
						kele::exception('error','passwordwrong');
					}
				}else {
					kele::exception('error','nouser');
				}
			}else{
				kele::exception('error','notrule');
			}
		}elseif(!keledata::getsession('userid')){
			keletpl::tplget('',$view);
		}else kele::exception('error','loginagain');
	}
	public function onlineuser($view){
		$userdb=keledata::getsession(array("userid","username","onlineip","grade"));
		if(!$this->userdb['id'] && $userdb['userid']){
			$this->userdb['id']=$userdb['userid'];
			$this->userdb['username']=$userdb['username'];
		}
		$this->online=keledatabase::getthisone("kele_useron",array("userid='".$this->userdb['id']."'","username='".$this->userdb['username']."'"));
		if($this->online['userid']&&$this->online['onlineip']!=$this->ip && (time()-$this->online['onlinetime']<300)){
			keledata::delsession(array("userid","username","onlineip"));
			kele::exception('error','havelogin');
		}else{
			if(!$userdb['userid']){
				keledatabase::delete("kele_useron","userid='".$this->online['userid']."'");				
				keledata::setsession(array('userid'=>$this->userdb['id'],'username'=>$this->userdb['username'],'onlineip'=>$this->ip));
				keledatabase::insert(array($this->userdb['id'],$this->userdb['username'],$this->ip,time()),'kele_useron',array('userid','username','onlineip','onlinetime'));
			}elseif($this->online['userid'] && $userdb['userid']){
				keledatabase::update("kele_useron","onlinetime='".time()."'",array("userid='".$userdb['userid']."'","username='".$userdb['username']."'","onlineip='".$userdb['onlineip']."'"));
			}else {
				keledata::delsession(array("userid","username","onlineip"));
				kele::exception('error','unknown');
			}
		}
	}
	
	public function edit($view){
		$amend=keledata::httpval("amend");
		kele::getinclass("app_contro_function");
		if ($amend=="true"){
			$_POST['user']['id']=keledata::getsession('userid');
			kelefunction::amend("user");
		}else {
			$data=kelefunction::amend("user",keledata::getsession('userid'));
			keletpl::tplget('amend',$view,$data);		
		}
	}
	public function logout($view){
		$userdb=keledata::getsession(array("userid","username","onlineip"));
		if($userdb['userid']){
			if(keledata::delsession(array("userid","username","onlineip"))){
				keledatabase::delete("kele_useron","userid='".$userdb['userid']."'");
				kele::exception('logout',$view);
			}
		}else {
			kele::exception('error','nologin');
		}
		kele::exception('error','unknown');
	} 
	
	public function forgotpwd($view){
		$issubmit=keledata::httpval("issubmit");
		if($issubmit){
			$email = keledata::checkdata(keledata::httpval("email"),'email');
			if ($email) {
				kele::getinclass("email_class.phpmailer");
				keledatabase::getthisone("");
				$mail = new PHPMailer(true);
				$mail->IsSMTP();
				$mail->Host       = "smtp.163.com"; // SMTP server
				//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
				$mail->Username   = "zhumiang2000@163.com"; // SMTP account username
				$mail->Password   = "111000";        // SMTP account password
				$mail->AddAddress($email);
  				$mail->SetFrom('zhumiang2000@163.com');
  				$mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  				$mail->Body  ='11111111111';
  				$mail->Send();
			}
		}
		kele::exception('forgotpwd',$view);
	}
}
?>