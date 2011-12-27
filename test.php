<?php 
header('Content-type: text/html; charset=utf-8'); 
setlocale(LC_ALL, 'ru_RU.UTF-8');
mb_internal_encoding('UTF-8');
ini_set('display_errors',1);
error_reporting(7);
session_start();
require './fmake/configs.php';
require('./fmake/FController.php');

echo strtotime("today");
exit;
$curl = new cURL();
$curl -> init();
echo 'http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=700';
$curl -> get('http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=700');
echo $curl->data();
