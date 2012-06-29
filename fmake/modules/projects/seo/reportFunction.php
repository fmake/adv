<?php

/**
 * 
 * функции для получения данных необходимых при составлении отчета
*/ 
class projects_seo_reportFunction{
	public $whois = false;
	
	function getWhois($host){
		$curl = new cURL();
		$curl->init();
		$curl->post("http://www.whois-service.ru/","real=true2.1simpleJ&domain=".$host);
		return $this->whois = $curl->data();
	}
	
	function getDateCreated($host){
		//if(!$this->whois)
		$this->getWhois($host);
		$patern = "/Creation Date:[\s]*(\d{4}.\d{1,2}.\d{1,2})|created:[\s]*(\d{4}.\d{1,2}.\d{1,2})/";
		preg_match_all($patern, $this->whois, $out);
		//printAr($out);
		$dateCreate = $out[1][0] ? $out[1][0] : $out[2][0];
		return $dateCreate;
	}
	
	function pageIndexYandex($host){
		$curl = new cURL();
		$curl->init();
		$url = "http://yandex.ru/yandsearch?p=0&lr=213&text=host%3Awww.";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$curl->get($url.$host);
		$page = $curl->data();
		/*<strong class="l">
			Нашлось<br>13&nbsp;ответов
			</strong>
		*/
		//echo $page;
		$patern = "#<strong class=\"b-head-logo__text\">.*<br>([0-9]+)[^0-9]*</strong>#isU";
		preg_match_all($patern, $page, $out);
		//printAr($out);
		return $out[1][0];
	}
	
	function inYaca($host){
		$curl = new cURL();
		$curl->init();
		$url = "http://search.yaca.yandex.ru/yca/cy/ch/";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$curl->get($url.$host);
		$page = $curl->data();
		//<p class="errmsg">
		$patern = "#<p class=\"errmsg\">#i";
		if(preg_match ($patern, $page)){
			return false;
		}
		
		$patern = "#http://img.yandex.net/i/arr-hilite.gif#i";
		if(preg_match ($patern, $page)){
			return true;
		}
		return false;
	}
	
	function inDmoz($host){
		//=bdbd.ru
		$curl = new cURL();
		$curl->init();
		$url = "http://search.dmoz.org/search/search?q=";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$curl->get($url.$host);
		$page = $curl->data();
		//echo $page;
		//<strong>Open Directory Sites</strong>
		$patern = "#<strong>Open Directory Sites</strong>#i";
		if(preg_match ($patern, $page)){
			return true;
		}
		
		return false;
	}
	
	function inMail($host){
		//=bdbd.ru
		$curl = new cURL();
		$curl->init();
		$url = "http://search.list.mail.ru/?q=";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$host = preg_replace("[/$]", '', $host);
		//echo $host;
		//exit;
		$curl->get($url.$host);
		$page = $curl->data();
		//echo $page;
		//<a target="_blank" href="http://www.promo-venta.ru">
		//<cite>http://www.promo-venta.ru</cite>
		$patern = "#<cite>http://(www.)?{$host}</cite>#i";
		if(preg_match ($patern, $page)){
			return true;
		}
		
		return false;
	}
	// <div class="links"><a href="http://www.promo-venta.ru/"
	
	function inRambler($host){
		//=bdbd.ru
		$curl = new cURL();
		$curl->init();
		$url = "http://top100.rambler.ru/?query=";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$host = preg_replace("[/$]", '', $host);
		//echo $host;
		//exit;
		$curl->get($url.$host);
		$page = $curl->data();
		//echo $page;
		//<a target="_blank" href="http://www.promo-venta.ru">
		$patern = "#<div class=\"links\"><a href=\"#i";
		if(preg_match ($patern, $page)){
			return true;
		}
		
		return false;
	}
	
	function yahooLinks($host){
		//http://siteexplorer.search.yahoo.com/search;_ylt=A0oG7zRkD7tMLyMASE7al8kF?p=http%3A%2F%2Fwww.mr-master.ru&y=Explore+URL&fr=sfp
		$curl = new cURL();
		$curl->init();
		$host = preg_replace("[^http://|www\.]", '', $host);
		$url = "http://siteexplorer.search.yahoo.com/search?p=http%3A%2F%2Fwww.{$host}&bwm=i&bwmo=d&bwmf=s";
		$curl->get($url.$host);
		$page =  $curl->data();
		//Inlinks (284)
		//echo $page;
		$patern = "#Inlinks \(([0-9\,]+)\)#isU";
		preg_match_all($patern, $page, $out);
		//printAr($out);
		return $out[1][0];
	}
	
	function tic($host){
		$curl = new cURL();
		$curl->init();
		$url = "http://search.yaca.yandex.ru/yca/cy/ch/";
		$host = preg_replace("[^http://|www\.]", '', $host);
		$curl->get($url.$host);
		$page = $curl->data();
		//<p class="errmsg">
		//$page = $curl->data();
		//echo $page;
		//$patern = "#<p class=\"errmsg\">.*&mdash;[\s]+([0-9]+)</b></p>#iU";
		$patern = '#<p class="errmsg">(.*)</p>#i';
		$patern = "#<p class=\"errmsg\">.*—[\s]+([0-9]+)[^0-9]*</p>#isU";
		preg_match_all($patern, $page, $out);
		//printAr($out[1]);
		if($out[1][0])
			return $out[1][0];
		$patern = "#<tr>.*http://img.yandex.net/i/arr-hilite.gif.*([\d]+)[^0-9]*</tr>#isU";//
		preg_match_all($patern, $page, $out);
		//printAr($out[1]);
		if($out[1][0])
			return $out[1][0];
		
		return 0;
	}
	
	function pr($host){
		$host = preg_replace("[^http://|www\.]", '', $host);
		$host = "http://".$host;
		return $this->GetPageRank($host);
	}
	
function GetPageRank($q,$host='toolbarqueries.google.com',$context=NULL) {
	$seed = "Mining PageRank is AGAINST GOOGLE'S TERMS OF SERVICE. Yes, I'm talking to you, scammer.";
	$result = 0x01020345;
	$len = strlen($q);
	for ($i=0; $i<$len; $i++) {
		$result ^= ord($seed{$i%strlen($seed)}) ^ ord($q{$i});
		$result = (($result >> 23) & 0x1ff) | $result << 9;
	}
	if (PHP_INT_MAX != 2147483647) { $result = -(~($result & 0xFFFFFFFF) + 1); }
	$ch=sprintf('8%x', $result);
	$url='http://%s/tbr?client=navclient-auto&ch=%s&features=Rank&q=info:%s';
	$url=sprintf($url,$host,$ch,$q);
	@$pr=file_get_contents($url,false,$context);
	return $pr?substr(strrchr($pr, ':'), 1):false;
}
	
	function getCountWord($url){
		$curl = new cURL();
		$curl->init();
		$curl->get($url);
		$data = $curl->data();
		$search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript
                 "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги
                 "'([\r\n])[\s]+'",                 // Вырезает пробельные символы
                 "'&(quot|#34);'i",                 // Заменяет HTML-сущности
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // интерпретировать как php-код
		$replace = array ("",
		                  "",
		                  "\\1",
		                  "\"",
		                  "&",
		                  "<",
		                  ">",
		                  " ",
		                  chr(161),
		                  chr(162),
		                  chr(163),
		                  chr(169),
		                  "chr(\\1)");
		
		$text = preg_replace($search, $replace, $data);
		
		return strlen($text);
	}
}




