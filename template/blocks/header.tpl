<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{modul.caption}</title>
	<meta name="description" content="{modul.description}" />
	<meta name="keywords" content="{modul.keywords}" />
	<link rel="stylesheet" type="text/css" href="/styles/main.css" />
	<link rel="stylesheet" href="/fmake/libs/phpObjectForms/css/pof/blue.css" type="text/css" />
	<script language="javascript" type="text/javascript" src="/js/jquery-1.6.1.min.js"></script>
	<script language="javascript" type="text/javascript" src="/js/scripts.js"></script>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	[[if xajax]]
		[[phpcode`
			$context['xajax']->printJavascript();
		`]]
	[[endif]]
</head>