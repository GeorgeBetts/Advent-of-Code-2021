<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

/**
 * Create an array to hold each binary column
 *
 * Each columns counts the number of 1s that appear in then column
 */
$columns = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0,
    9 => 0,
    10 => 0,
    11 => 0,
];

$total = count($values);


// Read the bits into their columns
foreach ($values as $value) {
    $bits = str_split($value);
    foreach ($bits as $key => $bit) {
        if ($bit == 1) {
            $columns[$key]++;
        }
    }
}

$gamma = "";
$epsilon  = "";

/**
 * Loop the columns and generate the Gamma and Epsilon
 */
foreach ($columns as $column) {
    // Check whether 1 was the majority (half or more of the numbers in a column = 1)
    if ($column >= ($total / 2)) {
        $gamma .= "1";
        $epsilon  .= "0";
    } else {
        $gamma .= "0";
        $epsilon  .= "1";
    }
}

echo bindec($gamma) * bindec($epsilon);
