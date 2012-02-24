<?php


/*class projects_accessRoleTest extends PHPUnit_Framework_TestCase {

	public function testUserAcces()
	{
		
		$this->assertEquals(8, 50);
	}
}

*/

require('./fmake/FController.php');
$update = new projects_update();
printAr( $update -> genPic() ); 



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