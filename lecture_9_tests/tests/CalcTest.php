<?php

include_once "phpunit.phar";
include_once "../autoload.php";

/**
 * Тестирование класса калькулятора
 */
class CalcTest extends PHPUnit_Framework_TestCase
{

	/*
	 * 1. Базовый тест
	 */

	public function testAdd1()
	{
		$calc = new Calc();
		$result = $calc->add(2, 2);
		$this->assertEquals(4, $result, 'Sum must be equal to 4');
	}

	/*
	 * 2. Использование провайдера данных
	 */

	/**
	 * @dataProvider additionProvider
	 */
	public function testAdd2($a, $b, $expected)
	{
		$calc = new Calc();
		$result = $calc->add($a, $b);
		$this->assertEquals($expected, $result);
	}

	public function additionProvider()
	{
		return array(
			array(1, 1, 2),
			array(2, 2, 4),
		);
	}

	/*
	 * 3. Использование полей класса и методов инициализации
	 */

	/**
	 * @var Calc Экземпляр калькулятора
	 */
	public $calc;

	public function setUp()
	{
		$this->calc = new Calc();
	}

	public function testAdd3()
	{
		$result = $this->calc->add(2, 2);
		$this->assertEquals(4, $result, 'Sum must be equal to 4');
	}

	/*
	 * 4. Утверждение относительно исключений
	 */

	public function testDiv0()
	{
		$this->setExpectedException('ArithmeticException', 'Division by zero');
		$this->calc->div(3, 0);
	}

}

$suite = new PHPUnit_Framework_TestSuite();
$suite->addTestSuite('CalcTest');

PHPUnit_TextUI_TestRunner::run($suite);
