<?php
class AuthModule{
	private $login;//String

	public function getLogin(){ 
		return $this->login;
	}
	public function connect($login){
		
		$this->login = $login;
	}
	public function disconnect(){
		$this->login = null;
	}
	public function isConnected(){
		return !is_null($this->login);
	}

	public function __construct(){
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION['authLogin'])){
			$this->login = $_SESSION['authLogin'];
		}
	}
	public function __destruct(){
		$_SESSION['authLogin'] = $this->login;
	}
}