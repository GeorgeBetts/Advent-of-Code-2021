<?php
$values = explode(',', file_get_contents('input.txt'));

// get the unique values
$valuesUnique = array_unique($values);

$alignmentFuelCost = [];

// loop the unique values, the current value will be the alignment
foreach ($valuesUnique as $alignment) {
    $totalFuelCost = 0;
    // loop all values, total the difference to the alignment
    foreach ($values as $value) {
        $totalFuelCost += abs($alignment - $value);
    }
    // add the total to an array
    $alignmentFuelCost[$alignment] = $totalFuelCost;
}

echo min($alignmentFuelCost);
