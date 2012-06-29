<?php
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
$project_info = $project->getInfo();
$current_url = $project_info['url'];
$id_report = intval($request -> id_report);

$sites_api = new yandex_webmaster;
$sites_api_info = $sites_api -> getSiteInfo();
/*
for($i = 0, $cnt = count($sites_api_info['host']); $i < $cnt; $i++){
	if(preg_match("/^(www\.)?".$current_url."/Ui", $sites_api_info['host'][$i]['name'])){
		printAr($sites_api->getExternalLinks($sites_api_info['host'][$i]['@attributes']['href']));
	}
}
*/

$projects = new projects($id_project);
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

$report = new projects_seo_report();
$current_report = $report->getForeignReport($id_project, REPORT_DONE);
$reports = $report->getReport($id_project, REPORT_DONE);

//printAr($reports);

if(count($reports)){
	$globalTemplateParam->set('reports', $reports);
}

if(count($current_report)){
	$globalTemplateParam->set('current_report', $current_report);
}

switch($request -> action){
	case "make_order": 
		$sapeProject -> addSapeProject(intval($request -> id_project));
		break;
	
	default:
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
}

if($id_report){
	$report->setId($id_report);
	//$current_report = $report->getInfo();
	$tyc = $report->getCyData($id_report);
	$pr = $report->getPrData($id_report);
	//unset($pr[0]);
	//printAr($tyc);
	$globalTemplateParam->set('tyc',$tyc);
	$globalTemplateParam->set('pr',$pr);
	//printAr($pr);
}

$globalTemplateParam->set('optimizator',$optimizator);
$globalTemplateParam->set('optimiziers',$optimiziers);
$globalTemplateParam->set('current_projects',$current_projects);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$modul->template = "promo/projects/report.tpl";
?>
