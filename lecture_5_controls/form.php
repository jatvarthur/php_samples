<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Элементы форм</title>
</head>

<body>
<h1>Элементы форм</h1>

<form action="process_form.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="hiddenField" id="hiddenField" value=""/>

	<div>
		<label for="pushButton">Кнопка</label>
		<input type="button" name="pushButton" id="pushButton" value="Нажать"/>
	</div>

	<div>
		<label for="textField">Поле ввода текста</label>
		<input type="text" name="textField" id="textField" value="">
	</div>

	<div>
		<label for="passwordField">Поле ввода пароля</label>
		<input type="password" name="passwordField" id="passwordField" value=""/>
	</div>

	<div>
		<label for="radioField1">Радиокнопка</label>
		<input type="radio" name="radioField" id="radioField1" value="radio1"/>
		<label for="radioField2">Вторая радиокнопка</label>
		<input type="radio" name="radioField" id="radioField2" value="radio2" checked="checked"/>
		<label for="radioField3">И еще одна радиокнопка</label>
		<input type="radio" name="radioField" id="radioField3" value="radio3"/>
	</div>

	<div>
		<label for="checkField1">Флажок</label>
		<input type="checkbox" name="checkField[]" id="checkField1" value="check1" checked="checked"/>
		<label for="checkField2">Еще флажок</label>
		<input type="checkbox" name="checkField[]" id="checkField2" value="check2"/>
		<label for="checkField3">Третий флажок</label>
		<input type="checkbox" name="checkField[]" id="checkField1" value="check3"/>
	</div>

	<div>
		<label for="pullDownMenu">Комбинированный список</label>
		<select name="pullDownMenu" id="pullDownMenu" size="1">
			<option value="option1">Первая строка</option>
			<option value="option2" selected="selected">Вторая строка</option>
			<option value="option3">Третья строка</option>
		</select>
	</div>

	<div>
		<label for="listBox">Список</label>
		<select name="listBox" id="listBox" size="3">
			<option value="option1">Первая строка</option>
			<option value="option2">Вторая строка</option>
			<option value="option3">Третья строка</option>
		</select>
	</div>

	<div>
		<label for="multiListBox">Список с множественным выбором</label>
		<select name="multiListBox[]" id="multiListBox" size="3" multiple="multiple">
			<option value="option1">Первая строка</option>
			<option value="option2" selected="selected">Вторая строка</option>
			<option value="option3" selected="selected">Третья строка</option>
		</select>
	</div>

	<div>
		<label for="textAreaField">Многострочное поле ввода текста</label>
		<textarea name="textAreaField" id="textAreaField" rows="4" cols="50"></textarea>
	</div>

	<div>
		<label for="fileSelectField">Поле загрузки файла</label>
		<input type="file" name="fileSelectField" id="fileSelectField" value=""/>
	</div>

	<div>
		<label for="submitButton">Кнопка отправки</label>
		<input type="submit" name="submitButton" id="submitButton" value="Отправить"/>

		<label for="resetButton">Кнопка сброса</label>
		<input type="reset" name="resetButton" id="resetButton" value="Сбросить"/>
	</div>

</form>
</body>
</html>