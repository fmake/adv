<?php



$userObj = $modul -> getUserObj();
$projects = new projects();
$userMoney = new projects_seo_moneyUsers();



if($request -> month < 0){
	$monthl1 = strtotime(($request -> month - 1)." month",strtotime(date('m/01/y')));
	$monthDays[0]['num'] = date("m",$monthl1);
	$monthDays[0]['name'] = getRusNameMoth( $monthDays[0]['num']);
	
	
	$month =  strtotime("{$request -> month} month",strtotime(date('m/01/y')));
	$monthDays[1]['num'] = date("m",$month);
	$monthDays[1]['name'] = getRusNameMoth( $monthDays[1]['num']);
	
	$date_from = $month;
	$date_to = strtotime("-1 day",  strtotime("+1 month",$month) );
	
	
	$monthln = strtotime(($request -> month + 1)." month",strtotime(date('m/01/y')));
	$monthDays[2]['num'] = date("m",$monthln);
	$monthDays[2]['name'] = getRusNameMoth( $monthDays[2]['num']);

}else{
	$monthl1 = strtotime("-1 month",strtotime(date('m/01/y')));
	$monthDays[0]['num'] = date("m",$monthl1);
	$monthDays[0]['name'] = getRusNameMoth( $monthDays[0]['num']);
	
	$date_from = strtotime(date('m/01/y'));
	$date_to =  strtotime("today");
	$fistdayNextMonth = strtotime("+1 month",$date_from);
	$nextDays = round($fistdayNextMonth - $date_to)/(60*60*24) - 1;
	
	$monthDays[1]['num'] = date("m",$date_from);
	$monthDays[1]['name'] = getRusNameMoth( $monthDays[1]['num']);
}
$globalTemplateParam->set('monthDays',$monthDays);


if(!isset($_REQUEST[$request->filter]['active'])){
	$request -> setFilter("active", 1);
}


$promos = $userObj -> getByRole(ID_OPTIMISATOR,$request -> getFilter('active'));
$globalTemplateParam->set('promos',$promos);

$accaunt = $userObj -> getByRole(ID_AKKAUNT,$request -> getFilter('active'));
$globalTemplateParam->set('accaunt',$accaunt);

if($user->role != ID_ADMINISTRATOR){
	$request -> setFilter("id_user", $user->id);
	define("ID_FINANSE_ROLE", $user->role);
}else if($request -> getFilter('id_user')){
	$userObj -> setId($request -> getFilter('id_user'));
	$filtr['id_user'] =  $request -> getFilter('id_user');
	$curUsr = ($userObj -> getInfo());
	define("ID_FINANSE_ROLE", $curUsr['role']);
	$request -> setFilter('userrole',ID_FINANSE_ROLE);
}else if($request -> getFilter('userrole')){
	define("ID_FINANSE_ROLE",$request -> getFilter('userrole'));
}else{
	define("ID_FINANSE_ROLE",ID_OPTIMISATOR);
}

	
$filtr['date'] =  $request -> getFilter('date');
$filtr['id_role'] = ID_FINANSE_ROLE;
$userProjects = ( $projects -> getProjectsWithSeoParamsWithAccessUser("DISTINCT ".$projects ->table.".id_project,url,max_seo_user_pay,pay_percent",$filtr)  );
$index = sizeof($userProjects);
//printAr($userProjects);
$finalSum['max_money'] = 0;
for ($i = 0; $i < $index; $i++) {
	$userProjects[$i]['cur_money'] = round($userMoney -> getProjectUserDateMoney($userProjects[$i][$projects -> idField], $request -> getFilter('id_user'), ID_FINANSE_ROLE, $date_from, $date_to));
	$userProjects[$i]['max_money'] = round( $userProjects[$i]['max_seo_user_pay'] * $userProjects[$i]['pay_percent'] / 100 );
	$userProjects[$i]['prognose_money'] = $userProjects[$i]['cur_money'] + round( $nextDays * $userMoney -> getProjectUserDateMoney($userProjects[$i][$projects -> idField], $request -> getFilter('id_user'), ID_FINANSE_ROLE,$date_to, $date_to) );
	$finalSum['max_money'] += $userProjects[$i]['max_money'];
	$finalSum['prognose_money'] += $userProjects[$i]['prognose_money'];
}
// чтобы учесть бывшие проекты
$finalSum['cur_money'] = round($userMoney -> getProjectUserDateMoney(false, $request -> getFilter('id_user'),ID_FINANSE_ROLE, $date_from, $date_to));
$globalTemplateParam->set('finalSum',$finalSum);
//printAr($userProjects);
$globalTemplateParam->set('userProjects',$userProjects);
$globalTemplateParam->setNonPointer('ID_ADMINISTRATOR',ID_ADMINISTRATOR);
$globalTemplateParam->setNonPointer('ID_AKKAUNT',ID_AKKAUNT);	
$globalTemplateParam->set('user',$user);	

$modul->template = "useroffice/finanse.tpl";