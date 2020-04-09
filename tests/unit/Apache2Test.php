<?php
class Apache2Test extends \Codeception\Test\Unit
{
	/**
	  * @var \UnitTester
	  */
    protected $tester;
    

    public function testVersion() {
		$this->assertGreaterThan("7.0", phpversion(), "php should be at least 7.0 or better");
	}

	public function testPDO() {
		$this->assertTrue(in_array("mysql", PDO::getAvailableDrivers()), "PDO has no MySQL Driver installed");
		$this->assertTrue(in_array("sqlite", PDO::getAvailableDrivers()), "PDO has no sqlite Driver installed");
	}

	
	
	/**
    * @dataProvider ServermoduleProvider
    */
    public function testMods($func, $name) {
		$this->assertTrue(function_exists($func), $name." Erweiterung nicht gefunden");
	}
	

	/**
     * @return array
     */
    public function ServermoduleProvider() 
    {
        return [
			"json" => ["json_encode", "JSON"],
			"xml" => ["simplexml_load_string", "XML"]
			];
    }


}