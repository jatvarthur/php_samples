<?php

function fib($N)
{
    $result = array( 1 => 1, 2 => 1 );
    for ($i = 3; $i <= $N; ++$i)
        $result[$i] = $result[$i - 1] + $result[$i - 2];
    return $result;
}

function render($fibs)
{
    require('templates/fibs.php');
}

function main()
{
    $N = isset($_GET['N']) ? (int)$_GET['N'] : 24;
    if ($N < 2) $N = 2;
    if ($N > 500) $N = 500;

    $fibs = fib($N);
    render($fibs);
}

main();
