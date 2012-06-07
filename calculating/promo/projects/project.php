<?php

function setParamUrl($id_param,$id_url,$value,$callback){
	global $user;
	if(!$user -> id){
		return;
	}
	$id_param = intval( $id_param);
	$id_url = intval( $id_url);
	$projectSeoUrlParamsValue = new projects_seo_urlParamsValue();

	$projectSeoUrlParamsValue -> addParam('id_projects_seo_url_param', $id_param);
	$projectSeoUrlParamsValue -> addParam('id_project_url', $id_url);
	if($value){
		$projectSeoUrlParamsValue -> addParam('value', $value);
	}else{
		$projectSeoUrlParamsValue -> addParam('value', "0");
	}
	$projectSeoUrlParamsValue -> addParam('date', $date = time());
	$projectSeoUrlParamsValue -> newItem();
	$date = date("d.m",$date);
	sleep(1);
	$objResponse = new xajaxResponse();
	if($callback)
		$objResponse->script("endSetValue($id_param,$id_url,'$date','$value')");
	
	return $objResponse;
}

function setName($id_param,$name){
	global $user;
	if(!$user -> id){
		return;
	}
	$id_param = intval( $id_param);

	$projectSeoUrl = new projects_seo_url();
                $projectSeoUrl->setId($id_param);
	$projectSeoUrl -> addParam('name', $name);
                $projectSeoUrl->update();

	$objResponse = new xajaxResponse();
	
	return $objResponse;
}

function setParamQuery($id_param,$id_query,$value,$callback){
	global $user;
	if(!$user -> id){
		return;
	}
	$id_param = intval( $id_param);
	$id_query = intval( $id_query);
	$projectSeoQueryParamsValue = new projects_seo_queryParamsValue();

	$projectSeoQueryParamsValue -> addParam('id_projects_seo_query_param', $id_param);
	$projectSeoQueryParamsValue -> addParam('id_seo_query', $id_query);
	if($value){
		$projectSeoQueryParamsValue -> addParam('value', $value);
	}else{
		$projectSeoQueryParamsValue -> addParam('value', "0");
	}
	$projectSeoQueryParamsValue -> addParam('date', $date = time());
	$projectSeoQueryParamsValue -> newItem();
	$date = date("d.m",$date);
	sleep(1);
	$objResponse = new xajaxResponse();
	if($callback)
		$objResponse->script("endSetQueryValue($id_param,$id_query,'$date','$value')");
	
	return $objResponse;
}

