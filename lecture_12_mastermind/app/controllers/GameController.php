<?php

class GameController
{
	/**
	 * возвращает историю игры
	 */
	public function actionHistory()
	{
		$game = $this->getCurrentGame();

		render('guess', array(
			'game' => $game, 'results' => $game->getHistory(),
		));
	}

	/**
	 * Обработка значения, присланного пользователем
	 */
	public function actionGuess()
	{
		// получаем догадку, введенную пользователем
		$guess = $_POST['guess'];

		$game = $this->getCurrentGame();
		$result = $game->checkGuess($guess);

		render('guess', array(
			'game' => $game, 'results' => array($result),
		));
	}

	/**
	 * Получает текущую игру для пользователя
	 */
	protected function getCurrentGame()
	{
		// которую мы храним в сессии, если ее там нет, то создаем новую
		if (!isset($_SESSION['current_game']))
			$_SESSION['current_game'] = new GameModel();

		$game = $_SESSION['current_game'];

		// если игра не активна, запускаем ее
		if (!$game->isActive())
			$game->start();

		return $game;
	}

}