<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Товары</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
<div class="wrapper">
	<h1>Товары</h1>
	<form action="" method="post">
		<table class="products" border="1">
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Категория</th>
				<th>Цена</th>
			</tr>
			<?php foreach ($products as $i => $product): ?>
			<tr class="<?= ($i+1)%2 == 0 ? 'even' : 'odd' ?>">
				<td><?= $product['id'] ?></td>
				<td><?= htmlspecialchars($product['title']) ?></td>
				<td><?= htmlspecialchars($product['category_title']) ?></td>
				<td><?= $product['price'] ?></td>
			</tr>
			<?php endforeach; ?>
			<tr class="form">
				<td>
					<input type="submit" name="insert" id="insert" value="+">
				</td>
				<td class="<?= is_error($errors, 'title') ? 'error' : '' ?>">
					<input type="text" name="title" id="title" value="<?= isset($form['title']) ? $form['title'] : '' ?>">
				</td>
				<td class="<?= is_error($errors, 'category_id') ? 'error' : '' ?>">
					<select name="category_id" id="category_id" size="1">
					<?php foreach ($categories as $category): ?>
						<option value="<?= $category['id'] ?>"
							<?= isset($form['category_id']) && $form['category_id'] == $category['id'] ? 'selected="selected"' : '' ?>>
							<?= htmlspecialchars($category['title']) ?>
						</option>
					<?php endforeach; ?>
					</select>
				</td>
				<td class="<?= is_error($errors, 'price') ? 'error' : '' ?>">
					<input type="text" name="price" id="price" value="<?= isset($form['price']) ? $form['price'] : '' ?>">
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>