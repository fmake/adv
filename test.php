<?php


/*class projects_accessRoleTest extends PHPUnit_Framework_TestCase {

	public function testUserAcces()
	{
		
		$this->assertEquals(8, 50);
	}
}

*/

require('./fmake/FController.php');
$sape = new sape_project();
//printAr( $sape -> getProjects() );

printAr( $sape -> getUrlsProject(545340) );
