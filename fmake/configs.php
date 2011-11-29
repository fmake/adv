<?php
	/*
	 * конфигурация всей системы системы
	 */
	define('ROOT', realpath(dirname(__FILE__).'/..'));
	define('REQUEST_SAFETY', false);
	$cronKey = "55ef35a83bb24ac9b4d959a1f1239aea";
	
	// регистрация шаблонизатора 
	require_once('libs/pear/PEAR.php');
	require_once('libs/pear/Twig/Autoloader.php');
	Twig_Autoloader::register();
	
	// подключение глобальных функций 
	require 'libs/includes/functions.php';
	// подключение инициализатора объектов 
	require 'libs/objectCreater/objectCreater.php';
	//устанавливаем пути к директории и определяем загрузчик
	objectCreater::setDirPaths();
	
	
	
	

	
	
?>