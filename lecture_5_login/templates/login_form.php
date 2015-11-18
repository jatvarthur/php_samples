<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Регистрация пользователя</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
<div class="wrapper">
	<h1>Регистрация и данные формы</h1>
	<div class="form">
		<?php if (has_errors($errors)): ?>
		<div class="error-msg">
		При заполнении формы возникли ошибки, пожалуйста проверьте правильность заполнения полей и нажмите "Зарегистрироваться"!
		</div>
		<?php endif; ?>
		<form action="index.php" method="POST">
			<div class="row <?= is_error($errors, 'username') ? 'error' : '' ?>">
				<label for="username">Имя пользователя<span class="required">*</span>:</label>
				<input type="text" name="username" id="username"
					   value="<?= isset($user['username']) ? $user['username'] : '' ?>">
			</div>
			<div class="row <?= is_error($errors, 'password') ? 'error' : '' ?>">
				<label for="password">Пароль<span class="required">*</span>:</label>
				<input type="password" name="password" id="password" value="">
			</div>
			<div class="row <?= is_error($errors, 'password_confirmation') ? 'error' : '' ?>">
				<label for="password_confirmation">Пароль еще раз<span class="required">*</span>:</label>
				<input type="password" name="password_confirmation" id="password_confirmation" value="">
			</div>
			<div class="row <?= is_error($errors, 'fullname') ? 'error' : '' ?>">
				<label for="fullname">ФИО<span class="required">*</span>:</label>
				<input type="text" name="fullname" id="fullname"
					   value="<?= isset($user['fullname']) ? $user['fullname'] : '' ?>">
			</div>
			<div class="row">
				<label>Ваш пол:</label>
				<input type="radio" name="gender" id="gender_Male" value="M"
					<?= isset($user['gender']) && $user['gender'] == 'M' ? 'checked="checked"' : '' ?>
					/>
				<label for="gender_Male">Джентельмен</label>
				<input type="radio" name="gender" id="gender_Female" value="F"
					<?= isset($user['gender']) && $user['gender'] == 'F' ? 'checked="checked"' : '' ?>
					/>
				<label for="gender_Female">Леди</label>
			</div>
			<div class="row">
				<label></label>
				<input type="checkbox" name="newsletter" id="newsletter" value="1"
					<?= isset($user['newsletter']) && $user['newsletter'] == '1' ? 'checked="checked"' : '' ?>
					/>
				<label for="newsletter">Я хочу получать новостную рассылку</label>
			</div>
			<div class="row footer">
				<input type="submit" name="register" id="register" value="Зарегистрироваться"/>
				<input type="reset" name="reset" id="reset" value="Очистить"/>
			</div>
		</form>
	</div>
</div>
</body>
</html>