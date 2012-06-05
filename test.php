<?php


/*class projects_accessRoleTest extends PHPUnit_Framework_TestCase {

	public function testUserAcces()
	{
		
		$this->assertEquals(8, 50);
	}
}

*/

require('./fmake/FController.php');
$curl = new cURL();
	$curl->cookie_in_file = true;
	$curl->init();

$proxyObj = new ethernetInterface_Proxy();
	$proxy = $proxyObj->getByGoogle () ;
	printAr($proxy);
	// если разгадываем капчу с определенного прокси
	//$curl->set_opt( CURLOPT_PROXY, $proxy['proxy']  );

//	$curl->set_opt( CURLOPT_PROXY, "46.243.181.54:3128"  );

//	$curl->set_opt( CURLOPT_PROXYUSERPWD, 'proxy_user117:Th8xLR06FG');

$curl -> get('http://advq.yandex.ru/'); 
echo $curl -> data;
echo 11111;



/*
echo strtotime("yesterday");

$sapeMoney = new sape_money();
echo $sapeMoney -> checkMoney();

exit;
$curl = new cURL();
$curl -> init();
echo 'http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=700';
$curl -> get('http://'.$hostname.'/cron/querys_check_position.php?key='.$cronKey.'&id_seo_query=700');
echo $curl->data();
*/
