<?php
/** @var $model		GameModel */
/** @var $results	array */
/** @var $result	GuessResult */
?>

<?php foreach ($results as $result): ?>
	<?php if ($result->is(GuessResult::SUCCESS)): ?>
	<p class="success <?= $result->getTryNo() == 1 ? 'first' : '' ?>">
		Поздравляем! Вы успешно угадали комбинацию: <strong><?php echo $result->getGuess() ?></strong>
	</p>
	<?php elseif ($result->is(GuessResult::GUESS)): ?>
	<p class="try <?= $result->getTryNo() == 1 ? 'first' : '' ?>">
		Хммммм, пробуйте еще! В <strong><?php echo $result->getGuess() ?></strong>
		<?php echo numeral_case($result->getBulls(), 'бык', array('ов', '', 'a','ов')) ?> и
		<?php echo numeral_case($result->getCows(), 'коров', array('', 'а', 'ы','ов')) ?>
	</p>
	<?php elseif ($result->is(GuessResult::INVALID_INPUT)): ?>
	<p class="error <?= $result->getTryNo() == 1 ? 'first' : '' ?>">
		Упс! Что-то ввели не так вы: <strong><?php echo $result->getGuess() ?></strong>
	</p>
	<?php endif; ?>
<?php endforeach; ?>