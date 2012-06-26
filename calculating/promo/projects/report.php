<?php
$id_project = intval($request -> id_project);
$project = new projects($id_project);
$project_info = $project->getInfo();
$current_url = $project_info['url'];

$sites_api = new yandex_webmaster;
$sites_api_info = $sites_api -> getSiteInfo();

for($i = 0, $cnt = count($sites_api_info['host']); $i < $cnt; $i++){
	//echo $sites_api_info['host'][$i]['name'].'<br>';
	if(preg_match("/^(www\.)?".$current_url."/Ui", $sites_api_info['host'][$i]['name'])){
		//echo $sites_api_info['host'][$i]['name'];
		printAr($sites_api->getExternalLinks($sites_api_info['host'][$i]['@attributes']['href']));
	}
}



$users = new fmakeSiteModule_users();
$optimiziers = $users->getByRole(ID_OPTIMISATOR, true);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$modul->template = "promo/projects/report.tpl";
?>
