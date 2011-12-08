<?php
class searchSystems_Google extends searchSystems{
	public $query		= '';
	public $host		= '';
	public $encoding	= 'utf-8'; 
	public $groups		= 10;
	public $systemUrl	= 'http://www.google.ru/search';
	public $url			= '';
	private $curl		= false;
	public $depth 		= 100;
	public $sleepTime	= 2;
	
	public function __construct($query = false, $host = false){
		$this -> setData($query, $host);
		$this -> initCurl();
	}
	
	function setData($query, $host){
		$this->query = $query;
		$this->host = preg_replace("[^http://|www\.]", '', $host);
		$this->url = '';
	}
	
	function initCurl(){
		$this -> curl = new cURL();
		$this -> curl -> init();
	}
	
	function setInterfaceCurl(){
		$ethernetInterface = new ethernetInterface();
		$proxy = $ethernetInterface -> getProxyByGoogle();
		$this -> curl ->set_opt( CURLOPT_PROXY, $proxy['proxy']  );
		$this -> sleepTotime($proxy['last_used'] + $this->sleepTime);
		return $proxy;
	}
	
	function getNodes($response){
		$tmp= preg_replace("/[\n\r\t]/", '', $response);
		//заменяем быстрые ссылки в поиске на пустой результат
		$pattern2 = "#<h3 class=[^>]*>(?<!</h3>)(.+?)</h3>#is";
		preg_match_all($pattern2, $tmp, $out);
		for($i=0;$i<count($out[0]);$i++){
			$pattern2 = "#<a href=\"(?!google)(http[^\"]+?)\"#i";
			preg_match_all($pattern2,$out[0][$i],$tmp);
			if ( $tmp[1][0] && !preg_match("/^http:\/\/(www\.)?([^\.]+\.)?google.ru[.]*/i", $tmp[1][0])){
				$link[count($link)] = $tmp[1][0];
			}
		}
			return $link;
	}
	
	function getResponse($page){
		$url = $this->systemUrl."?hl=ru&lr=&newwindow=1&q=".urlencode($this->query)."&start="
					.($page*$this->groups)."&sa=N";
		$this -> curl->get($url);
		return $this-> getNodes( $this -> curl ->data());
	}
	

}
