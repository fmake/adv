<?php 
	function getwordStat($word,$startId,$id_js,$count,$what){
		$worstat = new yandex_wordstat();

		
		$query = array($word);
		$report = $worstat->Words($query,$count_word = $count);
		$GLOBALS['count_word'] = $count_word;
		$GLOBALS['startId']  = $startId;
		$GLOBALS['what'] = $what;
		//printAr($GLOBALS['report']);
		$modul->template = "manager/core_inner.tpl";

		/*ob_start();
		$tpl = new utlTemplate();
		$tpl->display_file($modul->template);
		$answer = ob_get_contents();	
		ob_end_clean();
*/
		global $globalTemplateParam,$twig;
		$globalTemplateParam -> set('query',$query);
		$globalTemplateParam -> set('report',$report);
		$globalTemplateParam -> set('count_word',$count_word);
		$globalTemplateParam -> set('startId',$startId);
		$globalTemplateParam -> set('what',$what);
		$template = $twig->loadTemplate("manager/core_inner.tpl");
		$answer = $template->render($globalTemplateParam->get());

		//echo $answer;
		//include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
		$objResponse =  new xajaxResponse();
		
		$objResponse->append($id_js,"innerHTML",($answer)); 
		$objResponse->script("$('.tablesorter tr').unbind();init();startId=".(10*$startId));
		return $objResponse;
		
	}
	
	
	function getwordStatCapture($key,$value,$proxy,$word,$startId,$count,$what){
		$worstat = new yandex_wordstat();
		
		$worstat -> curProxy = $proxy;
		$worstat -> captcha_id = $key;
		$worstat -> captcha_val = $value;
		
		
		
		$GLOBALS['query'] = array($word);
		$GLOBALS['report'] = $worstat->Words($GLOBALS['query'],$count_word = $count);
		$GLOBALS['count_word'] = $count_word;
		$GLOBALS['startId']  = $startId;
		$GLOBALS['what'] = $what;
		//printAr($GLOBALS['report']);
		$modul->template = "office/yandex/yandex_word_inner";

		ob_start();
		$tpl = new utlTemplate();
		$tpl->display_file($modul->template);
		$answer = ob_get_contents();	
		ob_end_clean();
		//echo $sitesInfo;
		$objResponse =  new xajaxResponse('utf-8');
		//$objResponse->addScript("document.getElementById('{$key}').innerHTML = '';");
		$objResponse->addAssign($key,"innerHTML",($answer)); 
		$objResponse->addScript("document.getElementById('progress').style.display = 'none';$('.tablesorter tr').unbind();init();startId=".(10*$startId));
		return $objResponse->getXml();
		
	}
	
	include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
	$xajax = new xajax($action_url);
	$xajax->configure('javascript URI','/fmake/libs/xajax/');
	$xajax->register(XAJAX_FUNCTION,"getwordStat");
	$xajax->register(XAJAX_FUNCTION,"getwordStatCapture");
	$xajax->processRequest();	
	$globalTemplateParam->set('xajax',$xajax);
	

	switch ($request->action){
		case 'add_word':
			//include 'word_function.php';
			$ind = 0;
			$arr = explode("\n",$_REQUEST["word"]);
			//printAr($arr);
			foreach ($arr as $ar){
				if(!$ar)continue;
				$query[$ind++] = trim($ar);
			}
			//printAr($query);
			$count_word = $request->size;
			//$report[0] = "qq";
			$worstat = new yandex_wordstat();
			$report = $worstat->Words($query,$count_word);
			$what = $request->what;
			//include 'parse_yandex_word.php';	
			//printAr($report);
			$globalTemplateParam->set('report',$report);
			$globalTemplateParam->set('count_word',$count_word);
			$globalTemplateParam->set('what',$what);
		break;
	}

 $modul->template = "/manager/core.tpl";
