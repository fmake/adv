<?php
include 'IXR_Client/IXR_Client.php';
/**
 * Sape коннек, инициализация, основной объект
 */
class sape extends fmakeCore{
	
	public static $irxClient = false;
	private $server = 'api.sape.ru';
	private $url = '/xmlrpc/?v=extended';
	private $isLogin = false;
	
	function getIrxClient(){
		if(!self::$irxClient)
			self::$irxClient = new IXR_Client($this->server, $this -> url);
		return self::$irxClient;
	}
	
	/**
	 * 
	 * Коннект
	 * @param string $login
	 * @param string $pass
	 * @param string $md5
	 */
	function login ($login,$pass,$isMd5 = false){
		if($this->isLogin)
			return true;
		$irxClient = $this -> getIrxClient();
		$irxClient -> query('sape.login', $login, $pass, $isMd5);
		if( is_int($irxClient -> getResponse()) )
			return $this->isLogin = true;
		else 
			return $this->isLogin = false;
	}
	/**
	 * 
	 * Коннект с паролем из параметров
	 * @param string $login
	 * @param string $pass
	 * @param string $md5
	 */
	function loginDefault (){
		global $configs;
		return $this -> login($configs -> sape_login, $configs -> sape_password);
	}

	
	
	
}