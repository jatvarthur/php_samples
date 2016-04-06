<?php

/**
 * Ошибка арифметичекой операции
 */
class ArithmeticException extends Exception
{
	/**
	 * @var string Код операции, при которой возникла ошибка
	 */
	protected $operation;

	public function __construct($operation, $message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->operation = $operation;
	}

	public final function getOperation()
	{
		return $this->operation;
	}

}