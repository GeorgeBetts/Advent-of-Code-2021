<?php
$values = explode(',', file_get_contents('input.txt'));

// get the unique values
$valuesUnique = range(0, max($values));

$alignmentFuelCost = [];

// loop the unique values, the current value will be the alignment
foreach ($valuesUnique as $alignment) {
    $totalFuelCost = 0;
    // loop all values, total the difference to the alignment
    foreach ($values as $value) {
        $difference = abs($alignment - $value);
        $totalFuelCost += ($difference * ($difference + 1)) / 2;
    }
    // add the total to an array
    $alignmentFuelCost[$alignment] = $totalFuelCost;
}

echo min($alignmentFuelCost);
