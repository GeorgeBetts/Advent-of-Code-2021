<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

// counter for the number of times the sonar increases
$depthIncreaseCount = 0;

$measurementWindows = [];

// loop each value and generate the measurment windows
foreach ($values as $key => $value) {
    // stop the loop when there are no measurement windows left
    if ($key >= count($values) - 2) {
        break;
    }
    // generate the measurement window by suming the next 3 values
    $measurementWindows[] = intval($value) + intval($values[$key + 1]) + intval($values[$key + 2]);
}

// loop each measurement window value and check if it increases over the previous value
foreach ($measurementWindows as $key => $value) {
    if ($key == 0) {
        continue;
    }
    // check the value is greater than the previous value
    if ($measurementWindows[$key - 1] < $value) {
        $depthIncreaseCount++;
    }
}

echo $depthIncreaseCount;
