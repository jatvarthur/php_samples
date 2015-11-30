<?php

require('config.php');


/* ****************************************************************************
 * Общие функции
 */

/*
 * Выполняет переадресацию на указанный адрес $url
 */
function redirect($url)
{
	session_write_close();
	header('Location: '.$url);
	exit;
}

/*
 * Выполняет вывод указанного шаблона $template с данными
 */
function render($template, $data=array())
{
	extract($data);
	require('templates/'.$template.'.php');
}


/* ****************************************************************************
 * Функции работы с массивом ошибок
 */

/*
 * Инициализирует структуру массива для хранения информации об ошибках
 */
function empty_errors()
{
	return array(
		'fields' 	=> array(),
		'messages'	=> array(),
	);
}

/*
 * Проверяет, что есть ошибочные поля в описании ошибок
 */
function has_errors($errors)
{
	return isset($errors['fields']) && count($errors['fields']) > 0;
}

/*
 * Проверяет, что указанное поле есть в списке ошибочных полей
 */
function is_error($errors, $field)
{
	return isset($errors['fields']) && in_array($field, $errors['fields']);
}

/*
 * Добавляет описание ошибки в массив ошибок
 */
function add_error(&$errors, $field, $description)
{
	$errors['fields'][] = $field;
	$errors['messages'][$field] = "@$field-$description";
	return false;
}


/* ****************************************************************************
 * Валидация данных
 */

/*
 * Проверяет корректность строки в форме, если строка корректна, копирует ее в $obj
 * и возвращает true; false и заполненный массив ошибок, если нет
 */
function read_string($form, $field, &$obj, &$errors, $min, $max, $is_required, $default=null, $trim=true)
{
	$obj[$field] = $default;
	if (!isset($form[$field])) {
		return $is_required ? add_error($errors, $field, 'required') : true;
	}

	$value = $trim ? trim($form[$field]) : $form[$field];
	if ($value == '' && $is_required)
		return add_error($errors, $field, 'required');

	if (strlen($value) < $min)
		return add_error($errors, $field, 'too-short');

	if (strlen($value) > $max)
		return add_error($errors, $field, 'too-long');

	$obj[$field] = $value;
	return true;
}

/*
 * Проверяет корректность целого числа в форме, если передано правильное число, копирует его в $obj
 * и возвращает true; false и заполненный массив ошибок, если нет
 */
function read_integer($form, $field, &$obj, &$errors, $min, $max, $is_required, $default=null)
{
	$obj[$field] = $default;
	if (!isset($form[$field])) {
		return $is_required ? add_error($errors, $field, 'required') : true;
	}

	// проверяем, что передано число
	$value = filter_var($form[$field], FILTER_VALIDATE_INT);
	if ($value === false)
		return add_error($errors, $field, 'invalid');

	if (is_int($min) && $value < $min)
		return add_error($errors, $field, 'too-small');

	if (is_int($max) && $value > $max)
		return add_error($errors, $field, 'too-big');

	$obj[$field] = $value;
	return true;
}

/*
 * Проверяет корректность десятичного вещественного числа в форме, если передано правильное число,
 * копирует его в $obj и возвращает true; false и заполненный массив ошибок, если нет
 */
function read_decimal($form, $field, &$obj, &$errors, $min, $max, $is_required, $default=null)
{
	$obj[$field] = $default;
	if (!isset($form[$field])) {
		return $is_required ? add_error($errors, $field, 'required') : true;
	}

	// проверяем, что передано число
	$pattern = '/^[-+]?[0-9]*\.?[0-9]+$/';
	$value = trim($form[$field]);
	if (!preg_match($pattern, $value))
		return add_error($errors, $field, 'invalid');

	if (is_string($min) && $min != '' && bccomp($value, $min) == -1)
		return add_error($errors, $field, 'too-small');

	if (is_string($max) && $max != '' && bccomp($value, $max) == 1)
		return add_error($errors, $field, 'too-big');

	$obj[$field] = $value;
	return true;
}

/*
 * Добавляет описание товара в базу данных, возвращает true, если регистраиция
 * завершилась успешно, и false и заполненный массив ошибок в противном
 * случае
 */
function add_product($dbh, &$product, &$errors)
{
	$product = array();
	$errors  = empty_errors();

	// считываем строки из запроса
	read_string($_POST, 'title', $product, $errors, 2, 60, true);
	read_integer($_POST, 'category_id', $product, $errors, 1, null, true);
	read_decimal($_POST, 'price', $product, $errors,  '0.0', null, true);

	if (has_errors($errors))
		return false;

	// форма передана правильно, сохраняем пользователя в базу данных
	$db_product = db_product_insert($dbh, $product);

	return true;
}


