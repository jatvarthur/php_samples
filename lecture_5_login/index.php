<?php

require('lib/common.php');

/*
 * Проверяет, что была выполнена отправка формы регистрации
 */
function is_postback()
{
	return isset($_POST['register']);
}

/*
 * Извлекает данные пользователя из запроса и выполняет их вализадию.
 * Если в процессе валидации возникли ошибки, то заполняет массив ошибок $errors.
 * Возвращает true, если данные были введены правильно, false в противном случае
 */
function read_user_info(&$user, &$errors)
{
	$user = array();
	$errors = array(
		'fields' 	=> array(),
		'messages'	=> array(),
	);

	// читаем и проверяем имя пользователя
	if (!isset($_REQUEST['username'])) {
		$errors['fields'][] = 'username';
		$errors['messages']['username'] = '@username-required';
	} else {
		$user['username'] = $value = $_REQUEST['username'];
		if (strlen($value) < 2) {
			$errors['fields'][] = 'username';
			$errors['messages']['username'] = '@username-too-short';
		} else if (strlen($value) > 64) {
			$errors['fields'][] = 'username';
			$errors['messages']['username'] = '@username-too-long';
		}
	}

	// читаем и проверяем пароль
	if (!isset($_REQUEST['password'])) {
		$errors['fields'][] = 'password';
		$errors['messages']['password'] = '@password-required';
	} else {
		$user['password'] = $value = $_REQUEST['password'];
		if (strlen($value) < 6) {
			$errors['fields'][] = 'password';
			$errors['messages']['password'] = '@password-too-short';
		} else if (strlen($value) > 24) {
			$errors['fields'][] = 'password';
			$errors['messages']['password'] = '@password-too-long';
		}
	}

	// читаем и проверяем подтверждение пароля
	if (!isset($_REQUEST['password_confirmation'])) {
		$errors['fields'][] = 'password_confirmation';
		$errors['messages']['password_confirmation'] = '@password_confirmation-required';
	} else {
		$user['password_confirmation'] = $value = $_REQUEST['password_confirmation'];
		if (strlen($value) < 6) {
			$errors['fields'][] = 'password_confirmation';
			$errors['messages']['password_confirmation'] = '@password_confirmation-too-short';
		} else if (strlen($value) > 24) {
			$errors['fields'][] = 'password_confirmation';
			$errors['messages']['password_confirmation'] = '@password_confirmation-too-long';
		}
	}

	// пароль и подтверждение пароля должны совпадать
	if (!is_error($errors, 'password') &&
			!is_error($errors, 'password_confirmation') &&
			$user['password'] != $user['password_confirmation']) {
		$errors['fields'][] = 'password';
		$errors['fields'][] = 'password_confirmation';
		$errors['messages']['password_confirmation'] = '@password_confirmation-dont-match';
	}

	// читаем и проверяем полное имя пользователя
	if (!isset($_REQUEST['fullname'])) {
		$errors['fields'][] = 'fullname';
		$errors['messages']['fullname'] = '@fullname-required';
	} else {
		$user['fullname'] = $value = $_REQUEST['fullname'];
		if (strlen($value) < 1) {
			$errors['fields'][] = 'fullname';
			$errors['messages']['fullname'] = '@fullname-too-short';
		} else if (strlen($value) > 80) {
			$errors['fields'][] = 'fullname';
			$errors['messages']['fullname'] = '@fullname-too-long';
		}
	}

	// читаем и проверяем пол пользователя, его указание необязательно,
	// мы сохраним его только если было передано правильное значение
	if (isset($_REQUEST['gender']) && ($_REQUEST['gender'] == 'M' || $_REQUEST['gender'] == 'F')) {
		$user['gender'] = $_REQUEST['gender'];
	} else {
		$user['gender'] = null;
	}

	// читаем и проверяем флажок, хочет ли пользователь получать рассылку,
	// если передано  значение '1', то да, в противном случае, считаем, что не хочет
	if (isset($_REQUEST['newsletter']) && $_REQUEST['newsletter'] == '1') {
		$user['newsletter'] = true;
	} else {
		$user['newsletter'] = false;
	}

	return !has_errors($errors);
}

/*
 * Точка входа скрипта
 */
function main()
{
	// создаем сессию
	session_start();

	if (is_postback()) {
		// обрабатываем отправленную форму
		if (read_user_info($user, $errors)) {
			// информация о пользователе введена правильно
			$_SESSION['user'] = $user;
			// перенаправляем на страницу "Спасибо"
			redirect('thankyou.php');
		} else {
			// информация о пользователе заполнена неправильно, выведем страницу с ошибками
			render('login_form', array(
				'user' => $user, 'errors' => $errors
			));
		}
	} else {
		// отправляем пользователю чистую форму для регистрации
		render('login_form', array(
			'user' => array(), 'errors' => array()
		));
	}
}

main();

