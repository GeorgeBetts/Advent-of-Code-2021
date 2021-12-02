<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$horizontal = 0;
$depth = 0;

foreach ($values as $value) {
    $measurement = intval(substr($value, -2));
    $direction = substr($value, 0, -2);
    switch ($direction) {
        case 'forward':
            $horizontal += $measurement;
            break;
        case 'up':
            $depth -= $measurement;
            break;
        case 'down':
            $depth += $measurement;
            break;
    }
}

echo $horizontal * $depth;