//$action_url = "/".$request->parents."/".$request->modul;	
include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
$xajax = new xajax($action_url);
$xajax->configure('javascript URI','/fmake/libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"setParamUrl");
$xajax->register(XAJAX_FUNCTION,"setParamQuery");
$xajax->register(XAJAX_FUNCTION,"setName");
$xajax->processRequest();
$globalTemplateParam->set('xajax',$xajax);



$id_project = intval($request -> id_project);
$project = new projects($id_project);
$projectSeoUrl = new projects_seo_url();
$projectQuery = new projects_seo_query();
$projectQueryPosition = new projects_seo_position();
$projectSeoUrlParams = new projects_seo_urlParams();
$projectSeoUrlParamsValue = new projects_seo_urlParamsValue();
$projectSeoQueryParams = new projects_seo_queryParams();
$projectSeoQueryParamsValue = new projects_seo_queryParamsValue();
$projectsUpdate = new projects_update();
$action_url = "/".$request->parents."/".$request->modul;
$globalTemplateParam->set('action_url',$action_url);

$today = strtotime("today");
$yesterday = strtotime("-1 day",$today);
//echo $yesterday;

$projectSeo = $project -> getProjectWithSeoParams();
//printAr($projectSeo);
//printAr( $projectSeoUrlParamsValue->getValue(754) );


switch ($request -> action_group){
	case 2:
		if(!preg_match("/^http:\/\/(www\.)?{$projectSeo['url']}/i", $request -> group_param[url])){
			break;
		}
		$projectSeoUrl -> addParam("id_project", $id_project);
		$projectSeoUrl -> addParam("url", $request -> group_param[url]);
                                $projectSeoUrl -> addParam("name", $request -> group_param[name]);
		$projectSeoUrl -> newItem();
		$request -> group_param[url] = $projectSeoUrl -> id;
		$_REQUEST['group_param']['url'] = $projectSeoUrl -> id;
	case 1:
		$id_url = intval( $request -> group_param[url] );
		$querys = ( $request -> group_param[querys] );
		if(!$id_url || !$querys){
			break;
		}
		$projectSeoUrl -> setId($id_url);
		$url = ( $projectSeoUrl -> getInfo() );
		if( $url['id_project'] !=  $id_project){
			break;
		}
		$index = sizeof($querys);
		for ($i = 0; $i < $index; $i++) {
			$projectQuery -> setId( $querys[$i] );
			$query = ($projectQuery -> getInfo());
			if($query['id_project'] == $id_project){
				$projectQuery -> addParam("id_project_url", $id_url);
				$projectQuery -> update();
			}
		}
		
		break;
}


// удаляем урл
if($request -> action == "deleteurl"){
	$id_url = intval( $request -> id_url );
	$projectSeoUrl -> setId($id_url);
	$url = ( $projectSeoUrl -> getInfo() );
	if( $url['id_project'] !=  $id_project){
		break;
	}
	$tmpQuery = ( $projectQuery -> getQueryByUrl($id_project, $id_url,true) );
	$index = sizeof($tmpQuery);
	for ($i = 0; $i < $index; $i++) {
		$projectQuery -> setId( $tmpQuery[$i][$projectQuery ->idField ] );
		$projectQuery -> addParam("id_project_url",0);
		$projectQuery -> update();;
	}

	$projectSeoUrl -> delete();

}


$urlParams = $projectSeoUrlParams->getAll();
$globalTemplateParam->set('urlParams',$urlParams);



$updateCount = 7;
$viewCount = 4;
$nonUpdateCount = 2;
$globalTemplateParam->set('updateCount',$updateCount);
$globalTemplateParam->set('viewCount',$viewCount);
$globalTemplateParam->set('nonUpdateCount',$nonUpdateCount);



//$updateDate = array('1324929600','1324843200','1324584000','1324497600','1323720000','1323633600','1323374400');
$updateDate = ( $projectsUpdate -> getByLimit(5, $updateCount) );
$updateDate = array_reverse($updateDate);
if($updateDate[sizeof($updateDate) - 1]['date'] != $today){
	$updateDate[] = array('date' => $today,'update' => $projectsUpdate->getUpdate() );
}
// если позавчера был 
if($updateDate[sizeof($updateDate) - 2]['date'] == $yesterday){
	$yesterdayCheck = true;
	$globalTemplateParam->set('yesterdayCheck',$yesterdayCheck);	
}

$updateDate[] = array('date' => $yesterday,'update' => 0 );

$globalTemplateParam->set('updateDate',$updateDate);



$projectUrls = ( $projectSeoUrl->getUrlProject($id_project) );
$index = sizeof($projectUrls);
for ($i = 0; $i < $index; $i++) {
	$projectUrls[$i]['query'] = ( $projectQuery -> getQueryByUrl($id_project, $projectUrls[$i][$projectSeoUrl->idField],true) );
	$index2 = sizeof($projectUrls[$i]['query']);
	for ($j = 0; $j < $index2; $j++) {
		$projectUrls[$i]['query'][$j]['position'] = $projectQueryPosition -> getPositionsByQueryInDate($projectUrls[$i]['query'][$j][$projectQuery->idField], $updateDate);
		$projectUrls[$i]['query'][$j]['params'] = $projectSeoQueryParamsValue->getValue($projectUrls[$i]['query'][$j][$projectQuery->idField]);
		//printAr($projectUrls[$i]['query'][$j]['position']);
	}
	
	$projectUrls[$i]['params'] = ( $projectSeoUrlParamsValue->getValue($projectUrls[$i][$projectSeoUrl->idField]) );
}
$projectUrls[$index]['query'] = $projectQuery -> getQueryByUrl($id_project, 0,true);
if(!$projectUrls[$index]['query'])
	unset($projectUrls[$index]);
else{
	$projectUrls[$index]['name'] = "Без страницы";
	$projectUrls[$index][$projectSeoUrl->idField] = -1;
	$index2 = sizeof($projectUrls[$index]['query']);
	for ($j = 0; $j < $index2; $j++) {
		$projectUrls[$index]['query'][$j]['position'] = $projectQueryPosition -> getPositionsByQueryInDate($projectUrls[$index]['query'][$j][$projectQuery->idField], $updateDate);	
	}
}



//printAr($projectUrls);
$globalTemplateParam->set('projectUrls',$projectUrls);
$globalTemplateParam->set('projectSeo',$projectSeo);
$modul->template = "promo/projects/project.tpl";
