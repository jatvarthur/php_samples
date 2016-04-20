<?php

//////////////////////////////////////////////////////////
// ОБРАБОТКА СТРОК

/**
 * Проверка, что страка заканчивается на указанный префикс
 */
function starts_with($string, $prefix)
{
	$strlen = strlen($string);
	$fixlen = strlen($prefix);
	if ($fixlen > $strlen)
		return false;
	return substr_compare($string, $prefix, 0, $fixlen) === 0;
}

/**
 * Проверка, что страка заканчивается на указанный суффикс
 */
function ends_with($string, $suffix)
{
	$strlen = strlen($string);
	$fixlen = strlen($suffix);
	if ($fixlen > $strlen)
		return false;
	return substr_compare($string, $suffix, $strlen - $fixlen, $fixlen) === 0;
}

/**
 * Множественное число существительных
 * $endings[0] - окончание для $num == 0
 * $endings[1] - окончание для $num == 1
 * $endings[2] - окончание для $num in 2-4
 * $endings[3] - окончание для $num >= 5
 */
function numeral_case($num, $singular, $endings)
{
	if ($num > 4)
		return "$num&nbsp;$singular{$endings[3]}";
	else if ($num > 1)
		return "$num&nbsp;$singular{$endings[2]}";
	else if ($num > 0)
		return "$num&nbsp;$singular{$endings[1]}";
	return "$num&nbsp;$singular{$endings[0]}";
}

//////////////////////////////////////////////////////////
// ПОДДЕРЖКА ВИДОВ

/**
 * Выполняет вывод указанного шаблона $template с данными
 */
function render($template, $data = array())
{
	extract($data);
	require('templates/' . $template . '.php');
}

//////////////////////////////////////////////////////////
// МАРШРУТИЗАЦИЯ

/**
 * Выполняет переадресацию на указанный адрес $url
 */
function redirect($url = './')
{
	session_write_close();
	header('Location: ' . $url);
	exit;
}

/**
 * Отсылает клиенту код ошибки HTTP
 */
function set_http_error($code)
{
	header('X-PHP-Response-Code: '.$code, true, $code);
}

/**
 * Определяет контроллер и метод, в которы необходимо передать запрос
 */
function get_route_url()
{
	// параметры по умолчанию - метод IndexController::indexAction()
	$result = array(
		'module' => 'index',
		'action' => 'index',
	);

	// путь передается в параметре _R запроса
	$route = isset($_GET['_R']) ? $_GET['_R'] : '/';
	if (!empty($route) && $route != '/') {
		$uri_parts = array_filter(explode('/', trim($route, ' /')), 'strlen');
		$count_parts = count($uri_parts);
		if ($count_parts == 1) {
			// передан только метод
			$result['module'] = $uri_parts[0];
		} else if ($count_parts >= 2) {
			// передан контроллер и метод
			$result['module'] = $uri_parts[0];
			$result['action'] = $uri_parts[1];
		}
	}

	return $result;
}

/**
 * Выполняет метод контроллера
 */
function route_request()
{
	$route = get_route_url();
	$controllerClass = ucfirst($route['module']).'Controller';
	$actionName = 'action'.(strlen($route['action']) > 0 ? ucfirst($route['action']) : 'Index');

	if (!class_exists($controllerClass)) {
		set_http_error(404);
		return;
	}

	$controller = new $controllerClass();
	if (!method_exists($controller, $actionName)) {
		set_http_error(404);
		return;
	}

	call_user_func(array($controller, $actionName));
}

/**
 * Функция автозагрузки классов
 */
spl_autoload_register(function ($className) {
	$className = str_replace('..', '', $className);
	$root = __DIR__;

	// классы моделей и контроллеров расположены в специальных каталогах
	if (ends_with($className, 'Model')) {
		$classFile = $root.'/models/' . $className . '.php';
		if (file_exists($classFile)) {
			require_once($classFile);
			return;
		}
	}

	if (ends_with($className, 'Controller')) {
		$classFile = $root.'/controllers/' . $className . '.php';
		if (file_exists($classFile)) {
			require_once($classFile);
			return;
		}
	}

	// прочие классы расположены в ./classes
	$classFile = $root.'/classes/' . $className . '.php';
	if (file_exists($classFile))
		require_once($classFile);
});
