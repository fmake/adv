<?php
header('Content-type: text/xml; charset=utf-8');
ini_set('display_errors',1);
error_reporting(7);
ini_set ('max_execution_time',3500);

require '../fmake/configs.php';
if($_GET['key'] != $cronKey || !$_GET['id_seo_query'])exit;
require('../fmake/FController.php');

$id_seo_query = intval($_GET['id_seo_query']);
$seoPosition = new projects_seo_position();
echo $seoPosition -> getXml( $seoPosition -> checkPosition($id_seo_query,$_GET['checkIfExist']) );



