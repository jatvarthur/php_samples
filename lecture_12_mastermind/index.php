<?php

require('app/common.php');

/*
 * Точка входа скрипта
 */
function main()
{
	// создаем сессию
	session_start();
	// и выполняем маршрутизацию запроса
	route_request();
}

main();

