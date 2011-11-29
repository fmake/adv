<?php 
header('Content-type: text/html; charset=utf-8'); 
setlocale(LC_ALL, 'ru_RU.UTF-8');
mb_internal_encoding('UTF-8');
ini_set('display_errors',1);
error_reporting(7);
session_start();

require('./fmake/FController.php');

echo strtotime("today")."<br />";
echo strtotime("2011-11-29")."<br />";
echo time();

$pos = new projects_seo_position();
$pos -> checkAllPosition();
exit;

class MyMultiCurl extends cURL_multi {
    protected function onLoad($url, $content, $info) {
    	$arr = explode(";", $content);
        print ( "[$url]  $arr[0] ".($arr[1])."<br />" );
		//print htmlspecialchars($content);
        //print_r($info);
    }
}

try {
    $mc = new MyMultiCurl();
    $mc->setMaxSessions(20); // limit 2 parallel sessions (by default 10)
    //$mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    $start = time();
    for ($j = 0; $j < 2; $j++) {
	    for($i=0; $i < 20; $i++){
			$mc->addUrl('http://adv.my/cron/querys_check_position.php?key=55ef35a83bb24ac9b4d959a1f1239aea&id_seo_query='.($i+$j*20));
		}
	    $mc->wait();
    }
    echo time()-$start;
} catch (Exception $e) {
    die($e->getMessage());
}

/*
$yandex = new searchSystems_Yandex();
$yandex -> setData("ремонт стиральных машин", "www.mr-master.ru",213);
printAr(  $yandex -> getPosition() );


$google = new searchSystems_Google();
$google -> setData("ремонт стиральных машин Москва", "mr-master.ru");
printAr( $google -> getPosition());


$google = new searchSystems_GoogleCom();
$google -> setData("web developer", "www.onetonline.org");
printAr( $google -> getPositionWhithData() );



$mail = new searchSystems_Mail();
$mail -> setData("ремонт стиральных машин Москва", "plus-service.ru");
printAr( $mail -> getNumSite($num));
*/