<?php
class SRequest{
	private $_get;
	private $_post;
	private static $_instance;

	private function __construct(){
		$this->_get = $_GET;
		$this->_post = $_POST;
		$_GET = $_POST = null;
	}
	
	public function get($var = null){
		return $this->getVar($this->_get,$var);
	}
	
	public function post($var = null){
		return $this->getVar($this->_post,$var);
	} 

	private function getVar($array,$key = null){
		if(isset($key)){
			if(isset($array[$key])){
				$result = $array[$key];
			}else{
				$result = null;
			}
		}else{
			$result = $array;
		}
		return $result;
	}

	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new SRequest();
		}
		return self::$_instance;
	}
}