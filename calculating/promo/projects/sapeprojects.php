<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
$projects = new projects();
$projectSeoUrl = new projects_seo_url();
$projectQuery = new projects_seo_query();
$projectQueryPosition = new projects_seo_position();
$projectSeoUrlParams = new projects_seo_urlParams();
$projectSeoUrlParamsValue = new projects_seo_urlParamsValue();
$projectSeoQueryParams = new projects_seo_queryParams();
$projectSeoQueryParamsValue = new projects_seo_queryParamsValue();
$projectsUpdate = new projects_update();
$action_url = "/".$request->parents."/prmprojects";

///////////////////////////////////////////////////////////////////////////////////

$users = new fmakeSiteModule_users();
$optimiziers = $users->getByRole(ID_OPTIMISATOR, true);

$projects_accessRole = new projects_accessRole();
$roles = $projects_accessRole->getProjectRols($id_project);
//printAr($roles);
//printAr($optimiziers);
foreach($optimiziers as $key => $value){
	if($roles[4]['id_user'] == $value['id_user'])
		$optimizator = $optimiziers[$key];
}

$optimizer = intval($request -> id_user);
foreach($optimiziers as $value){
	if($value['id_user'] == $optimizer){
		$optimizator = $value;
	}
}

$filtr['id_user'] = $optimizator['id_user'];
$filtr['date'] = $request->getFilter('date');
$filtr['id_role'] = ID_OPTIMISATOR;
$filtr['active'] = 1;

$current_projects = ( $projects->getProjectsWithSeoParamsWithAccessUser("DISTINCT " . $projects->table . ".id_project,url,sape_money,max_seo_user_pay,pay_percent,important", $filtr) );
//printAr($current_projects);
$today = strtotime("today");
$yesterday = strtotime("-1 day",$today);

switch($request -> action){
	case "change_optimizer":
		$check = false;
		foreach($current_projects as $cur_proj){
			if($cur_proj['id_project'] == $id_project){
				$check = true;
			}
		}
		if(!$check){
			$id_project = $current_projects[0]['id_project'];
			$project = new projects($id_project);
		}
		break;
		
	case "add_project_to_sape": echo 111;
		break;
}

$projectSeo = $project -> getProjectWithSeoParams();

$urlParams = $projectSeoUrlParams->getAll();
$globalTemplateParam->set('urlParams',$urlParams);

$updateCount = 8;
$viewCount = 8;
$nonUpdateCount = 2;
$globalTemplateParam->set('updateCount',$updateCount);
$globalTemplateParam->set('viewCount',$viewCount);
$globalTemplateParam->set('nonUpdateCount',$nonUpdateCount);


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

$globalTemplateParam->set('action_url',$action_url);
$globalTemplateParam->set('optimizator',$optimizator);
$globalTemplateParam->set('optimiziers',$optimiziers);
$globalTemplateParam->set('current_projects',$current_projects);
$globalTemplateParam->set('projectSeo',$projectSeo);
$globalTemplateParam->set('projectUrls',$projectUrls);
$modul->template = "promo/projects/sapeprojects.tpl";
?>
