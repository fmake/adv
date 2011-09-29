<?php
/**
 * Файл проверки пользователяы, если он не залогинен то доступ к системе запрещен 
 * 
 */
$user = $modul->getUserObj();
$user->load();

if ($request->action=="logout")
{
	$user->logout();
	setcookie("clogin",$row['login'],time()-3600*24*60,"/");
	setcookie("cpassword",md5(""),time()-3600*24*60,"/");
	Header ("Location: /");
	exit();
}else if ($request->action=="Login"){
	if ($row = $user->login($request->login, $request->password)){
		$user->setLogin($row['id'], $row['login'], $row['role'], $row['name']);
		if($_REQUEST['save']){
			setcookie("clogin",$row['login'],time()+3600*24*60,"/");
			setcookie("cpassword",md5($request->password),time()+3600*24*60,"/");
		}
	}else{
		$error = true;
		$globalTemplateParam->set('error',$error);	
	}         
}else if($_COOKIE['clogin']){
	if ($row = $user->login($_COOKIE['clogin'], $_COOKIE['cpassword'],true)) 
	{
		$user->setLogin($row['id'], $row['login'], $row['role'], $row['name']);
		setcookie("clogin",$row['login'],time()+3600*24*60,"/");
		setcookie("cpassword",$_COOKIE['cpassword'],time()+3600*24*60,"/");
	}
}
// показывает страницу логина если так и не смог войти 
if (!$user->isLogined()) 
{	   	
	$modul->template = "login.tpl";
	$template = $twig->loadTemplate($modul->template);
	$template->display($globalTemplateParam->get());
	exit();
}
