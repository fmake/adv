<?php


/*class projects_accessRoleTest extends PHPUnit_Framework_TestCase {

	public function testUserAcces()
	{
		
		$this->assertEquals(8, 50);
	}
}

*/
require('./fmake/FController.php');
printAr($_REQUEST);
$curl = new cURL();
$curl->init();
echo $request -> code;
$curl -> post("https://oauth.yandex.ru/token","grant_type=authorization_code&code={$request -> code}&client_id=055c71b71f604603a2f633093a1980dd&client_secret=850a7628167f4fed8652e4cbb125a3d9");
printAr( $curl -> data );

