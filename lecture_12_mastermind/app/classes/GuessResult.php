<?php

/**
 * Описание результата очережного угадывания
 */
class GuessResult
{
	/**
	 * Результат: пользователь ввел неправильное значение догадки.
	 */
	const INVALID_INPUT	= 'INV';

	/**
	 * Результат: пользователь угадал и игра закончена.
	 */
	const SUCCESS		= 'SCS';

	/**
	 * Результат: пользователь угадал часть цифр, игра продолжается.
	 */
	const GUESS			= 'GES';

	/**
	 * @var integer Номер попытки
	 */
	protected $tryNo;

	/**
	 * @var string Значение догадки
	 */
	protected $guess;

	/**
	 * @var integer Количество быков - количество совпадений вплоть до позиции
	 */
	protected $bulls;

	/**
	 * @var integer Количество коров - количество совпадений
	 */
	protected $cows;

	/**
	 * @param $result Резолюция угадывания
	 */
	protected $result;


	public function __construct($tryNo, $guess, $result, $bulls = 0, $cows = 0)
	{
		$this->tryNo = $tryNo;
		$this->guess = $guess;
		$this->result = $result;
		$this->bulls = $bulls;
		$this->cows = $cows;
	}

	public function getTryNo()
	{
		return $this->tryNo;
	}

	public function getGuess()
	{
		return $this->guess;
	}

	public function getResult()
	{
		return $this->result;
	}

	public function getBulls()
	{
		return $this->bulls;
	}

	public function getCows()
	{
		return $this->cows;
	}

	public function isFinished()
	{
		return $this->result == self::SUCCESS;
	}

	/**
	 * Проверяет, что результат совпадает с указанным
	 */
	public function is($result)
	{
		return $this->result === $result;
	}

}