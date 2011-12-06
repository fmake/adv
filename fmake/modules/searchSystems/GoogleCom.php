<?php
class searchSystems_GoogleCom extends searchSystems{
	
	public $query		= '';
	public $host		= '';
	public $encoding	= 'utf-8'; //'utf-8';
	public $groups		= 10;
	public $google		= 'http://www.google.com/search';
	public $googleEng	= 'http://www.google.com/ncr';
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
	
	function cmpUrls($a, $b){
		return preg_match("/{$a}/i", $b);
	}

	function getNodes($response){
		$tmp = preg_replace("/[\n\r\t]/", '', $response);
		//заменяем быстрые ссылки в поиске на пустой результат
		$pattern2 = "#<div class=osl>(.+?)</div>#is";
		preg_match_all($pattern2, $tmp, $out);
		for($i=0;$i<count($out[0]);$i++){
			$tmp = str_replace($out[0][$i],"",$tmp);
		}
		
		$pattern = "#<div class=\"s\">(.+?)</div>#is";
		preg_match_all($pattern, $tmp, $out1);
		for($i=0,$j=0;$i<count($out1[1]);$i++){
			$tmp = "";
			$pattern = "#<cite>(.+?)</cite>#is";
			preg_match_all($pattern, $out1[1][$i],$tmp);
			if($tmp[1]){
				$ans[$j] = str_replace("<b>","",$tmp[1][0]);
				$ans[$j] = str_replace("</b>","",$ans[$j]);
				$ans[$j] = str_replace(" - ","",$ans[$j]);
				$ans[$j] = preg_replace("[^http://|www\.]", '',$ans[$j]);
				$j++;
			}
		}
		return $ans;
	}
	
	function getResponse($page){
		$url = $this->google."?hl=en&q=".urlencode($this->query)."&start="
					.($page*$this->count)."&sa=N";
		$this -> curl->get($url);
		return $this-> getNodes( $this -> curl ->data());
	}
	

}
