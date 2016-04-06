<?php

/**
 * Элементарный калькулятор
 */
class Calc
{

	public function add($a, $b)
	{
		return $a + $b;
	}

	public function sub($a, $b)
	{
		return $a - $b;
	}

	public function mul($a, $b)
	{
		return $a * $b;
	}

	public function div($a, $b)
	{
		if ($b == 0)
			throw new ArithmeticException('div', 'Division by zero');
		return $a / $b;
	}

}
