<?php

//include 'modules/office/word_function.php';

class yandex_wordstat {

	public $region = false;
	public $curProxy = false;
	public $lastProxy = false;
	public $captcha_id = false;
	public $captcha_val = false;

	
function cp1251_to_utf8_recursive( $data)
{
    if (is_array($data))
    {
        $d = array();
        foreach ($data as $k => &$v) $d[$this->cp1251_to_utf8_recursive($k)] = $this->cp1251_to_utf8_recursive($v);
        return $d;
    }
    if (is_string($data))
    {
        if (function_exists('iconv')){ return iconv('cp1251', 'utf-8//IGNORE//TRANSLIT', $data);}
        if (! function_exists('cp1259_to_utf8')) include_once 'cp1259_to_utf8.php';
        return cp1259_to_utf8($data);
    }
    if (is_scalar($data) or is_null($data)) return $data;
    #throw warning, if the $data is resource or object:
    trigger_error('An array, scalar or null type expected, ' . gettype($data) . ' given!', E_USER_WARNING);
    return $data;
}

function Encode ( $str, $type )
{ // $type: 'w' - encodes from UTF to win 'u' - encodes from win to UTF
	static $conv='';
	if (!is_array ( $conv )){
	$conv=array ();
	for ( $x=128; $x <=143; $x++ ){
	$conv['utf'][]=chr(209).chr($x);
	$conv['win'][]=chr($x+112);
	}
	for ( $x=144; $x <=191; $x++ ){
	$conv['utf'][]=chr(208).chr($x);
	$conv['win'][]=chr($x+48);
	}
	$conv['utf'][]=chr(208).chr(129);
	$conv['win'][]=chr(168);
	$conv['utf'][]=chr(209).chr(145);
	$conv['win'][]=chr(184);
	}
	if ( $type=='w' ) return str_replace ( $conv['utf'], $conv['win'], $str );
	elseif ( $type=='u' ) return str_replace ( $conv['win'], $conv['utf'], $str );
	else return $str;
}

/**
 * 
 * Получаем таблицу значение слов
 * @param $query
 * @param $page
 */
function parse_word($query,$page){
	$addToUrl = "";
	if($this->captcha_id)
		$addToUrl = "&captcha_id=".$this->captcha_id;
	if($this->captcha_val)
		$addToUrl .= "&captcha_val=".$this->captcha_val;	
	//echo $addToUrl;
	if($this->region)
		$addToUrl .= "&geo=".$this->region;	
	
	
	$query_esc = str_replace (' ','%20',htmlspecialchars("$query"));
	//$query_esc = urlencode ($this->cp1251_to_utf8_recursive($query));
	$query_esc = urlencode (($query));
	$str2 = convert_cyr_string($query_esc,"w","k");
	$url = 'http://wordstat.yandex.ru/?cmd=words&page='.$page.'&t='.($query_esc).$addToUrl;
	
	//echo $url;
	//$user_agent = 'WordParser 1.0';
	$curl = new cURL();
	$curl->cookie_in_file = true;
	$curl->init();
	
	/*$ipObj = new absIp();
	$ip = $ipObj->getByGoogle();
	$curl->set_opt(CURLOPT_INTERFACE,$ip);
	*/
	
	$proxyObj = new ethernetInterface_Proxy();
	$proxy = $proxyObj->getByGoogle () ;
	
	// если разгадываем капчу с определенного прокси
	/*if($this -> curProxy){
		$curl->set_opt( CURLOPT_PROXY, $this->lastProxy = $this -> curProxy  );
	}else{
		$curl->set_opt( CURLOPT_PROXY, $this->lastProxy = $proxy['proxy']  );
	}
	//echo $proxy['proxy']."<br/>";
	*/
	$curl->get($url);
	//echo $url;
	$URL_OBJ = $curl->data();
	//echo $URL_OBJ;
	if( $URL_OBJ )
	{
		//$match = new ArrayObject();
	  $CONTENT = $URL_OBJ;
	  //$str = $this->Encode ( $CONTENT, "w" )."<br/>";
	  $str =  ( $CONTENT )."<br/>";
	  return $str;
	  //$HEADER_INFO = $URL_OBJ['header'];
	 // $TIME_REQUEST = $URL_OBJ['time'];
	}
	else
	  return false;
}
/**
 * 
 * Парсим слова
 * @param  $ans_site
 * @param  $count
 * @param  $capture
 * @return string|boolean
 */
function get_first_key_word($ans_site,$count,&$capture){
	  //echo $ans_site;
	  $pattern2 = "#<table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">(.+?)</table>#is";
	  //$pattern2 = "#<table  class=\"l-page l-page_layout_12-60-16\" style=\"border-collapse: collapse; width: 100%; \"  cellpadding=\"0\" cellspacing=\"0\"  border=\"0\">(.+?)</table>#is";
	  preg_match_all($pattern2, $ans_site, $out2);
	  //printAr($out2[0][0]);
	  //echo $out2[0][0];
	  $pattern = "#<td>(.+?)</td>#is";  
	  preg_match_all($pattern, $out2[1][0], $out);
	  
	
	  
	  if(!$out[1][0]){
		$patternCap="#<input name=\"captcha_id\"(.+?)<input name=\"captcha_val\"#is";
		
		$patternCap="#<img src=\"(http://i\.captcha\.yandex\.net/image\?key\=([^\"]+))\">#is";
					//<img src="http://i.captcha.yandex.net/image?key=10u6hg7TyTmsybPeQ7mgXhPBvAcfLeqR">
		preg_match_all($patternCap, $ans_site, $form);
		  //echo "qweeeeeeeeeeeeeeeeee";
		  //echo $ans_site;
		  //printAr($form);
		$capture['img'] =  $form[1][0];
		$capture['key'] =  $form[2][0];
		$capture['proxy'] = $this->lastProxy;
		//printAr($capture); 
		return null;
	  }
		//printAr($out[1]);
	  for($i=0,$j=1;$i<count($out[1]) && $i<$count;$i++,$j+=2){
		preg_match_all("#>(.+?)</a>#is", $out[1][$j], $tmp_ans);
		//printAr($tmp_ans);
	  	$out[1][$i] = $tmp_ans[1][0];
	  }
	
	  for($i=0;$i<count($out[1]) && $i<$count;$i++){
	  	$ans[$i]['query_first'] = trim($out[1][$i]);
	  }
	  unset($out);
	  preg_match_all($pattern, $out2[1][1], $out);


	  for($i=0,$j=1;$i<count($out[1]) && $i<$count;$i++,$j+=2){
		preg_match_all("#>(.+?)</a>#is", $out[1][$j], $tmp_ans);
		//printAr($tmp_ans);
	  	$out[1][$i] = $tmp_ans[1][0];
	  }

	  for($i=0;$i<count($out[1]) && $i<$count;$i++){
	  	$ans[$i]['query_second'] = trim($out[1][$i]);
	  }
	  
	  unset($out);

	  $pattern = "#<td class=\"align-right-td\">([0-9]+?)</td>#is";
	  preg_match_all($pattern, $out2[1][0], $out);
	  unset($out[0]);
	  for($i=0;$i<count($out[1]) && $i<($count);$i++){
	  	$ans[$i]['count_first'] = $out[1][$i];
	  }
	  preg_match_all($pattern, $out2[1][1], $out);
	  unset($out[0]);
	  for($i=0;$i<count($out[1]) && $i<($count);$i++){
	  	$ans[$i]['count_second'] = $out[1][$i];
	  }
	 // printAr($ans);
	return $ans;
}

/**
 * 
 * Получить слова по запросу
 * @param unknown_type $query
 * @param unknown_type $count_word
 */
function Words($query,$count_word){
	$size = count($query);
	
	for($i=0;$i<$size;$i++){
		if($count_word <= 50){
			$data_word = $this->parse_word($query[$i],$page = 1);
			$capture = "";
			//echo $data_word."qqqq";
			$report[$i] = $this->get_first_key_word($data_word,$count_word,$capture);
			//echo $capture;
			$report[$i]['query'] = $query[$i];
			$report[$i]['capture'] = $capture; 
		}else{
			$page = 1;
			$report[$i] = array();
			$tmp_count_word = $count_word;
			while($tmp_count_word/50 > 0){
				$data_word = $this->parse_word($query[$i],$page);
				$capture = "";
				//printAr($nextQuery);
				$report[$i] = array_merge($report[$i],$nextQuery = $this->get_first_key_word($data_word,50,$capture));
				//printAr($report[$i]);
				$tmp_count_word -= 50;
				$page++;
			}
			$report[$i]['query'] = $query[$i];
		}
		
	}
	return $report;
}

function getRegular($word){
	$prev = "([\+](((на)|(в)|(при)|(у)|(об)|(о)|(с)|(к)|(во))[\s])?)?";
	$words = split("[ ]",$word);
	if(count($words)==1)return "/^{$words[0]}$/";
	$reg = "/^{$words[0]}[\s]";
	for($i=1;$i<count($words);$i++){
		$reg .= $prev.$words[$i];
		if($i != count($words) - 1)
			$reg .= "[\s]";	
	}
	$reg .= "$/i";	
	return $reg;
}

function getClearWord($word){
	$search = array ("'\+'si",  
               
  );                    

$replace = array ("",

);

return $text = preg_replace ($search, $replace, $word);
}

function getWordCount($word){
	$query[0] = $word;
	$report = $this->Words($query,50);
	$report = $report[0]; 
	$regular = $this->getRegular($word);
	for($i=0;$i<count($report);$i++){
		if(preg_match($regular,$report[$i]['query_first'])){
			return $report[$i]['count_first'];
		}
		if(preg_match($regular,$report[$i]['query_second'])){
			return $report[$i]['query_second'];
		}
	}
	return 0;
}

function getWordTotalCount($word){
	$query[0] = $word;
	$word = '"'.$word.'"';
	$report = $this->parse_word($word,0);
	$pattern = "#&nbsp;([0-9]+)&nbsp;#isU";
	preg_match_all($pattern, $report, $out);
	$iter = 10;
	while(!$out[1][0] && $iter > 0){
		$report = $this->parse_word($word,0);
		preg_match_all($pattern, $report, $out);
		$iter--;
	}
	
	return $out[1][0];
}
	
	

		
	
}
