<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

// counter for the number of times the sonar increases
$depthIncreaseCount = 0;

$comparisonValue = null;

// loop each value and generate the measurment windows
foreach ($values as $key => $value) {
    // stop the loop when there are no measurement windows left
    if ($key >= count($values) - 2) {
        break;
    }
    // generate the measurement window by suming the next 3 values
    $currentWindow = intval($value) + intval($values[$key + 1]) + intval($values[$key + 2]);
    // compare the current window with the previous one to check if there is an increase
    if ($comparisonValue != null && $currentWindow > $comparisonValue) {
        $depthIncreaseCount++;
    }
    $comparisonValue = intval($value) + intval($values[$key + 1]) + intval($values[$key + 2]);
}


echo $depthIncreaseCount;
