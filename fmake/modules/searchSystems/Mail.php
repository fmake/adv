<?php
class searchSystems_Mail extends searchSystems{
	
	public $query		= '';
	public $host		= '';
	public $encoding	= 'windows-1251';
	public $groups		= 10;
	public $systemUrl	= 'http://go.mail.ru/search?';
	public $url			= '';
	private $curl		= false;
	public $depth 		= 100;
	public $sleepTime	= 5;
	
	function __construct($query = false, $host  = false){
		$this -> setData($query, $host,$region);
		$this -> initCurl();
	}
	
	function setData($query, $host){
		$this->query = $query;
		$this->host = trim(preg_replace("[^http://|www\.]", '', $host));
		$this->url = '';
		
	}
	
	function initCurl(){
		$this -> curl = new cURL();
		$this -> curl -> init();
	}
	
	function setInterfaceCurl(){
		$ethernetInterface = new ethernetInterface();
		$proxy = $ethernetInterface -> getProxyByGoogle();
		$this -> curl -> set_opt( CURLOPT_PROXY, $proxy['proxy']  );
		$this -> sleepTotime($proxy['last_used'] + $this->sleepTime);
		return $proxy;
	}
	
	function cmpUrls($a, $b){
		return preg_match("/{$a}/i", $b);
	}
	
	function getNodes($response){
		$pattern = "#<cite[\s]*class=\"src\">[\s]*<a[^>]+href\=\"(.+)\">.+</a>[\s]*</cite>#isU";
		preg_match_all($pattern, $response, $links);
		return $links[1];
	}
	
	function getResponse($page){
		$url = $this->systemUrl."mailru=1&drch=l&q="
						.htmlentities(urlencode( iconv("utf-8", $this -> encoding, $this->query) ) )
							."&rch=l&num=".$this->count."&sf=".($page*$this->groups);
		$this -> curl -> get( $url );
		//echo $this -> curl -> data();
		return $this->getNodes( $this -> curl -> data() );
	}
	
	
	
	
}
