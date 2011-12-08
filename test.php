<?php 
header('Content-type: text/html; charset=utf-8'); 
setlocale(LC_ALL, 'ru_RU.UTF-8');
mb_internal_encoding('UTF-8');
ini_set('display_errors',1);
error_reporting(7);
session_start();
require './fmake/configs.php';
if($_GET['key'] != $cronKey )exit;
require('./fmake/FController.php');
$pos = new projects_seo_position();
$pos -> checkAllPosition();