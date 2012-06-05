<?php 

	function getwordStat($word,$startId,$id_js){
		$worstat = new yandex_wordstat();

		$count = $worstat->getWordTotalCount($word);		
		$querys[0]['count'] = $count;
		$querys[0]['query'] = $worstat->getClearWord($word);
		$GLOBALS['startId']  = $startId;
		$GLOBALS['what'] = $what;

		global $globalTemplateParam,$twig;
		$globalTemplateParam -> set('querys',$querys);
		$globalTemplateParam -> set('startId',$startId);
		$globalTemplateParam -> set('what',$what);
		$template = $twig->loadTemplate("manager/core_exactness_inner.tpl");
		$answer = $template->render($globalTemplateParam->get());

		$objResponse =  new xajaxResponse();
		
		$objResponse->append($id_js,"innerHTML",($answer)); 
		//$objResponse->addScript("document.getElementById('progress').style.display = 'none';$('.tablesorter tr').unbind();init();startId=".(10*$startId));
		return $objResponse;
		
	}

	include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
	$xajax = new xajax();
	//$xajax->bDebug = true; 
	$xajax->registerFunction("getwordStat");
	$xajax->configure('javascript URI','/fmake/libs/xajax/');
	$xajax->register(XAJAX_FUNCTION,"getwordStat");
	$xajax->processRequest();
	$globalTemplateParam->set('xajax',$xajax);

	switch ($request->action){
		case 'add_word':
			//include 'word_function.php';
			$ind = 0;
			$arr = explode("\n",$_REQUEST["word"]);
			//printAr($_REQUEST);
			//printAr($arr);
			foreach ($arr as $ar){
				if(!$ar)continue;
				$query[$ind++] = trim($ar);
			}
			$query = array_unique($query);
			
			$worstat = new yandex_wordstat();
			$worstat->region = $request->reg;
			
			for($i=0;$i<sizeof($query);$i++){
				//$count = $worstat->getWordCount($query[$i]);
				$count = $worstat->getWordTotalCount($query[$i]);
				$querys[$i]['query'] = $worstat->getClearWord($query[$i]);
				$querys[$i]['count'] = $count;
			}
			//printAr($querys);
			$globalTemplateParam->set('querys',$querys);
		break;
		case 'add_word_query':
			//include 'word_function.php';
			$query = array_unique($_REQUEST['query']);
			$worstat = new yandex_wordstat();
			$worstat->region = $request->reg;
			$i = 0;
			if($query){
				foreach ($query as $word){
					$word = trim($word);
					//$count = $worstat->getWordCount($word);
					$count = $worstat->getWordTotalCount($word);
					$querys[$i]['query'] = $worstat->getClearWord($word);
					$querys[$i++]['count'] = $count;
				}
			}
			$globalTemplateParam->set('querys',$querys);
		break;
	}
	$searchSystems = new projects_seo_searchSystem();
	$regions =	$searchSystems -> getChilds(1);
 	$globalTemplateParam->set('regions',$regions);
	$modul->template =  "/manager/core_exactness.tpl";

