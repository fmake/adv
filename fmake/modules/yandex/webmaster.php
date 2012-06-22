<?php
class yandex_webmaster{
	public $url = "https://webmaster.yandex.ru/api/";
	public $autorization = "me/";

	/**
	* получение получения сервисного документа, происходит автоматический редирект на станицу вида /api/uid которая выдает xml
	*/
	function getServiceDocument($token){
		$curl = new cURL();
		$curl -> init();
		//$curl -> set_opt(CURLOPT_HEADER, true);
		$curl -> set_opt(CURLOPT_HTTPHEADER,array("Authorization: OAuth $token"));
		//echo $this -> url . $this -> autorization;
		$curl -> get($this -> url . $this -> autorization);
		//printAr($curl -> data);
		$xml = new xmlParser();
		return ( $xml -> xmlToArray($curl -> data) );
	}

	/**
	* получение информации о сайтах по массиву сервисного документа
	*/
	function getSiteInfoServiceDocument($serviceDocument,$token){
		$curl = new cURL();
		$curl -> init();
		//$curl -> set_opt(CURLOPT_HEADER, true);
		$curl -> set_opt(CURLOPT_HTTPHEADER,array("Authorization: OAuth $token"));
		//echo $this -> url . $this -> autorization;
		$curl -> get($serviceDocument['workspace']['collection']['@attributes']['href']);
		//printAr($curl -> data);
		$xml = new xmlParser();
		return ( $xml -> xmlToArray($curl -> data) );
	}

	/**
	* получение информации о сайтах
	*/
	function getSiteInfo(){
		global $configs;
		$token = $configs -> yandex_api_token;
		$serviceDocument = $this -> getServiceDocument($token);
		return $this -> getSiteInfoServiceDocument($serviceDocument,$token);
	}


}
