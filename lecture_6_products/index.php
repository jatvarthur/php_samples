<?php

require('lib/common.php');

/*
 * Проверяет, что была выполнена отправка формы добавления товара
 */
function is_postback()
{
	return isset($_POST['insert']);
}

/*
 * Точка входа скрипта
 */
function main()
{
	// подключаемся к базе данных
	$dbh = db_connect();

	$product = array();
	$errors  = array();

	if (is_postback()) {
		$post_result = add_product($dbh, $product, $errors);

		if ($post_result) {
			db_close($dbh);
			// перенаправляем на список товаров
			redirect('./');
		}
	}

	// считываем список товаров и категорий
	$categories = db_category_find_all($dbh);
	$products   = db_product_find_all($dbh);

	// выводим результирующую страницу
	render('product_list', array(
		'categories' => $categories, 'products' => $products, 'form' => $_POST, 'errors' => $errors
	));

	// закрываем соединение с базой данных
	db_close($dbh);
}

main();

