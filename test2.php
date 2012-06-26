<?php

require('./fmake/FController.php');
//$curl = new cURL();

//$curl->init();
//$curl->set_opt(CURLOPT_HEADER, true);
//$curl->set_opt(CURLOPT_HTTPHEADER,array("Authorization: OAuth cd633178a7594ffe9b2a2b4bbeb3f380"));
//$curl->post("https://oauth.yandex.ru/token",
//				"grant_type=password&username=ventacom&password=5727731&client_id=52e6a76e532946afaa701a5c1dd5832e&client_secret=6d4a316581cf43f0b1653da944bce047");

//$curl->get("https://oauth.yandex.ru/authorize?response_type=code&client_id=055c71b71f604603a2f633093a1980dd");

//CURLOPT_HTTPHEADER

//$curl->get("https://webmaster.yandex.ru/api/27724314/hosts");

//printAr( $curl -> data );

//$webmaster = new yandex_webmaster();
//$serviceDocument = $webmaster -> getSiteInfo();
//printAr($serviceDocument);

$report = new projects_seo_report();
$report -> makeReport(1);
