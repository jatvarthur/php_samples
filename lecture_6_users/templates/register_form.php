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
		<a href="#" class="user">Вход не выполнен</a>
	</div>
</header>
<div class="wrapper form-container">
	<div class="form">
		<div class="row header">
			<h1>Регистрация</h1>
		</div>
		<?php if (has_errors($errors)): ?>
		<div class="error-msg">
		При заполнении формы возникли ошибки, пожалуйста проверьте правильность заполнения полей и нажмите "Зарегистрироваться"!
		</div>
		<?php endif; ?>
		<form action="register.php" method="POST">
			<div class="row <?= is_error($errors, 'nickname') ? 'error' : '' ?>">
				<label for="nickname">Имя пользователя<span class="required">*</span>:</label>
				<input type="text" name="nickname" id="nickname"
					   value="<?= isset($form['nickname']) ? $form['nickname'] : '' ?>">
			</div>
			<div class="row <?= is_error($errors, 'email') ? 'error' : '' ?>">
				<label for="email">Эл.почта<span class="required">*</span>:</label>
				<input type="text" name="email" id="email"
					   value="<?= isset($form['email']) ? $form['email'] : '' ?>">
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
					   value="<?= isset($form['fullname']) ? $form['fullname'] : '' ?>">
			</div>
			<div class="row">
				<label>Ваш пол:</label>
				<input type="radio" name="gender" id="gender_Male" value="M"
					<?= isset($form['gender']) && $form['gender'] == 'M' ? 'checked="checked"' : '' ?>
					/>
				<label for="gender_Male">Джентельмен</label>
				<input type="radio" name="gender" id="gender_Female" value="F"
					<?= isset($form['gender']) && $form['gender'] == 'F' ? 'checked="checked"' : '' ?>
					/>
				<label for="gender_Female">Леди</label>
			</div>
			<div class="row">
				<label></label>
				<input type="checkbox" name="newsletter" id="newsletter" value="1"
					<?= isset($form['newsletter']) && $form['newsletter'] == '1' ? 'checked="checked"' : '' ?>
					/>
				<label for="newsletter">Я хочу получать новостную рассылку</label>
			</div>
			<div class="row footer">
				<input type="submit" name="register" id="register" value="Зарегистрироваться"/>
				<input type="reset" name="reset" id="reset" value="Очистить"/>
			</div>
			<div class="row footer">
				Уже зарегистрированы? <a href="login.php">Войдите в систему!</a>
			</div>
		</form>
	</div>
</div>
</body>
</html>