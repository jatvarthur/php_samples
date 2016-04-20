<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Быки и коровы</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
<div class="wrapper">
	<h1>Быки и коровы</h1>
	<div class="guess-form">
		<div class="error-msg" id="error" style="display:none;"></div>
		<form id="guessForm">
			<div class="row">
				<label for="guess">Ваш ответ</label>
				<input type="text" name="guess" id="guessVal" maxlength="<?= GameModel::COUNT_CODE_CHARS ?>" value="">
			</div>
			<div class="row footer">
				<input type="submit" name="submitGuess" id="submitGuess" value="Угадать"/>
			</div>
		</form>
		<div class="output" id="output"></div>
	</div>

	<div class="rules">
		<p>
			В классическом варианте игра рассчитана на двух игроков. Каждый из игроков задумывает и записывает тайное 4-значное число с неповторяющимися цифрами. Игрок, который начинает игру по жребию, делает первую попытку отгадать число. Попытка — это 4-значное число с неповторяющимися цифрами, сообщаемое противнику. Противник сообщает в ответ, сколько цифр угадано без совпадения с их позициями в тайном числе (то есть количество коров) и сколько угадано вплоть до позиции в тайном числе (то есть количество быков). Например:
		</p>
		<p>
			Задумано тайное число «3219».
		</p>
		<p>
			Попытка: «2310».
		</p>
		<p>
			Результат: две «коровы» (две цифры: «2» и «3» — угаданы на неверных позициях) и один «бык» (одна цифра «1» угадана вплоть до позиции).
		</p>
		<p>
			Игроки делают попытки угадать по очереди. Побеждает тот, кто угадает число первым, при условии, что он не начинал игру. Если же отгадавший начинал игру — его противнику предоставляется последний шанс угадать последовательность.
		</p>
		<p>
			При игре против компьютера игрок вводит комбинации одну за другой, пока не отгадает всю последовательность.
		</p>
	</div>
</div>
</body>
</html>