/* ****************************************************************************
 * Работа с базой данных
 */

/*
 * Выполняет подключение к базе данных
 */
function db_connect()
{
	$dbh = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	// проверка соединения
	if (mysqli_connect_errno())
		db_handle_error($dbh);

	mysqli_set_charset($dbh, "utf8");

	return $dbh;
}

/*
 * Закрывает подключение к базе данных
 */
function db_close($dbh)
{
	mysqli_close($dbh);
}

/*
 * Обработка ошибок подключения к базе данных
 */
function db_handle_error($dbh)
{
	$code = '@unknown-error';
	$message = '';
	if (mysqli_connect_error()) {
		$code = '@connect-error';
		$message = mysqli_connect_error();
	}

	if (mysqli_error($dbh)) {
		$code = '@query-error';
		$message =mysqli_error($dbh);
	}

	render('error', array(
		'code' => $code, 'message' => $message,
	));
	exit;
}

/*
 * Извлекает из базы данных список категорий
 */
function db_category_find_all($dbh)
{
	$query = 'SELECT * FROM categories ORDER BY title';
	$result = array();

	// выполняем запрос к базе данных
	$qr = mysqli_query($dbh, $query, MYSQLI_STORE_RESULT);
	if ($qr === false)
		db_handle_error($dbh);

	// последовательно извлекаем строки
	while ($row = mysqli_fetch_assoc($qr))
		$result[] = $row;

	// освобождаем ресурсы, связанные с хранением результата
	mysqli_free_result($qr);

	return $result;
}

/*
 * Извлекает из базы данных список товаров
 */
function db_product_find_all($dbh)
{
	$query = 'SELECT p.*, c.title as category_title FROM products p INNER JOIN categories c ON c.id=p.category_id';
	$result = array();

	// выполняем запрос к базе данных
	$qr = mysqli_query($dbh, $query, MYSQLI_STORE_RESULT);
	if ($qr === false)
		db_handle_error($dbh);

	// последовательно извлекаем строки
	while ($row = mysqli_fetch_assoc($qr))
		$result[] = $row;

	// освобождаем ресурсы, связанные с хранением результата
	mysqli_free_result($qr);

	return $result;
}

/*
 * Вставляет в базу данных строку с информацией о товаре, возвращает массив
 * с данными товара и его id в базе данных
 */
function db_product_insert($dbh, $product)
{
	$query = 'INSERT INTO products(title,category_id,price) VALUES(?,?,?)';

	// подготовливаем запрос для выполнения
	$stmt = mysqli_prepare($dbh, $query);
	if ($stmt === false)
		db_handle_error($dbh);

	mysqli_stmt_bind_param($stmt, 'sss',
		$product['title'], $product['category_id'], $product['price']);

	// выполняем запрос
	if (mysqli_stmt_execute($stmt) === false)
		db_handle_error($dbh);

	// получаем идентификатор вставленной записи
	$product['id'] = mysqli_insert_id($dbh);

	// освобождаем ресурсы, связанные с хранением результата и запроса
	mysqli_stmt_close($stmt);

	return $product;
}

/*
 * Выполняет поиск в базе данных и загрузку товаров, принадлежащих указанной категории
 */
function db_product_find_by_category_id($dbh, $category_id)
{
	$query = 'SELECT p.*, c.title as category_title FROM products p INNER JOIN categories c ON c.id=p.category_id WHERE p.category_id=?';
	$result = array();

	// подготовливаем запрос для выполнения
	$stmt = mysqli_prepare($dbh, $query);
	if ($stmt === false)
		db_handle_error($dbh);

	mysqli_stmt_bind_param($stmt, 's', $category_id);

	// выполняем запрос и получаем результат
	if (mysqli_stmt_execute($stmt) === false)
		db_handle_error($dbh);

	// получаем результирующий набор строк
	$qr = mysqli_stmt_get_result($stmt);
	if ($qr === false)
		db_handle_error($dbh);

	// последовательно извлекаем строки
	while ($row = mysqli_fetch_assoc($qr))
		$result[] = $row;

	// освобождаем ресурсы, связанные с хранением результата и запроса
	mysqli_free_result($qr);
	mysqli_stmt_close($stmt);

	return $result;
}
