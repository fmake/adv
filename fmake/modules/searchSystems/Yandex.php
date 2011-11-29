<?php
class searchSystems_Yandex extends searchSystems{
	
	public $query		= '';
	public $host		= '';
	public $encoding	= 'utf-8';
	public $groups		= 100;
	public $systemUrl	= 'http://xmlsearch.yandex.ru/xmlsearch?';
	public $xpath		= '/yandexsearch/response/results/grouping/group/doc/url';
	public $region		= false;
	public $url			= '';
	private $curl		= false;
	public $depth 		= 100;
	
	function __construct($query = false, $host  = false,$region = false){
		$this -> setData($query, $host,$region);
		$this -> initCurl();
	}
	
	function setData($query, $host,$region = false){
		$this->query = $query;
		$this->host = trim(preg_replace("[^http://|www\.]", '', $host));
		$this->region = $region;
		$this->url = '';
		
	}
	
	function initCurl(){
		$this -> curl = new cURL();
		$this -> curl -> init();
	}
	
	function setInterfaceCurl(){
		$ethernetInterfaceObj = new ethernetInterface();
		$proxy = $ethernetInterfaceObj -> getProxyByYandex(true);
		$this -> curl -> set_opt(CURLOPT_HTTPHEADER,Array("Content-Type: application/xml"));
		$this -> curl -> set_opt(CURLOPT_HTTPHEADER,Array("Accept: application/xml"));
		$this -> curl ->set_opt( CURLOPT_PROXY, $proxy['proxy']  );
		return $proxy;
	}
	
	function getNodes($response){
		try {
			$xmldoc = new SimpleXMLElement($response,LIBXML_NOERROR);
			return $xmldoc->xpath($this->xpath);
		} catch (Exception $e) {
			return array();
		}
	}
	
	function getResponse($page){
		$proxy = $this -> setInterfaceCurl();
		$get = $this -> systemUrl;
		if($proxy['key']){
			$get .= "".($proxy['key']);
		}
		if($this->region){
			$get .= "&lr=".$this->region;
		}
		$get .= "&query=".urlencode(trim($this->query));
		$get .= "&p=".$page;
		$get .= "&groupby=attr%3Dd.mode%3Ddeep.groups-on-page%3D{$this->groups}.docs-in-group%3D1.curcateg%3D-1";
		//$get .= "&groupby=attr%3Dd.mode%3Ddeep.groups-on-page%3D{$this->groups}.docs-in-group%3D1";
		$this -> curl -> get( $get );
		return $this->getNodes( $this -> curl -> data() );
	}
	
	/**
	*
	* позиция сайта
	*/
	public function getPosition(){
		$page  = 0;
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
		while( $page < ($this -> depth/ $this -> groups) ){
			$ans = $this->getResponse($page);
			for ($i=0;$i<count($ans);$i++){
				if ($this->cmpUrls($this->host, $ans[$i])){
					$this->url = $ans[$i];
					$pos =  ($page*$this->groups)+$i+1;
					return array('pos' => $pos,'url' => $this->url);
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
