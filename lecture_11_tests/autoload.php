<?php

function _do_autoload($className)
{
	$classFile = __DIR__.'/classes/'.str_replace('..', '', $className).'.php';
	if (file_exists($classFile))
		require_once($classFile);
}

spl_autoload_register('_do_autoload');
