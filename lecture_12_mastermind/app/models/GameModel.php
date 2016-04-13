<?php

/**
 * Основной класс игры
 */
class GameModel
{
	/**
	 * Количество символов в коде
	 */
	const COUNT_CODE_CHARS	= 4;

	/**
	 * Максимальное количество элементов в истории.
	 */
	const HISTORY_MAX		= 20;

	/**
	 * @var bool Активна ли игра
	 */
	private $active = false;

	/**
	 * @var string Текущий загаданный код
	 */
	private $code;

	/**
	 * @var integer
	 */
	private $tries;

	/**
	 * @var array История догадок
	 */
	private $history;

	public function isActive()
	{
		return $this->active;
	}

	public function getHistory()
	{
		return $this->history;
	}

	/**
	 * Запуск новой игры
	 */
	public function start()
	{
		// загадываем комбинацию, поскольку повторения не допускаются, мы просто перемешиваем
		// строку из символов цифр и берем первые 4 символа результата
		$this->code = substr(str_shuffle('123456789'), 0, self::COUNT_CODE_CHARS);

		// сбрасываем количество попыток
		$this->tries = 0;
		// сбрасываем историю
		$this->history = array();
		// игра активна
		$this->active = true;
	}

	/**
	 * Проверяем догадку пользователя
	 */
	public function checkGuess($guess)
	{
		if (strlen($guess) != self::COUNT_CODE_CHARS || !ctype_digit($guess))
			return $this->result($guess, GuessResult::INVALID_INPUT);

		// считаем количество быков - совпадение вплоть до позиции в тайном числе
		$bulls = 0;
		for ($i = 0; $i < self::COUNT_CODE_CHARS; ++$i)
			if ($this->code[$i] == $guess[$i])
				$bulls += 1;

		// если угадали код, то завершаем игру
		if ($bulls == self::COUNT_CODE_CHARS) {
			$this->active = false;
			return $this->result($guess, GuessResult::SUCCESS);
		}

		// считаем количество коров - совпадение без позиции в тайном числе
		$cows = 0;
		for ($i = 0; $i < self::COUNT_CODE_CHARS; ++$i) {
			for ($j = 0; $j < self::COUNT_CODE_CHARS; ++$j) {
				if ($guess[$i] == $this->code[$j] && $i != $j)
					$cows += 1;
			}
		}

		return $this->result($guess, GuessResult::GUESS, $bulls, $cows);
	}

	/**
	 * Создание и сохранение в истории результата попытки
	 */
	protected function result($guess, $result, $bulls = 0, $cows = 0)
	{
		// нет смысла хранить слишком длинные неправильные значения
		if (strlen($guess) > 2 * self::COUNT_CODE_CHARS)
			$guess = substr($guess, 0, 2 * self::COUNT_CODE_CHARS).'...';

		// увеличиваем количество попыток
		$this->tries += 1;

		// создадим объект результата и запишем его в историю
		$gr = new GuessResult($this->tries, $guess, $result, $bulls, $cows);

		if (count($this->history) == self::HISTORY_MAX)
			array_shift($this->history);
		array_push($this->history, $gr);

		return $gr;
	}

}