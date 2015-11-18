<?php

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
