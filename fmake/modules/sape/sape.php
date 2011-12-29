<?php
/**
 * Sape коннек, инициализация, основной объект
 */
class sape extends fmakeCore{
	
	public static $irxClient = false;
	private $server = 'api.sape.ru';
	private $url = '/xmlrpc/?v=extended';
	
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
		$irxClient = $this -> getIrxClient();
		printAr( $irxClient -> query('sape.login', $login, $pass, $isMd5) );
		return true;
	}
	/**
	 * 
	 * Получить 
	 * @param unknown_type $id_project
	 * @param unknown_type $date_start
	 * @param unknown_type $date_end
	 */
	function getMoney($id_project,$date_start,$date_end){
		return array();	
	}
	
}