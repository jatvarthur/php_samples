<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Список пользователей</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
<header>
	<div class="wrapper">
		<?php if ($current_user): ?>
			<a href="#" class="user"><?= $current_user['fullname'] ?></a><a href="logout.php" class="button">Выход</a>
		<?php endif; ?>
	</div>
</header>
<div class="wrapper">
	<h1>Зарегистрированные пользователи</h1>
	<table class="users" border="1">
		<tr>
			<th>ID</th>
			<th>Ник</th>
			<th>Эл.почта</th>
			<th>ФИО</th>
			<th>Пол</th>
			<th>Рассылка</th>
		</tr>
		<?php foreach ($user_list as $i => $user): ?>
		<tr class="<?= ($i+1)%2 == 0 ? 'even' : 'odd' ?>">
			<td><?= $user['id'] ?></td>
			<td><?= htmlspecialchars($user['nickname']) ?></td>
			<td><?= htmlspecialchars($user['email']) ?></td>
			<td><?= htmlspecialchars($user['fullname']) ?></td>
			<td><?= $user['gender'] == 'M' ? 'Джентльмен' : 'Леди' ?></td>
			<td><?= $user['newsletter'] ? 'Да' : 'Нет' ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
</body>
</html>