<?php
function importantProject($id_project,$important){
	$projects = new projects_seo_seoParams($id_project);
	if($important){
		$projects -> addParam('important', 1);
	}else{
		$projects -> addParam('important', 0);
	}
	$projects -> update();
	$objResponse = new xajaxResponse();
		//$objResponse->script("$('#{$id_preloader}').hide()");
	return $objResponse;
}

$userObj = $modul -> getUserObj();
$sape = new sape_money();
$projects = new projects();
$projectsPos = new projects_seo_position();
$projectUserMoney = new projects_seo_moneyUsers();
include_once ROOT.'/fmake/libs/xajax/xajax_core/xajax.inc.php';
$xajax = new xajax($action_url);
$xajax->configure('javascript URI','/fmake/libs/xajax/');
$xajax->register(XAJAX_FUNCTION,"importantProject");
$xajax->processRequest();	
$globalTemplateParam->set('xajax',$xajax);
$monthDay = 30;
$filtr['date'] =  $request -> getFilter('date');
$filtr['id_role'] = ID_OPTIMISATOR;
$filtr['active'] = 1;

if($request -> getFilter('status') == 'important'){
	$filtr['important'] = 1;
}else if($request -> getFilter('status') == 'newproject'){
	// 3 месяца назад
	$l3firstdaymonth = strtotime('-2 month', strtotime(date('m/01/y')));
	$filtr['newproject'] = $l3firstdaymonth;
}else if($request -> getFilter('status') == 'archive'){
	$filtr['active'] = 0;
}

if($request -> getFilter('id_user')){
	$filtr['id_user'] = $request -> getFilter('id_user');
}

if($user->role != ID_ADMINISTRATOR){
	$request -> setFilter("id_user", $user->id);
	$filtr['id_user'] = $user->id;
}else if($request -> getFilter('id_user')){
	$filtr['id_user'] = $request -> getFilter('id_user');
}

$userProjects = ( $projects -> getProjectsWithSeoParamsWithAccessUser("DISTINCT ".$projects ->table.".id_project,url,sape_money,max_seo_user_pay,pay_percent,important",$filtr)  );
//printAr($userProjects);
$index = sizeof($userProjects);
$today = strtotime("today");
$yesterday = strtotime("-1 day",$today);
$firstmonthday = strtotime(date('m/01/y'));
// осталось дней в месяце
$days = ceil( ( strtotime('+1 month', strtotime(date('m/01/y'))) - $today) / (60*60*24) - 1 );

$lfirstdaymonth = strtotime('-1 month', strtotime(date('m/01/y')));
$lenddaymonth =  strtotime('-1 day', strtotime(date('m/01/y')));

$monthPayToday = round($projectUserMoney -> getProjectUserDateMoney(false, $request -> getFilter('id_user'), ID_OPTIMISATOR, $firstmonthday, $today));

$todayPay = round($projectUserMoney -> getProjectUserDateMoney(false, $request -> getFilter('id_user'), ID_OPTIMISATOR, $today, $today));
$monthPay = $monthPayToday + ($todayPay * $days); 
$yesterdayPay = round($projectUserMoney -> getProjectUserDateMoney(false, $request -> getFilter('id_user'), ID_OPTIMISATOR, $yesterday, $yesterday));
//$lastMonthPay = round($projectUserMoney -> getProjectUserDateMoney(false, $request -> getFilter('id_user'), ID_OPTIMISATOR, $lfirstdaymonth, $lenddaymonth));
$yesterdayMonthPay =  ($monthPayToday - $todayPay) + ($yesterdayPay * ($days+1));
$globalTemplateParam->set('monthPay',$monthPay);
$globalTemplateParam->set('yesterdayMonthPay',$yesterdayMonthPay);
$maxseopay = 0;
for ($i = 0; $i < $index; $i++) {
	// максимальная премия
	$userProjects[$i]['seo_pay'] = round($userProjects[$i]['max_seo_user_pay']*$userProjects[$i]['pay_percent']/100);
	$maxseopay += $userProjects[$i]['seo_pay'];
	// процент закупки сейп
	$userProjects[$i]['sape_percent'] = $sape -> getMoneyDay($userProjects[$i][$projects -> idField],$yesterday);
	if($userProjects[$i]['sape_money'])
		$userProjects[$i]['sape_percent'] = round($userProjects[$i]['sape_percent'][0]['sum']/($userProjects[$i]['sape_money']/$monthDay)*100);
	else 
		$userProjects[$i]['sape_percent'] = 0;	
	$userProjects[$i]['change_pos'] = $projectsPos -> getChangeQueryPos($userProjects[$i][$projects -> idField],$today);
	$userProjects[$i]['change_plus'] = ($userProjects[$i]['change_pos']['plus']);
	$userProjects[$i]['change_mines'] = ($userProjects[$i]['change_pos']['mines']); 
	if($userProjects[$i]['seo_pay']){
		$userProjects[$i]['seo_percent'] = round( $projectUserMoney ->
										getProjectUserDateMoney($userProjects[$i][$projects -> idField], $request -> getFilter('id_user'), ID_OPTIMISATOR, $today, $today)
										/ ($userProjects[$i]['seo_pay']/$monthDay) *100 );
	}else{
		$userProjects[$i]['seo_percent'] = 0;
	}

	if($userProjects[$i]['seo_pay']){
		$userProjects[$i]['seo_percent_yesterday'] = round( $projectUserMoney ->
										getProjectUserDateMoney($userProjects[$i][$projects -> idField], $request -> getFilter('id_user'), ID_OPTIMISATOR, $yesterday, $yesterday)
										/ ($userProjects[$i]['seo_pay']/$monthDay) *100 );
	}else{
		$userProjects[$i]['seo_percent_yesterday'] = 0;
	}
										
}
if($maxseopay){
	$todayPercent = round($todayPay/($maxseopay/$monthDay)*100);
	$yesterdayPercent = round($yesterdayPay/($maxseopay/$monthDay)*100);
	$globalTemplateParam->set('todayPercent',$todayPercent);
	$globalTemplateParam->set('yesterdayPercent',$yesterdayPercent);
}
$globalTemplateParam->set('userProjects',$userProjects);
$surpricepay =  round( $maxseopay * $configs -> promo_percent_surprise_default / 100 );
$globalTemplateParam->set('surpricepay',$surpricepay);


$promos = $userObj -> getByRole(ID_OPTIMISATOR,true);

$globalTemplateParam->set('promos',$promos);
$globalTemplateParam->setNonPointer('ID_ADMINISTRATOR',ID_ADMINISTRATOR);
$globalTemplateParam->setNonPointer('ID_AKKAUNT',ID_AKKAUNT);
$modul->template = "promo/projects/projects.tpl";