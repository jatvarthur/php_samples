<?php

include_once "phpunit.phar";
include_once "../autoload.php";

class CalcTest extends PHPUnit_Framework_TestCase
{

	public function testAdd1()
	{
		$calc = new Calc();
		$result = $calc->add(2, 2);
		$this->assertEquals(4, $result, 'Sum must be equal to 4');
	}

	/**
	 * @dataProvider additionProvider
	 */
	public function testAdd2($a, $b, $expected)
	{
		$calc = new Calc();
		$result = $calc->add(2, 2);
		$this->assertEquals($expected, $a + $b);
	}

	public function additionProvider()
	{
		return array(
			array(1, 1, 2),
			array(2, 2, 4),
		);
	}
}

$suite = new PHPUnit_Framework_TestSuite();
$suite->addTestSuite('CalcTest');

PHPUnit_TextUI_TestRunner::run($suite);
