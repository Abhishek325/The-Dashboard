<?php
namespace Prote\Objects;
use DIC\Service;
class Auth{
	private $salt='';
	private $hash='';
	private $AuthToken=NULL;
	private $Service;
	private $DbName='admin';
	public function __construct(Service $Service){
		$this->Service=$Service;
		$this->Service->DbSession();
		$this->Db=$this->Service->Database();
		$this->Db->connect();
		$this->setup();
	}

	public function login($email,$pwd,$auth_token){
		$email=strtolower($email);
		if($this->auth_token_verification_fails($auth_token)){
			if($this->Service->Config()->debug_mode_is_on()){
				$this->Service->Config()->collect_debug_data('<br>Could not verify auth token');
				var_dump($this->Service->Config()->get_debug_data());
			}
			return false;
		}
		
		$this->make_salt($email,$pwd);
		$pwd=$this->generate_hash($pwd);
		/*
		$email="MAIL@jargonsmaze.com";
		$pwd="";
		echo $pwd;
		exit();*/
		// $this->Db->set_parameters(array($email,$this->hash));
		// if($data=$this->Db->find_one('SELECT id,privilege from '.$this->DbName.' where email=? && pwd=?')){
		if($id=$this->Service->Prote()->DBI()->Func()->users()->verify($email,$pwd)){	
			$_SESSION['id']=$id;
			// $this->Service->Privilege()->set($data->privilege);
			return true;
		}else{
			return false;
		}
	} 

	public function login_debug(){
		$email=$_POST['uname'];
		$pwd=$_POST['upwd'];
		$auth_token=$_POST['auth_token'];
		$this->make_salt($email,$pwd);
		$pwd=$this->generate_hash($pwd);
		$status=$this->Service->Prote()->DBI()->Func()->data()->verify($email,$pwd,$auth_token);
		var_dump($status);
		exit();
	}

	public function logout($auth_token){
		if($this->auth_token_verification_fails($auth_token))
			return false;

		if(!isset($_SESSION['id'])){
			return false;
		}
		else{
			// $this->Service->DbSession()->destroy($_SESSION['id']);
			session_destroy();
			$this->setup();
			return true;
		}
	}

	
	public function email2pwd($email){
		$this->Db->set_parameters(array($email));
		return $this->Db->find_one('SELECT pwd from '.$this->DbName.' where Email=?')->Pwd;
	}

	public function email2id($email){
		$this->Db->set_parameters(array($email));
		return $this->Db->find_one('SELECT Id from '.$this->DbName.' where Email=?')->Id;
	}

	public function generate_hash($pwd){
		return $this->hash=hash('sha512',$pwd.$this->salt);
	}

	public function make_salt($email,$pwd){
		return $this->salt=crypt($pwd, $email.'5UCK5'.$pwd);	
	}

	public function user_exists($email){
		$this->Db->set_parameters(array($email));
		$a=$this->Db->find_one('Select count(*) as count from '.$this->DbName.' where Email=?');
		if($a->count==1)
			return true;
		else
			return false;
	}

	public function generate_auth_token(){
		return $_SESSION['auth_token']=$this->Service->Html()->auth_token=uniqid(mt_rand());
	}

	public function generate_random_key(){
		return uniqid(mt_rand());
	}

	public function get_auth_token(){
		if(isset($_SESSION['auth_token']))
			$this->Service->Html()->auth_token=$_SESSION['auth_token'];
		else
			$this->generate_auth_token();
	}

	public function auth_token_verified($auth_token){
		if(!empty($auth_token) && $_SESSION['auth_token']==$auth_token ){
			$this->generate_auth_token();
			return true;
		}
		else {
			return false;
		}
	}

	public function auth_token_verification_fails($auth_token){
		if(empty($auth_token) || $_SESSION['auth_token']!=$auth_token ){
			return true;
		}
		else {
			$this->generate_auth_token();
			return false;
		}
	}

	public function setup($name="PHPSESSID"){
		if(isset($_COOKIE[$name])){
			if(empty($_COOKIE[$name])){
            	// $this->Service->DbSession()->session_repair();  
            	session_start();
                session_destroy();
                session_start();  
                session_regenerate_id();
                $this->generate_auth_token();
                return session_id();
            
			}
			else{
				//session_start();
				$this->get_auth_token();

			}
		}else{
			session_start();
			$this->generate_auth_token();
		}
	}

	public function logged_out(){
		if(isset($_SESSION['id']))
			return false;
		else
			return true;
	}
	
	public function logged_in(){
		if(isset($_SESSION['id']))
			return true;
		else
			return false;
	}

	public function get_uid(){
		return $_SESSION['id'];
	}

	public function verify_session($name="PHPSESSID"){

		

	}

}
?>