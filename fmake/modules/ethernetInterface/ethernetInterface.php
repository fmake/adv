<?php
/**
 * Смена интерфеса ethernet ip, proxy
 * 
 */
class ethernetInterface {
	private static $proxy = false;
	
	/**
	 * 
	 * получить объект прокси
	 * @return ethernetInterface_Proxy
	 */
	private	function getProxyObj(){
		if(!self::$proxy){
			self::$proxy = new ethernetInterface_Proxy();
		}
		return self::$proxy;
	}
	
	function getProxyByYandex($active = true){
		return $this -> getProxyObj() -> getByYandex ($active);
	}
	
	function getProxyByGoogle($active = false){
		return $this -> getProxyObj() -> getByGoogle ($active);
	}
	
	function setDefault(){
		return $this -> getProxyObj() -> setDefault();
	}
	
	
}