<?php
abstract class  searchSystems{
	
	public static $parentClassName = "searchSystems";
	
	/**
	*
	* получить данные с определенной страницы
	*/
	abstract function getResponse($page);
	
	/**
	*
	* установить адресс запроса
	*/
	abstract function setInterfaceCurl();
	
	
	/**
	*
	* инициализировать cURL
	*/
	abstract function initCurl();
	
	/**
	*
	*  сравнение хостов
	*/
	public function cmpUrls($a,$b){
		return preg_match("/^http:\/\/(www\.)?{$a}/i", $b);
	}
	
	/**
	*
	* перекодировка для сайтов на русском
	*/
	public function idnaConvert($a){
		require_once('idna_convert.class.php');
		$IDNA = new idna_convert();
		return $IDNA->encode($a);
	}

	
	/**
	*
	* позиция сайта
	*/
	public function getPosition(){
		$page  = 0;
		$this -> setInterfaceCurl();
		while( $page < ($this -> depth/ $this -> groups) ){
			$ans = $this->getResponse($page);
			for ($i=0;$i<count($ans);$i++){
	
				if ($this->cmpUrls($this->host, $ans[$i])){
					return ($page*$this->groups)+$i+1;
				}
			}
			$page++;
		}
	
		return false;
	}
	
	/**
	*
	* получить позицю с данными сайта, урлом и т.п.
	*/
	public function getPositionWhithData(){
		$page  = 0;
		$this -> setInterfaceCurl();
		while( $page < ($this -> depth/ $this -> groups) ){
			$ans = $this->getResponse($page);
			for ($i=0;$i<count($ans);$i++){
				if ($this->cmpUrls($this->host, $ans[$i])){
					$this->url = $ans[$i];
					$pos =  ($page*$this->groups)+$i+1;
					return array($pos,$this->url);
				}
			}
			$page++;
		}
		return false;
	}
	
	/**
	*
	* получить определенное колличество сайтов по запросу
	*/
	function getNumSite($num){
		$pages = $num/$this->groups;
		$ans = array();
		$this -> setInterfaceCurl();
		if(!$pages){
			$pages = 1;
		}
		for($i=0;$i<$pages;$i++){
			$nodes 	= $this->getResponse($i);
			$ans = array_merge($ans,$nodes);
		}
		return array_slice($ans,0,$num);
	}
	
}