<?php

require('lib/common.php');

function main()
{
	// создаем сессию
	session_start();

	// если в сессии нет пользователя, переходим на регистрацию
	if (!isset($_SESSION['user']))
		redirect('/');

	// иначе отображаем страницу "Спасибо"
	render('thankyou', array( 'user' => $_SESSION['user'] ));
}

main();